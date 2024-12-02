<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verification Code</title>
</head>
<body>
    <h1>Verification Code</h1>
    <p>Dear {{ $name }},</p>
    <p>Your verification code is: <strong>{{ $token }}</strong></p>
    <p>If you did not request this, please ignore this email.</p>
    <p>Best regards,<br>Smart Platform</p>
</body>
</html>
