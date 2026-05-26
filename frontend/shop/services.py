import requests
from django.conf import settings
from typing import Optional, Dict, Any, List


class LaravelAPIClient:
    """Service client for Laravel API"""

    def __init__(self):
        self.base_url = settings.LARAVEL_API_BASE_URL
        self.backend_url = self.base_url.replace('/api', '')  # Remove /api for image URLs
        self.timeout = 10

    def _make_request(
        self,
        method: str,
        endpoint: str,
        data: Optional[Dict[str, Any]] = None,
        params: Optional[Dict[str, Any]] = None
    ) -> Dict[str, Any]:
        """Make HTTP request to Laravel API with error handling"""
        url = f"{self.base_url}/{endpoint}"

        try:
            response = requests.request(
                method=method,
                url=url,
                json=data,
                params=params,
                timeout=self.timeout,
                headers={'Accept': 'application/json'}
            )

            response.raise_for_status()
            return response.json()

        except requests.Timeout:
            raise Exception("Backend API timeout - Service temporarily unavailable")
        except requests.ConnectionError:
            raise Exception("Backend API unreachable - Service offline")
        except requests.HTTPError as e:
            if e.response.status_code == 500:
                raise Exception("Backend API error - Internal server error")
            elif e.response.status_code == 404:
                raise Exception("Backend API resource not found")
            else:
                raise Exception(f"Backend API error: {e.response.status_code}")
        except ValueError as e:
            raise Exception("Backend API returned invalid JSON")
        except Exception as e:
            raise Exception(f"Unexpected error: {str(e)}")

    def _process_product_images(self, products: List[Dict[str, Any]]) -> List[Dict[str, Any]]:
        """Process product images to add full URLs"""
        for product in products:
            if product.get('image_path'):
                # Construct full URL for image
                product['image_url'] = f"{self.backend_url}/storage/{product['image_path']}"
            else:
                product['image_url'] = None
        return products

    def get_products(
        self,
        search: Optional[str] = None,
        category_id: Optional[int] = None,
        min_price: Optional[float] = None,
        max_price: Optional[float] = None,
        in_stock: Optional[str] = None,
        per_page: int = 20,
        page: int = 1
    ) -> Dict[str, Any]:
        """Get products with filters from Laravel API"""
        try:
            params = {
                'per_page': per_page,
                'page': page
            }

            if search:
                params['search'] = search
            if category_id:
                params['category_id'] = category_id
            if min_price:
                params['min_price'] = min_price
            if max_price:
                params['max_price'] = max_price
            if in_stock:
                params['in_stock'] = in_stock

            result = self._make_request('GET', 'products', params=params)
            
            # Process images
            if 'data' in result:
                result['data'] = self._process_product_images(result['data'])
            
            return result
        except Exception as e:
            # Return empty data structure to prevent crashes
            return {
                'data': [],
                'current_page': 1,
                'last_page': 1,
                'total': 0
            }

    def get_product(self, product_id: int) -> Dict[str, Any]:
        """Get single product by ID from Laravel API"""
        try:
            result = self._make_request('GET', f'products/{product_id}')
            
            # Process image for single product
            if 'product' in result and result['product']:
                result['product'] = self._process_product_images([result['product']])[0]
            
            return result
        except Exception as e:
            # Return empty product to prevent crashes
            return {'product': None}

    def get_categories(self) -> List[Dict[str, Any]]:
        """Get all categories from Laravel API"""
        try:
            return self._make_request('GET', 'categories')
        except Exception as e:
            # Return empty list to prevent crashes
            return []

    def create_order(self, order_data: Dict[str, Any]) -> Dict[str, Any]:
        """Create order via Laravel API"""
        try:
            return self._make_request('POST', 'orders', data=order_data)
        except Exception as e:
            raise Exception(f"Failed to create order: {str(e)}")

    def create_quote(self, quote_data: Dict[str, Any]) -> Dict[str, Any]:
        """Create quote via Laravel API"""
        try:
            return self._make_request('POST', 'quotes', data=quote_data)
        except Exception as e:
            raise Exception(f"Failed to create quote: {str(e)}")


# Singleton instance
api_client = LaravelAPIClient()
