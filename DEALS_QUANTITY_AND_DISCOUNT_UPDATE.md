# Deals Update - Quantity Field & Auto-Calculate Discount

## ✅ Changes Completed

Added quantity field to deals and made discount percentage auto-calculate from original and discounted prices.

## Database Changes

### Migration: Add Quantity Field
✅ Created migration: `database/migrations/2026_01_24_011156_add_quantity_to_deals_table.php`
✅ Added `quantity` INTEGER field (default: 0) to deals table
✅ Migration executed successfully

## Model Updates

### Deal Model (`app/Models/Deal.php`)
✅ Added `quantity` to fillable array
✅ Added `quantity` to casts as integer

## Validation Updates

### StoreDealRequest (`app/Http/Requests/StoreDealRequest.php`)
✅ Added `quantity` validation: nullable, integer, min:0

### UpdateDealRequest (`app/Http/Requests/UpdateDealRequest.php`)
✅ Added `quantity` validation: nullable, integer, min:0

## Form Updates

### Deal Form (`resources/views/pages/deals/partials/form.blade.php`)

#### 1. Quantity Field Added
✅ Added quantity input field after buyer_counter
✅ Field type: number (min: 0)
✅ Placeholder: "Available quantity"
✅ Help text: "Number of items available for this deal"

#### 2. Discount Percentage Auto-Calculation
✅ Made discount_percentage field **readonly**
✅ Added gray background to indicate it's auto-calculated
✅ Added help text: "Automatically calculated from original and discounted prices"
✅ Added IDs to original_price and discounted_price fields for JavaScript

#### 3. JavaScript Auto-Calculation
✅ Added JavaScript to automatically calculate discount percentage
✅ Formula: `((original_price - discounted_price) / original_price) * 100`
✅ Calculates on:
  - Page load (if values exist)
  - Original price input/change
  - Discounted price input/change
✅ Validates that discounted price <= original price
✅ Shows result with 2 decimal places

## How It Works

### Quantity Field
- Admins can now specify how many items are available for each deal
- Field is optional (defaults to 0)
- Can be used to track inventory
- Useful for limited-time or limited-quantity deals

### Auto-Calculate Discount Percentage
1. Admin enters **Original Price** (e.g., $100)
2. Admin enters **Discounted Price** (e.g., $80)
3. **Discount %** automatically calculates and displays: **20.00%**
4. Field is readonly - cannot be manually edited
5. Updates in real-time as prices change

### Calculation Formula
```javascript
discount_percentage = ((original_price - discounted_price) / original_price) * 100
```

### Examples
| Original Price | Discounted Price | Discount % (Auto) |
|----------------|------------------|-------------------|
| $100.00 | $80.00 | 20.00% |
| $50.00 | $35.00 | 30.00% |
| $200.00 | $150.00 | 25.00% |
| $75.00 | $75.00 | 0.00% |

## Form Fields Summary

### Pricing Section (Updated)
1. **Original Price** * (required, number)
2. **Discounted Price** * (required, number, must be <= original price)
3. **Discount %** (auto-calculated, readonly, gray background)
4. **Quantity** (optional, number, min: 0)

### Visual Changes
- Discount % field now has:
  - Gray background (`bg-gray-100`)
  - Readonly attribute
  - Cursor not-allowed
  - Help text explaining it's auto-calculated

## Testing

### Test Auto-Calculation
1. Go to Create Deal or Edit Deal page
2. Enter Original Price: 100
3. Enter Discounted Price: 75
4. Verify Discount % shows: 25.00
5. Change Original Price to 200
6. Verify Discount % updates to: 62.50
7. Change Discounted Price to 150
8. Verify Discount % updates to: 25.00

### Test Quantity Field
1. Go to Create Deal page
2. Enter Quantity: 50
3. Save deal
4. Verify quantity is saved correctly
5. Edit deal and change quantity
6. Verify quantity updates correctly

## Files Modified

1. ✅ **Migration**: `database/migrations/2026_01_24_011156_add_quantity_to_deals_table.php`
2. ✅ **Model**: `app/Models/Deal.php`
3. ✅ **Validation**: `app/Http/Requests/StoreDealRequest.php`
4. ✅ **Validation**: `app/Http/Requests/UpdateDealRequest.php`
5. ✅ **Form**: `resources/views/pages/deals/partials/form.blade.php`

## Benefits

### Quantity Field
- ✅ Track inventory for each deal
- ✅ Manage limited-quantity offers
- ✅ Better stock management
- ✅ Can be used for "Only X left!" messaging

### Auto-Calculate Discount
- ✅ No manual calculation needed
- ✅ Eliminates human error
- ✅ Always accurate
- ✅ Updates in real-time
- ✅ Consistent discount display
- ✅ Saves time for admins

---

**Status**: ✅ Complete and Ready to Use
**Date**: January 24, 2026
