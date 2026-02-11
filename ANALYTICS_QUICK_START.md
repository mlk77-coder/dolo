# Analytics Daily - Quick Start Guide

## ✅ Setup Complete!

Your analytics page now has **real data** from the last 30 days.

## View Analytics

Visit: **http://127.0.0.1:8000/analytics-daily**

## What You'll See

### Daily Metrics:
- **Total Users**: Cumulative user count
- **New Users**: Users registered that day
- **Total Orders**: Orders placed that day
- **Revenue**: Money earned from delivered orders
- **Deal Views**: How many times deals were viewed
- **Page Views**: Estimated page traffic
- **Sessions**: Active users that day

### Current Data:
- ✅ **31 days** of analytics generated
- ✅ Based on **real orders** from your database
- ✅ Shows **$405.00** revenue today
- ✅ **4 orders** placed today

## Features

### 1. Date Filtering
- Select "From Date" and "To Date"
- Click "Filter" to view specific period
- Click "Clear" to reset

### 2. Automatic Updates
- Analytics update **automatically every day** at 12:30 AM
- No manual work needed

### 3. Manual Update
If you want to update analytics manually:
```bash
php artisan analytics:generate --days=1
```

## Commands

### Generate Last 7 Days
```bash
php artisan analytics:generate --days=7
```

### Generate Last 30 Days
```bash
php artisan analytics:generate --days=30
```

### Generate Last 90 Days
```bash
php artisan analytics:generate --days=90
```

## How It Works

The system:
1. Counts orders placed each day
2. Calculates revenue from delivered orders
3. Tracks new user registrations
4. Estimates page views and sessions
5. Stores everything in `analytics_daily` table
6. Updates automatically every night

## Data Sources

- **Orders**: From `orders` table
- **Users**: From `customers` table
- **Revenue**: Sum of `final_price` from delivered orders
- **Deal Views**: From `deal_views` table

## Need More Days?

Run this command to generate more historical data:
```bash
php artisan analytics:generate --days=90
```

This will create analytics for the last 90 days.

## Troubleshooting

### Page is Empty?
```bash
php artisan analytics:generate --days=30
```

### Data Looks Wrong?
```bash
# Clear and regenerate
php artisan tinker --execute="App\Models\AnalyticsDaily::truncate();"
php artisan analytics:generate --days=30
```

## That's It!

Your analytics page is now fully functional with real data. It will update automatically every day, so you always have current metrics.

Visit: **http://127.0.0.1:8000/analytics-daily** to see it in action! 🎉
