from django.shortcuts import render
from django.http import JsonResponse
from django.views.decorators.http import require_http_methods
from django.views.decorators.csrf import csrf_exempt
import json
from .services import api_client


def home(request):
    """Home page with featured products"""
    try:
        # Get featured products (first 6)
        products_data = api_client.get_products(per_page=6)
        products = products_data.get('data', []) if isinstance(products_data, dict) else products_data
    except Exception as e:
        products = []
        error_message = str(e)

    return render(request, 'shop/home.html', {
        'products': products,
        'error': error_message if 'error_message' in locals() else None
    })


def products(request):
    """Products catalog with filters"""
    try:
        # Get filter parameters
        search = request.GET.get('search')
        category_id = request.GET.get('category_id')
        min_price = request.GET.get('min_price')
        max_price = request.GET.get('max_price')
        in_stock = request.GET.get('in_stock')
        per_page = int(request.GET.get('per_page', 20))
        page = int(request.GET.get('page', 1))

        # Get categories for filter dropdown
        categories = api_client.get_categories()

        # Get products with filters
        products_data = api_client.get_products(
            search=search,
            category_id=int(category_id) if category_id else None,
            min_price=float(min_price) if min_price else None,
            max_price=float(max_price) if max_price else None,
            in_stock=in_stock,
            per_page=per_page,
            page=page
        )

        products = products_data.get('data', []) if isinstance(products_data, dict) else products_data
        pagination = products_data if isinstance(products_data, dict) else {}

    except Exception as e:
        products = []
        categories = []
        pagination = {}
        error_message = str(e)

    return render(request, 'shop/products.html', {
        'products': products,
        'categories': categories,
        'pagination': pagination,
        'error': error_message if 'error_message' in locals() else None
    })


def product_detail(request, product_id):
    """Single product detail page"""
    try:
        product_data = api_client.get_product(product_id)
        product = product_data.get('product', product_data)
    except Exception as e:
        product = None
        error_message = str(e)

    return render(request, 'shop/product_detail.html', {
        'product': product,
        'error': error_message if 'error_message' in locals() else None
    })


@require_http_methods(["GET", "POST"])
def quote_form(request):
    """Quote request form"""
    if request.method == 'POST':
        try:
            quote_data = {
                'customer_name': request.POST.get('customer_name'),
                'customer_email': request.POST.get('customer_email'),
                'customer_phone': request.POST.get('customer_phone'),
                'company_name': request.POST.get('company_name'),
                'message': request.POST.get('message'),
                'estimated_amount': float(request.POST.get('estimated_amount')) if request.POST.get('estimated_amount') else None
            }

            result = api_client.create_quote(quote_data)
            return render(request, 'shop/quote_success.html', {
                'quote': result.get('quote')
            })

        except Exception as e:
            return render(request, 'shop/quote_form.html', {
                'error': str(e)
            })

    return render(request, 'shop/quote_form.html')


@require_http_methods(["GET", "POST"])
def cart(request):
    """Shopping cart and order submission"""
    if request.method == 'POST':
        try:
            # Parse order data from POST
            order_data = {
                'customer_name': request.POST.get('customer_name'),
                'customer_email': request.POST.get('customer_email'),
                'customer_phone': request.POST.get('customer_phone'),
                'shipping_address': request.POST.get('shipping_address'),
                'items': json.loads(request.POST.get('items', '[]')),
                'total_amount': float(request.POST.get('total_amount', 0))
            }

            # Send order to Laravel API
            result = api_client.create_order(order_data)
            return render(request, 'shop/order_success.html', {
                'order': result.get('order')
            })

        except Exception as e:
            return render(request, 'shop/cart.html', {
                'error': str(e)
            })

    return render(request, 'shop/cart.html')

