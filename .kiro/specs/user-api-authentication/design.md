# Design Document: User API Authentication

## Overview

This design implements a RESTful API authentication system for user registration and login using Laravel Sanctum for token-based authentication. The system supports Syrian phone numbers (starting with 9), optional email addresses, and flexible login credentials.

## Architecture

### Technology Stack
- **Authentication:** Laravel Sanctum (token-based API authentication)
- **Validation:** Laravel Form Request classes
- **Database:** Existing Laravel migrations (users table modification)
- **API Format:** JSON responses with consistent structure

### API Endpoints

```
POST /api/register
POST /api/login
```

### Database Schema

The existing `users` table will be modified to include:
- `name` (string, required)
- `surname` (string, required)
- `phone` (string, unique, required) - Syrian phone number starting with 9
- `email` (string, unique, nullable) - Optional email
- `date_of_birth` (date, required)
- `gender` (enum: male/female, required)
- `password` (string, hashed, required)
- `email_verified_at` (timestamp, nullable)
- `remember_token` (string, nullable)
- `timestamps` (created_at, updated_at)

## Components and Interfaces

### 1. API Controllers

**AuthController**
- `register(RegisterRequest $request): JsonResponse`
  - Validates registration data
  - Creates new user
  - Generates Sanctum token
  - Returns user data + token

- `login(LoginRequest $request): JsonResponse`
  - Validates login credentials
  - Detects credential type (email vs phone)
  - Authenticates user
  - Generates Sanctum token
  - Returns user data + token

### 2. Form Request Classes

**RegisterRequest**
- Validates: name, surname, phone, email (optional), date_of_birth, gender, password
- Custom rules:
  - Phone: starts with 9, exactly 10 digits, unique
  - Email: valid format, unique (if provided)
  - Date of birth: valid date, in the past
  - Gender: in ['male', 'female']
  - Password: min 8 characters

**LoginRequest**
- Validates: credential (email or phone), password
- Custom logic: detects if credential is email or phone

### 3. API Resources

**UserResource**
- Transforms user model to JSON
- Excludes sensitive fields (password, remember_token)
- Includes: id, name, surname, phone, email, date_of_birth, gender, created_at

### 4. Middleware

- `api` middleware group (already configured in Laravel)
- Sanctum authentication for protected routes

## Data Models

### User Model Updates

```php
protected $fillable = [
    'name',
    'surname', 
    'phone',
    'email',
    'date_of_birth',
    'gender',
    'password',
];

protected $hidden = [
    'password',
    'remember_token',
];

protected $casts = [
    'email_verified_at' => 'datetime',
    'date_of_birth' => 'date',
    'password' => 'hashed',
];
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Phone Number Validation
*For any* registration request with a phone number, the phone number should start with 9 and be exactly 10 digits long.
**Validates: Requirements 1.2, 1.3**

### Property 2: Unique Phone Numbers
*For any* two users in the system, their phone numbers should be different.
**Validates: Requirements 1.10**

### Property 3: Unique Emails
*For any* two users in the system with non-null emails, their email addresses should be different.
**Validates: Requirements 1.11**

### Property 4: Password Security
*For any* user in the database, the stored password should be a bcrypt hash, not plain text.
**Validates: Requirements 5.1**

### Property 5: Successful Registration Returns Token
*For any* valid registration request, the response should include an authentication token.
**Validates: Requirements 1.9**

### Property 6: Login Credential Detection
*For any* login request, if the credential contains an @ symbol, it should be treated as email; otherwise, it should be treated as phone number.
**Validates: Requirements 2.7**

### Property 7: Successful Login Returns Token and User Data
*For any* valid login request, the response should include both an authentication token and user profile information.
**Validates: Requirements 2.4, 2.6**

### Property 8: Password Never in Response
*For any* API response containing user data, the password field should not be present.
**Validates: Requirements 5.5**

### Property 9: Validation Error Format
*For any* request that fails validation, the response should have status 422 and include an "errors" object with field-specific messages.
**Validates: Requirements 3.3, 3.6**

### Property 10: Gender Validation
*For any* registration request, the gender field should only accept "male" or "female".
**Validates: Requirements 1.7**

## Error Handling

### Validation Errors (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "phone": ["The phone number must start with 9 and be 10 digits long."],
        "email": ["The email has already been taken."]
    }
}
```

### Authentication Errors (401)
```json
{
    "success": false,
    "message": "Invalid credentials"
}
```

### Success Response (200/201)
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
            "created_at": "2024-01-01T10:00:00.000000Z"
        },
        "token": "1|abc123xyz..."
    }
}
```

## Testing Strategy

### Unit Tests
- Test phone number validation logic
- Test email validation logic (including optional)
- Test credential type detection (email vs phone)
- Test password hashing
- Test unique constraint violations
- Test gender validation

### Property-Based Tests
- Generate random valid/invalid phone numbers and verify validation
- Generate random user data and verify uniqueness constraints
- Generate random credentials and verify detection logic
- Verify password never appears in responses across all scenarios

### Integration Tests
- Test complete registration flow
- Test complete login flow with email
- Test complete login flow with phone
- Test registration with optional email (null)
- Test registration with provided email
- Test duplicate phone number rejection
- Test duplicate email rejection
- Test invalid credentials rejection

### API Testing (Postman/Manual)
- Register new user with all fields
- Register new user without email
- Login with email
- Login with phone number
- Test validation errors
- Test duplicate registration attempts

**Testing Framework:** Pest PHP with minimum 100 iterations per property test.

**Test Tags:** Each property test will be tagged with:
```php
// Feature: user-api-authentication, Property 1: Phone Number Validation
```

## Implementation Notes

### Laravel Sanctum Setup
1. Sanctum is already installed (check composer.json)
2. Ensure `HasApiTokens` trait is added to User model
3. Configure sanctum middleware in `api` routes

### Migration Strategy
1. Create migration to modify existing `users` table
2. Add new columns: surname, phone, date_of_birth, gender
3. Make email nullable
4. Add unique index on phone
5. Ensure email unique index exists

### Route Configuration
- API routes will be in `routes/api.php`
- No authentication middleware on register/login endpoints
- Use `api` middleware group for rate limiting

### Validation Rules
```php
// Phone validation
'phone' => ['required', 'string', 'regex:/^9\d{9}$/', 'unique:users,phone']

// Email validation (optional)
'email' => ['nullable', 'email', 'unique:users,email']

// Date of birth validation
'date_of_birth' => ['required', 'date', 'before:today']

// Gender validation
'gender' => ['required', 'in:male,female']
```

### Security Considerations
- Use bcrypt for password hashing (Laravel default)
- Rate limit API endpoints (60 requests per minute)
- Validate all input data
- Never expose password in responses
- Use HTTPS in production
- Implement CORS properly for mobile apps
