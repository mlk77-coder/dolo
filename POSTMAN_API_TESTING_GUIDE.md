# API Testing Guide - User Authentication

This guide will help you test the User Authentication API using Postman.

## Base URL

```
http://localhost:8000/api
```

Make sure your Laravel development server is running:
```bash
php artisan serve
```

---

## 1. Register New User

### Endpoint
```
POST http://localhost:8000/api/register
```

### Headers
```
Content-Type: application/json
Accept: application/json
```

### Request Body (JSON)

**Example 1: With Email**
```json
{
    "name": "Ahmad",
    "surname": "Hassan",
    "phone": "9123456789",
    "email": "ahmad@example.com",
    "date_of_birth": "1990-01-15",
    "gender": "male",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Example 2: Without Email (Optional)**
```json
{
    "name": "Fatima",
    "surname": "Ali",
    "phone": "9987654321",
    "email": null,
    "date_of_birth": "1995-05-20",
    "gender": "female",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Success Response (201 Created)
```json
{
    "success": true,
    "message": "Registration successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Ahmad",
            "surname": "Hassan",
            "phone": "9123456789",
            "email": "ahmad@example.com",
            "date_of_birth": "1990-01-15",
            "gender": "male",
            "created_at": "2024-12-23T10:00:00.000000Z",
            "updated_at": "2024-12-23T10:00:00.000000Z"
        },
        "token": "1|abc123xyz..."
    }
}
```

### Error Response (422 Validation Error)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "phone": [
            "The phone number must start with 9 and be exactly 10 digits long."
        ],
        "email": [
            "This email address is already registered."
        ]
    }
}
```

---

## 2. Login with Email

### Endpoint
```
POST http://localhost:8000/api/login
```

### Headers
```
Content-Type: application/json
Accept: application/json
```

### Request Body (JSON)
```json
{
    "credential": "ahmad@example.com",
    "password": "password123"
}
```

### Success Response (200 OK)
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Ahmad",
            "surname": "Hassan",
            "phone": "9123456789",
            "email": "ahmad@example.com",
            "date_of_birth": "1990-01-15",
            "gender": "male",
            "created_at": "2024-12-23T10:00:00.000000Z",
            "updated_at": "2024-12-23T10:00:00.000000Z"
        },
        "token": "2|xyz789abc..."
    }
}
```

### Error Response (401 Unauthorized)
```json
{
    "success": false,
    "message": "Invalid credentials"
}
```

---

## 3. Login with Phone Number

### Endpoint
```
POST http://localhost:8000/api/login
```

### Headers
```
Content-Type: application/json
Accept: application/json
```

### Request Body (JSON)
```json
{
    "credential": "9123456789",
    "password": "password123"
}
```

### Success Response (200 OK)
Same as login with email above.

---

## 4. Get Authenticated User Profile

### Endpoint
```
GET http://localhost:8000/api/user
```

### Headers
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

**Important:** Replace `YOUR_TOKEN_HERE` with the token you received from register or login.

### Success Response (200 OK)
```json
{
    "id": 1,
    "name": "Ahmad",
    "surname": "Hassan",
    "phone": "9123456789",
    "email": "ahmad@example.com",
    "date_of_birth": "1990-01-15",
    "gender": "male",
    "created_at": "2024-12-23T10:00:00.000000Z",
    "updated_at": "2024-12-23T10:00:00.000000Z"
}
```

---

## 5. Logout

### Endpoint
```
POST http://localhost:8000/api/logout
```

### Headers
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

### Success Response (200 OK)
```json
{
    "success": true,
    "message": "Logout successful"
}
```

---

## Postman Setup Instructions

### Step 1: Create a New Collection
1. Open Postman
2. Click "New" → "Collection"
3. Name it "User Authentication API"

### Step 2: Add Environment Variables
1. Click on "Environments" in the left sidebar
2. Click "Create Environment"
3. Name it "Local Development"
4. Add variables:
   - `base_url` = `http://localhost:8000/api`
   - `token` = (leave empty, will be set automatically)

### Step 3: Create Requests

#### Register Request
1. Click "Add Request" in your collection
2. Name: "Register User"
3. Method: POST
4. URL: `{{base_url}}/register`
5. Headers:
   - `Content-Type`: `application/json`
   - `Accept`: `application/json`
6. Body → raw → JSON:
   ```json
   {
       "name": "Ahmad",
       "surname": "Hassan",
       "phone": "9123456789",
       "email": "ahmad@example.com",
       "date_of_birth": "1990-01-15",
       "gender": "male",
       "password": "password123",
       "password_confirmation": "password123"
   }
   ```
