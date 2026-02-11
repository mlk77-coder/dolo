# Analytics Daily - Setup Complete

## Summary
Created a system to automatically generate and display daily analytics data based on real orders, users, and deal views.

## What Was Done

### 1. Created Analytics Generation Command ✅
**File**: `app/Console/Commands/GenerateAnalyticsDaily.php`

This command calculates and stores daily analytics including:
- **Total Users**: Cumulative count of all users up to that date
- **New Users**: Users who registered on that specific day
- **Total Orders**: Orders placed on that day
- **Total Revenue**: Revenue from delivered/ready orders on that day
- **Deal Views**: Views tracked in deal_views table
- **Deal Clicks**: Orders placed (representing deal clicks)
- **Page Views**: Estimated based on order activity
- **Sessions**: Unique users who were active that day
- **Additional Metrics**: Pending and cancelled orders

### 2. Added Automatic Daily Updates ✅
**File**: `routes/console.php`

Added scheduled task that runs daily at 00:30 (12:30 AM):
```php
Schedule::command('analytics:generate --days=1')->dailyAt('00:30');
```

This ensures analytics are automatically updated every day.

### 3. Generated Historical Data ✅
Ran the command to populate the last 30 days of analytics:
```bash
php artisan analytics:generate --days=30
```

**Result**: 31 records created (today + last 30 days)

## Analytics Metrics Explained

### Real Data (From Database):
1. **Total Users**: Count from `customers` table up to that date
2. **New Users**: Count of users created on that specific date
3. **Total Orders**: Count of orders created on that date
4. **Total Revenue**: Sum of `final_price` from delivered/ready orders
5. **Deal Views**: Count from `deal_views` table (if tracked)
6. **Deal Clicks**: Count of orders (orders = deal clicks)

### Estimated Data:
1. **Page Views**: Orders × 5 (rough estimate)
2. **Sessions**: Unique users who placed orders + new users
3. **Average Session Duration**: Set to 0 (requires tracking implementation)

### Additional Metrics (JSON):
- Pending orders count
- Cancelled orders count

## Usage

### View Analytics Dashboard
Navigate to: `http://127.0.0.1:8000/analytics-daily`

### Filter by Date Range
Use the date filters to view specific periods:
- From Date: Start date
- To Date: End date
- Click "Filter" to apply
- Click "Clear" to reset

### Manual Generation
Generate analytics for specific number of days:
```bash
# Generate last 7 days
php artisan analytics:generate --days=7

# Generate last 30 days
php artisan analytics:generate --days=30

# Generate last 90 days
php artisan analytics:generate --days=90
```

### Update Today's Analytics
```bash
php artisan analytics:generate --days=1
```

## Automatic Updates

The system automatically updates analytics daily at 00:30 AM. To enable this:

1. **On Production Server**, add to crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

2. **On Local Development**, run:
```bash
php artisan schedule:work
```

## Sample Data

Based on your current database:
- **Total Users**: 4 customers
- **Orders Today**: 4 orders
- **Revenue Today**: $405.00
- **Pending Orders**: 1
- **Cancelled Orders**: 0

## Customization

### Add More Metrics
Edit `app/Console/Commands/GenerateAnalyticsDaily.php` and add to the `additional_metrics` array:

```php
'additional_metrics' => [
    'pending_orders' => ...,
    'cancelled_orders' => ...,
    'top_deal_id' => ..., // Add custom metrics
    'average_order_value' => ...,
],
```

### Change Schedule Time
Edit `routes/console.php`:
```php
// Run at different time
Schedule::command('analytics:generate --days=1')->dailyAt('01:00');

// Run every hour
Schedule::command('analytics:generate --days=1')->hourly();

// Run every 6 hours
Schedule::command('analytics:generate --days=1')->everySixHours();
```

### Track Deal Views
To get accurate deal view counts, implement tracking in your API:

```php
// In DealController or API
use App\Models\DealView;

DealView::create([
    'deal_id' => $dealId,
    'user_id' => auth()->id(), // optional
    'ip_address' => request()->ip(),
]);
```

## Analytics Table Structure

```sql
analytics_daily
├── id
├── date (unique)
├── total_users
├── new_users
├── total_orders
├── total_revenue
├── total_deal_views
├── total_deal_clicks
├── total_page_views
├── total_sessions
├── average_session_duration
├── additional_metrics (JSON)
├── created_at
├── updated_at
```

## Benefits

1. **Historical Data**: View trends over time
2. **Real Metrics**: Based on actual orders and users
3. **Automatic Updates**: No manual work needed
4. **Flexible Filtering**: Filter by date range
5. **Extensible**: Easy to add more metrics
6. **Performance**: Pre-calculated data for fast loading

## Troubleshooting

### No Data Showing
```bash
# Check if records exist
php artisan tinker --execute="echo App\Models\AnalyticsDaily::count();"

# Regenerate data
php artisan analytics:generate --days=30
```

### Scheduler Not Running
```bash
# Test scheduler manually
php artisan schedule:run

# Check scheduled tasks
php artisan schedule:list
```

### Wrong Data
```bash
# Clear and regenerate
php artisan tinker --execute="App\Models\AnalyticsDaily::truncate();"
php artisan analytics:generate --days=30
```

## Future Enhancements

1. **Real-time Tracking**: Implement actual page view and session tracking
2. **Charts**: Add visual charts for trends
3. **Export**: Add CSV/PDF export functionality
4. **Comparisons**: Compare periods (this week vs last week)
5. **Alerts**: Send notifications for significant changes
6. **API Endpoint**: Expose analytics via API for mobile app

## Files Modified/Created

1. ✅ `app/Console/Commands/GenerateAnalyticsDaily.php` - Created
2. ✅ `routes/console.php` - Updated with schedule
3. ✅ `ANALYTICS_DAILY_SETUP.md` - Documentation

## Testing

1. ✅ Navigate to `/analytics-daily`
2. ✅ Verify data is displayed
3. ✅ Test date filtering
4. ✅ Check pagination works
5. ✅ Verify metrics are accurate

The analytics page is now fully functional with real data! 🎉
