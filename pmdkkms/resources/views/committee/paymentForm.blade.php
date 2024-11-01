<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Membership Payment</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Updated styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden;
            background-color: #f4f4f4;
        }

        .payment-container {
            max-width: 600px;
            margin: 60px auto;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 40px;
            color: #333;
        }

        .payment-details {
            display: flex;
            flex-direction: column;
            gap: 25px;
            margin-bottom: 20px;
        }

        .payment-details label {
            font-weight: 500;
            color: #444;
        }

        .payment-details .membership-info {
            font-weight: 400;
            color: #555;
        }

        .payment-details select,
        .payment-details input {
            padding: 12px;
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
            font-weight: 500;
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

        /* Success and error message styles */
        .alert-success, .error-message {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .error-message {
            background-color: #f8d7da;
            color: #cd5c5c;
        }

        .close {
            background: none;
            border: none;
            font-size: 20px;
            color: inherit;
            cursor: pointer;
            padding: 0 5px;
        }

        .payment-container hr {
            border: none;
            border-top: 2px solid #e0e0e0;
            margin: 10px 0 20px;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .payment-container {
                padding: 25px;
                margin: 20px auto;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Header is included here -->
    <header>
        @include('components.committeeHeader')
    </header>

    <!-- Success and Error Messages with Close Buttons -->
    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

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

        <div class="payment-details">
            <div>
                <label for="membership-id">Membership ID:</label>
                <span class="membership-info" id="membership-id">
                    {{ $membership_id }}
                </span>
            </div>
            <div>
                <label for="membership-status">Membership Status:</label>
                <span class="membership-info" id="membership-status">
                    {{ $membership_status }}
                </span>
            </div>
            <div>
                <label for="membership-expiry">Membership Expiry:</label>
                <span class="membership-info" id="membership-expiry">
                    {{ $membership_expiry }}
                </span>
            </div>
        </div>
        
        <form action="{{ route('committee.initiatePayment') }}" method="POST">
            @csrf
            <div class="payment-details">
                <div>
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
