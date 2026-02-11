<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Preview - {{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .preview-header {
            background-color: #4F46E5;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 0 0 8px 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .content {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 30px;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            margin-top: 30px;
            font-size: 14px;
            color: #6b7280;
        }
        .footer a {
            color: #4F46E5;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="preview-header">
        <h2 style="margin: 0; font-size: 18px;">📧 Email Preview</h2>
        <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">This is how your email will look to customers</p>
    </div>

    <div class="email-container">
        <div class="header">
            <div class="logo">{{ config('app.name', 'Deals App') }}</div>
        </div>

        <div class="greeting">
            Hello [Customer Name],
        </div>

        <div class="content">
{{ $message }}
        </div>

        <div class="footer">
            <p>Thank you for being a valued customer!</p>
            <p>
                <a href="{{ config('app.url') }}">Visit our website</a>
            </p>
            <p style="font-size: 12px; color: #9ca3af; margin-top: 20px;">
                You received this email because you are a registered customer.<br>
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #4F46E5; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">
            Close Preview
        </button>
    </div>
</body>
</html>
