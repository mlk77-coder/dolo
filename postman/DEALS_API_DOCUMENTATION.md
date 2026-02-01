# Deals API Documentation

## Overview
This API provides endpoints for fetching deals to display in your mobile app. All deals are dynamically loaded from the database, so any deals added through the dashboard will automatically appear in the app.

## Base URL
```
http://your-domain.com/api
```

For local development:
```
http://127.0.0.1:8000/api
```

---

## Endpoints

### 1. Get All Deals (Home Screen)
**Endpoint:** `GET /api/deals`

**Description:** Fetches all active deals with pagination. Perfect for the main deals list in your app.

**Query Parameters:**
| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `per_page` | integer | 20 | Number of deals per page |
| `page` | integer | 1 | Page number |
| `category_id` | integer | - | Filter by category ID |
| `merchant_id` | integer | - | Filter by merchant ID |
| `featured` | boolean | - | Filter featured deals only |
| `search` | string | - | Search in deal titles (EN/AR) |
| `sort_by` | string | sort_order | Sort by: sort_order, created_at, discount_percentage, original_price |
| `sort_order` | string | asc | Sort order: asc or desc |

**Example Request:**
```bash
GET /api/deals?per_page=20&page=1
```

**Example Response:**
```json
{
  "success": true,
  "message": "Deals retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": {
        "en": "50% Off Pizza",
        "ar": "خصم 50٪ على البيتزا"
      },
      "merchant": {
        "id": 1,
        "name": "Pizza Palace"
      },
      "category": {
        "id": 2,
        "name_en": "Food",
        "name_ar": "طعام"
      },
      "prices": {
        "original": 1000.00,
        "discounted": 500.00,
        "discount_percentage": 50.00,
        "savings": 500.00
      },
      "buyer_counter": {
        "count": 150,
        "show": true
      },
      "image": "http://127.0.0.1:8000/storage/deal-images/image.jpg",
      "availability": {
        "is_available": true,
        "status": "active",
        "start_date": "2026-01-20T00:00:00+00:00",
        "end_date": "2026-02-20T23:59:59+00:00",
        "time_remaining": {
          "days": 25,
          "hours": 14,
          "minutes": 30,
          "seconds": 45,
          "total_seconds": 2203845
        }
      },
      "featured": true,
      "quantity": 100,
      "show_savings_percentage": true
    }
  ],
  "pagination": {
    "total": 50,
    "per_page": 20,
    "current_page": 1,
    "last_page": 3,
    "from": 1,
    "to": 20
  }
}
```

---

### 2. Get Featured Deals
**Endpoint:** `GET /api/deals/featured`

**Description:** Fetches featured deals for home screen banner/slider.

**Query Parameters:**
| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `limit` | integer | 10 | Number of featured deals to return |

**Example Request:**
```bash
GET /api/deals/featured?limit=5
```

**Example Response:**
```json
{
  "success": true,
  "message": "Featured deals retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": {
        "en": "50% Off Pizza",
        "ar": "خصم 50٪ على البيتزا"
      },
      "merchant": {
        "id": 1,
        "name": "Pizza Palace"
      },
      "prices": {
        "original": 1000.00,
        "discounted": 500.00,
        "discount_percentage": 50.00,
        "savings": 500.00
      },
      "image": "http://127.0.0.1:8000/storage/deal-images/image.jpg",
      "availability": {
        "is_available": true,
        "status": "active",
        "start_date": "2026-01-20T00:00:00+00:00",
        "end_date": "2026-02-20T23:59:59+00:00",
        "time_remaining": {
          "days": 25,
          "hours": 14,
          "minutes": 30,
          "seconds": 45,
          "total_seconds": 2203845
        }
      },
      "featured": true
    }
  ]
}
```

---

### 3. Get Deal by ID (Detail Page)
**Endpoint:** `GET /api/deals/{id}`

**Description:** Fetches detailed information about a specific deal including all images, location, stock status, and merchant contact information. Use this when user clicks on a deal from home screen.

**Example Request:**
```bash
GET /api/deals/1
```

**What You Get:**
- ✅ Deal name (English & Arabic)
- ✅ **All images** (for carousel/slider)
- ✅ Discount amount & percentage
- ✅ Buyer counter
- ✅ Merchant name & contact (phone, email)
- ✅ Description & deal information
- ✅ **Stock availability** (quantity)
- ✅ SKU
- ✅ Original & discounted prices
- ✅ **Countdown timer data**
- ✅ **Location** (name, latitude, longitude for map)
- ✅ Video URL (if available)

