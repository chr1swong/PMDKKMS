<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            font-size: 18px;
            margin: 10px 0;
        }

        .submit-btn {
            background-color: #5A67D8;
            color: white;
            padding: 15px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            width: 100%;
            text-align: center;
        }

        .submit-btn:hover {
            background-color: #434190;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Confirm Payment</h2>

        <div class="details">
            <p><strong>Name:</strong> {{ $user->account_full_name }}</p>
            <p><strong>Email:</strong> {{ $user->account_email_address }}</p>
            <p><strong>Contact:</strong> {{ $user->account_contact_number }}</p>
            <p><strong>Duration:</strong> {{ $duration }} month(s)</p>
            <p><strong>Amount:</strong> RM{{ $amount }}</p>
        </div>

        <form action="{{ route('committee.processPayment') }}" method="POST">
            @csrf
            <input type="hidden" name="duration" value="{{ $duration }}">
            <button type="submit" class="submit-btn">Proceed to Payment</button>
        </form>
    </div>
</body>
</html>
