# Order API - Request & Response Examples

Complete examples for frontend integration.

---

## 1. CREATE ORDER

### Request
```http
POST /api/orders HTTP/1.1
Host: 10.78.142.13:8000
Authorization: Bearer 1|abc123xyz...
Accept: application/json
Content-Type: application/json

{
    "deal_id": 7,
    "quantity": 2,
    "payment_method": "cash_on_delivery",
    "notes": "يرجى التوصيل بعد الساعة 5 مساءً"
}
```

### Success Response (201 Created)
```json
{
    "success": true,
    "message": "تم إنشاء الطلب بنجاح",
    "data": {
        "order": {
            "id": 1,
            "order_number": "ORD-2026-00001",
            "user_id": 1,
            "deal_id": 7,
            "deal_title": "بدأ يومك بأناقة مع بوفيه فطور 5 نجوم في مطعم انفي - فندق شاطئ أرابيلا",
            "merchant_name": "مركز سبا",
            "quantity": 2,
            "unit_price": 345.00,
            "total_price": 690.00,
            "discount_amount": 0.00,
            "final_price": 690.00,
            "payment_method": "cash_on_delivery",
            "payment_status": "pending",
            "order_status": "pending",
            "notes": "يرجى التوصيل بعد الساعة 5 مساءً",
            "created_at": "2026-02-01T22:54:32+00:00",
            "estimated_delivery": "2026-02-04T22:54:32+00:00"
        }
    }
}
```

### Error Response - Out of Stock (409 Conflict)
```json
{
    "success": false,
    "message": "فشل إنشاء الطلب",
    "errors": {
        "quantity": [
            "الكمية المطلوبة غير متوفرة في المخزون"
        ]
    }
}
```

### Error Response - Deal Not Available (409 Conflict)
```json
{
    "success": false,
    "message": "فشل إنشاء الطلب",
    "errors": {
        "deal_id": [
            "العرض غير متوفر"
        ]
    }
}
```

### Error Response - Validation Failed (422)
```json
{
    "success": false,
    "message": "فشل التحقق من البيانات",
    "errors": {
        "deal_id": [
            "The deal id field is required."
        ],
        "quantity": [
            "The quantity must be at least 1.",
            "The quantity must not be greater than 10."
        ],
        "payment_method": [
            "The selected payment method is invalid."
        ]
    }
}
```

---

## 2. GET USER ORDERS

### Request
```http
GET /api/orders?page=1&per_page=10&status=all HTTP/1.1
Host: 10.78.142.13:8000
Authorization: Bearer 1|abc123xyz...
Accept: application/json
```

### Success Response (200 OK)
```json
{
    "success": true,
    "message": "تم جلب الطلبات بنجاح",
    "data": [
        {
            "id": 1,
            "order_number": "ORD-2026-00001",
            "deal": {
                "id": 7,
                "title": "بدأ يومك بأناقة مع بوفيه فطور 5 نجوم في مطعم انفي - فندق شاطئ أرابيلا",
                "image": "http://10.78.142.13:8000/storage/deal-images/DzL5BQ6H9VoLSRvO6DGWmGJiZIjszTNdE7OQbVDo.png",
                "merchant_name": "مركز سبا"
            },
            "quantity": 2,
            "final_price": 690.00,
            "payment_method": "cash_on_delivery",
            "payment_status": "pending",
            "order_status": "pending",
            "created_at": "2026-02-01T22:54:32+00:00",
            "estimated_delivery": "2026-02-04T22:54:32+00:00"
        },
        {
            "id": 2,
            "order_number": "ORD-2026-00002",
            "deal": {
                "id": 8,
                "title": "تذكرة طيران مقدمة من وكيل رحلات الشاطئ",
                "image": "http://10.78.142.13:8000/storage/deal-images/iaGHZdZx4eaeQrSrNbT4dG4zbG01ZDzVML294qdu.png",
                "merchant_name": "الشاطئ"
            },
            "quantity": 1,
            "final_price": 100.00,
            "payment_method": "credit_card",
            "payment_status": "pending",
            "order_status": "confirmed",
            "created_at": "2026-02-01T20:30:00+00:00",
            "estimated_delivery": "2026-02-04T20:30:00+00:00"
        }
    ],
    "pagination": {
        "total": 2,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1,
        "from": 1,
        "to": 2
    }
}
```

### Empty Response (200 OK)
```json
{
    "success": true,
    "message": "تم جلب الطلبات بنجاح",
    "data": [],
    "pagination": {
        "total": 0,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1,
        "from": null,
        "to": null
    }
}
```

---

## 3. GET ORDER DETAILS

### Request
```http
GET /api/orders/1 HTTP/1.1
Host: 10.78.142.13:8000
Authorization: Bearer 1|abc123xyz...
Accept: application/json
```

