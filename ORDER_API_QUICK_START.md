# Order API - Quick Start Guide

## Setup Complete ✅

The order system is ready to use! Follow these steps to test it.

---

## Step 1: Import Postman Collection

1. Open Postman
2. Click **Import**
3. Select file: `postman/Orders_API.postman_collection.json`
4. Collection "Orders API" will be added

---

## Step 2: Set Variables

In Postman, update the collection variables:

1. Click on "Orders API" collection
2. Go to **Variables** tab
3. Set values:
   - `base_url`: `http://10.78.142.13:8000` (or your server URL)
   - `auth_token`: Your authentication token (get from login)

---

## Step 3: Get Authentication Token

### Option 1: Use Existing Token
If you already have a token from login, use it.

### Option 2: Login to Get Token

**Endpoint:** `POST /api/login`

**Request:**
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "token": "1|abc123xyz...",
        "user": {...}
    }
}
```

Copy the `token` value and paste it in Postman variable `auth_token`.

---

## Step 4: Test Create Order

### Request
```
POST /api/orders
Authorization: Bearer {your_token}
```

**Body:**
```json
{
    "deal_id": 7,
    "quantity": 1,
    "payment_method": "cash_on_delivery",
    "notes": "Test order"
}
```

### Expected Response (201 Created)
```json
{
    "success": true,
    "message": "تم إنشاء الطلب بنجاح",
    "data": {
        "order": {
            "id": 1,
            "order_number": "ORD-2026-00001",
            "deal_title": "بدأ يومك بأناقة...",
            "quantity": 1,
            "final_price": 345.00,
            "order_status": "pending",
            ...
        }
    }
}
```

---

## Step 5: Test Get Orders

### Request
```
GET /api/orders?page=1&per_page=10
Authorization: Bearer {your_token}
```

### Expected Response (200 OK)
```json
{
    "success": true,
    "message": "تم جلب الطلبات بنجاح",
    "data": [
        {
            "id": 1,
            "order_number": "ORD-2026-00001",
            "deal": {
                "title": "...",
                "image": "...",
                "merchant_name": "..."
            },
            "quantity": 1,
            "final_price": 345.00,
            "order_status": "pending",
            ...
        }
    ],
    "pagination": {
        "total": 1,
        "current_page": 1,
        ...
    }
}
```

---

## Step 6: Test Get Order Details

### Request
```
GET /api/orders/1
Authorization: Bearer {your_token}
```

### Expected Response (200 OK)
Full order details including:
- User information
- Deal information
- Merchant information
- Location details
- Status history

---

## Step 7: Test Cancel Order

### Request
```
POST /api/orders/1/cancel
Authorization: Bearer {your_token}
```

**Body:**
```json
{
    "reason": "لم أعد بحاجة للطلب"
}
```

### Expected Response (200 OK)
```json
{
    "success": true,
    "message": "تم إلغاء الطلب بنجاح",
    "data": {
        "order_id": 1,
        "order_status": "cancelled",
        "cancelled_at": "2026-02-01T23:00:00+00:00"
    }
}
```

---

## Common Issues & Solutions

### Issue 1: "Unauthenticated" Error (401)

**Cause:** Missing or invalid auth token

**Solution:**
1. Make sure you're logged in
2. Get fresh token from `/api/login`
3. Update `auth_token` variable in Postman
4. Ensure header is: `Authorization: Bearer {token}`

---

### Issue 2: "العرض غير متوفر" (409)

**Cause:** Deal is not active or expired

**Solution:**
1. Check deal status is 'active'
2. Check deal dates:
   ```bash
   php artisan tinker
   >>> App\Models\Deal::find(7)->start_date;
   >>> App\Models\Deal::find(7)->end_date;
   ```
3. Update dates if needed (see DEAL_DATES_GUIDE.md)

---

### Issue 3: "الكمية المطلوبة غير متوفرة" (409)

**Cause:** Not enough stock

**Solution:**
1. Check deal quantity:
   ```bash
   php artisan tinker
   >>> App\Models\Deal::find(7)->quantity;
   ```
2. Reduce order quantity or increase deal stock

---

### Issue 4: "الطلب غير موجود" (404)

**Cause:** Order ID doesn't exist or belongs to another user

**Solution:**
1. Check order exists:
   ```bash
   php artisan tinker
   >>> App\Models\Order::find(1);
   ```
2. Make sure you're using correct order ID
3. Verify order belongs to logged-in user

---

## Verification Checklist

Before testing, verify:

- [ ] Migrations ran successfully: `php artisan migrate`
- [ ] You have active deals in database
- [ ] Deals have valid dates (start_date <= now, end_date >= now)
- [ ] Deals have quantity > 0
- [ ] You have a registered user account
- [ ] You can login and get auth token
- [ ] Postman collection is imported
- [ ] Variables are set in Postman

---

## Quick Database Check

Run these commands to verify setup:

```bash
# Check deals
php artisan tinker
>>> App\Models\Deal::where('status', 'active')->count();
# Should be > 0

# Check customers
>>> App\Models\Customer::count();
# Should be > 0

# Check orders table exists
>>> Schema::hasTable('orders');
# Should return true

# Check order_status_history table exists
>>> Schema::hasTable('order_status_history');
# Should return true
```

---

## API Endpoints Summary

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | /api/orders | Create order | ✅ Yes |
| GET | /api/orders | List user orders | ✅ Yes |
| GET | /api/orders/{id} | Get order details | ✅ Yes |
| POST | /api/orders/{id}/cancel | Cancel order | ✅ Yes |

---

## Payment Methods

Currently supported:
- `cash_on_delivery` - الدفع عند الاستلام
- `credit_card` - بطاقة ائتمان
- `wallet` - محفظة إلكترونية

---

## Order Status Values

- `pending` - قيد الانتظار
- `confirmed` - مؤكد
- `preparing` - قيد التحضير
- `ready` - جاهز
- `delivered` - تم التسليم
- `cancelled` - ملغي

---

## Next Steps

1. ✅ Test all endpoints in Postman
2. ✅ Verify order creation updates inventory
3. ✅ Verify cancellation restores inventory
4. ✅ Check status history is recorded
5. ✅ Test with different payment methods
6. ✅ Test pagination and filtering
7. ✅ Integrate with frontend mobile app

---

## Support

If you encounter issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify database structure: `php artisan migrate:status`
3. Test with Postman first before frontend
4. Check authentication is working
5. Verify deal availability and stock

---

**Ready to test!** 🚀

Start with Postman collection and follow the steps above.
