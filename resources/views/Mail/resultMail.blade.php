<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Poll Results - {{ env('APP_NAME') }}</title>
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

        .poll-info {
            text-align: center;
            margin-bottom: 24px;
        }

        .total-votes {
            display: inline-block;
            background: #f8f8f8;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            color: #666666;
        }

        .option {
            margin-bottom: 16px;
        }

        .option-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .option-name {
            font-weight: 600;
        }

        .option-votes {
            color: #666666;
        }

        .progress-bar {
            height: 24px;
            background: #f0f0f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #9b87f5;
            border-radius: 12px;
            transition: width 0.3s ease;
        }

        .footer {
            background: #f5f5f5;
            padding: 16px 24px;
            text-align: center;
            font-size: 14px;
            color: #666666;
        }

        .gradient-1 {
            background: #9b87f5;
        }

        .gradient-2 {
            background: #7E69AB;
        }

        .gradient-3 {
            background: #6E59A5;
        }

        .gradient-4 {
            background: #8B5CF6;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0;font-size:24px">Poll Results</h1>
        </div>
        <div class="content">

            <div class="poll-info">
                <h2 style="margin:0 0 16px;color:#333333">{{ $poll_data['title'] }}</h2>
                <span class="total-votes">Total Votes: {{ $poll_data['total_vote'] }}</span>
            </div>
            @foreach ($poll_data['result'] as $optionResult)
                <div class="option">
                    <div class="option-header">
                        <span class="option-name">{{ $optionResult['option'] }}</span>
                        <span class="option-votes">{{ $optionResult['votes'] }} votes
                            ({{ $optionResult['percentage'] }}%)
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill gradient-1" style="width: {{ $optionResult['percentage'] }}%"></div>
                    </div>
                </div>
            @endforeach


            <p style="margin-top:32px;text-align:center">
                Thank you for participating in our poll! View more details on our website.
            </p>
        </div>
        <div class="footer">
            <div>© {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.</div>
            <div style="margin-top:8px">
                <a href="#" style="color:#666666;text-decoration:none;margin:0 8px">Privacy Policy</a>
                <a href="#" style="color:#666666;text-decoration:none;margin:0 8px">Terms of Service</a>
                <a href="#" style="color:#666666;text-decoration:none;margin:0 8px">Unsubscribe</a>
            </div>
        </div>
    </div>
</body>

</html>
