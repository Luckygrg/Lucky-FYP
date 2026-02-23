<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            color: #c9a961;
            margin: 0;
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 3px;
            font-family: Georgia, serif;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h2 {
            color: #1a1a1a;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .email-body p {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .reset-button {
            display: inline-block;
            padding: 15px 40px;
            background: #c9a961;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #c9a961;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-box p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e8e8e8;
        }
        .email-footer p {
            color: #999;
            font-size: 13px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>SPALUSH</h1>
        </div>
        
        <div class="email-body">
            <h2>Reset Your Password</h2>
            
            <p>Hello {{ $user->name }},</p>
            
            <p>We received a request to reset your password for your SpaLush account. Click the button below to reset your password:</p>
            
            <center>
                <a href="{{ $resetLink }}" class="reset-button">Reset Password</a>
            </center>
            
            <div class="warning-box">
                <p><strong>⚠ Important:</strong> This link will expire in 40 seconds for security reasons. If you don't reset your password within this time, you'll need to request a new link.</p>
            </div>
            
            <p>If you didn't request a password reset, please ignore this email. Your password will remain unchanged.</p>
            
            <p style="color: #999; font-size: 14px; margin-top: 30px;">
                If the button doesn't work, copy and paste this link into your browser:<br>
                <span style="color: #c9a961; word-break: break-all;">{{ $resetLink }}</span>
            </p>
        </div>
        
        <div class="email-footer">
            <p><strong>SpaLush</strong> - Your Premier Spa Booking Platform</p>
            <p>&copy; {{ date('Y') }} SpaLush. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
