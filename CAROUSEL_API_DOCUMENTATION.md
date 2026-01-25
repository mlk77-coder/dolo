# Carousel Images API Documentation

## Overview
This API provides dynamic carousel images for the mobile application. Images can be managed and updated anytime from the dashboard, and changes are reflected immediately in the API response.

## Endpoint

### Get Carousel Images
**GET** `/api/carousel`

Returns all active carousel images sorted by sort_order.

#### Features
- ✅ Public endpoint (no authentication required)
- ✅ Returns only active carousel images
- ✅ Sorted by sort_order (ascending) then created_at (descending)
- ✅ Dynamic - images can be changed anytime from dashboard
- ✅ Full image URLs included for easy display

#### Request
```http
GET /api/carousel HTTP/1.1
Host: 127.0.0.1:8000
Accept: application/json
```

#### Response Fields
| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique carousel image ID |
| `title` | string | Carousel image title |
| `description` | string | Carousel image description |
| `image` | string | Full URL to the image (ready to use) |
| `image_url` | string | Storage path to the image |
| `link_url` | string\|null | External link URL (if exists) |
| `sort_order` | integer | Display order (lower numbers first) |
| `status` | string | Status: "active" or "inactive" |
| `is_active` | boolean | Boolean representation of status |
| `created_at` | string | Creation timestamp |

#### Success Response (200 OK)
```json
{
    "success": true,
    "message": "Carousel images retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "Welcome to Bee Order",
            "description": "Order your favorite food from the best restaurants",
            "image": "http://127.0.0.1:8000/storage/carousel/image1.jpg",
            "image_url": "carousel/image1.jpg",
            "link_url": "https://play.google.com/store/apps/details?id=com.beeorder.customer",
            "sort_order": 1,
            "status": "active",
            "is_active": true,
            "created_at": "2026-01-22 10:30:00"
        },
        {
            "id": 2,
            "title": "Special Offers",
            "description": "Get 20% off on your first order",
            "image": "http://127.0.0.1:8000/storage/carousel/image2.jpg",
            "image_url": "carousel/image2.jpg",
            "link_url": null,
            "sort_order": 2,
            "status": "active",
            "is_active": true,
            "created_at": "2026-01-22 10:35:00"
        }
    ]
}
```

#### Empty Response (No Active Images)
```json
{
    "success": true,
    "message": "Carousel images retrieved successfully",
    "data": []
}
```

#### Error Response (500)
```json
{
    "success": false,
    "message": "Failed to retrieve carousel images",
    "error": "Error details here"
}
```

## Dashboard Management

Carousel images can be managed from the dashboard at `/mobile-carousel-images` route. Administrators can:

1. **Create** new carousel images
2. **Edit** existing images (title, description, image, link_url, sort_order, status)
3. **Delete** carousel images
4. **Toggle status** between active/inactive
5. **Reorder** images using sort_order field

### Important Notes
- Only images with `status = 'active'` are returned by the API
- Images are sorted by `sort_order` (ascending), then `created_at` (descending)
- Changes made in the dashboard are reflected immediately in the API
- The `image` field returns the full URL ready for display in mobile apps
- The `link_url` field is optional - use it to link to external pages or deep links

## Mobile App Integration

### Display Carousel
```javascript
// Example: Fetch and display carousel images
fetch('http://127.0.0.1:8000/api/carousel')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const carouselImages = data.data;
      // Display images in your carousel component
      carouselImages.forEach(item => {
        console.log(item.title);
        console.log(item.image); // Full URL ready to use
        console.log(item.link_url); // Optional link
      });
    }
  });
```

### Handle Link Clicks
```javascript
// When user clicks on carousel image
function handleCarouselClick(carouselItem) {
  if (carouselItem.link_url) {
    // Open the link (external URL or deep link)
    window.open(carouselItem.link_url, '_blank');
  }
}
```

## Testing with Postman

1. Import the collection: `postman/Carousel_Images_API.postman_collection.json`
2. Set the `base_url` variable to your API URL (default: `http://127.0.0.1:8000`)
3. Send the "Get Carousel Images" request
4. View the response with all active carousel images

## API Workflow

```
Mobile App Request
       ↓
GET /api/carousel
       ↓
Filter: status = 'active'
       ↓
Sort: sort_order ASC, created_at DESC
       ↓
Transform to Resource
       ↓
Return JSON Response
```

## Files Created

1. **Controller**: `app/Http/Controllers/Api/CarouselController.php`
2. **Resource**: `app/Http/Resources/Api/CarouselImageResource.php`
3. **Route**: Added to `routes/api.php`
4. **Postman Collection**: `postman/Carousel_Images_API.postman_collection.json`
5. **Documentation**: `CAROUSEL_API_DOCUMENTATION.md`

---

**Last Updated**: January 22, 2026
