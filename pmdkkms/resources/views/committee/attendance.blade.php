<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archer Attendance</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }

        .attendance-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .attendance-header {
            background-color: #E0ECF8; /* Light blue background */
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 24px;
            font-weight: 500;
        }

        .attendance-form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            align-items: start;
        }

        .attendance-form div {
            display: flex;
            flex-direction: column;
        }

        .attendance-form label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .attendance-form select,
        .attendance-form input {
            padding: 10px;
            font-size: 16px;
            background-color: #E0E0E0; /* Gray background for input fields */
            border-radius: 8px;
            border: none;
            outline: none;
        }

        .full-width {
            grid-column: span 2; /* Make element take the whole row */
        }

        .submit-btn {
            background-color: #555555; /* Dark grey button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            transition: background-color 0.3s ease;
            width: fit-content;
        }

        .submit-btn:hover {
            background-color: #333333;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .attendance-form {
                grid-template-columns: 1fr;
            }
        }

        /* Success Message Styling */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 40px 15px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

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
    </style>
</head>

<body>
    <!-- Header is included here -->
    <header>
        @include('components.archerHeader')
    </header>

    <!-- Success Message with Close Button -->
    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

    <!-- Attendance Form Section -->
    <div class="attendance-container">
        <div class="attendance-header">
            Record Archer Attendance
        </div>

        <form action="{{ route('attendance.store') }}" method="POST" class="attendance-form">
            @csrf
            <div>
                <label for="membership_id">Select Archer</label>
                <select name="membership_id" id="membership_id" required>
                    @foreach($memberships as $membership)
                        <option value="{{ $membership->membership_id }}">{{ $membership->membership_id }} - {{ $membership->account->account_full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="attendance_date">Attendance Date</label>
                <input type="date" name="attendance_date" id="attendance_date" required>
            </div>

            <div class="full-width">
                <label for="attendance_status">Attendance Status</label>
                <select name="attendance_status" id="attendance_status" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="excused">Excused</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Submit Attendance</button>
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
