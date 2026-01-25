# Discount Codes API Documentation

## Overview
This API provides dynamic discount codes for the mobile application. Codes can be managed and updated anytime from the dashboard, and changes are reflected immediately in the API response.

## Endpoints

### 1. Get All Active Codes
**GET** `/api/codes`

Returns all active and valid discount codes.

#### Features
- ✅ Public endpoint (no authentication required)
- ✅ Returns only active codes (is_active = true)
- ✅ Filters out expired codes (valid_to < today)
- ✅ Sorted by created_at (descending - newest first)
- ✅ Dynamic - codes can be changed anytime from dashboard
- ✅ Full image URLs included for easy display

#### Request
```http
GET /api/codes HTTP/1.1
Host: 127.0.0.1:8000
Accept: application/json
```

#### Response Fields
| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique code ID |
| `subject` | string | Code subject/title |
| `code` | string | Discount code (e.g., SUMMER20) |
| `discount_amount` | float | Discount amount in dollars |
| `discount_formatted` | string | Formatted discount (e.g., $20.00) |
| `valid_to` | string\|null | Expiration date (Y-m-d format) |
| `valid_to_formatted` | string\|null | Formatted expiration date |
| `is_expired` | boolean | Whether the code has expired |
| `is_active` | boolean | Whether the code is active |
| `status` | string | Status: "active" or "inactive" |
| `image` | string\|null | Full URL to the image |
| `image_url` | string\|null | Storage path to the image |
| `external_url` | string\|null | External link URL (if exists) |
| `created_at` | string | Creation timestamp |

#### Success Response (200 OK)
```json
{
    "success": true,
    "message": "Codes retrieved successfully",
    "data": [
        {
            "id": 1,
            "subject": "Summer Sale 2026",
            "code": "SUMMER20",
            "discount_amount": 20.00,
            "discount_formatted": "$20.00",
            "valid_to": "2026-12-31",
            "valid_to_formatted": "Dec 31, 2026",
            "is_expired": false,
            "is_active": true,
            "status": "active",
            "image": "http://127.0.0.1:8000/storage/codes/image1.jpg",
            "image_url": "codes/image1.jpg",
            "external_url": "https://play.google.com/store/apps/details?id=com.beeorder.customer",
            "created_at": "2026-01-22 10:30:00"
        },
        {
            "id": 2,
            "subject": "Welcome Discount",
            "code": "WELCOME10",
            "discount_amount": 10.00,
            "discount_formatted": "$10.00",
            "valid_to": null,
            "valid_to_formatted": null,
            "is_expired": false,
            "is_active": true,
            "status": "active",
            "image": "http://127.0.0.1:8000/storage/codes/image2.jpg",
            "image_url": "codes/image2.jpg",
            "external_url": null,
            "created_at": "2026-01-22 10:35:00"
        }
    ]
}
```

#### Empty Response (No Active Codes)
```json
{
    "success": true,
    "message": "Codes retrieved successfully",
    "data": []
}
```

---

### 2. Get Code by Code String
**GET** `/api/codes/{code}`

Get a specific discount code by its code string.

#### Features
- ✅ Public endpoint (no authentication required)
- ✅ Returns code only if active and not expired
- ✅ Case-insensitive code lookup
- ✅ Returns 404 if code not found or expired
- ✅ Perfect for validating codes before applying

#### Request
```http
GET /api/codes/SUMMER20 HTTP/1.1
Host: 127.0.0.1:8000
Accept: application/json
```

#### Success Response (200 OK)
```json
{
    "success": true,
    "message": "Code retrieved successfully",
    "data": {
        "id": 1,
        "subject": "Summer Sale 2026",
        "code": "SUMMER20",
        "discount_amount": 20.00,
        "discount_formatted": "$20.00",
        "valid_to": "2026-12-31",
        "valid_to_formatted": "Dec 31, 2026",
        "is_expired": false,
        "is_active": true,
        "status": "active",
        "image": "http://127.0.0.1:8000/storage/codes/image1.jpg",
        "image_url": "codes/image1.jpg",
        "external_url": "https://play.google.com/store/apps/details?id=com.beeorder.customer",
        "created_at": "2026-01-22 10:30:00"
    }
}
```

#### Error Response - Code Not Found (404)
```json
{
    "success": false,
    "message": "Code not found or expired"
}
```

#### Error Response - Server Error (500)
```json
{
    "success": false,
    "message": "Failed to retrieve code",
    "error": "Error details here"
}
```

---

## Dashboard Management

Discount codes can be managed from the dashboard at `/codes` route. Administrators can:

1. **Create** new discount codes
2. **Edit** existing codes (subject, code, discount_amount, valid_to, status, image, external_url)
3. **Delete** discount codes
4. **Toggle status** between active/inactive
5. **Set expiration date** using valid_to field
6. **Filter** codes by status (Active/Inactive)
7. **Search** codes by subject or code string

