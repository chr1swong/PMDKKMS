<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archer Attendance - Coach View</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden; 
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
            background-color: #E0ECF8;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 24px;
            font-weight: 500;
        }

        .attendance-form {
            display: grid;
            grid-template-columns: 1fr auto;
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
            width: 200px;
            padding: 8px;
            font-size: 16px;
            background-color: #E0E0E0;
            border-radius: 8px;
            border: none;
            outline: none;
        }

        #membership_id {
            width: 200px;
        }

        #archer_name {
            width: 200px;
        }

        #attendance_status {
            width: 220px;
        }

        .full-width {
            grid-column: span 2;
        }

        .submit-btn {
            background-color: #555555;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
            width: fit-content;
        }

        .submit-btn:hover {
            background-color: #333333;
        }

        .selected-date-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .selected-date {
            font-size: 18px;
        }

        .present-count {
            font-size: 18px;
            font-weight: 600;
            margin-left: 20px;
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .attendance-form {
                grid-template-columns: 1fr;
            }

            .attendance-form select,
            .attendance-form input {
                width: 100%; /* Full width on smaller screens */
            }

            .selected-date-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .present-count {
                margin-left: 0;
                margin-top: 10px;
            }
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

        #calendar {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Present and absent day styles */
        .fc-daygrid-day.present-day {
            background-color: green !important;
            color: white !important;
        }

        .fc-daygrid-day.absent-day {
            background-color: red !important;
            color: white !important;
        }

        /* Back Button Styling */
        .back-btn {
            background-color: #5f4bb6;  /* Purple background to match the theme */
            color: white;  /* White text */
            padding: 10px 20px;  /* Padding for a larger, clickable area */
            text-decoration: none;  /* Remove underline */
            border-radius: 5px;  /* Rounded corners */
            font-weight: 600;  /* Slightly bolder text */
            transition: background-color 0.3s ease;  /* Smooth hover transition */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  /* Subtle shadow for depth */
            justify-self: end; /* Align button to the right in grid */
        }

        /* Back Button Hover Effect */
        .back-btn:hover {
            background-color: #4831a6;  /* Darker shade on hover */
            text-decoration: none;  /* Keep text-decoration off during hover */
            color: white;  /* Ensure white text on hover */
        }

    </style>
</head>

<body>
    <header>
        @include('components.coachHeader')
    </header>

    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

    <div class="attendance-container">

        <div class="attendance-header">
            Record Archer Attendance
        </div>

        <!-- Form for updating attendance -->
        <form action="{{ route('coach.updateAttendance', $membership->membership_id) }}" method="POST" class="attendance-form">
            @csrf
            <div>
                <label for="membership_id">Archer Membership ID</label>
                <input type="text" name="membership_id" id="membership_id" value="{{ $membership->membership_id }}" readonly>
            </div>

            <!-- Back Button -->
            <?php $referrer = request()->query('referrer', 'myArcher'); // Default to 'myArcher' if not provided ?>
            <a href="{{ route('coach.' . $referrer) }}" class="btn btn-secondary back-btn">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <div class="full-width">
                <label for="archer_name">Archer Name</label>
                <input type="text" name="archer_name" id="archer_name" value="{{ $membership->account_full_name }}" readonly>
            </div>

            <div class="full-width">
                <label for="attendance_status">Attendance Status</label>
                <select name="attendance_status" id="attendance_status" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                </select>
            </div>

            <input type="hidden" name="attendance_date" id="attendance_date">

            <button type="submit" class="submit-btn">Submit Attendance</button>
        </form>

        <!-- Selected Date and Present Count Section -->
        <div class="selected-date-container">
            <div class="selected-date" id="selected-date-display">
                Selected Date: None
            </div>
            <div class="present-count" id="present-count-display">
                Present Days this Month: 0
            </div>
        </div>

        <!-- FullCalendar Section -->
        <div id="calendar"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <script>
        function closeSuccessMessage() {
            document.getElementById('success-message').style.display = 'none';
        }

        var attendanceData = @json($attendanceData);

        var presentCount = 0;

        function updatePresentCountDisplay(count) {
            document.getElementById('present-count-display').innerText = 'Present Days this Month: ' + count;
        }

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                datesSet: function(info) {
                    presentCount = 0;
                    var currentMonth = info.view.currentStart.getMonth();

                    attendanceData.forEach(function(attendance) {
                        var dateElement = document.querySelector(`[data-date="${attendance.date}"]`);
                        if (dateElement) {
                            var attendanceDate = new Date(attendance.date);
                            if (attendanceDate.getMonth() === currentMonth) {
                                if (attendance.status === 'present') {
                                    dateElement.classList.add('present-day');
                                    presentCount++;
                                } else if (attendance.status === 'absent') {
                                    dateElement.classList.add('absent-day');
                                }
                            }
                        }
                    });

                    updatePresentCountDisplay(presentCount);
                },
                select: function (info) {
                    // When a date is selected, populate the hidden input field and show the selected date
                    document.getElementById('attendance_date').value = info.startStr;
                    document.getElementById('selected-date-display').innerText = 'Selected Date: ' + info.startStr;

                    // Find the selected date in attendanceData
                    let selectedAttendance = attendanceData.find(attendance => attendance.date === info.startStr);
                    
                    // Set the attendance status dropdown based on existing data, or default to "present"
                    if (selectedAttendance) {
                        document.getElementById('attendance_status').value = selectedAttendance.status;
                    } else {
                        document.getElementById('attendance_status').value = 'present';
                    }
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
