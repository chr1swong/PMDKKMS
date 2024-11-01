<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Membership Payment</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Your existing styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden;
            background-color: #f4f4f4;
        }

        .payment-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
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
            .payment-container {
                padding: 20px;
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

        .alert-success .close:hover {
            color: #0c3d20; 
        }

        .error-message .close {
            color: #cd5c5c; 
        }

        .error-message .close:hover {
            color: #a94442; 
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

        .error-message {
            background-color: #f8d7da; /* Light red background for error */
            color: #cd5c5c; /* Red text */
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .payment-container hr {
            border: none;
            border-top: 2px solid #e0e0e0;
            margin: 10px 0 20px;
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

    <!-- Error Message with Close Button -->
    @if (session('error'))
        <div class="error-message" id="error-message">
            {{ session('error') }}
            <button type="button" class="close" onclick="closeErrorMessage()">&times;</button>
        </div>
    @endif

    <!-- Main Payment Content -->
    <div class="payment-container">
        <h2>Extend Membership</h2>
        <hr>

        <form action="{{ route('committee.initiatePayment') }}" method="POST">
            @csrf
            <div class="payment-details">
                <div class="full-width">
                    <label for="duration">Select Duration:</label>
                    <select name="duration" id="duration" class="form-control" required>
                        <option value="">-- Select Duration --</option>
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

    <!-- JavaScript for closing the success and error messages -->
    <script>
        function closeSuccessMessage() {
            document.getElementById('success-message').style.display = 'none';
        }
        function closeErrorMessage() {
            document.getElementById('error-message').style.display = 'none';
        }
    </script>
</body>
</html>
