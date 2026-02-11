# Order View Image Display Fix

## Problem
Images were not appearing in the order view blade because:
1. Wrong column name: Used `image_path` instead of `image_url`
2. Wrong deal title: Used `title` instead of `title_en` or `title_ar`
3. Wrong merchant name: Used `name` instead of `business_name`
4. No fallback when primary image doesn't exist
5. Missing `deal.images` relationship loading

## Solution Applied

### 1. Fixed Column Names ✅

**Image Column**: Changed from `image_path` to `image_url`
```php
// ❌ WRONG
$order->deal->primaryImage->image_path

// ✅ CORRECT
$order->deal->primaryImage->image_url
```

**Deal Title**: Changed from `title` to `title_en` with fallback to `title_ar`
```php
// ❌ WRONG
$order->deal->title

// ✅ CORRECT
$order->deal->title_en ?? $order->deal->title_ar
```

**Merchant Name**: Changed from `name` to `business_name`
```php
// ❌ WRONG
$order->deal->merchant->name

// ✅ CORRECT
$order->deal->merchant->business_name
```

### 2. Added Image Fallback Logic ✅

The view now:
1. First tries to get the primary image
2. If no primary image, gets the first available image
3. If no images at all, shows a placeholder icon

```php
@php
    $dealImage = null;
    if($order->deal) {
        // Try to get primary image first
        $dealImage = $order->deal->primaryImage;
        // If no primary image, get first image
        if(!$dealImage && $order->deal->images && $order->deal->images->count() > 0) {
            $dealImage = $order->deal->images->first();
        }
    }
@endphp

@if($dealImage)
    <img src="{{ asset('storage/' . $dealImage->image_url) }}" 
         alt="{{ $order->deal->title_en ?? $order->deal->title_ar ?? 'Deal' }}" 
         class="w-16 h-16 object-cover rounded border"
         onerror="this.src='{{ asset('images/placeholder.png') }}'; this.onerror=null;">
@else
    <!-- SVG placeholder icon -->
@endif
```

### 3. Updated Controller to Load Images ✅

**File**: `app/Http/Controllers/OrderController.php`

Added `deal.images` to the eager loading:
```php
public function show(Order $order)
{
    $order->load([
        'user', 
        'deal.merchant', 
        'deal.primaryImage', 
        'deal.images',  // ← Added this
        'statusHistory'
    ]);
    return view('pages.orders.show', compact('order'));
}
```

### 4. Added Error Handling ✅

Added `onerror` attribute to handle broken image links:
```html
<img src="..." onerror="this.src='{{ asset('images/placeholder.png') }}'; this.onerror=null;">
```

## Database Schema Reference

### deal_images Table
```sql
- id
- deal_id (foreign key)
- image_url (string) ← This is the correct column name
- is_primary (boolean)
- created_at
- updated_at
```

### deals Table
```sql
- id
- title_en (string) ← English title
- title_ar (string) ← Arabic title
- description (text)
- merchant_id (foreign key)
- ...
```

### merchants Table
```sql
- id
- business_name (string) ← This is the correct column name
- owner_name (string)
- phone (string)
- email (string)
- ...
```

## Testing Checklist

1. ✅ Navigate to Orders page in dashboard
2. ✅ Click "View" on any order
3. ✅ Verify deal image appears (if deal has images)
4. ✅ Verify placeholder icon appears (if deal has no images)
5. ✅ Verify deal title displays correctly
6. ✅ Verify merchant name displays correctly
7. ✅ Verify all order details are visible

## Files Modified

1. `resources/views/pages/orders/show.blade.php`
   - Fixed image column name from `image_path` to `image_url`
   - Fixed deal title from `title` to `title_en ?? title_ar`
   - Fixed merchant name from `name` to `business_name`
   - Added fallback logic for missing images
   - Added placeholder icon for deals without images
   - Added error handling for broken image links

2. `app/Http/Controllers/OrderController.php`
   - Added `deal.images` to eager loading in `show()` method

## Common Issues & Solutions

### Issue: Image still not showing
**Check**:
1. Is the image file actually in `storage/app/public/` folder?
2. Is the symbolic link created? Run: `php artisan storage:link`
3. Check the `image_url` value in database - does it match the file path?
4. Check browser console for 404 errors

### Issue: Placeholder not showing
**Solution**: The placeholder uses an SVG icon, so it will always show even without an image file.

### Issue: Wrong title language showing
**Solution**: The code uses `title_en` first, then falls back to `title_ar`. To change priority, swap them:
```php
{{ $order->deal->title_ar ?? $order->deal->title_en ?? 'N/A' }}
```

## Image Display Priority

1. **Primary Image** (is_primary = true)
2. **First Image** (if no primary)
3. **Placeholder Icon** (if no images)

This ensures orders always have a visual representation, even if images are missing.