### Code Fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `subject` | string | Yes | Code subject/title |
| `code` | string | Yes | Unique discount code (uppercase) |
| `discount_amount` | decimal | Yes | Discount amount in dollars |
| `valid_to` | date | No | Expiration date (leave empty for no expiry) |
| `is_active` | boolean | No | Active status (default: true) |
| `image` | file | No | Code image (PNG, JPG, WEBP, max 2MB) |
| `external_url` | url | No | External link URL |

### Important Notes
- Only codes with `is_active = true` are returned by the API
- Expired codes (valid_to < today) are automatically filtered out
- Codes with `valid_to = null` never expire
- Changes made in the dashboard are reflected immediately in the API
- The `code` field is case-insensitive in API lookups but stored as uppercase
- The `image` field returns the full URL ready for display in mobile apps
- The `external_url` field is optional - use it to link to external pages or deep links

---

## Mobile App Integration

### Display All Codes
```javascript
// Example: Fetch and display all active codes
fetch('http://127.0.0.1:8000/api/codes')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const codes = data.data;
      codes.forEach(code => {
        console.log(code.code); // SUMMER20
        console.log(code.discount_formatted); // $20.00
        console.log(code.valid_to_formatted); // Dec 31, 2026
        console.log(code.is_expired); // false
        console.log(code.image); // Full URL ready to use
      });
    }
  });
```

### Validate a Specific Code
```javascript
// Example: Validate a discount code entered by user
function validateCode(codeString) {
  fetch(`http://127.0.0.1:8000/api/codes/${codeString}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const code = data.data;
        console.log(`Valid code! Discount: ${code.discount_formatted}`);
        console.log(`Expires: ${code.valid_to_formatted || 'Never'}`);
        return code.discount_amount;
      } else {
        console.log('Invalid or expired code');
        return 0;
      }
    });
}
```

### Check Expiration
```javascript
// Example: Check if code is expired
function isCodeExpired(code) {
  if (!code.valid_to) {
    return false; // No expiration date
  }
  return code.is_expired;
}
```

---

## Testing with Postman

1. Import the collection: `postman/Codes_API.postman_collection.json`
2. Set the `base_url` variable to your API URL (default: `http://127.0.0.1:8000`)
3. Test the endpoints:
   - **Get All Active Codes**: Send GET request to `/api/codes`
   - **Get Specific Code**: Send GET request to `/api/codes/SUMMER20`
4. View the responses with all code details

---

## API Workflow

### Get All Codes
```
Mobile App Request
       ↓
GET /api/codes
       ↓
Filter: is_active = true
       ↓
Filter: valid_to >= today OR valid_to IS NULL
       ↓
Sort: created_at DESC
       ↓
Transform to Resource
       ↓
Return JSON Response
```

### Get Specific Code
```
Mobile App Request
       ↓
GET /api/codes/{code}
       ↓
Find: code = {code} (case-insensitive)
       ↓
Filter: is_active = true
       ↓
Filter: valid_to >= today OR valid_to IS NULL
       ↓
Transform to Resource
       ↓
Return JSON Response (or 404)
```

---

## Files Created/Updated

### New Files
1. **Controller**: `app/Http/Controllers/Api/CodeController.php`
2. **Resource**: `app/Http/Resources/Api/CodeResource.php`
3. **Migration**: `database/migrations/2026_01_22_010425_add_valid_to_to_codes_table.php`
4. **Postman Collection**: `postman/Codes_API.postman_collection.json`
5. **Documentation**: `CODES_API_DOCUMENTATION.md`

### Updated Files
1. **Model**: `app/Models/Code.php` (added valid_to field)
2. **Routes**: `routes/api.php` (added code endpoints)
3. **Validation**: `app/Http/Requests/StoreCodeRequest.php` (added valid_to validation)
4. **Validation**: `app/Http/Requests/UpdateCodeRequest.php` (added valid_to validation)
5. **View**: `resources/views/pages/codes/create.blade.php` (added valid_to field)
6. **View**: `resources/views/pages/codes/edit.blade.php` (added valid_to field)
7. **View**: `resources/views/pages/codes/index.blade.php` (added valid_to column)

---

## Database Changes

### Migration: Add valid_to Field
```sql
ALTER TABLE codes ADD COLUMN valid_to DATE NULL AFTER discount_amount;
```

The `valid_to` field:
- Type: DATE (nullable)
- Purpose: Set expiration date for discount codes
- Validation: Must be today or a future date
- Behavior: Codes with `valid_to < today` are filtered out from API
- Optional: Leave empty for codes that never expire

---

**Last Updated**: January 22, 2026
