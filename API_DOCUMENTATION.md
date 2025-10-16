# Car Rental System - REST API Documentation

## Overview
This document provides comprehensive documentation for the Car Rental System REST API. The API follows RESTful principles and uses JSON for data exchange.

## Base URL
```
http://your-domain.com/api/v1
```

## Authentication
The API uses Laravel Sanctum for authentication. Include the Bearer token in the Authorization header:

```
Authorization: Bearer {your-token}
```

## Response Format
All API responses follow a consistent format:

### Success Response
```json
{
    "data": {
        // Response data
    },
    "message": "Success message",
    "status": "success"
}
```

### Error Response
```json
{
    "message": "Error message",
    "errors": {
        "field": ["Validation error message"]
    },
    "status": "error"
}
```

## Endpoints

### Public Endpoints (No Authentication Required)

#### 1. Get All Cars
**GET** `/cars`

Retrieve a paginated list of available cars.

**Query Parameters:**
- `search` (string): Search by car name, location, or type
- `type` (string): Filter by car type
- `location` (string): Filter by location
- `min_price` (number): Minimum price per day
- `max_price` (number): Maximum price per day
- `per_page` (number): Number of items per page (default: 12)

**Example Request:**
```
GET /api/v1/cars?search=Toyota&type=Sedan&min_price=50&max_price=200
```

