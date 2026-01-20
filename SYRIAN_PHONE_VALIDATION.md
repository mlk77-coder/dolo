# 📱 Syrian Phone Number Validation

## ✅ Updated: Syrian Phone Format

The registration API now accepts **Syrian phone numbers** with the following format:

---

## 📋 Phone Number Format

### Requirements:
- **9 digits** total
- **Must start with 9**
- **No spaces, dashes, or special characters**
- **Unique** (cannot be used by another customer)

### Format:
```
9XXXXXXXX
```

### Examples:
```
✅ 912345678  (Valid - 9 digits starting with 9)
✅ 987654321  (Valid - 9 digits starting with 9)
✅ 900000000  (Valid - 9 digits starting with 9)
✅ 999999999  (Valid - 9 digits starting with 9)

❌ 812345678  (Invalid - doesn't start with 9)
❌ 91234567   (Invalid - only 8 digits)
❌ 9123456789 (Invalid - 10 digits)
❌ 9 12345678 (Invalid - contains space)
❌ 9-12345678 (Invalid - contains dash)
❌ +9123456789 (Invalid - contains +)
```

---

## 🔧 Validation Rule

### Regex Pattern:
```php
'phone' => [
    'required',
    'string',
    'regex:/^9\d{8}$/',  // 9 followed by 8 more digits
    'unique:customers,phone'
]
```

### Breakdown:
- `^` - Start of string
- `9` - Must start with 9
- `\d{8}` - Followed by exactly 8 more digits (0-9)
- `$` - End of string
- Total: **9 digits**

---

## 📊 Registration Examples

### Valid Registration
```json
POST /api/register

{
    "name": "Ahmad",
    "surname": "Ali",
    "phone": "912345678",
    "email": "ahmad@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "date_of_birth": "1990-01-15",
    "gender": "male"
}

Response (201):
{
    "success": true,
    "message": "Registration successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Ahmad",
            "phone": "912345678",
            "email": "ahmad@example.com"
        },
        "token": "1|abc123xyz..."
    }
}
```

---

### Invalid Phone - Doesn't Start with 9
```json
POST /api/register

{
    "phone": "812345678"
}

Response (422):
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "phone": [
            "The phone number must be a Syrian number: 9 digits starting with 9 (e.g., 912345678)."
        ]
    }
}
```

---

### Invalid Phone - Too Short
```json
POST /api/register

{
    "phone": "91234567"
}

Response (422):
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "phone": [
            "The phone number must be a Syrian number: 9 digits starting with 9 (e.g., 912345678)."
        ]
    }
}
```

---

### Invalid Phone - Too Long
```json
POST /api/register

{
    "phone": "9123456789"
}

Response (422):
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "phone": [
            "The phone number must be a Syrian number: 9 digits starting with 9 (e.g., 912345678)."
        ]
    }
}
```

---

### Invalid Phone - Already Registered
```json
POST /api/register

{
    "phone": "912345678"  // Already exists
}

Response (422):
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "phone": [
            "This phone number is already registered."
        ]
    }
}
```

---

## 🔐 Login with Phone Number

### Login Using Phone
```json
POST /api/login

{
    "credential": "912345678",
    "password": "password123"
}

Response (200):
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "phone": "912345678",
            "name": "Ahmad"
        },
        "token": "2|xyz789abc..."
    }
}
```

### Login Using Email
```json
POST /api/login

{
    "credential": "ahmad@example.com",
    "password": "password123"
}

Response (200):
{
    "success": true,
    "message": "Login successful"
}
```

---

## 📱 Mobile App Integration

### React Native - Phone Input Validation

```javascript
const validateSyrianPhone = (phone) => {
    // Remove any spaces or special characters
    const cleanPhone = phone.replace(/[^0-9]/g, '');
    
    // Check if it's 9 digits starting with 9
    const regex = /^9\d{8}$/;
    
    if (!regex.test(cleanPhone)) {
        return {
            valid: false,
            message: 'Phone must be 9 digits starting with 9'
        };
    }
    
    return { valid: true };
};

// Usage in registration form
const handleRegister = async () => {
    const phoneValidation = validateSyrianPhone(phoneInput);
    
    if (!phoneValidation.valid) {
        Alert.alert('Invalid Phone', phoneValidation.message);
        return;
    }
    
    // Proceed with registration
    const response = await fetch('http://localhost:8000/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            surname: surname,
            phone: phoneInput,
            email: email,
            password: password,
            password_confirmation: passwordConfirmation,
            date_of_birth: dateOfBirth,
            gender: gender
        })
    });
    
    const result = await response.json();
    
    if (result.success) {
        console.log('Registration successful');
        // Save token
        await AsyncStorage.setItem('auth_token', result.data.token);
    } else {
        console.error('Registration failed:', result.errors);
    }
};
```

