<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service Date</title>
</head>
<body>

    <p>Dear Admin,</p>

    <p>We are writing to inform you about the updates to service dates:</p>

    <p><strong>Arrival Date:</strong> {{ $arrival_date }}</p>
    <p><strong>Arrival Time:</strong> {{ $arrival_time }}</p>
    <p><strong>Departure Date:</strong> {{ $departure_date }}</p>
    <p><strong>Departure Time:</strong> {{ $departure_time }}</p>
    <p><strong>Room Code:</strong> {{ $room_code }}</p>
    <p><strong>Notes:</strong> {{ $notes }}</p>

    <p>Please review the updated details and <a href="{{ $url }}">click here</a> to make any necessary edits.</p>

    <p>Thank you!</p>

    <p>Best regards,<br>{{ $user }}</p>
</body>
</html>
