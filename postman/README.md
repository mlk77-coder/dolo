# Postman Collection - Customer Profile API

## 📦 Collection File
`Customer_Profile_API.postman_collection.json`

## 🚀 How to Import

### Method 1: Import File
1. Open Postman
2. Click **"Import"** button (top left)
3. Click **"Upload Files"**
4. Select `Customer_Profile_API.postman_collection.json`
5. Click **"Import"**

### Method 2: Drag & Drop
1. Open Postman
2. Drag the JSON file into Postman window
3. Collection will be imported automatically

## 📋 What's Included

### Authentication Folder
- ✅ Register - Create new customer account
- ✅ Login - Get authentication token (auto-saves token)
- ✅ Logout - Revoke current token

### Customer Profile Folder
- ✅ Get Customer Profile - Full profile with order history
- ✅ Get Order History (Paginated) - All orders with pagination
- ✅ Get Basic User Info - Simple user data

## 🔧 Setup

### 1. Set Base URL
The collection uses a variable `{{base_url}}` which is set to:
```
http://localhost:8000
```

**To change it:**
1. Click on the collection name
2. Go to "Variables" tab
3. Update `base_url` value
4. Save

### 2. Authentication Token
The token is automatically saved after login!

**How it works:**
1. Use the "Login" request
2. Token is extracted from response
3. Saved to `{{auth_token}}` variable
4. All other requests use this token automatically

**Manual token setup (if needed):**
1. Click on collection name
2. Go to "Variables" tab
3. Set `auth_token` value
4. Save

## 🧪 Testing Flow

### Step 1: Login
1. Open **"Authentication"** → **"Login"**
2. Update credentials in request body:
   ```json
   {
       "credential": "your.email@example.com",
       "password": "your_password"
   }
   ```
3. Click **"Send"**
4. Token is automatically saved ✅

### Step 2: Get Profile
1. Open **"Customer Profile"** → **"Get Customer Profile"**
2. Click **"Send"**
3. View response with:
   - Name, email, phone
   - Total orders count
   - Order history
   - Created at timestamp

### Step 3: Get Order History
1. Open **"Customer Profile"** → **"Get Order History"**
2. Adjust `per_page` parameter if needed
3. Click **"Send"**
4. View paginated order list

## 📊 Example Responses

### Login Response
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John",
            "email": "john.doe@example.com"
        },
        "token": "1|abc123xyz..."
    }
}
```

### Profile Response
```json
{
    "success": true,
    "data": {
        "name": "John",
        "surname": "Doe",
        "email": "john.doe@example.com",
        "phone": "+1234567890",
        "orders_count": 5,
        "created_at": "2025-01-15 10:30:00",
        "order_history": [...]
    }
}
```

## 🔑 Environment Variables

| Variable | Description | Default Value |
|----------|-------------|---------------|
| `base_url` | API base URL | http://localhost:8000 |
| `auth_token` | Bearer token | (auto-set after login) |

## 💡 Tips

### Auto-Save Token
The Login request has a test script that automatically saves the token:
```javascript
if (pm.response.code === 200) {
    var jsonData = pm.response.json();
    pm.environment.set("auth_token", jsonData.data.token);
}
```

### View Saved Token
1. Click on collection name
2. Go to "Variables" tab
3. See `auth_token` current value

### Test Different Users
1. Login with different credentials
2. Token updates automatically
3. All requests use new token

### Pagination
Adjust `per_page` in order history request:
```
?per_page=20
```

## 🐛 Troubleshooting

### "Unauthenticated" Error
**Problem:** Token not set or expired

**Solution:**
1. Login again to get fresh token
2. Check token is saved in variables
3. Verify Authorization header is set

### "404 Not Found"
**Problem:** Wrong base URL

**Solution:**
1. Check Laravel server is running: `php artisan serve`
2. Verify `base_url` variable matches your server
3. Default: http://localhost:8000

### Token Not Auto-Saving
**Problem:** Test script not running

**Solution:**
1. Open Login request
2. Go to "Tests" tab
3. Verify script is present
4. Try login again

## 📝 Request Details

### All Requests Include:
- ✅ Proper HTTP method (GET/POST)
- ✅ Required headers (Accept, Content-Type)
- ✅ Authorization header (where needed)
- ✅ Example request bodies
- ✅ Example responses

### Headers Used:
```
Accept: application/json
Content-Type: application/json
Authorization: Bearer {{auth_token}}
```

## 🎯 Quick Reference

**Base URL:** http://localhost:8000/api

**Endpoints:**
- POST `/register` - Register
- POST `/login` - Login
- POST `/logout` - Logout
- GET `/customer/profile` - Get profile + orders
- GET `/customer/order-history` - Get paginated orders
- GET `/user` - Get basic user info

## 📚 Additional Resources

- **Full API Documentation:** `../API_DOCUMENTATION.md`
- **Quick Guide:** `../QUICK_API_GUIDE.md`
- **Laravel Docs:** https://laravel.com/docs/sanctum

## ✅ Checklist

Before testing:
- [ ] Laravel server is running (`php artisan serve`)
- [ ] Database is migrated (`php artisan migrate`)
- [ ] Postman collection is imported
- [ ] Base URL is correct
- [ ] You have test user credentials

Ready to test! 🚀
