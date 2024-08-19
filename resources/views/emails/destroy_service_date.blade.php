<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Deleted</title>
</head>
<body>

    <p>Dear Admin,</p>

    <p>We regret to inform you that the following service has been deleted:</p>

    <p><strong>Service ID:</strong> {{ $service_id }}</p>

    <p>To review the deleted details, <a href="{{ $url }}">click here</a>.</p>


    <p>Thank you.</p>

    <p>Best regards,<br>{{ $user }}</p>
</body>
</html>