7. Tests tab (to auto-save token):
   ```javascript
   if (pm.response.code === 201) {
       var jsonData = pm.response.json();
       pm.environment.set("token", jsonData.data.token);
   }
   ```

#### Login Request
1. Click "Add Request"
2. Name: "Login User"
3. Method: POST
4. URL: `{{base_url}}/login`
5. Headers:
   - `Content-Type`: `application/json`
   - `Accept`: `application/json`
6. Body → raw → JSON:
   ```json
   {
       "credential": "ahmad@example.com",
       "password": "password123"
   }
   ```
7. Tests tab:
   ```javascript
   if (pm.response.code === 200) {
       var jsonData = pm.response.json();
       pm.environment.set("token", jsonData.data.token);
   }
   ```

#### Get User Profile Request
1. Click "Add Request"
2. Name: "Get User Profile"
3. Method: GET
4. URL: `{{base_url}}/user`
5. Headers:
   - `Content-Type`: `application/json`
   - `Accept`: `application/json`
6. Authorization tab:
   - Type: Bearer Token
   - Token: `{{token}}`

#### Logout Request
1. Click "Add Request"
2. Name: "Logout"
3. Method: POST
4. URL: `{{base_url}}/logout`
5. Headers:
   - `Content-Type`: `application/json`
   - `Accept`: `application/json`
6. Authorization tab:
   - Type: Bearer Token
   - Token: `{{token}}`

---

## Testing Scenarios

### Scenario 1: Complete Registration Flow
1. Send "Register User" request
2. Verify you get a 201 response with user data and token
3. Token should be automatically saved to environment
4. Send "Get User Profile" request to verify authentication works

### Scenario 2: Login Flow
1. Send "Login User" request with email
2. Verify you get a 200 response with user data and token
3. Send "Get User Profile" request to verify authentication works

### Scenario 3: Login with Phone
1. Change credential in "Login User" to phone number (e.g., "9123456789")
2. Send request
3. Verify successful login

### Scenario 4: Validation Errors
1. Try registering with invalid phone (e.g., "1234567890" - doesn't start with 9)
2. Verify you get 422 error with validation message
3. Try registering with duplicate phone number
4. Verify you get 422 error

### Scenario 5: Invalid Credentials
1. Send "Login User" with wrong password
2. Verify you get 401 error with "Invalid credentials" message

### Scenario 6: Logout
1. After logging in, send "Logout" request
2. Verify you get success message
3. Try sending "Get User Profile" again - should fail with 401

---

## Phone Number Validation Rules

✅ **Valid Syrian Phone Numbers:**
- `9123456789` (starts with 9, 10 digits total)
- `9987654321`
- `9111111111`

❌ **Invalid Phone Numbers:**
- `1234567890` (doesn't start with 9)
- `912345678` (only 9 digits)
- `91234567890` (11 digits)
- `+9123456789` (contains +)
- `09123456789` (starts with 0)

---

## Common Issues & Solutions

### Issue 1: "Route not found"
**Solution:** Make sure your Laravel server is running (`php artisan serve`)

### Issue 2: "CSRF token mismatch"
**Solution:** Add `Accept: application/json` header to all requests

### Issue 3: "Unauthenticated" on protected routes
**Solution:** Make sure you're sending the Bearer token in Authorization header

### Issue 4: "Column not found" errors
**Solution:** Run migrations: `php artisan migrate`

### Issue 5: "Class 'Laravel\Sanctum\HasApiTokens' not found"
**Solution:** Sanctum should be installed. Check `composer.json` for `laravel/sanctum`

---

## Quick Test with cURL

### Register
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Ahmad",
    "surname": "Hassan",
    "phone": "9123456789",
    "email": "ahmad@example.com",
    "date_of_birth": "1990-01-15",
    "gender": "male",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "credential": "ahmad@example.com",
    "password": "password123"
  }'
```

### Get User (replace TOKEN with actual token)
```bash
curl -X GET http://localhost:8000/api/user \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer TOKEN"
```

---

## Notes

- All API responses follow a consistent format with `success`, `message`, and `data`/`errors` fields
- Tokens are generated using Laravel Sanctum
- Phone numbers must be Syrian format (start with 9, 10 digits total)
- Email is optional during registration
- Login accepts either email or phone number in the same `credential` field
- Password must be at least 8 characters
- Date of birth must be in the past
- Gender must be either "male" or "female"