**Example Response:**
```json
{
  "success": true,
  "message": "Deal retrieved successfully",
  "data": {
    "id": 1,
    "title": {
      "en": "50% Off Pizza",
      "ar": "خصم 50٪ على البيتزا"
    },
    "sku": "PIZZA-001",
    "merchant": {
      "id": 1,
      "name": "Pizza Palace",
      "phone": "+963-11-1234567",
      "email": "info@pizzapalace.com"
    },
    "category": {
      "id": 2,
      "name_en": "Food",
      "name_ar": "طعام"
    },
    "prices": {
      "original": 1000.00,
      "discounted": 500.00,
      "discount_percentage": 50.00,
      "savings": 500.00
    },
    "buyer_counter": {
      "count": 150,
      "show": true
    },
    "quantity": 100,
    "description": "Delicious pizza with fresh ingredients",
    "deal_information": "Valid for dine-in and takeaway",
    "video_url": "https://example.com/video.mp4",
    "location": {
      "city": "Damascus",
      "area": "Mezzeh",
      "location_name": "Pizza Palace Main Branch",
      "latitude": 33.5102,
      "longitude": 36.2781
    },
    "images": [
      {
        "id": 1,
        "url": "http://127.0.0.1:8000/storage/deal-images/image1.jpg",
        "is_primary": true
      },
      {
        "id": 2,
        "url": "http://127.0.0.1:8000/storage/deal-images/image2.jpg",
        "is_primary": false
      }
    ],
    "availability": {
      "is_available": true,
      "status": "active",
      "start_date": "2026-01-20T00:00:00+00:00",
      "end_date": "2026-02-20T23:59:59+00:00",
      "time_remaining": {
        "days": 25,
        "hours": 14,
        "minutes": 30,
        "seconds": 45,
        "total_seconds": 2203845
      }
    },
    "featured": true,
    "show_savings_percentage": true,
    "created_at": "2026-01-15T10:30:00+00:00",
    "updated_at": "2026-01-20T15:45:00+00:00"
  }
}
```

---

### 4. Get Deals by Category
**Endpoint:** `GET /api/deals/category/{categoryId}`

**Description:** Fetches all deals in a specific category.

**Query Parameters:**
| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `per_page` | integer | 20 | Number of deals per page |
| `page` | integer | 1 | Page number |

**Example Request:**
```bash
GET /api/deals/category/2?per_page=20&page=1
```

**Example Response:**
Same structure as "Get All Deals" endpoint.

---

## Response Fields Explanation

### Deal Object (List View)
| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique deal identifier |
| `title.en` | string | Deal title in English |
| `title.ar` | string | Deal title in Arabic |
| `merchant.id` | integer | Merchant ID |
| `merchant.name` | string | Merchant business name |
| `category.id` | integer | Category ID |
| `category.name_en` | string | Category name in English |
| `category.name_ar` | string | Category name in Arabic |
| `prices.original` | float | Original price before discount |
| `prices.discounted` | float | Price after discount |
| `prices.discount_percentage` | float | Discount percentage (0-100) |
| `prices.savings` | float | Amount saved |
| `buyer_counter.count` | integer | Number of buyers |
| `buyer_counter.show` | boolean | Whether to show buyer counter |
| `image` | string | URL of primary image |
| `availability.is_available` | boolean | Whether deal is currently available |
| `availability.status` | string | Deal status: active, inactive, draft, expired |
| `availability.start_date` | string | ISO 8601 date when deal starts |
| `availability.end_date` | string | ISO 8601 date when deal ends |
| `availability.time_remaining` | object | Time remaining until deal ends |
| `featured` | boolean | Whether deal is featured |
| `quantity` | integer | Available quantity |
| `show_savings_percentage` | boolean | Whether to show savings percentage |

### Time Remaining Object
| Field | Type | Description |
|-------|------|-------------|
| `days` | integer | Days remaining |
| `hours` | integer | Hours remaining (0-23) |
| `minutes` | integer | Minutes remaining (0-59) |
| `seconds` | integer | Seconds remaining (0-59) |
| `total_seconds` | integer | Total seconds remaining (for countdown) |

---

## Error Responses

### 404 Not Found
```json
{
  "success": false,
  "message": "Deal not found"
}
```

### 500 Server Error
```json
{
  "success": false,
  "message": "Failed to retrieve deals",
  "error": "Error details here"
}
```

---

## Frontend Implementation Guide

### React Native / Flutter Example

