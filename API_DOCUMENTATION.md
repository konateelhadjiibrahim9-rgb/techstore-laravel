# API Laravel Documentation - Pour Consommation Django

## 📡 Base URL
```
http://localhost:8000/api
```

## 🔐 Authentification

### Register
```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}

Response 201:
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}

Response 200:
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}

Response 200:
{
  "message": "Successfully logged out"
}
```

### Get Current User
```http
GET /api/auth/user
Authorization: Bearer {token}

Response 200:
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "role": "user"
}
```

---

## 📦 Produits

### List Products
```http
GET /api/products
Authorization: Bearer {token}

Query Parameters:
- category: string (optional)
- search: string (optional)
- page: integer (default: 1)
- per_page: integer (default: 15)

Response 200:
{
  "data": [
    {
      "id": 1,
      "name": "Laptop Dell XPS 15",
      "description": "High-performance laptop",
      "price": 1500000,
      "stock": 10,
      "category": {
        "id": 1,
        "category": "Ordinateurs",
        "description": "PC portables et de bureau"
      },
      "image_path": "/storage/products/laptop.jpg",
      "processor": "Intel i7",
      "ram": "16GB",
      "storage": "512GB SSD",
      "created_at": "2026-05-28T10:00:00Z",
      "updated_at": "2026-05-28T10:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 50,
    "last_page": 4
  }
}
```

### Get Product Details
```http
GET /api/products/{id}
Authorization: Bearer {token}

Response 200:
{
  "id": 1,
  "name": "Laptop Dell XPS 15",
  "description": "High-performance laptop",
  "price": 1500000,
  "stock": 10,
  "category": {
    "id": 1,
    "category": "Ordinateurs",
    "description": "PC portables et de bureau"
  },
  "image_path": "/storage/products/laptop.jpg",
  "processor": "Intel i7",
  "ram": "16GB",
  "storage": "512GB SSD",
  "specifications": {
    "screen": "15.6\" FHD",
    "battery": "8 hours",
    "weight": "2.0 kg"
  },
  "created_at": "2026-05-28T10:00:00Z",
  "updated_at": "2026-05-28T10:00:00Z"
}

Response 404:
{
  "error": "Product not found"
}
```

---

## 📂 Catégories

### List Categories
```http
GET /api/categories
Authorization: Bearer {token}

Response 200:
{
  "data": [
    {
      "id": 1,
      "category": "Ordinateurs",
      "description": "PC portables et de bureau",
      "profile": "individual",
      "product_count": 25
    },
    {
      "id": 2,
      "category": "Serveurs",
      "description": "Serveurs professionnels",
      "profile": "enterprise",
      "product_count": 10
    }
  ]
}
```

### Get Category Details
```http
GET /api/categories/{id}
Authorization: Bearer {token}

Response 200:
{
  "id": 1,
  "category": "Ordinateurs",
  "description": "PC portables et de bureau",
  "profile": "individual",
  "product_count": 25,
  "products": [
    {
      "id": 1,
      "name": "Laptop Dell XPS 15",
      "price": 1500000
    }
  ]
}
```

---

## 🛒 Commandes

### List Orders
```http
GET /api/orders
Authorization: Bearer {token}

Query Parameters:
- status: string (optional: pending, paid, shipped, delivered)
- page: integer (default: 1)

Response 200:
{
  "data": [
    {
      "id": 1,
      "reference": "ORD-2026-001",
      "total_amount": 2500000,
      "status": "pending",
      "created_at": "2026-05-28T10:00:00Z",
      "items": [
        {
          "id": 1,
          "product_id": 1,
          "quantity": 2,
          "unit_price": 1500000,
          "subtotal": 3000000
        }
      ]
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 5
  }
}
```

### Create Order
```http
POST /api/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 3,
      "quantity": 1
    }
  ],
  "delivery_address": {
    "address": "123 Rue Principale",
    "city": "Abidjan",
    "country": "Côte d'Ivoire",
    "phone": "+225 07 00 00 00 00"
  }
}

Response 201:
{
  "id": 1,
  "reference": "ORD-2026-001",
  "total_amount": 2500000,
  "status": "pending",
  "delivery_fee": 15000,
  "created_at": "2026-05-28T10:00:00Z"
}
```

### Get Order Details
```http
GET /api/orders/{id}
Authorization: Bearer {token}

Response 200:
{
  "id": 1,
  "reference": "ORD-2026-001",
  "total_amount": 2500000,
  "status": "pending",
  "delivery_fee": 15000,
  "delivery_address": {
    "address": "123 Rue Principale",
    "city": "Abidjan",
    "country": "Côte d'Ivoire",
    "phone": "+225 07 00 00 00 00"
  },
  "items": [
    {
      "id": 1,
      "product": {
        "id": 1,
        "name": "Laptop Dell XPS 15",
        "price": 1500000
      },
      "quantity": 2,
      "unit_price": 1500000,
      "subtotal": 3000000
    }
  ],
  "created_at": "2026-05-28T10:00:00Z",
  "updated_at": "2026-05-28T10:00:00Z"
}
```

