<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; background: #f4f6f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
        .header { background: #1a5c2e; padding: 24px 28px; }
        .header-title { color: #fff; font-size: 20px; font-weight: 700; margin: 0; }
        .header-sub { color: #a5d6b0; font-size: 13px; margin-top: 4px; }
        .body { padding: 28px; }
        .greeting { font-size: 16px; color: #1a2e1e; margin-bottom: 16px; }
        .message-box { background: #f8fdf9; border-left: 4px solid #1a5c2e; border-radius: 8px; padding: 16px 20px; font-size: 14px; color: #2d4a35; line-height: 1.7; margin-bottom: 20px; }
        .footer-note { font-size: 12px; color: #888; margin-top: 20px; line-height: 1.6; }
        .footer { background: #f0fbf4; padding: 16px 28px; border-top: 1px solid #e0e8e2; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="header-title">PaddyCare</div>
        <div class="header-sub">Agricultural Advisory — {{ $district }} District</div>
    </div>
    <div class="body">
        <div class="greeting">
            Dear <strong>{{ $farmerName }}</strong>,
        </div>
        <div class="message-box">
            {!! nl2br(e($notifMessage)) !!}
        </div>
        <div class="footer-note">
            This message was sent by <strong>{{ $officerName }}</strong>,
            Field Officer — {{ $district }} District.<br>
            If you have questions, please contact your field officer or visit PaddyCare.
        </div>
    </div>
    <div class="footer">
        2026 PaddyCare · SLIATE Gampaha · Department of Agriculture Sri Lanka
    </div>
</div>
</body>
</html>