#### 1. Fetch All Deals
```javascript
// React Native Example
const fetchDeals = async (page = 1) => {
  try {
    const response = await fetch(
      `http://your-domain.com/api/deals?per_page=20&page=${page}`,
      {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
        },
      }
    );
    
    const data = await response.json();
    
    if (data.success) {
      return data.data; // Array of deals
    }
  } catch (error) {
    console.error('Error fetching deals:', error);
  }
};
```

#### 2. Display Deal Card
```javascript
// React Native Component
const DealCard = ({ deal }) => {
  return (
    <View style={styles.card}>
      <Image source={{ uri: deal.image }} style={styles.image} />
      
      <Text style={styles.title}>
        {deal.title.en} {/* or deal.title.ar for Arabic */}
      </Text>
      
      <Text style={styles.merchant}>{deal.merchant.name}</Text>
      
      <View style={styles.priceContainer}>
        <Text style={styles.originalPrice}>
          ${deal.prices.original}
        </Text>
        <Text style={styles.discountedPrice}>
          ${deal.prices.discounted}
        </Text>
        <Text style={styles.discount}>
          {deal.prices.discount_percentage}% OFF
        </Text>
      </View>
      
      {deal.buyer_counter.show && (
        <Text style={styles.buyers}>
          {deal.buyer_counter.count} buyers
        </Text>
      )}
      
      {deal.availability.is_available ? (
        <CountdownTimer timeRemaining={deal.availability.time_remaining} />
      ) : (
        <Text style={styles.expired}>Deal Expired</Text>
      )}
    </View>
  );
};
```

#### 3. Countdown Timer Component
```javascript
// React Native Countdown Timer
import React, { useState, useEffect } from 'react';

const CountdownTimer = ({ timeRemaining }) => {
  const [seconds, setSeconds] = useState(timeRemaining.total_seconds);
  
  useEffect(() => {
    if (seconds <= 0) return;
    
    const timer = setInterval(() => {
      setSeconds(prev => prev - 1);
    }, 1000);
    
    return () => clearInterval(timer);
  }, [seconds]);
  
  const days = Math.floor(seconds / 86400);
  const hours = Math.floor((seconds % 86400) / 3600);
  const minutes = Math.floor((seconds % 3600) / 60);
  const secs = seconds % 60;
  
  return (
    <View style={styles.timer}>
      <Text>{days}d {hours}h {minutes}m {secs}s</Text>
    </View>
  );
};
```

#### 4. Check Deal Availability
```javascript
const isDealAvailable = (deal) => {
  return deal.availability.is_available && 
         deal.availability.status === 'active';
};

// Usage
if (isDealAvailable(deal)) {
  // Show deal as active
} else {
  // Show deal as expired/inactive
}
```

---

## Dynamic Updates

### How It Works
1. **Dashboard Updates**: When you add/edit/delete deals in the dashboard, changes are saved to the database
2. **API Reflects Changes**: The API automatically fetches the latest data from the database
3. **App Shows Updates**: Your mobile app fetches fresh data from the API
4. **No App Update Needed**: Users don't need to update the app to see new deals

### Refresh Strategy
```javascript
// Pull-to-refresh implementation
const onRefresh = async () => {
  setRefreshing(true);
  await fetchDeals(1); // Fetch first page
  setRefreshing(false);
};

// Auto-refresh every 5 minutes
useEffect(() => {
  const interval = setInterval(() => {
    fetchDeals(currentPage);
  }, 300000); // 5 minutes
  
  return () => clearInterval(interval);
}, [currentPage]);
```

---

## Testing with Postman

1. **Import Collection**: Import `postman/Deals_API.postman_collection.json` into Postman
2. **Set Base URL**: Update the `base_url` variable to your server URL
3. **Test Endpoints**: Run each request to test the API

---

## Best Practices

### 1. Caching
Cache deal images locally to improve performance:
```javascript
// Use react-native-fast-image or similar
<FastImage
  source={{ uri: deal.image, priority: FastImage.priority.high }}
  cacheControl={FastImage.cacheControl.immutable}
/>
```

### 2. Pagination
Implement infinite scroll for better UX:
```javascript
const loadMore = () => {
  if (currentPage < lastPage) {
    fetchDeals(currentPage + 1);
  }
};
```

### 3. Error Handling
Always handle API errors gracefully:
```javascript
try {
  const data = await fetchDeals();
} catch (error) {
  showErrorMessage('Failed to load deals. Please try again.');
}
```

### 4. Loading States
Show loading indicators while fetching:
```javascript
{loading ? <ActivityIndicator /> : <DealsList deals={deals} />}
```

---

## Support

For issues or questions, check:
- Laravel logs: `storage/logs/laravel.log`
- API response errors
- Network connectivity

---

## Changelog

### Version 1.0.0 (2026-01-26)
- Initial release
- Get all deals endpoint
- Get featured deals endpoint
- Get deal by ID endpoint
- Get deals by category endpoint
- Countdown timer support
- Dynamic updates from dashboard
