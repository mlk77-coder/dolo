# Email Marketing - Quick Start Guide

## ✅ Setup Complete!

The "App Notifications" section has been replaced with a complete **Email Marketing System**.

## Access

Visit: **http://127.0.0.1:8000/email-marketing**

## Quick Steps to Send Email

### 1. Click "Compose Email"
### 2. Fill in the form:
   - **Subject**: Your email subject line
   - **Message**: Your email content
   - **Recipients**: Choose "All Customers" or "Selected Customers"

### 3. (Optional) Click "Preview" to see how it looks

### 4. Click "Send Email"

Done! ✅

## Before First Use

Configure email settings in `.env` file:

### For Testing (Mailtrap):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourapp.com"
MAIL_FROM_NAME="Your App Name"
```

### For Gmail (Testing Only):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Your App Name"
```

**Note**: For Gmail, you need to create an "App Password" in your Google Account settings.

## Features

✅ Send to all customers or select specific ones
✅ Preview email before sending
✅ Professional email template
✅ Personalized with customer name
✅ Success/failure tracking
✅ Mobile-friendly emails

## Example Email

```
Subject: 🎉 New Deals Available!

Message:
We're excited to announce brand new deals just for you!

Check out our latest offers with up to 50% off.

Visit our app to explore all deals.

Best regards,
The Team
```

## Menu Location

Look for **"Email Marketing"** in the sidebar menu (replaced "Notifications").

## Test It

1. Go to `/email-marketing/create`
2. Enter subject: "Test Email"
3. Enter message: "This is a test email"
4. Select "All Customers"
5. Click "Preview" to see how it looks
6. Click "Send Email"

## Need Help?

See `EMAIL_MARKETING_SYSTEM.md` for complete documentation.

That's it! Your email marketing system is ready to use! 🎉
