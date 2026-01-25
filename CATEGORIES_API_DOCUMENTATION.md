# Categories API Documentation

## Overview
This API provides categories with deal counts for the mobile application. Each category includes English and Arabic names, along with the number of deals (products) that belong to it.

## Endpoints

### 1. Get All Categories
**GET** `/api/categories`

Returns all categories with deal counts.

#### Features
- ✅ Public endpoint (no authentication required)
- ✅ Returns all categories
- ✅ Includes deal count for each category
- ✅ Sorted by name_en (ascending)
- ✅ No icons or descriptions (as requested)

#### Request
```http
GET /api/categories HTTP/1.1
Host: 127.0.0.1:8000
Accept: application/json
```

#### Response Fields
| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique category ID |
| `name_en` | string | Category name in English |
| `name_ar` | string | Category name in Arabic |
| `slug` | string | URL-friendly category identifier |
| `deals_count` | integer | Number of deals in this category |
| `products_count` | integer | Alias for deals_count |
| `created_at` | string | Creation timestamp |

#### Success Response (200 OK)
```json
{
    "success": true,
    "message": "Categories retrieved successfully",
    "data": [
        {
            "id": 1,
            "name_en": "Food & Restaurants",
            "name_ar": "الطعام والمطاعم",
            "slug": "food-restaurants",
            "deals_count": 25,
            "products_count": 25,
            "created_at": "2026-01-22 10:30:00"
        },
        {
            "id": 2,
            "name_en": "Beauty & Spa",
            "name_ar": "التجميل والسبا",
            "slug": "beauty-spa",
            "deals_count": 15,
            "products_count": 15,
            "created_at": "2026-01-22 10:35:00"
        },
        {
            "id": 3,
            "name_en": "Entertainment",
            "name_ar": "الترفيه",
            "slug": "entertainment",
            "deals_count": 10,
            "products_count": 10,
            "created_at": "2026-01-22 10:40:00"
        },
        {
            "id": 4,
            "name_en": "Shopping",
            "name_ar": "التسوق",
            "slug": "shopping",
            "deals_count": 0,
            "products_count": 0,
            "created_at": "2026-01-22 10:45:00"
        }
    ]
}
```

#### Empty Response (No Categories)
```json
{
    "success": true,
    "message": "Categories retrieved successfully",
    "data": []
}
```

#### Error Response (500)
```json
{
    "success": false,
    "message": "Failed to retrieve categories",
    "error": "Error details here"
}
```

---

### 2. Get Category by ID
**GET** `/api/categories/{id}`

Get a specific category by ID with deal count.

#### Features
- ✅ Public endpoint (no authentication required)
- ✅ Returns category details with deal count
- ✅ Returns 404 if category not found

#### Request
```http
GET /api/categories/1 HTTP/1.1
Host: 127.0.0.1:8000
Accept: application/json
```

#### Success Response (200 OK)
```json
{
    "success": true,
    "message": "Category retrieved successfully",
    "data": {
        "id": 1,
        "name_en": "Food & Restaurants",
        "name_ar": "الطعام والمطاعم",
        "slug": "food-restaurants",
        "deals_count": 25,
        "products_count": 25,
        "created_at": "2026-01-22 10:30:00"
    }
}
```

#### Error Response - Category Not Found (404)
```json
{
    "success": false,
    "message": "Category not found"
}
```

#### Error Response - Server Error (500)
```json
{
    "success": false,
    "message": "Failed to retrieve category",
    "error": "Error details here"
}
```

---

## Dashboard Management

Categories can be managed from the dashboard at `/categories` route. Administrators can:

1. **Create** new categories
2. **Edit** existing categories (name_en, name_ar, slug, icon, description)
3. **Delete** categories
4. **View** deal counts for each category

### Important Notes
- The API returns only `name_en`, `name_ar`, `slug`, and `deals_count`
- Icons and descriptions are NOT included in the API response (as requested)
- `deals_count` shows the total number of deals in each category
- `products_count` is an alias for `deals_count` (same value)
- Categories with 0 deals are still returned

---

## Mobile App Integration

### Display All Categories
```javascript
// Example: Fetch and display all categories
fetch('http://127.0.0.1:8000/api/categories')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const categories = data.data;
      categories.forEach(category => {
        console.log(category.name_en); // Food & Restaurants
        console.log(category.name_ar); // الطعام والمطاعم
        console.log(category.deals_count); // 25
      });
    }
  });
```

### Display Category with Localization
```javascript
// Example: Display category name based on user language
function getCategoryName(category, language) {
  return language === 'ar' ? category.name_ar : category.name_en;
}

// Usage
const userLanguage = 'ar'; // or 'en'
categories.forEach(category => {
  const displayName = getCategoryName(category, userLanguage);
  console.log(displayName);
});
```

### Get Specific Category
```javascript
// Example: Get a specific category by ID
function getCategory(categoryId) {
  fetch(`http://127.0.0.1:8000/api/categories/${categoryId}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const category = data.data;
        console.log(`${category.name_en} has ${category.deals_count} deals`);
      } else {
        console.log('Category not found');
      }
    });
}
```

### Filter Categories with Deals
```javascript
// Example: Show only categories that have deals
fetch('http://127.0.0.1:8000/api/categories')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const categoriesWithDeals = data.data.filter(cat => cat.deals_count > 0);
      console.log('Categories with deals:', categoriesWithDeals);
    }
  });
```

---

## Testing with Postman

1. Import the collection: `postman/Categories_API.postman_collection.json`
2. Set the `base_url` variable to your API URL (default: `http://127.0.0.1:8000`)
3. Test the endpoints:
   - **Get All Categories**: Send GET request to `/api/categories`
   - **Get Specific Category**: Send GET request to `/api/categories/1`
4. View the responses with all category details

---

## API Workflow

### Get All Categories
```
Mobile App Request
       ↓
GET /api/categories
       ↓
Load all categories with deal counts
       ↓
Sort by name_en (ascending)
       ↓
Transform to Resource (exclude icon & description)
       ↓
Return JSON Response
```

### Get Specific Category
```
Mobile App Request
       ↓
GET /api/categories/{id}
       ↓
Find category by ID with deal count
       ↓
Transform to Resource (exclude icon & description)
       ↓
Return JSON Response (or 404)
```

---

## Files Created

1. **Controller**: `app/Http/Controllers/Api/CategoryController.php`
   - `index()` method returns all categories with deal counts
   - `show($id)` method returns specific category by ID

2. **Resource**: `app/Http/Resources/Api/CategoryResource.php`
   - Transforms category data
   - Excludes icon and description fields
   - Includes deals_count

3. **Route**: Updated `routes/api.php`
   - Added GET `/api/categories` endpoint
   - Added GET `/api/categories/{id}` endpoint

4. **Postman Collection**: `postman/Categories_API.postman_collection.json`
   - Ready to import and test
   - Includes example responses

5. **Documentation**: `CATEGORIES_API_DOCUMENTATION.md`
   - Complete API documentation
   - Mobile integration examples

## Files Updated

1. **Model**: `app/Models/Category.php`
   - Added `deals()` relationship method

---

## Database Structure

### Categories Table Fields
- `id` - Primary key
- `name_en` - English name
- `name_ar` - Arabic name
- `slug` - URL-friendly identifier
- `icon` - Category icon (NOT included in API)
- `description` - Category description (NOT included in API)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Deals Table Relationship
- Deals have `category_id` foreign key
- Each deal belongs to one category
- Each category can have many deals
- `deals_count` is calculated using `withCount('deals')`

---

**Last Updated**: January 22, 2026
