<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance QR Code</title>
    <style>
        .qr-container {
            text-align: center;
            margin-top: 50px;
        }

        h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <h2>QR Code for Archer ID: {{ $membership_id }}</h2>
        {!! $qrCode !!}
        <p>QR Code generated for {{ $currentDate }}</p>
    </div>
</body>
</html>