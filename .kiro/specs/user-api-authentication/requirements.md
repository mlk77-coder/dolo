# Requirements Document

## Introduction

This document specifies the requirements for a User API Authentication system that allows users to register and login via API endpoints. The system supports Syrian phone numbers, optional email addresses, and flexible login credentials (email or phone number).

## Glossary

- **User**: An individual who registers and authenticates with the system
- **API**: Application Programming Interface - RESTful endpoints for mobile/external applications
- **Syrian_Phone_Number**: A phone number starting with 9 (Syrian format)
- **Authentication_Token**: A secure token (Laravel Sanctum) used to authenticate API requests
- **Login_Credential**: Either an email address or phone number used for authentication

## Requirements

### Requirement 1: User Registration

**User Story:** As a new user, I want to register via API with my personal information, so that I can create an account and access the platform.

#### Acceptance Criteria

1. WHEN a user submits registration data with name, surname, Syrian phone number, date of birth, gender, and password THEN the System SHALL create a new user account
2. WHEN a user submits a phone number THEN the System SHALL validate it starts with 9
3. WHEN a user submits a phone number THEN the System SHALL validate it is exactly 9 digits after the leading 9 (10 digits total)
4. WHEN a user submits an email THEN the System SHALL validate it is a valid email format
5. WHEN a user submits registration data without an email THEN the System SHALL accept the registration (email is optional)
6. WHEN a user submits a date of birth THEN the System SHALL validate it is a valid date in the past
7. WHEN a user submits a gender THEN the System SHALL validate it is either "male" or "female"
8. WHEN a user submits a password THEN the System SHALL validate it is at least 8 characters long
9. WHEN a user successfully registers THEN the System SHALL return an authentication token
10. WHEN a user attempts to register with a phone number that already exists THEN the System SHALL return an error
11. WHEN a user attempts to register with an email that already exists THEN the System SHALL return an error
12. WHEN registration fails validation THEN the System SHALL return detailed error messages for each field

### Requirement 2: User Login

**User Story:** As a registered user, I want to login via API using my email or phone number, so that I can authenticate and access protected resources.

#### Acceptance Criteria

1. WHEN a user submits a login credential (email or phone) and password THEN the System SHALL authenticate the user
2. WHEN a user submits a phone number as login credential THEN the System SHALL attempt to find the user by phone number
3. WHEN a user submits an email as login credential THEN the System SHALL attempt to find the user by email
4. WHEN a user submits valid credentials THEN the System SHALL return an authentication token
5. WHEN a user submits invalid credentials THEN the System SHALL return an authentication error
6. WHEN a user successfully logs in THEN the System SHALL return user profile information along with the token
7. WHEN a user submits a login credential THEN the System SHALL automatically detect whether it is an email or phone number

### Requirement 3: API Response Format

**User Story:** As a mobile app developer, I want consistent API response formats, so that I can easily integrate with the backend.

#### Acceptance Criteria

1. WHEN an API request succeeds THEN the System SHALL return a JSON response with status code 200 or 201
2. WHEN an API request fails validation THEN the System SHALL return a JSON response with status code 422
3. WHEN an API request fails authentication THEN the System SHALL return a JSON response with status code 401
4. WHEN an API response is successful THEN the System SHALL include a "success" field set to true
5. WHEN an API response fails THEN the System SHALL include a "success" field set to false and a "message" field with error details
6. WHEN validation fails THEN the System SHALL include an "errors" object with field-specific error messages

### Requirement 4: Token Management

**User Story:** As a system administrator, I want secure token-based authentication, so that user sessions are protected.

#### Acceptance Criteria

1. WHEN a user registers or logs in THEN the System SHALL generate a Laravel Sanctum token
2. WHEN a token is generated THEN the System SHALL associate it with the user account
3. WHEN a user makes authenticated API requests THEN the System SHALL validate the token
4. WHEN a token is invalid or expired THEN the System SHALL return an authentication error

### Requirement 5: Data Storage

**User Story:** As a system, I want to securely store user data, so that user information is protected.

#### Acceptance Criteria

1. WHEN a user password is stored THEN the System SHALL hash it using bcrypt
2. WHEN user data is stored THEN the System SHALL store name, surname, phone, email (nullable), date_of_birth, and gender
3. WHEN a phone number is stored THEN the System SHALL ensure it is unique in the database
4. WHEN an email is stored THEN the System SHALL ensure it is unique in the database (if provided)
5. WHEN user data is retrieved THEN the System SHALL never include the password hash in API responses
