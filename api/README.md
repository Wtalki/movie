# Laravel API Documentation

A comprehensive RESTful API built with Laravel featuring user authentication, product catalog, categories, and order management.

## Features

- **Authentication**: User registration, login, logout with Laravel Sanctum
- **User Management**: Profile management with role-based access control
- **Product Catalog**: CRUD operations for products with categories
- **Category Management**: Organize products into categories
- **Order Management**: Place orders, view order history, and order status management
- **Admin Panel**: Admin-only features for managing the entire system

## Installation

1. **Install Dependencies**:
   ```bash
   cd api
   composer install
   ```

2. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Configuration**:
   Update your `.env` file with database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_api
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run Migrations and Seed Data**:
   ```bash
   php artisan migrate --seed
   ```

5. **Start Development Server**:
   ```bash
   php artisan serve
   ```

## API Endpoints

### Authentication

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/register` | Register new user | No |
| POST | `/api/login` | User login | No |
| POST | `/api/logout` | User logout | Yes |
| GET | `/api/profile` | Get user profile | Yes |
| PUT | `/api/profile` | Update user profile | Yes |

### Categories

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/categories` | List all categories | No |
| GET | `/api/categories/{id}` | Get single category | No |
| GET | `/api/categories/{id}/products` | Get category products | No |
| POST | `/api/categories` | Create category | Admin |
| PUT | `/api/categories/{id}` | Update category | Admin |
| DELETE | `/api/categories/{id}` | Delete category | Admin |

### Products

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/products` | List all products | No |
| GET | `/api/products/featured` | Get featured products | No |
| GET | `/api/products/search` | Search products | No |
| GET | `/api/products/{id}` | Get single product | No |
| POST | `/api/products` | Create product | Admin |
| PUT | `/api/products/{id}` | Update product | Admin |
| DELETE | `/api/products/{id}` | Delete product | Admin |

### Orders

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/orders` | List user orders | Yes |
| POST | `/api/orders` | Create new order | Yes |
| GET | `/api/orders/{id}` | Get single order | Yes |
| PUT | `/api/orders/{id}` | Update order | Admin |
| POST | `/api/orders/{id}/cancel` | Cancel order | Yes |
| GET | `/api/orders/statistics` | Order statistics | Admin |

## Request/Response Examples

### User Registration
```json
POST /api/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "+1234567890"
}
```

### Create Order
```json
POST /api/orders
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
  "billing_address": {
    "name": "John Doe",
    "address": "123 Main St",
    "city": "Anytown",
    "state": "CA",
    "zip": "12345",
    "country": "US"
  },
  "shipping_address": {
    "name": "John Doe",
    "address": "123 Main St",
    "city": "Anytown",
    "state": "CA",
    "zip": "12345",
    "country": "US"
  },
  "notes": "Please handle with care"
}
```

### Response Format
All API responses follow this format:
```json
{
  "success": true,
  "data": {
    // Response data here
  },
  "message": "Success message"
}
```

For paginated responses:
```json
{
  "success": true,
  "data": {
    "items": [...],
    "pagination": {
      "current_page": 1,
      "last_page": 5,
      "per_page": 15,
      "total": 73,
      "from": 1,
      "to": 15
    }
  },
  "message": "Success message"
}
```

## Authentication

The API uses Laravel Sanctum for authentication. Include the bearer token in the Authorization header:

```
Authorization: Bearer {your-token-here}
```

## User Roles

- **User**: Can register, login, view products/categories, place orders, view their orders
- **Admin**: Has all user permissions plus can manage products, categories, and all orders

## Seeded Data

The application comes with pre-seeded data:

### Users
- **Admin**: admin@example.com / password
- **Users**: john@example.com, jane@example.com, bob@example.com / password

### Sample Data
- 6 Categories (Electronics, Clothing, Books, etc.)
- 10+ Products across different categories
- Sample orders for each user

## Query Parameters

### Products
- `active=true/false` - Filter by active status
- `featured=true/false` - Filter featured products
- `category_id=1` - Filter by category
- `in_stock=true/false` - Filter by stock status
- `search=keyword` - Search in name/description
- `min_price=10&max_price=100` - Price range
- `sort_by=price&sort_order=asc` - Sorting
- `per_page=20` - Items per page

### Categories
- `active=true/false` - Filter by active status
- `search=keyword` - Search by name

### Orders
- `status=pending` - Filter by status
- `start_date=2024-01-01` - Date range start
- `end_date=2024-12-31` - Date range end
- `user_id=1` - Filter by user (admin only)

## Error Handling

The API returns appropriate HTTP status codes:

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

## Development

### File Structure
```
api/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── API/
│   │   └── Middleware/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
└── config/
```

### Key Models
- **User**: Authentication and user management
- **Category**: Product categorization
- **Product**: Product catalog with inventory
- **Order**: Order management
- **OrderItem**: Order line items

This API provides a solid foundation for e-commerce applications with proper authentication, authorization, and data management.