### Update Order Status
```http
PATCH /api/orders/{id}/status
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "shipped"
}

Response 200:
{
  "id": 1,
  "reference": "ORD-2026-001",
  "status": "shipped",
  "updated_at": "2026-05-28T11:00:00Z"
}
```

---

## 📄 Devis

### List Quotes
```http
GET /api/quotes
Authorization: Bearer {token}

Query Parameters:
- status: string (optional: pending, approved, rejected)
- page: integer (default: 1)

Response 200:
{
  "data": [
    {
      "id": 1,
      "reference": "QT-2026-001",
      "total_amount": 3500000,
      "status": "pending",
      "created_at": "2026-05-28T10:00:00Z",
      "items": [
        {
          "id": 1,
          "product_id": 1,
          "quantity": 2,
          "unit_price": 1500000,
          "subtotal": 3000000
        }
      ]
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 3
  }
}
```

### Create Quote
```http
POST /api/quotes
Authorization: Bearer {token}
Content-Type: application/json

{
  "profile": "individual",
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 3,
      "quantity": 1
    }
  ],
  "message": "Besoin urgent pour projet professionnel",
  "contact_info": {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+225 07 00 00 00 00",
    "company": "Tech Solutions"
  }
}

Response 201:
{
  "id": 1,
  "reference": "QT-2026-001",
  "total_amount": 3500000,
  "status": "pending",
  "created_at": "2026-05-28T10:00:00Z",
  "emitter": {
    "name": "Konate El Hadji Ibrahim",
    "role": "Full-Stack Developer",
    "organization": "IDA Groupe LOKO"
  }
}
```

### Get Quote Details
```http
GET /api/quotes/{id}
Authorization: Bearer {token}

Response 200:
{
  "id": 1,
  "reference": "QT-2026-001",
  "total_amount": 3500000,
  "status": "pending",
  "profile": "individual",
  "message": "Besoin urgent pour projet professionnel",
  "contact_info": {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+225 07 00 00 00 00",
    "company": "Tech Solutions"
  },
  "items": [
    {
      "id": 1,
      "product": {
        "id": 1,
        "name": "Laptop Dell XPS 15",
        "price": 1500000
      },
      "quantity": 2,
      "unit_price": 1500000,
      "subtotal": 3000000
    }
  ],
  "emitter": {
    "name": "Konate El Hadji Ibrahim",
    "role": "Full-Stack Developer",
    "organization": "IDA Groupe LOKO"
  },
  "created_at": "2026-05-28T10:00:00Z",
  "updated_at": "2026-05-28T10:00:00Z"
}
```

### Update Quote Status
```http
PATCH /api/quotes/{id}/status
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "approved"
}

Response 200:
{
  "id": 1,
  "reference": "QT-2026-001",
  "status": "approved",
  "updated_at": "2026-05-28T11:00:00Z"
}
```

---

## 👤 Utilisateurs

### Get Current User Profile
```http
GET /api/users/me
Authorization: Bearer {token}

Response 200:
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "role": "user",
  "created_at": "2026-05-28T10:00:00Z"
}
```

### Update User Profile
```http
PATCH /api/users/me
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Smith",
  "phone": "+225 07 00 00 00 00"
}

Response 200:
{
  "id": 1,
  "name": "John Smith",
  "email": "john@example.com",
  "phone": "+225 07 00 00 00 00",
  "role": "user",
  "updated_at": "2026-05-28T11:00:00Z"
}
```

---

## ⚠️ Erreurs

### 400 Bad Request
```json
{
  "error": "Validation failed",
  "message": "The given data was invalid",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

### 401 Unauthorized
```json
{
  "error": "Unauthorized",
  "message": "Invalid token or token expired"
}
```

### 403 Forbidden
```json
{
  "error": "Forbidden",
  "message": "You do not have permission to access this resource"
}
```

### 404 Not Found
```json
{
  "error": "Not Found",
  "message": "The requested resource was not found"
}
```

### 500 Internal Server Error
```json
{
  "error": "Internal Server Error",
  "message": "An unexpected error occurred"
}
```

---

## 🔒 CORS Configuration

Laravel doit configurer CORS pour autoriser les requêtes depuis Django :

```php
// config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:8001', 'http://127.0.0.1:8001'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

---

## 📝 Notes d'Implémentation

### Headers Requis
```
Content-Type: application/json
Authorization: Bearer {token}
Accept: application/json
```

### Pagination
- Par défaut : 15 items par page
- Utiliser query parameters `page` et `per_page`
- Response inclut `meta` avec informations pagination

### Format de Date
- Format ISO 8601 : `YYYY-MM-DDTHH:mm:ssZ`
- Timezone : UTC

### Montants
- Format : FCFA (Franc CFA)
- Type : integer (sans décimales)
