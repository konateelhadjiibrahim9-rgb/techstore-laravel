# Architecture TechStore - Séparation Backend/Frontend

## 📋 Architecture Cible

### BACKEND : PHP (Laravel)
- **Rôle** : Logique serveur, gestion des données, APIs REST
- **Responsabilités** :
  - Gestion de la base de données
  - Authentification et autorisation
  - APIs REST pour consommation par Django
  - Validation des données
  - Business logic
- **Port** : 8000
- **Endpoints** : `/api/*`

### FRONTEND : Python (Django)
- **Rôle** : Interfaces utilisateurs, partie client
- **Responsabilités** :
  - Rendu des pages HTML
  - Gestion de l'état client
  - Appels APIs Laravel
  - Navigation et routing
  - Templates et composants UI
- **Port** : 8001
- **Endpoints** : `/*` (sauf APIs)

---

## 🔧 État Actuel

### Laravel (Backend avec frontend mélangé)
- ❌ **49 fichiers Blade** dans `resources/views/`
- ❌ **Layouts personnalisés** (techstore, header, footer)
- ❌ **DashboardController** retourne des vues Blade
- ❌ **Routes web.php** servent des pages HTML
- ✅ **Modèles et Migrations** (corrects pour backend)
- ✅ **Controllers** (logique métier correcte)

### Django (Frontend partiellement implémenté)
- ✅ **Projet Django configuré** dans `/frontend/techstore_frontend`
- ✅ **Templates Django** dans `/frontend/templates/shop/`
- ✅ **Configuration API** : `LARAVEL_API_BASE_URL`
- ✅ **URL proxy** pour `/api/products`
- ⚠️ **Templates incomplets** (manquent dashboard, auth, etc.)

---

## 🎯 Plan de Migration

### Phase 1 : Création APIs Laravel (Backend)
1. **Créer API Resources** :
   - ProductResource
   - CategoryResource
   - OrderResource
   - QuoteResource
   - UserResource

2. **Créer API Controllers** :
   - Api/ProductController
   - Api/CategoryController
   - Api/OrderController
   - Api/QuoteController
   - Api/AuthController

3. **Définir Routes API** :
   - `routes/api.php` pour endpoints REST
   - Authentification via Sanctum ou JWT
   - CORS configuration pour Django

### Phase 2 : Migration Templates vers Django (Frontend)
1. **Migrer Layouts** :
   - `layouts/techstore.blade.php` → `templates/base.html`
   - `layouts/header.blade.php` → `templates/components/header.html`
   - `layouts/footer.blade.php` → `templates/components/footer.html`

2. **Migrer Pages** :
   - `dashboard/index.blade.php` → `templates/dashboard/index.html`
   - `dashboard/products.blade.php` → `templates/dashboard/products.html`
   - `auth/login.blade.php` → `templates/auth/login.html`
   - etc.

3. **Migrer Composants** :
   - `components/product-card.blade.php` → Django template tags
   - `components/whatsapp-float.blade.php` → Django template tags

### Phase 3 : Suppression Blade Laravel
1. **Supprimer** : `resources/views/`
2. **Modifier** : Controllers pour retourner JSON au lieu de vues
3. **Nettoyer** : Routes web.php (ne garder que APIs)

---

## 📡 APIs Laravel Requises

### Authentification
```
POST /api/auth/register
POST /api/auth/login
POST /api/auth/logout
GET  /api/auth/user
POST /api/auth/refresh
```

### Produits
```
GET    /api/products
GET    /api/products/{id}
GET    /api/products?category={category}
GET    /api/products?search={query}
```

### Catégories
```
GET /api/categories
GET /api/categories/{id}
```

### Commandes
```
GET    /api/orders
POST   /api/orders
GET    /api/orders/{id}
PATCH  /api/orders/{id}/status
```

### Devis
```
GET    /api/quotes
POST   /api/quotes
GET    /api/quotes/{id}
PATCH  /api/quotes/{id}/status
```

### Utilisateurs
```
GET  /api/users/me
PATCH /api/users/me
```

---

## 🔗 Configuration Django

### settings.py
```python
# Laravel API Configuration
LARAVEL_API_BASE_URL = os.environ.get('LARAVEL_API_BASE_URL', 'http://backend:8000/api')

# CORS Configuration
CORS_ALLOWED_ORIGINS = [
    "http://localhost:8001",
    "http://127.0.0.1:8001",
]

# Authentication (via Laravel API)
# Utiliser session-based auth ou token-based auth
```

### Services Django
```python
# services/laravel_api.py
import requests
from django.conf import settings

class LaravelAPIService:
    BASE_URL = settings.LARAVEL_API_BASE_URL
    
    @classmethod
    def get_products(cls, category=None, search=None):
        params = {}
        if category:
            params['category'] = category
        if search:
            params['search'] = search
        
        response = requests.get(f"{cls.BASE_URL}/products", params=params)
        return response.json()
    
    @classmethod
    def create_quote(cls, data):
        response = requests.post(f"{cls.BASE_URL}/quotes", json=data)
        return response.json()
```

---

## 📝 Notes de Développement

### Règles à Respecter
1. **Laravel** : Ne retourne jamais de HTML, uniquement JSON
2. **Django** : Ne contient aucune logique métier, uniquement UI
3. **Communication** : Uniquement via APIs REST
4. **Base de données** : Gérée exclusivement par Laravel

### Conventions
- **Nommage APIs** : RESTful (GET/POST/PATCH/DELETE)
- **Format réponse** : JSON standardisé
- **Erreurs** : Codes HTTP appropriés (400, 401, 403, 404, 500)
- **Pagination** : Standard Laravel pagination

---

## 🚀 Étapes Suivantes

1. ✅ Audit architecture complété
2. ⏳ Créer API Resources Laravel
3. ⏳ Créer API Controllers Laravel
4. ⏳ Configurer routes/api.php
5. ⏳ Migrer templates Blade vers Django
6. ⏳ Supprimer fichiers Blade Laravel
7. ⏳ Tester communication Django ↔ Laravel
