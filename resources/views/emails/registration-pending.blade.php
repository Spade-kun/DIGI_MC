<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Pending</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: #fff3cd;
            border-left: 4px solid #ffc107;
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
            background: #667eea;
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
            <h1>Registration Pending</h1>
        </div>
        <div class="content">
            <div class="icon">⏳</div>
            <h2>Hello, {{ $user->name }}!</h2>
            <p>Thank you for registering with <strong>{{ config('app.name') }}</strong>!</p>
            <p>Your registration has been received and is currently <strong>pending admin approval</strong>.</p>
            
            <div class="message">
                <strong>⚠️ What's Next?</strong><br>
                Our admin team will review your registration shortly. You will receive another email once your account has been approved.
            </div>
            
            <p><strong>Registration Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Status:</strong> Pending Approval</li>
                <li><strong>Registered:</strong> {{ $user->created_at ? $user->created_at->format('F d, Y H:i') : now()->format('F d, Y H:i') }}</li>
            </ul>
            
            <p>Please wait for the approval notification before attempting to log in.</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>
