<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); }
        .header { background-color: #0f172a; color: #ffffff; padding: 40px; text-align: center; }
        .content { padding: 40px; text-align: center; color: #334155; }
        .otp-code { font-size: 48px; font-weight: 900; letter-spacing: 12px; color: #0ea5e9; margin: 30px 0; padding: 20px; background-color: #f0f9ff; border-radius: 12px; display: inline-block; }
        .footer { padding: 20px; text-align: center; color: #94a3b8; font-size: 12px; border-top: 1px solid #f1f5f9; }
        .warning { color: #ef4444; font-size: 12px; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px; text-transform: uppercase; letter-spacing: 4px;">RD-VIROLOGI</h1>
            <p style="margin:10px 0 0; opacity: 0.7; font-size: 14px;">Defense Intelligence Portal</p>
        </div>
        <div class="content">
            <h2 style="margin:0; color: #0f172a;">Identity Verification Required</h2>
            <p style="margin:15px 0;">Your access request to the security panel requires a second factor of authentication. Please use the following one-time password:</p>
            
            <div class="otp-code">{{ $otp }}</div>
            
            <p style="margin:0;">This code will expire in <strong>5 minutes</strong>.</p>
            
            <p class="warning italic text-red-500">If you did not initiate this request, please contact the cybersecurity department immediately.</p>
        </div>
        <div class="footer">
            &copy; 2026 RD-VIROLOGI. Tactical Research & Defensive Technologies.
        </div>
    </div>
</body>
</html>
