<!DOCTYPE html>
<html>
<head>
    <title>Your Car Has Been Rented</title>
</head>
<body>
    <h1>Car Rental Notification</h1>
    <p>Dear,</p>
    <p>Your car "{{ $rental->car->name }}" has been successfully rented.</p>
    <p><strong>Rental Details:</strong></p>
    <ul>
        <li>Rented By: {{ $rental->user->name }}</li>
        <li>Start Date: {{ $rental->start_date }}</li>
        <li>End Date: {{ $rental->end_date }}</li>
        <li>Total Cost: {{ $rental->total_cost }}</li>
    </ul>
    <p>Thank you for being a valued member of our service!</p>
</body>
</html>
