<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .icon {
            text-align: center;
            font-size: 60px;
            margin: 20px 0;
        }
        .message {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #6c757d;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registration Status Update</h1>
        </div>
        <div class="content">
            <div class="icon">❌</div>
            <h2>Hello, {{ $user->name }}</h2>
            <p>We regret to inform you that your registration with <strong>{{ config('app.name') }}</strong> has not been approved at this time.</p>
            
            <div class="message">
                <strong>ℹ️ What This Means</strong><br>
                Your registration request has been reviewed and we are unable to approve your account at this time.
            </div>
            
            <p><strong>Account Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Status:</strong> Not Approved</li>
                <li><strong>Date:</strong> {{ now()->format('F d, Y H:i') }}</li>
            </ul>
            
            <p>If you believe this is a mistake or would like more information, please contact our support team.</p>
            
            <p style="text-align: center;">
                <a href="mailto:{{ config('mail.from.address') }}" class="btn">Contact Support</a>
            </p>
            
            <p>Thank you for your interest in {{ config('app.name') }}.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>
