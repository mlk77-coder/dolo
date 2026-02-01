# Deals API - Postman Collection

## Quick Start

### 1. Import Collection
1. Open Postman
2. Click **Import** button
3. Select `Deals_API.postman_collection.json`
4. Collection will appear in your sidebar

### 2. Set Base URL
1. Click on the **Deals API** collection
2. Go to **Variables** tab
3. Update `base_url` value:
   - Local: `http://127.0.0.1:8000`
   - Production: `http://your-domain.com`
4. Click **Save**

### 3. Test Endpoints

#### Get All Deals
- **Request**: Get All Deals
- **Method**: GET
- **URL**: `{{base_url}}/api/deals`
- **Use Case**: Home screen deals list
- **Try It**: Click Send

#### Get Featured Deals
- **Request**: Get Featured Deals
- **Method**: GET
- **URL**: `{{base_url}}/api/deals/featured`
- **Use Case**: Home screen banner/slider
- **Try It**: Click Send

#### Get Deal by ID
- **Request**: Get Deal by ID
- **Method**: GET
- **URL**: `{{base_url}}/api/deals/1`
- **Use Case**: Deal detail page
- **Try It**: Change `1` to any deal ID, then Send

#### Get Deals by Category
- **Request**: Get Deals by Category
- **Method**: GET
- **URL**: `{{base_url}}/api/deals/category/1`
- **Use Case**: Category page
- **Try It**: Change `1` to any category ID, then Send

## Available Filters

### Get All Deals - Query Parameters

Enable/disable parameters by checking/unchecking them in Postman:

| Parameter | Example | Description |
|-----------|---------|-------------|
| `per_page` | 20 | Items per page (default: 20) |
| `page` | 1 | Page number |
| `category_id` | 1 | Filter by category |
| `merchant_id` | 1 | Filter by merchant |
| `featured` | true | Only featured deals |
| `search` | pizza | Search in titles |
| `sort_by` | discount_percentage | Sort field |
| `sort_order` | desc | asc or desc |

### Example Combinations

**Get top 10 featured deals:**
```
GET /api/deals?featured=true&per_page=10&sort_by=discount_percentage&sort_order=desc
```

**Search for pizza deals:**
```
GET /api/deals?search=pizza
```

**Get deals in category 2:**
```
GET /api/deals?category_id=2&per_page=20
```

## Response Examples

### Success Response
```json
{
  "success": true,
  "message": "Deals retrieved successfully",
  "data": [...],
  "pagination": {...}
}
```

### Error Response
```json
{
  "success": false,
  "message": "Deal not found"
}
```

## Testing Checklist

- [ ] Get all deals works
- [ ] Pagination works (change page parameter)
- [ ] Featured deals returns only featured items
- [ ] Get deal by ID returns full details
- [ ] Get deals by category filters correctly
- [ ] Search works with English and Arabic
- [ ] Sorting works (try different sort_by values)
- [ ] Images URLs are accessible
- [ ] Countdown timer data is present
- [ ] Deal availability status is correct

## Troubleshooting

### Empty data array
**Problem**: API returns empty array
**Solution**: 
- Check if you have active deals in database
- Verify deals have status = 'active'
- Check start_date and end_date are valid

### 404 Not Found
**Problem**: Endpoint not found
**Solution**:
- Verify base_url is correct
- Check Laravel server is running: `php artisan serve`
- Verify routes: `php artisan route:list | findstr deals`

### 500 Server Error
**Problem**: Internal server error
**Solution**:
- Check Laravel logs: `storage/logs/laravel.log`
- Verify database connection
- Check Deal model exists

### Images not loading
**Problem**: Image URLs return 404
**Solution**:
- Run: `php artisan storage:link`
- Check images exist in `storage/app/public/deal-images/`
- Verify storage symlink exists in `public/storage`

## Frontend Integration

### React Native Example
```javascript
const fetchDeals = async () => {
  const response = await fetch('http://your-domain.com/api/deals');
  const data = await response.json();
  
  if (data.success) {
    setDeals(data.data);
  }
};
```

### Flutter Example
```dart
Future<List<Deal>> fetchDeals() async {
  final response = await http.get(
    Uri.parse('http://your-domain.com/api/deals')
  );
  
  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    return data['data'];
  }
  throw Exception('Failed to load deals');
}
```

## Important Fields

### For Home Screen
- `id`: Deal identifier
- `title.en` / `title.ar`: Deal title
- `merchant.name`: Merchant name
- `prices.discounted`: Final price
- `prices.discount_percentage`: Discount %
- `buyer_counter.count`: Number of buyers
- `image`: Primary image URL
- `availability.is_available`: Is active?
- `availability.time_remaining`: Countdown data

### For Countdown Timer
Use `availability.time_remaining.total_seconds`:
```javascript
// Start countdown from total_seconds
let seconds = deal.availability.time_remaining.total_seconds;

setInterval(() => {
  seconds--;
  // Update UI with remaining time
}, 1000);
```

## Dynamic Updates

✅ **Automatic**: When you add/edit deals in dashboard, API automatically returns updated data

✅ **No App Update**: Users don't need to update the app to see new deals

✅ **Real-time**: Mobile app fetches fresh data from API

### Recommended Refresh Strategy
1. **On App Open**: Fetch latest deals
2. **Pull-to-Refresh**: User swipes down to refresh
3. **Auto-Refresh**: Every 5 minutes in background
4. **After Purchase**: Refresh to update buyer counter

## Support

For detailed documentation, see:
- `DEALS_API_DOCUMENTATION.md` - Complete API documentation
- `postman/dealsApi.txt` - Quick reference guide

For issues:
- Check Laravel logs: `storage/logs/laravel.log`
- Verify database has active deals
- Test endpoints in Postman first
- Check network connectivity in mobile app