### Success Response (200 OK)
```json
{
    "success": true,
    "message": "تم جلب تفاصيل الطلب بنجاح",
    "data": {
        "id": 1,
        "order_number": "ORD-2026-00001",
        "user": {
            "id": 1,
            "name": "أحمد محمد",
            "phone": "963987654321",
            "email": "ahmad@example.com"
        },
        "deal": {
            "id": 7,
            "title": "بدأ يومك بأناقة مع بوفيه فطور 5 نجوم في مطعم انفي - فندق شاطئ أرابيلا",
            "description": "استمتع بوجبة فطور فاخرة في مطعم انفي الموجود في فندق شاطئ أرابيلا",
            "image": "http://10.78.142.13:8000/storage/deal-images/DzL5BQ6H9VoLSRvO6DGWmGJiZIjszTNdE7OQbVDo.png",
            "merchant": {
                "id": 1,
                "name": "مركز سبا",
                "phone": "+963984256128",
                "email": "alor62@gmail.com"
            },
            "location": {
                "city": "دمشق",
                "area": "المزة",
                "location_name": "فندق شاطئ أرابيلا",
                "latitude": 33.5138,
                "longitude": 36.2765
            }
        },
        "quantity": 2,
        "unit_price": 345.00,
        "total_price": 690.00,
        "discount_amount": 0.00,
        "final_price": 690.00,
        "payment_method": "cash_on_delivery",
        "payment_status": "pending",
        "order_status": "pending",
        "notes": "يرجى التوصيل بعد الساعة 5 مساءً",
        "created_at": "2026-02-01T22:54:32+00:00",
        "updated_at": "2026-02-01T22:54:32+00:00",
        "estimated_delivery": "2026-02-04T22:54:32+00:00",
        "status_history": [
            {
                "status": "pending",
                "timestamp": "2026-02-01T22:54:32+00:00",
                "note": "تم إنشاء الطلب"
            }
        ]
    }
}
```

### Error Response - Not Found (404)
```json
{
    "success": false,
    "message": "الطلب غير موجود"
}
```

### Error Response - Unauthorized (403)
```json
{
    "success": false,
    "message": "غير مسموح"
}
```

---

## 4. CANCEL ORDER

### Request
```http
POST /api/orders/1/cancel HTTP/1.1
Host: 10.78.142.13:8000
Authorization: Bearer 1|abc123xyz...
Accept: application/json
Content-Type: application/json

{
    "reason": "لم أعد بحاجة للطلب"
}
```

### Success Response (200 OK)
```json
{
    "success": true,
    "message": "تم إلغاء الطلب بنجاح",
    "data": {
        "order_id": 1,
        "order_status": "cancelled",
        "cancelled_at": "2026-02-01T23:15:00+00:00"
    }
}
```

### Error Response - Cannot Cancel (400)
```json
{
    "success": false,
    "message": "لا يمكن إلغاء هذا الطلب",
    "errors": {
        "order_status": [
            "يمكن إلغاء الطلبات في حالة \"قيد الانتظار\" أو \"مؤكد\" فقط"
        ]
    }
}
```

---

## Frontend Implementation Examples

### React Native

```javascript
import React, { useState } from 'react';
import { View, Text, Button, Alert } from 'react-native';

const OrderScreen = () => {
    const [loading, setLoading] = useState(false);
    const authToken = 'YOUR_AUTH_TOKEN'; // Get from login

    // Create Order
    const createOrder = async (dealId, quantity, paymentMethod, notes) => {
        setLoading(true);
        try {
            const response = await fetch('http://10.78.142.13:8000/api/orders', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    deal_id: dealId,
                    quantity: quantity,
                    payment_method: paymentMethod,
                    notes: notes,
                }),
            });

            const data = await response.json();

            if (data.success) {
                Alert.alert('نجح', data.message);
                console.log('Order created:', data.data.order);
                // Navigate to order details or orders list
            } else {
                Alert.alert('خطأ', data.message);
                console.error('Errors:', data.errors);
            }
        } catch (error) {
            Alert.alert('خطأ', 'حدث خطأ في الاتصال');
            console.error('Error:', error);
        } finally {
            setLoading(false);
        }
    };

    // Get Orders
    const fetchOrders = async (page = 1, status = 'all') => {
        try {
            const response = await fetch(
                `http://10.78.142.13:8000/api/orders?page=${page}&per_page=10&status=${status}`,
                {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                    },
                }
            );

            const data = await response.json();

            if (data.success) {
                console.log('Orders:', data.data);
                console.log('Pagination:', data.pagination);
                return data.data;
            }
        } catch (error) {
            console.error('Error fetching orders:', error);
        }
    };

    // Get Order Details
    const fetchOrderDetails = async (orderId) => {
        try {
            const response = await fetch(
                `http://10.78.142.13:8000/api/orders/${orderId}`,
                {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                    },
                }
            );

            const data = await response.json();

            if (data.success) {
                console.log('Order details:', data.data);
                return data.data;
            }
        } catch (error) {
            console.error('Error fetching order details:', error);
        }
    };

    // Cancel Order
    const cancelOrder = async (orderId, reason) => {
        try {
            const response = await fetch(
                `http://10.78.142.13:8000/api/orders/${orderId}/cancel`,
                {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ reason }),
                }
            );

            const data = await response.json();

            if (data.success) {
                Alert.alert('نجح', data.message);
                // Refresh orders list
                fetchOrders();
            } else {
                Alert.alert('خطأ', data.message);
            }
        } catch (error) {
            console.error('Error cancelling order:', error);
        }
    };

    return (
        <View>
            <Button
                title="Create Test Order"
                onPress={() => createOrder(7, 1, 'cash_on_delivery', 'Test order')}
                disabled={loading}
            />
        </View>
    );
};

