# Order System - Inventory Management

## How It Works

### 1. Quantity Reduction on Order Creation ✅

When a user creates an order, the system **automatically reduces** the deal quantity.

#### Example Scenario

**Before Order:**
```
Deal #7: "بوفيه فطور 5 نجوم"
- Quantity: 10 items
- Buyer Counter: 5 people
```

**User Creates Order:**
```json
POST /api/orders
{
    "deal_id": 7,
    "quantity": 3,
    "payment_method": "cash_on_delivery"
}
```

**After Order:**
```
Deal #7: "بوفيه فطور 5 نجوم"
- Quantity: 7 items (10 - 3 = 7) ✅
- Buyer Counter: 8 people (5 + 3 = 8) ✅
```

#### Code Implementation

```php
// In OrderController@store (line 109-110)
$deal->decrement('quantity', $validated['quantity']);
$deal->increment('buyer_counter', $validated['quantity']);
```

**What happens:**
- `decrement('quantity', 3)` → Reduces stock by 3
- `increment('buyer_counter', 3)` → Increases buyer count by 3

---

### 2. Quantity Restoration on Order Cancellation ✅

When a user cancels an order, the system **restores** the deal quantity.

#### Example Scenario

**Before Cancellation:**
```
Deal #7: "بوفيه فطور 5 نجوم"
- Quantity: 7 items
- Buyer Counter: 8 people

Order #1:
- Quantity: 3 items
- Status: pending
```

**User Cancels Order:**
```json
POST /api/orders/1/cancel
{
    "reason": "لم أعد بحاجة للطلب"
}
```

**After Cancellation:**
```
Deal #7: "بوفيه فطور 5 نجوم"
- Quantity: 10 items (7 + 3 = 10) ✅
- Buyer Counter: 5 people (8 - 3 = 5) ✅

Order #1:
- Quantity: 3 items
- Status: cancelled ✅
```

#### Code Implementation

```php
// In OrderController@cancel (line 313-316)
if ($order->deal) {
    $order->deal->increment('quantity', $order->quantity);
    $order->deal->decrement('buyer_counter', $order->quantity);
}
```

**What happens:**
- `increment('quantity', 3)` → Adds back 3 items to stock
- `decrement('buyer_counter', 3)` → Reduces buyer count by 3

---

### 3. Deal Expiration Check ✅

Before allowing an order, the system checks if the deal is expired.

#### Example Scenario

**Deal #7:**
```
Title: "بوفيه فطور 5 نجوم"
Status: active
Start Date: 2026-01-27 00:00:00
End Date: 2026-02-07 23:59:59
Current Date: 2026-02-08 10:00:00 (EXPIRED!)
```

**User Tries to Order:**
```json
POST /api/orders
{
    "deal_id": 7,
    "quantity": 1,
    "payment_method": "cash_on_delivery"
}
```

**Response (409 Conflict):**
```json
{
    "success": false,
    "message": "فشل إنشاء الطلب",
    "errors": {
        "deal_id": ["العرض غير متوفر"]
    }
}
```

**Order is REJECTED** ❌

#### Code Implementation

```php
// In OrderController@store (line 47-50)
$now = Carbon::now();
$isAvailable = $deal->status === 'active' 
    && $deal->start_date <= $now 
    && $deal->end_date >= $now;

if (!$isAvailable) {
    return response()->json([
        'success' => false,
        'message' => 'فشل إنشاء الطلب',
        'errors' => [
            'deal_id' => ['العرض غير متوفر']
        ],
    ], 409);
}
```

**Checks:**
1. ✅ Deal status is 'active'
2. ✅ Deal has started (start_date <= now)
3. ✅ Deal hasn't expired (end_date >= now)

If **any check fails**, order is rejected.

---

### 4. Stock Availability Check ✅

Before allowing an order, the system checks if enough stock is available.

#### Example Scenario

**Deal #7:**
```
Title: "بوفيه فطور 5 نجوم"
Quantity: 2 items (only 2 left!)
```

**User Tries to Order 5 Items:**
```json
POST /api/orders
{
    "deal_id": 7,
    "quantity": 5,
    "payment_method": "cash_on_delivery"
}
```

**Response (409 Conflict):**
```json
{
    "success": false,
    "message": "فشل إنشاء الطلب",
    "errors": {
        "quantity": ["الكمية المطلوبة غير متوفرة في المخزون"]
    }
}
```

**Order is REJECTED** ❌

#### Code Implementation

