# Quick API Test

## Start the server
```bash
php artisan serve
```

## Test Registration (using PowerShell)

```powershell
$body = @{
    name = "Ahmad"
    surname = "Hassan"
    phone = "9123456789"
    email = "ahmad@example.com"
    date_of_birth = "1990-01-15"
    gender = "male"
    password = "password123"
    password_confirmation = "password123"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/register" -Method Post -Body $body -ContentType "application/json"
```

## Test Login (using PowerShell)

```powershell
$body = @{
    credential = "ahmad@example.com"
    password = "password123"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/login" -Method Post -Body $body -ContentType "application/json"
$token = $response.data.token
Write-Host "Token: $token"
```

## Test Get User Profile (using PowerShell)

```powershell
$headers = @{
    "Authorization" = "Bearer $token"
    "Accept" = "application/json"
}

Invoke-RestMethod -Uri "http://localhost:8000/api/user" -Method Get -Headers $headers
```

## Or use the POSTMAN_API_TESTING_GUIDE.md for detailed Postman instructions
