"""
URL configuration for techstore_frontend project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/6.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path, include
from django.http import JsonResponse
import requests
import os

def products_view(request):
    backend_url = os.environ.get('BACKEND_URL', 'http://localhost:8000')
    try:
        response = requests.get(f'{backend_url}/api/products', headers={'Accept': 'application/json'}, timeout=10)

        # Check response status
        if response.status_code != 200:
            return JsonResponse({
                'error': 'Backend returned non-200 status',
                'status_code': response.status_code,
                'response_text': response.text[:500]
            }, status=response.status_code)

        # Check if response is JSON
        content_type = response.headers.get('Content-Type', '')
        if 'application/json' not in content_type:
            return JsonResponse({
                'error': 'Backend did not return JSON',
                'status_code': response.status_code,
                'content_type': content_type,
                'response_text': response.text[:500]
            }, status=500)

        # Parse JSON
        products_data = response.json()

        # Ensure data is a list or dict
        if not isinstance(products_data, (list, dict)):
            return JsonResponse({
                'error': 'Backend returned unexpected data type',
                'data_type': str(type(products_data))
            }, status=500)

        return JsonResponse(products_data, safe=False)

    except requests.Timeout:
        return JsonResponse({'error': 'Backend request timed out'}, status=504)
    except requests.RequestException as e:
        return JsonResponse({'error': f'Request failed: {str(e)}'}, status=500)
    except ValueError as e:
        return JsonResponse({
            'error': 'Failed to parse JSON response',
            'details': str(e),
            'response_text': response.text[:500] if hasattr(response, 'text') else 'N/A'
        }, status=500)
    except Exception as e:
        return JsonResponse({
            'error': 'Unexpected error',
            'details': str(e)
        }, status=500)

urlpatterns = [
    path('admin/', admin.site.urls),
    path('', include('shop.urls')),
    path('api/products/', products_view),
]
