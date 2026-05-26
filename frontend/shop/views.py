from django.shortcuts import render
from django.http import JsonResponse
import requests
import os

def home(request):
    return render(request, 'shop/home.html')

def products(request):
    return render(request, 'shop/products.html')
