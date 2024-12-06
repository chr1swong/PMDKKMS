<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Recorded</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 5px;
            display: inline-block;
            font-size: 24px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .details {
            margin-top: 10px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="message">
        <h2>Attendance Successfully Recorded!</h2>
        <div class="details">
            <p><strong>Membership ID:</strong> {{ $membershipId }}</p>
            <p><strong>Archer Name:</strong> {{ $archerName }}</p>
            <p><strong>Date:</strong> {{ $attendanceDate }}</p>
            <p><strong>Check-In Time:</strong> {{ $checkInTime }}</p>
        </div>
    </div>
</body>
</html>
