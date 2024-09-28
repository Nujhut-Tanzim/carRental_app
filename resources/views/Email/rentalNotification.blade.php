<!DOCTYPE html>
<html>
<head>
    <title>Car Rental Confirmation</title>
</head>
<body>
    <h1>Rental Confirmation</h1>
    <p>Dear {{ $rental->user->name }},</p>
    <p>Your rental for the car "{{ $rental->car->name }}" has been confirmed.</p>
    <p><strong>Rental Details:</strong></p>
    <ul>
        <li>Start Date: {{ $rental->start_date }}</li>
        <li>End Date: {{ $rental->end_date }}</li>
        <li>Total Cost: {{ $rental->total_cost }}</li>
    </ul>
    <p>Thank you for choosing us!</p>
</body>
</html>
