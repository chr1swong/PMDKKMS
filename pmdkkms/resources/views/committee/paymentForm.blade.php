<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Payment</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden;
            background-color: #f4f4f4;
        }

        .payment-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .payment-details div {
            display: flex;
            flex-direction: column;
        }

        .payment-details label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .payment-details select,
        .payment-details input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        .full-width {
            grid-column: span 2; /* Make element take the whole row */
        }

        .submit-btn {
            background-color: #5A67D8;
            color: white;
            padding: 15px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            text-align: center;
            margin-top: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #434190;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .payment-details {
                grid-template-columns: 1fr;
            }
        }

        /* Close Button Styling */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 30px;
            font-weight: bold;
            color: #155724;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #0c3d20; /* Darker green on hover */
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Header is included here -->
    <header>
        @include('components.committeeHeader')
    </header>

    <!-- Success Message with Close Button -->
    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

    <!-- Main Payment Content -->
    <div class="payment-container">
        <h2>Extend Membership</h2>

        <form action="{{ route('committee.processPayment') }}" method="POST">
            @csrf
            <div class="payment-details">
                <div class="full-width">
                    <label for="duration">Select Duration:</label>
                    <select name="duration" id="duration" class="form-control" required>
                        <option value="1">1 Month (RM30)</option>
                        <option value="3">3 Months (RM90)</option>
                        <option value="6">6 Months (RM180)</option>
                        <option value="12">1 Year (RM360)</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="submit-btn">Proceed to Payment</button>
        </form>
    </div>

    <!-- JavaScript for closing the success message -->
    <script>
        function closeSuccessMessage() {
            document.getElementById('success-message').style.display = 'none';
        }
    </script>
</body>
</html>
