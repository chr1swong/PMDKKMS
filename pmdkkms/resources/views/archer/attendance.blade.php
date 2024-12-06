<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archer Attendance</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    
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

        /* Ensure both membership ID and attendance status have the same fixed width */
        .attendance-form select,
        .attendance-form input {
            width: 200px; /* Fixed width for consistency */
            padding: 8px;
            font-size: 16px;
            background-color: #E0E0E0;
            border-radius: 8px;
            border: none;
            outline: none;
        }
        
        #membership_id {
            width: 200px; /* Fixed width for membership ID */
        }

        #attendance_status {
            width: 220px; /* Fixed width for attendance status */
        }

        .open-camera-btn {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px; /* Same padding as submit button */
            border-radius: 6px;  /* Same border-radius as submit button */
            font-size: 16px;     /* Same font size as submit button */
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: fit-content;  /* Adjust width to match content */
            display: none;
        }

        .open-camera-btn:hover {
            background-color: #0056b3;
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

            .open-camera-btn {
                display: inline-block; /* Show the button only on mobile view */
                margin-top: 10px;
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

        .close:hover {
            color: #0c3d20;
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
    </style>
</head>

<body>
    <header>
        @include('components.archerHeader')
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
            <form action="{{ route('archer.attendanceMore', ['membership_id' => $membership->membership_id]) }}" method="GET">
                <button type="submit" class="view-more-btn">View More</button>
            </form>
        </div>

        <form action="{{ route('attendance.store') }}" method="POST" class="attendance-form">
            @csrf
            <div class="membership-id-container">
                <label for="membership_id">Archer Membership ID</label>
                <input type="text" name="membership_id" id="membership_id" 
                    value="{{ $membership->membership_id }}" readonly>
            </div>

            <div class="full-width">
                <label for="attendance_status">Name</label>
                <input type="text" name="membership_id" id="membership_id" 
                    value="{{ $membership->account->account_full_name }}" readonly>
                </select>
            </div>

            
        </form>

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
                select: function (info) {
                    // When a date is selected, populate the hidden input field and show the selected date
                    document.getElementById('attendance_date').value = info.startStr;
                    document.getElementById('selected-date-display').innerText = 'Selected Date: ' + info.startStr;
                }
            });
            calendar.render();
        });

        function openCamera() {
            const video = document.getElementById('video');

            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then((stream) => {
                    console.log("Camera access granted.");
                    video.style.display = 'block'; // Show video feed
                    video.srcObject = stream;
                    video.play();

                    // Create a canvas element for scanning
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');

                    // Recursive function to scan for QR code
                    function scanQRCode() {
                        if (!video.srcObject || !video.srcObject.active) {
                            console.log("Video stream inactive.");
                            return;
                        }

                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;

                        // Draw the current video frame to the canvas
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);

                        // Decode QR code from the canvas
                        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height);

                        if (code) {
                            console.log("QR Code detected:", code.data);

                            // Stop the video stream
                            video.srcObject.getTracks().forEach(track => track.stop());
                            video.style.display = 'none';

                            // Handle QR code data
                            alert(`QR Code Scanned: ${code.data}`);
                            if (code.data.startsWith("http")) {
                                window.location.href = code.data; // Redirect if URL
                            } else {
                                document.getElementById('membership_id').value = code.data; // Populate membership ID
                            }
                        } else {
                            console.log("No QR code detected. Retrying...");
                            requestAnimationFrame(scanQRCode); // Retry
                        }
                    }

                    // Start scanning
                    scanQRCode();
                })
                .catch((error) => {
                    console.error("Error accessing camera:", error);
                    alert("Unable to access camera. Please check your permissions and try again.");
                });
        }


    </script>
</body>
</html>
