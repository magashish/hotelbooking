<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service Date</title>
</head>
<body>

    <p>Dear Admin,</p>

    <p>We are writing to inform you about the add to service dates:</p>

        @foreach($mail_data as $id => $data)
        <div>
            <p><strong>Arrival Date:</strong> {{ $data['arrival_date'] }}</p>
            <p><strong>Arrival Time:</strong> {{ $data['arrival_time'] }}</p>
            <p><strong>Departure Date:</strong> {{ $data['departure_date'] }}</p>
            <p><strong>Departure Time:</strong> {{ $data['departure_time'] }}</p>
            <p><strong>Room Code:</strong> {{ $data['room_code'] }}</p>
            <p><strong>Notes:</strong> {{ $data['notes'] }}</p>
            <p><strong>User:</strong> {{ $data['user'] }}</p>
            <p>Please review the details and <a href="{{ $data['url'] }}">click here</a> to make any necessary edits.</p>
            
        </div>
        <hr>
    @endforeach

   {{--  <p><strong>Arrival Date:</strong> {{ $arrival_date }}</p>
    <p><strong>Arrival Time:</strong> {{ $arrival_time }}</p>
    <p><strong>Departure Date:</strong> {{ $departure_date }}</p>
    <p><strong>Departure Time:</strong> {{ $departure_time }}</p>
    <p><strong>Room Code:</strong> {{ $room_code }}</p>
    <p><strong>Notes:</strong> {{ $notes }}</p>
    <p>Please review the updated details and <a href="{{ $url }}">click here</a> to make any necessary edits.</p> --}}

    <p>Thank you!</p>
    <p>Best regards,<br>Rental Project Database</p>
</body>
</html>
