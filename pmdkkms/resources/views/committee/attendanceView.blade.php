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
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .attendance-header label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Flexbox layout to place Membership ID and Back button side by side */
        .membership-id-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .attendance-header .input-box {
            background-color: #d3d3d3;
            border-radius: 10px;
            padding: 10px;
            font-size: 16px;
            color: #333;
            box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px; /* Keep input box size compact */
        }

        /* Move present-count below the archer_name input-box */
        .present-count {
            font-size: 18px;
            font-weight: 600;
            margin-top: 15px; /* Spacing below the archer name */
            margin-bottom: 0px;
            text-align: left;  /* Align text to the left */
            width: 300px; /* Match the width of input boxes */
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

        /* Reset calendar padding */
        #calendar {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
    <!-- Header is included here -->
    <header>
        @include('components.committeeHeader')
    </header>
    
    <!-- Attendance Form Section -->
    <div class="attendance-container">
        
        <div class="attendance-header">

            <!-- Membership ID and Back Button in the same row -->
            <div class="membership-id-row">
                <div>
                    <label for="membership_id">Membership ID</label>
                    <div class="input-box">{{ $membership->membership_id }}</div>
                </div>

                <!-- Back Button -->
                <div>
                    <a href="{{ route('committee.attendanceList') }}" class="btn btn-secondary back-btn">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div>
                <label for="archer_name">Name</label>
                <div class="input-box">{{ $membership->account->account_full_name }}</div>
            </div>
            <!-- Move present-count below the archer_name input box -->
            <div class="present-count" id="present-count-display">
                Present Days this Month: 0
            </div>
        </div>

        <!-- FullCalendar Section -->
        <div id="calendar"></div>
    </div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <script>
        // Pre-existing attendance data (from the backend)
        var attendanceData = @json($attendanceData); // Dynamic data from backend

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
                    var currentMonthStart = new Date(info.view.currentStart); // Start of the current month
                    var currentMonthEnd = new Date(info.view.currentEnd); // End of the current month

                    // Style the boxes based on the attendance data
                    attendanceData.forEach(function(attendance) {
                        var attendanceDate = new Date(attendance.date);

                        // Ensure the attendance date is strictly within the current month view
                        if (attendanceDate >= currentMonthStart && attendanceDate < currentMonthEnd) {
                            var dateElement = document.querySelector(`[data-date="${attendance.date}"]`);
                            if (dateElement) {
                                if (attendance.status === 'present') {
                                    dateElement.classList.add('present-day');
                                    presentCount++; // Increment present count if it falls within the current month
                                } else if (attendance.status === 'absent') {
                                    dateElement.classList.add('absent-day');
                                }
                            }
                        }
                    });

                    // Update the displayed count of present days
                    updatePresentCountDisplay(presentCount);
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
