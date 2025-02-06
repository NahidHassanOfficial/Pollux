<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to {{ env('APP_NAME') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: #9b87f5;
            color: white;
            padding: 32px 24px;
            text-align: center;
        }

        .content {
            padding: 32px 24px;
            color: #444444;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 16px 0;
        }

        .button {
            display: inline-block;
            background: #9b87f5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 16px 0;
        }

        .footer {
            background: #f5f5f5;
            padding: 16px 24px;
            text-align: center;
            font-size: 14px;
            color: #666666;
        }

        .footer a {
            color: #666666;
            text-decoration: none;
            margin: 0 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0;font-size:24px">Welcome to Pollux! 🎉</h1>
        </div>

        <div class="content">
            <p>Hi {{ $username }},</p>

            <p>Thank you for joining Pollux! We're excited to have you on board.</p>

            <div class="feature">
                ✨ Create beautiful polls in minutes
            </div>
            <div class="feature">
                👥 Collaborate with your team in real-time
            </div>
            <div class="feature">
                📊 Get instant insights and analytics
            </div>

            <center>
                <a href="#" class="button">Get Started Now</a>
            </center>

            <p>Need help? Check out our <a href="#" style="color:#9b87f5">documentation</a> or <a href="#"
                    style="color:#9b87f5">contact support</a>.</p>

            <p>Best regards,<br>The Pollux Team</p>
        </div>

        <div class="footer">
            <div>© {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.</div>
            <div style="margin-top:8px">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Unsubscribe</a>
            </div>
        </div>
    </div>
</body>

</html>
