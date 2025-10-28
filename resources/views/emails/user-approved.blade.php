<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Approved</title>
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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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
            background: #d4edda;
            border-left: 4px solid #28a745;
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
            background: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Account Approved!</h1>
        </div>
        <div class="content">
            <div class="icon">✅</div>
            <h2>Great News, {{ $user->name }}!</h2>
            <p>Your account has been <strong>approved</strong> by our admin team!</p>
            
            <div class="message">
                <strong>✨ You can now log in!</strong><br>
                Your account is now active and ready to use. You can sign in using Google authentication.
            </div>
            
            <p><strong>Account Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Status:</strong> ✅ Approved</li>
                <li><strong>Approved:</strong> {{ now()->format('F d, Y H:i') }}</li>
            </ul>
            
            <p style="text-align: center;">
                <a href="{{ url('/user/login') }}" class="btn">Login Now</a>
            </p>
            
            <p>Click the button above to access your account, or visit: <br>
            <a href="{{ url('/user/login') }}">{{ url('/user/login') }}</a></p>
            
            <p>Thank you for joining <strong>{{ config('app.name') }}</strong>!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>
