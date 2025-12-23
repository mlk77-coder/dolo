# Implementation Plan: User API Authentication

## Overview

This implementation plan breaks down the User API Authentication feature into discrete coding tasks. Each task builds on previous steps to create a complete registration and login API system with Laravel Sanctum.

## Tasks

- [x] 1. Setup Laravel Sanctum and prepare User model
  - Install/verify Laravel Sanctum is configured
  - Add `HasApiTokens` trait to User model
  - Update User model fillable fields and casts
  - _Requirements: 4.1, 4.2, 5.2_

- [x] 2. Create database migration for users table modifications
  - Create migration to add surname, phone, date_of_birth, gender columns
  - Make email column nullable
  - Add unique index on phone column
  - Run migration
  - _Requirements: 5.2, 5.3, 5.4_

- [x] 3. Create API routes
  - Add POST /api/register route
  - Add POST /api/login route
  - Configure rate limiting for API routes
  - _Requirements: 1.1, 2.1_

- [ ] 4. Create Form Request validation classes
  - [x] 4.1 Create RegisterRequest with validation rules
    - Validate name, surname (required strings)
    - Validate phone (required, starts with 9, 10 digits, unique)
    - Validate email (nullable, email format, unique)
    - Validate date_of_birth (required, date, before today)
    - Validate gender (required, in: male, female)
    - Validate password (required, min 8 characters, confirmed)
    - _Requirements: 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8, 1.10, 1.11_

  - [x] 4.2 Create LoginRequest with validation rules
    - Validate credential (required, string)
    - Validate password (required, string)
    - _Requirements: 2.1_

- [x] 5. Create UserResource for API responses
  - Transform User model to JSON
  - Include: id, name, surname, phone, email, date_of_birth, gender, created_at
  - Exclude: password, remember_token
  - _Requirements: 5.5_

- [ ] 6. Create AuthController with register method
  - [x] 6.1 Implement register method
    - Accept RegisterRequest
    - Create new user with validated data
    - Hash password automatically (Laravel default)
    - Generate Sanctum token
    - Return JSON response with user data and token
    - _Requirements: 1.1, 1.9, 4.1, 5.1_

  - [ ] 6.2 Write property test for phone number validation
    - **Property 1: Phone Number Validation**
    - **Validates: Requirements 1.2, 1.3**

  - [ ] 6.3 Write property test for unique phone numbers
    - **Property 2: Unique Phone Numbers**
    - **Validates: Requirements 1.10**

  - [ ] 6.4 Write property test for password hashing
    - **Property 4: Password Security**
    - **Validates: Requirements 5.1**

  - [ ] 6.5 Write unit tests for registration
    - Test successful registration with all fields
    - Test successful registration without email
    - Test duplicate phone number rejection
    - Test duplicate email rejection
    - Test validation errors for each field
    - _Requirements: 1.1, 1.5, 1.10, 1.11, 1.12_

- [ ] 7. Implement login method in AuthController
  - [x] 7.1 Implement credential detection logic
    - Detect if credential is email (contains @) or phone number
    - Query user by appropriate field
    - _Requirements: 2.2, 2.3, 2.7_

  - [x] 7.2 Implement authentication logic
    - Verify password using Hash::check()
    - Generate Sanctum token on success
    - Return user data and token
    - Return error on invalid credentials
    - _Requirements: 2.1, 2.4, 2.5, 2.6_

  - [ ] 7.3 Write property test for credential detection
    - **Property 6: Login Credential Detection**
    - **Validates: Requirements 2.7**

  - [ ] 7.4 Write property test for successful login response
    - **Property 7: Successful Login Returns Token and User Data**
    - **Validates: Requirements 2.4, 2.6**

  - [ ] 7.5 Write unit tests for login
    - Test login with email
    - Test login with phone number
    - Test login with invalid credentials
    - Test login with non-existent user
    - _Requirements: 2.1, 2.2, 2.3, 2.5_

- [ ] 8. Implement consistent API response formatting
  - [x] 8.1 Create helper methods or traits for response formatting
    - Success response format (status 200/201)
    - Error response format (status 422/401)
    - Include success field, message, and data/errors
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6_

  - [ ] 8.2 Write property test for password never in response
    - **Property 8: Password Never in Response**
    - **Validates: Requirements 5.5**

  - [ ] 8.3 Write property test for validation error format
    - **Property 9: Validation Error Format**
    - **Validates: Requirements 3.3, 3.6**

- [ ] 9. Integration testing and final verification
  - [ ] 9.1 Write integration tests for complete flows
    - Test complete registration flow
    - Test complete login flow with email
    - Test complete login flow with phone
    - Test authenticated API request with token
    - _Requirements: 1.1, 2.1, 4.3_

  - [ ] 9.2 Manual API testing preparation
    - Document Postman collection examples
    - Verify all endpoints work correctly
    - Test error scenarios
    - _Requirements: All_

- [ ] 10. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Each task references specific requirements for traceability
- Property tests validate universal correctness properties
- Unit tests validate specific examples and edge cases
- Laravel Sanctum provides token-based authentication out of the box
- Phone validation uses regex: `/^9\d{9}$/` (starts with 9, total 10 digits)
- Email is optional (nullable) but must be unique if provided
- Password is automatically hashed by Laravel when using `'password' => 'hashed'` cast