---

### React Native - Phone Input Component

```javascript
import React, { useState } from 'react';
import { TextInput, Text, View } from 'react-native';

const PhoneInput = ({ value, onChangeText, error }) => {
    const [isValid, setIsValid] = useState(true);
    
    const handleChange = (text) => {
        // Only allow numbers
        const cleaned = text.replace(/[^0-9]/g, '');
        
        // Limit to 9 digits
        const limited = cleaned.slice(0, 9);
        
        // Validate
        const valid = /^9\d{8}$/.test(limited);
        setIsValid(valid || limited.length < 9);
        
        onChangeText(limited);
    };
    
    return (
        <View>
            <TextInput
                value={value}
                onChangeText={handleChange}
                placeholder="912345678"
                keyboardType="phone-pad"
                maxLength={9}
                style={{
                    borderWidth: 1,
                    borderColor: isValid ? '#ccc' : 'red',
                    padding: 10,
                    borderRadius: 5
                }}
            />
            {!isValid && (
                <Text style={{ color: 'red', fontSize: 12 }}>
                    Phone must be 9 digits starting with 9
                </Text>
            )}
            {error && (
                <Text style={{ color: 'red', fontSize: 12 }}>
                    {error}
                </Text>
            )}
        </View>
    );
};

export default PhoneInput;
```

---

## 🧪 Testing

### Using Postman

**Register with Syrian Phone:**
```
POST http://localhost:8000/api/register

Body (JSON):
{
    "name": "Ahmad",
    "surname": "Ali",
    "phone": "912345678",
    "email": "ahmad@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "date_of_birth": "1990-01-15",
    "gender": "male"
}
```

**Login with Phone:**
```
POST http://localhost:8000/api/login

Body (JSON):
{
    "credential": "912345678",
    "password": "password123"
}
```

---

### Using cURL

**Register:**
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Ahmad",
    "surname": "Ali",
    "phone": "912345678",
    "email": "ahmad@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "date_of_birth": "1990-01-15",
    "gender": "male"
  }'
```

**Login:**
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "credential": "912345678",
    "password": "password123"
  }'
```

---

## 📊 Valid Syrian Phone Numbers

All these are valid Syrian phone numbers:

```
900000000
911111111
922222222
933333333
944444444
955555555
966666666
977777777
988888888
999999999
912345678
987654321
945678901
```

---

## ⚠️ Common Mistakes

### 1. Including Country Code
```
❌ +963912345678  (Don't include +963)
✅ 912345678      (Just the 9-digit number)
```

### 2. Adding Spaces or Dashes
```
❌ 9 1234 5678    (No spaces)
❌ 9-1234-5678    (No dashes)
❌ 9.1234.5678    (No dots)
✅ 912345678      (No separators)
```

### 3. Wrong Length
```
❌ 91234567       (8 digits - too short)
❌ 9123456789     (10 digits - too long)
✅ 912345678      (9 digits - correct)
```

### 4. Not Starting with 9
```
❌ 812345678      (Starts with 8)
❌ 012345678      (Starts with 0)
✅ 912345678      (Starts with 9)
```

---

## 🔒 Security Notes

### Phone Number is Unique Identifier
- ✅ Each phone number can only be registered once
- ✅ Phone number cannot be changed after registration
- ✅ Used for login (as credential)
- ✅ Ensures user account security

### Why Phone Cannot Be Updated
- Phone is the primary unique identifier
- Prevents account hijacking
- Maintains data integrity
- If user needs new phone, they must create new account

---

## 📁 Files Updated

1. **Validation File:**
   ```
   app/Http/Requests/Api/RegisterRequest.php
   ```
   - Updated regex from `/^9\d{9}$/` to `/^9\d{8}$/`
   - Updated error message
   - Now accepts 9 digits starting with 9

2. **Documentation:**
   ```
   SYRIAN_PHONE_VALIDATION.md (this file)
   ```

---

## ✅ Summary

**Phone Format:** 9 digits starting with 9

**Examples:**
- ✅ `912345678` - Valid
- ✅ `987654321` - Valid
- ❌ `812345678` - Invalid (doesn't start with 9)
- ❌ `91234567` - Invalid (only 8 digits)
- ❌ `9123456789` - Invalid (10 digits)

**Features:**
- ✅ Syrian phone number format
- ✅ Unique validation
- ✅ Works with login
- ✅ Cannot be updated after registration
- ✅ Clear error messages

**Ready to use!** 🚀
