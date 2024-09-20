<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archer Attendance</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

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

        /* Selected Date Display */
        .selected-date {
            font-size: 18px;
            margin-top: 20px;
        }

        /* Present and Absent Day Styles */
        .fc-day.present-day {
            background-color: green !important;
            color: white;
        }

        .fc-day.absent-day {
            background-color: red !important;
            color: white;
        }

        /* Present Day Count Display */
        .present-count {
            font-size: 18px;
            margin-top: 20px;
            font-weight: 600;
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

        #calendar {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
                <label for="membership_id">Archer Membership ID</label>
                <input type="text" name="membership_id" id="membership_id" value="{{ $membership->membership_id }}" readonly>
            </div>

            <div class="full-width">
                <label for="attendance_status">Attendance Status</label>
                <select name="attendance_status" id="attendance_status" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                </select>
            </div>

            <!-- Hidden input to store selected date from FullCalendar -->
            <input type="hidden" name="attendance_date" id="attendance_date">

            <button type="submit" class="submit-btn">Submit Attendance</button>
        </form>

        <!-- Display selected date -->
        <div class="selected-date" id="selected-date-display">
            Selected Date: None
        </div>

        <!-- FullCalendar Section -->
        <div id="calendar"></div>

        <!-- Display present days count -->
        <div class="present-count" id="present-count-display">
            Present Days this Month: 0
        </div>
    </div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <!-- JavaScript for closing the success message -->
    <script>
        function closeSuccessMessage() {
            document.getElementById('success-message').style.display = 'none';
        }

        // Pre-existing attendance data (this should come from your backend)
        var attendanceData = [
            { date: '2024-09-18', status: 'present' },
            { date: '2024-09-19', status: 'absent' },
        ];

        var presentCount = 0; // Initialize counter for present days

        // Function to update present day count display
        function updatePresentCountDisplay(count) {
            document.getElementById('present-count-display').innerText = 'Present Days this Month: ' + count;
        }

        // FullCalendar Initialization
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Month view by default
                selectable: true, // Allows date selection
                datesSet: function(info) {
                    presentCount = 0; // Reset present count
                    var currentMonthStart = info.view.activeStart;
                    var currentMonthEnd = info.view.activeEnd;

                    // Style the boxes based on the attendance data
                    attendanceData.forEach(function(attendance) {
                        var dateElement = document.querySelector(`[data-date="${attendance.date}"]`);
                        if (dateElement) {
                            if (attendance.status === 'present') {
                                dateElement.classList.add('present-day');
                                // Check if the attendance date is within the current month view
                                var attendanceDate = new Date(attendance.date);
                                if (attendanceDate >= currentMonthStart && attendanceDate < currentMonthEnd) {
                                    presentCount++; // Increment present count if in the current month
                                }
                            } else if (attendance.status === 'absent') {
                                dateElement.classList.add('absent-day');
                            }
                        }
                    });

                    // Update the displayed count of present days
                    updatePresentCountDisplay(presentCount);
                },
                select: function (info) {
                    // When a date is selected, populate the hidden input field and show the selected date
                    document.getElementById('attendance_date').value = info.startStr;
                    document.getElementById('selected-date-display').innerText = 'Selected Date: ' + info.startStr;
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