**Example Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Toyota Camry",
            "type": "Sedan",
            "location": "New York",
            "price_per_day": "75.00",
            "image": "cars/toyota-camry.jpg",
            "description": "Comfortable sedan perfect for city driving",
            "is_available": true,
            "supplier": {
                "id": 2,
                "name": "John Supplier",
                "email": "john@supplier.com"
            },
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ],
    "links": {
        "first": "http://localhost/api/v1/cars?page=1",
        "last": "http://localhost/api/v1/cars?page=5",
        "prev": null,
        "next": "http://localhost/api/v1/cars?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "per_page": 12,
        "to": 12,
        "total": 50
    }
}
```

#### 2. Get Single Car
**GET** `/cars/{id}`

Retrieve details of a specific car.

**Example Request:**
```
GET /api/v1/cars/1
```

**Example Response:**
```json
{
    "data": {
        "id": 1,
        "name": "Toyota Camry",
        "type": "Sedan",
        "location": "New York",
        "price_per_day": "75.00",
        "image": "cars/toyota-camry.jpg",
        "description": "Comfortable sedan perfect for city driving",
        "is_available": true,
        "supplier": {
            "id": 2,
            "name": "John Supplier",
            "email": "john@supplier.com"
        },
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### 3. Check Car Availability
**POST** `/cars/{id}/check-availability`

Check if a car is available for specific dates.

**Request Body:**
```json
{
    "start_date": "2024-02-01",
    "end_date": "2024-02-05"
}
```

**Example Response:**
```json
{
    "available": true,
    "message": "Car is available for the selected dates.",
    "total_days": 5,
    "total_amount": "375.00"
}
```

#### 4. Book a Car
**POST** `/cars/{id}/book`

Create a new booking for a car.

**Request Body:**
```json
{
    "start_date": "2024-02-01",
    "end_date": "2024-02-05",
    "customer_name": "John Doe",
    "customer_email": "john@example.com",
    "customer_phone": "+1234567890",
    "notes": "Special requirements"
}
```

**Example Response:**
```json
{
    "data": {
        "id": 1,
        "user_id": null,
        "car_id": 1,
        "start_date": "2024-02-01",
        "end_date": "2024-02-05",
        "total_amount": "375.00",
        "status": "pending",
        "notes": "Special requirements",
        "customer_name": "John Doe",
        "customer_email": "john@example.com",
        "customer_phone": "+1234567890",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    },
    "message": "Booking created successfully"
}
```

### Authenticated Endpoints

#### 5. Get User Bookings
**GET** `/bookings`

Retrieve bookings for the authenticated user.

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `status` (string): Filter by booking status
- `per_page` (number): Number of items per page

**Example Response:**
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "car_id": 1,
            "start_date": "2024-02-01",
            "end_date": "2024-02-05",
            "total_amount": "375.00",
            "status": "confirmed",
            "notes": "Special requirements",
            "customer_name": "John Doe",
            "customer_email": "john@example.com",
            "customer_phone": "+1234567890",
            "car": {
                "id": 1,
                "name": "Toyota Camry",
                "type": "Sedan",
                "location": "New York",
                "price_per_day": "75.00"
            },
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### 6. Get Single Booking
**GET** `/bookings/{id}`

Retrieve details of a specific booking.

**Example Response:**
```json
{
    "data": {
        "id": 1,
        "user_id": 1,
        "car_id": 1,
        "start_date": "2024-02-01",
        "end_date": "2024-02-05",
        "total_amount": "375.00",
        "status": "confirmed",
        "notes": "Special requirements",
        "customer_name": "John Doe",
        "customer_email": "john@example.com",
        "customer_phone": "+1234567890",
        "car": {
            "id": 1,
            "name": "Toyota Camry",
            "type": "Sedan",
            "location": "New York",
            "price_per_day": "75.00",
            "supplier": {
                "id": 2,
                "name": "John Supplier",
                "email": "john@supplier.com"
            }
        },
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### 7. Cancel Booking
**POST** `/bookings/{id}/cancel`

Cancel a booking.

**Example Response:**
```json
{
    "message": "Booking cancelled successfully.",
    "data": {
        "id": 1,
        "status": "cancelled",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

## Error Codes

| Code | Description |
|------|-------------|
| 200  | Success |
| 201  | Created |
| 400  | Bad Request |
| 401  | Unauthorized |
| 403  | Forbidden |
| 404  | Not Found |
| 422  | Validation Error |
| 500  | Internal Server Error |

## Validation Rules

### Car Booking
- `start_date`: Required, must be a valid date, must be today or later
- `end_date`: Required, must be a valid date, must be after start_date
- `customer_name`: Required, string, max 255 characters
- `customer_email`: Required, valid email address
- `customer_phone`: Required, string, max 20 characters
- `notes`: Optional, string

### Availability Check
- `start_date`: Required, must be a valid date, must be today or later
- `end_date`: Required, must be a valid date, must be after start_date

## Rate Limiting
API requests are rate-limited to 60 requests per minute per IP address.

## Postman Collection
You can import the following Postman collection to test the API:

```json
{
    "info": {
        "name": "Car Rental System API",
        "description": "Complete API collection for Car Rental System",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    },
    "item": [
        {
            "name": "Get All Cars",
            "request": {
                "method": "GET",
                "header": [],
                "url": {
                    "raw": "{{base_url}}/api/v1/cars",
                    "host": ["{{base_url}}"],
                    "path": ["api", "v1", "cars"]
                }
            }
        },
        {
            "name": "Get Single Car",
            "request": {
                "method": "GET",
                "header": [],
                "url": {
                    "raw": "{{base_url}}/api/v1/cars/1",
                    "host": ["{{base_url}}"],
                    "path": ["api", "v1", "cars", "1"]
                }
            }
        },
        {
            "name": "Check Availability",
            "request": {
                "method": "POST",
                "header": [
                    {
                        "key": "Content-Type",
                        "value": "application/json"
                    }
                ],
                "body": {
                    "mode": "raw",
                    "raw": "{\n    \"start_date\": \"2024-02-01\",\n    \"end_date\": \"2024-02-05\"\n}"
                },
                "url": {
                    "raw": "{{base_url}}/api/v1/cars/1/check-availability",
                    "host": ["{{base_url}}"],
                    "path": ["api", "v1", "cars", "1", "check-availability"]
                }
            }
        },
        {
            "name": "Book Car",
            "request": {
                "method": "POST",
                "header": [
                    {
                        "key": "Content-Type",
                        "value": "application/json"
                    }
                ],
                "body": {
                    "mode": "raw",
                    "raw": "{\n    \"start_date\": \"2024-02-01\",\n    \"end_date\": \"2024-02-05\",\n    \"customer_name\": \"John Doe\",\n    \"customer_email\": \"john@example.com\",\n    \"customer_phone\": \"+1234567890\",\n    \"notes\": \"Special requirements\"\n}"
                },
                "url": {
                    "raw": "{{base_url}}/api/v1/cars/1/book",
                    "host": ["{{base_url}}"],
                    "path": ["api", "v1", "cars", "1", "book"]
                }
            }
        }
    ],
    "variable": [
        {
            "key": "base_url",
            "value": "http://localhost:8000"
        }
    ]
}
```

## Testing the API

### Using cURL

#### Get All Cars
```bash
curl -X GET "http://localhost:8000/api/v1/cars" \
     -H "Accept: application/json"
```

#### Check Availability
```bash
curl -X POST "http://localhost:8000/api/v1/cars/1/check-availability" \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{
         "start_date": "2024-02-01",
         "end_date": "2024-02-05"
     }'
```

#### Book a Car
```bash
curl -X POST "http://localhost:8000/api/v1/cars/1/book" \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{
         "start_date": "2024-02-01",
         "end_date": "2024-02-05",
         "customer_name": "John Doe",
         "customer_email": "john@example.com",
         "customer_phone": "+1234567890",
         "notes": "Special requirements"
     }'
```

## Support
For API support or questions, please contact the development team or refer to the main application documentation.