export default OrderScreen;
```

### Flutter/Dart

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class OrderService {
  final String baseUrl = 'http://10.78.142.13:8000/api';
  final String authToken;

  OrderService(this.authToken);

  // Create Order
  Future<Map<String, dynamic>> createOrder({
    required int dealId,
    required int quantity,
    required String paymentMethod,
    String? notes,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/orders'),
        headers: {
          'Authorization': 'Bearer $authToken',
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: jsonEncode({
          'deal_id': dealId,
          'quantity': quantity,
          'payment_method': paymentMethod,
          'notes': notes,
        }),
      );

      return jsonDecode(response.body);
    } catch (e) {
      print('Error creating order: $e');
      rethrow;
    }
  }

  // Get Orders
  Future<Map<String, dynamic>> getOrders({
    int page = 1,
    int perPage = 10,
    String status = 'all',
  }) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/orders?page=$page&per_page=$perPage&status=$status'),
        headers: {
          'Authorization': 'Bearer $authToken',
          'Accept': 'application/json',
        },
      );

      return jsonDecode(response.body);
    } catch (e) {
      print('Error fetching orders: $e');
      rethrow;
    }
  }

  // Get Order Details
  Future<Map<String, dynamic>> getOrderDetails(int orderId) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/orders/$orderId'),
        headers: {
          'Authorization': 'Bearer $authToken',
          'Accept': 'application/json',
        },
      );

      return jsonDecode(response.body);
    } catch (e) {
      print('Error fetching order details: $e');
      rethrow;
    }
  }

  // Cancel Order
  Future<Map<String, dynamic>> cancelOrder(int orderId, {String? reason}) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/orders/$orderId/cancel'),
        headers: {
          'Authorization': 'Bearer $authToken',
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: jsonEncode({
          'reason': reason,
        }),
      );

      return jsonDecode(response.body);
    } catch (e) {
      print('Error cancelling order: $e');
      rethrow;
    }
  }
}
```

---

## Status Codes Reference

| Code | Meaning | When It Happens |
|------|---------|-----------------|
| 200 | OK | Successful GET/POST request |
| 201 | Created | Order created successfully |
| 400 | Bad Request | Invalid data or cannot process |
| 401 | Unauthorized | Missing or invalid auth token |
| 403 | Forbidden | User not allowed to access resource |
| 404 | Not Found | Order or deal doesn't exist |
| 409 | Conflict | Deal unavailable or out of stock |
| 422 | Unprocessable Entity | Validation failed |
| 500 | Server Error | Something went wrong on server |

---

## Payment Methods

| Value | Arabic | Description |
|-------|--------|-------------|
| `cash_on_delivery` | الدفع عند الاستلام | Cash on delivery |
| `credit_card` | بطاقة ائتمان | Credit card payment |
| `wallet` | محفظة إلكترونية | Digital wallet |

---

## Order Status Values

| Value | Arabic | Description |
|-------|--------|-------------|
| `pending` | قيد الانتظار | Waiting for confirmation |
| `confirmed` | مؤكد | Order confirmed |
| `preparing` | قيد التحضير | Being prepared |
| `ready` | جاهز | Ready for pickup/delivery |
| `delivered` | تم التسليم | Successfully delivered |
| `cancelled` | ملغي | Order cancelled |

---

## Payment Status Values

| Value | Arabic | Description |
|-------|--------|-------------|
| `pending` | قيد الانتظار | Payment pending |
| `paid` | مدفوع | Payment completed |
| `failed` | فشل | Payment failed |
| `refunded` | مسترد | Payment refunded |

---

**Ready to integrate!** Use these examples as reference for your frontend implementation.
