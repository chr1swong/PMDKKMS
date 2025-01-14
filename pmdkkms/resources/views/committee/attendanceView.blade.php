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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .attendance-header .header-text {
            flex-grow: 1;  /* Allow the text to take available space */
            text-align: center;  /* Ensure the text is centered */
            margin-left: 80px;
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
            width: 216px;
        }

        #check_in_time {
            width: 203px;
            height: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        .submit-btn {
            background-color: #191970; /* Midnight Blue */
            color: white;
            padding: 12px 18px;  /* Increased vertical padding for more height */
            font-size: 16px;  /* Font size remains unchanged */
            font-weight: 500;  /* Slightly lighter text weight */
            border-radius: 6px;  /* Smaller border radius for a tighter shape */
            border: none;
            cursor: pointer;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Soft shadow */
            transition: all 0.3s ease; /* Smooth transition for all states */
            width: auto;  /* Allow natural width based on text */
            max-width: 222px;  /* Set a maximum width */
            text-align: center;  /* Ensure text is centered */
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #1c1c8c;  /* Slightly lighter dark blue on hover */
            box-shadow: 0 10px 14px rgba(0, 0, 0, 0.3); /* Larger shadow on hover */
            transform: translateY(-1px); /* Slight movement for interaction */
        }

        .submit-btn:active {
            background-color: #1c1c8c; /* Keep the same blue on active */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Smaller shadow on active */
            transform: translateY(1px); /* Button slightly pressed down */
        }

        .selected-date-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            width: 100%;
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
                margin-top: 20px;
            }
        }

        #calendar {
            margin-top: 0px;
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

        .selected-date-input {
            width: 204px !important;
            padding: 8px;
            font-size: 16px;
            background-color: #E0E0E0;
            border-radius: 8px;
            border: none;
            outline: none;
            color: #333;
            display: flex;
            align-items: left;
            justify-content: space-between;
        }

        .view-more-btn {
            background-color: #4CAF50; /* Green background */
            color: white;
            padding: 12px 20px;  /* Add some padding */
            font-size: 16px;
            font-weight: 500;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            transition: background-color 0.3s, transform 0.3s ease;
            margin-left: auto;  /* Push button to the right */
            display: inline-block; /* Ensure button is inline-block */
            text-align: center; /* Center the text */
            width: auto;
        }

        .view-more-btn a {
            display: block; /* Makes the anchor tag fill the button */
            color: white;
            text-decoration: none; /* Remove the underline */
            width: 100%; /* Make sure the anchor tag takes full width of the button */
            height: 100%; /* Ensure it occupies full height as well */
        }

        .view-more-btn:hover {
            background-color: #45a049;  /* Darker shade of green on hover */
            transform: scale(1.0); /* Slightly scale up on hover */
        }

        .view-more-btn:active {
            background-color: #388e3c; /* Even darker green on click */
            transform: scale(0.98); /* Slightly scale down on click */
        }

        /* Modal Background */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Dark semi-transparent background */
            backdrop-filter: blur(6px); /* Blur effect for background */
            justify-content: center;
            align-items: center;
            padding: 20px;
            border-radius: 12px;
            z-index: 1050;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: opacity 0.3s ease-in-out;
        }

        /* Modal Content Styling */
        .modal-content {
            background-color: #fff;
            padding: 40px 30px; /* Increased padding for more space around content */
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            color: #333;
            text-align: center;
            position: relative;
            overflow: hidden;
            top: -20%; /* Adjust this value to move the modal content up */
            transform: translateY(0); /* Optional: Ensure it's not displaced when scaling */
            animation: fadeInUp 0.5s ease-in-out; /* Optional: Add an animation for smooth upward motion */
            width: 400px; /* Limit the width for better appearance */
            max-width: 100%;
        }

        /* Modal Header */
        .modal-content h4 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px; /* Adjust margin if needed */
            color: #2e3d49;
            text-transform: capitalize;
            white-space: nowrap; /* Prevent the text from wrapping */
        }

        /* Modal Text */
        .modal-content p {
            font-size: 16px;
            color: #777;
            line-height: 1.5;
            margin-bottom: 30px; /* More spacing after text */
        }

        /* Modal Details */
        .modal-content .modal-details {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
            text-align: left; /* Align details to the left for better readability */
            padding-left: 10px;
            margin-bottom: 20px;
        }

        /* Close Button in Top Right */
        .close-btn {
            color: #e74c3c;
            font-size: 30px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #c0392b;
        }

        /* Close Modal Button */
        .close-modal-btn {
            background-color: #FF0000; /* Change to red */
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .close-modal-btn:hover {
            background-color: #CC0000; /* Darker shade of red for hover effect */
        }

        /* Modal Open Animation */
        .modal.open {
            display: flex; /* Show the modal */
            opacity: 1;
            animation: fadeIn 0.5s ease-in-out;
        }


        /* Smooth fade-in animation */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20%);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Prevent Page Scroll When Modal is Open */
        body.modal-open {
            overflow: hidden; /* Disable scrolling on body */
        }



        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .modal-content {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <header>
        @include('components.committeeHeader')
    </header>

    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
            <button type="button" class="close" onclick="closeSuccessMessage()">&times;</button>
        </div>
    @endif

    <div class="attendance-container">

    <div class="attendance-header">
        <div class="header-text">Record Archer Attendance</div>
        <form action="{{ route('committee.attendanceMore', ['membership_id' => $membership->membership_id]) }}" method="GET">
            <button type="submit" class="view-more-btn" >
                View More
            </button>
        </form>
    </div>

        <!-- Form for updating attendance (Committee) -->
    <form action="{{ route('committee.updateCommitteeArcherAttendance', $membership->membership_id) }}" method="POST" class="attendance-form">
        @csrf
        <div>
            <label for="membership_id">Archer Membership ID</label>
            <input type="text" name="membership_id" id="membership_id" value="{{ $membership->membership_id }}" readonly>
        </div>

        <!-- Back Button -->
        <a href="{{ route('committee.attendanceList') }}" class="btn btn-secondary back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        <div class="full-width">
            <label for="archer_name">Archer Name</label>
            <input type="text" name="archer_name" id="archer_name" value="{{ $membership->account->account_full_name }}" readonly>
        </div>

        <div class="full-width">
            <label for="attendance_status">Attendance Status</label>
            <select name="attendance_status" id="attendance_status" required>
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>
        </div>

        <div class="full-width">
            <label for="check_in_time">Check-in Time</label>
            <input type="time" id="check_in_time" name="check_in_time" required>
        </div>

        <div class="full-width">
            <label for="selected-date-display">Selected Date</label>
            <input type="text" id="selected-date-display" class="selected-date-input" readonly>
        </div>

        <input type="hidden" name="attendance_date" id="attendance_date">

        <button type="submit" class="submit-btn">Submit Attendance</button>
        
    </form>


        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h4>Attendance Recorded Successfully!</h4>
                <div class="modal-details">
                    <strong>Membership ID:</strong> <span id="modalMembershipId">N/A</span><br>
                    <strong>Archer Name:</strong> <span id="modalArcherName">N/A</span><br>
                    <strong>Attendance Date:</strong> <span id="modalAttendanceDate">N/A</span><br>
                    <strong>Status:</strong> <span id="modalAttendanceStatus">N/A</span><br>
                    <strong>Check-in Time:</strong> <span id="modalCheckInTime">N/A</span>
                </div>
                <button class="close-modal-btn" id="closeModalBtn">Close</button> <!-- Close button -->
            </div>
        </div>
        
        <!-- Selected Date and Present Count Section -->
        <div class="selected-date-container">
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
                select: function(info) {
                    // When a date is selected, populate the hidden input field and show the selected date
                    document.getElementById('attendance_date').value = info.startStr;
                    document.getElementById('selected-date-display').value = info.startStr; // Just show the date

                    // Show the selected date display
                    document.getElementById('selected-date-display').removeAttribute('hidden');

                    // Find the selected date in attendanceData
                    let selectedAttendance = attendanceData.find(attendance => attendance.date === info.startStr);
                    
                    // Set the attendance status dropdown based on existing data, or default to "present"
                    if (selectedAttendance) {
                        document.getElementById('attendance_status').value = selectedAttendance.status;
                    } else {
                        document.getElementById('attendance_status').value = 'present';
                    }

                    // Automatically set the check-in time to the current time (HH:mm)
                    var currentTime = new Date();
                    var hours = String(currentTime.getHours()).padStart(2, '0');
                    var minutes = String(currentTime.getMinutes()).padStart(2, '0');
                    var timeString = hours + ':' + minutes;

                    document.getElementById('check_in_time').value = timeString;
                }
            });
            calendar.render();
        });

        // This code will run when the page loads and success is present in the session
        window.onload = function() {
            // Check if the necessary data exists in the session
            @if(session('archer') && session('attendance_status') && session('attendance_date'))
                const archer = @json(session('archer'));
                const attendanceStatus = @json(session('attendance_status'));
                const checkInTime = @json(session('check_in_time')) || 'N/A'; // Default to 'N/A' if null
                const attendanceDate = @json(session('attendance_date'));

                // Populate modal with the data (with fallback to 'N/A' if undefined)
                document.getElementById('modalMembershipId').textContent = archer ? archer.membership_id : 'N/A';
                document.getElementById('modalArcherName').textContent = archer ? archer.account.account_full_name : 'N/A';
                document.getElementById('modalAttendanceStatus').textContent = attendanceStatus || 'N/A';
                document.getElementById('modalCheckInTime').textContent = checkInTime;
                document.getElementById('modalAttendanceDate').textContent = attendanceDate;

                // Show the modal
                const successModal = document.getElementById('successModal');
                successModal.style.display = 'flex';
            @endif
        }

        // Close modal and allow scrolling again
        function closeModal() {
            const modal = document.getElementById('successModal');
            const body = document.body;
            
            // Hide the modal
            modal.style.display = 'none';  // Or modal.classList.remove('open');
            
            // Allow scrolling again on the body
            body.classList.remove('modal-open');
        }

        // Show modal and prevent scrolling on body
        function showModal() {
            const modal = document.getElementById('successModal');
            const body = document.body;

            // Show the modal
            modal.style.display = 'flex';  // Or modal.classList.add('open');
            
            // Prevent page scrolling
            body.classList.add('modal-open');
        }

        // Event listener for closing the modal when the close button is clicked
        document.querySelector('.close-btn').addEventListener('click', closeModal);

        // Event listener for closing the modal when the close modal button is clicked
        document.getElementById('closeModalBtn').addEventListener('click', closeModal);

        // Modal open functionality when page is loaded and session data exists
        window.onload = function() {
            // Check if the necessary data exists in the session
            @if(session('archer') && session('attendance_status') && session('attendance_date'))
                const archer = @json(session('archer'));
                const attendanceStatus = @json(session('attendance_status'));
                const checkInTime = @json(session('check_in_time')) || 'N/A'; // Default to 'N/A' if null
                const attendanceDate = @json(session('attendance_date'));

                // Populate modal with the data (with fallback to 'N/A' if undefined)
                document.getElementById('modalMembershipId').textContent = archer ? archer.membership_id : 'N/A';
                document.getElementById('modalArcherName').textContent = archer ? archer.account.account_full_name : 'N/A';
                document.getElementById('modalAttendanceStatus').textContent = attendanceStatus || 'N/A';
                document.getElementById('modalCheckInTime').textContent = checkInTime;
                document.getElementById('modalAttendanceDate').textContent = attendanceDate;

                // Show the modal
                const successModal = document.getElementById('successModal');
                successModal.style.display = 'flex';
            @endif
        }


    </script>
</body>
</html>