```php
// In OrderController@store (line 62-71)
if ($deal->quantity < $validated['quantity']) {
    return response()->json([
        'success' => false,
        'message' => 'فشل إنشاء الطلب',
        'errors' => [
            'quantity' => ['الكمية المطلوبة غير متوفرة في المخزون']
        ],
    ], 409);
}
```

**Check:**
- If requested quantity > available quantity → REJECT

---

## Complete Flow Diagram

```
User Creates Order (quantity: 3)
         ↓
    Check Deal Status
         ↓
    Is Active? ──NO──→ REJECT (العرض غير متوفر)
         ↓ YES
    Check Dates
         ↓
    Not Expired? ──NO──→ REJECT (العرض غير متوفر)
         ↓ YES
    Check Stock
         ↓
    Enough Stock? ──NO──→ REJECT (الكمية غير متوفرة)
         ↓ YES
    Create Order
         ↓
    Reduce Quantity (-3)
         ↓
    Increase Buyer Counter (+3)
         ↓
    SUCCESS ✅
```

---

## Testing Examples

### Test 1: Order Reduces Quantity

```bash
# Check initial quantity
php artisan tinker
>>> $deal = App\Models\Deal::find(7);
>>> echo "Quantity: " . $deal->quantity;
# Output: Quantity: 10

# Create order via API
POST /api/orders
{
    "deal_id": 7,
    "quantity": 3,
    "payment_method": "cash_on_delivery"
}

# Check quantity after order
>>> $deal->refresh();
>>> echo "Quantity: " . $deal->quantity;
# Output: Quantity: 7 ✅
```

### Test 2: Cancellation Restores Quantity

```bash
# Check quantity before cancellation
>>> $deal = App\Models\Deal::find(7);
>>> echo "Quantity: " . $deal->quantity;
# Output: Quantity: 7

# Cancel order via API
POST /api/orders/1/cancel
{
    "reason": "Test cancellation"
}

# Check quantity after cancellation
>>> $deal->refresh();
>>> echo "Quantity: " . $deal->quantity;
# Output: Quantity: 10 ✅
```

### Test 3: Expired Deal Rejection

```bash
# Set deal to expired
>>> $deal = App\Models\Deal::find(7);
>>> $deal->end_date = now()->subDays(1);
>>> $deal->save();

# Try to create order
POST /api/orders
{
    "deal_id": 7,
    "quantity": 1,
    "payment_method": "cash_on_delivery"
}

# Response: 409 Conflict
{
    "success": false,
    "message": "فشل إنشاء الطلب",
    "errors": {
        "deal_id": ["العرض غير متوفر"]
    }
}
```

### Test 4: Out of Stock Rejection

```bash
# Set deal quantity to 2
>>> $deal = App\Models\Deal::find(7);
>>> $deal->quantity = 2;
>>> $deal->save();

# Try to order 5 items
POST /api/orders
{
    "deal_id": 7,
    "quantity": 5,
    "payment_method": "cash_on_delivery"
}

# Response: 409 Conflict
{
    "success": false,
    "message": "فشل إنشاء الطلب",
    "errors": {
        "quantity": ["الكمية المطلوبة غير متوفرة في المخزون"]
    }
}
```

---

## Database Transactions ✅

All inventory updates use **database transactions** to ensure data consistency:

```php
DB::beginTransaction();

try {
    // Create order
    $order = Order::create([...]);
    
    // Update inventory
    $deal->decrement('quantity', $validated['quantity']);
    $deal->increment('buyer_counter', $validated['quantity']);
    
    DB::commit(); // ✅ All changes saved together
    
} catch (\Exception $e) {
    DB::rollBack(); // ❌ If error, undo all changes
    throw $e;
}
```

**Benefits:**
- If order creation fails, inventory is NOT updated
- If inventory update fails, order is NOT created
- Data is always consistent

---

## Summary

### ✅ Quantity Management
- **Order Creation**: Automatically reduces deal quantity
- **Order Cancellation**: Automatically restores deal quantity
- **Buyer Counter**: Automatically updated both ways

### ✅ Deal Validation
- **Status Check**: Must be 'active'
- **Date Check**: Must not be expired
- **Stock Check**: Must have enough quantity

### ✅ Data Consistency
- **Transactions**: All or nothing approach
- **Rollback**: Automatic on errors
- **Integrity**: Data always consistent

---

**Everything is already implemented and working!** 🎉

Test it with the Postman collection to see it in action.
