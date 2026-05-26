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
from django.urls import path
from django.http import JsonResponse
import requests
import os

def products_view(request):
    backend_url = os.environ.get('BACKEND_URL', 'http://localhost:8000')
    try:
        response = requests.get(f'{backend_url}/api/products', headers={'Accept': 'application/json'})
        
        # Check if response is JSON
        if 'application/json' in response.headers.get('Content-Type', ''):
            products_data = response.json()
            return JsonResponse(products_data)
        else:
            # If not JSON, return error with response text
            return JsonResponse({
                'error': 'Backend did not return JSON',
                'status_code': response.status_code,
                'content_type': response.headers.get('Content-Type', 'unknown'),
                'response_text': response.text[:500]  # First 500 chars for debugging
            }, status=500)
    except requests.RequestException as e:
        return JsonResponse({'error': str(e)}, status=500)
    except ValueError as e:
        return JsonResponse({
            'error': 'Failed to parse JSON response',
            'details': str(e)
        }, status=500)

urlpatterns = [
    path('admin/', admin.site.urls),
    path('api/products/', products_view),
]
