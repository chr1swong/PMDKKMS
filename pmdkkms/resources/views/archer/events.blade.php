<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Calendar</title>

    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .calendar-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease, transform 0.3s ease;
            opacity: 0;
            transform: scale(0.95);
        }

        .modal.show {
            display: flex;
            opacity: 1;
            transform: scale(1);
        }

        .modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            position: relative;
            text-align: left;
            animation: fadeInModal 0.3s ease-in-out;
        }

        @keyframes fadeInModal {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px; /* Increased size */
            color: #ff5b5b;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover,
        .close:focus {
            color: #ff0000;
            text-decoration: none;
        }

        .modal-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.8em;
            color: #333;
        }

        .modal-body p {
            margin: 10px 0;
            line-height: 1.6;
            color: #555;
        }

        .modal-body p strong {
            color: #333;
        }

        .modal-body p span {
            font-weight: 600;
            color: #2c3e50;
        }

        /* Button styling for close or action buttons */
        .modal-footer {
            text-align: right;
            margin-top: 20px;
        }

        .modal-footer button {
            background-color: #ff5b5b; /* Match with the top close button */
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .modal-footer button:hover {
            background-color: #ff0000;
            transform: scale(1.05);
        }

        .modal-footer button:active {
            transform: scale(1);
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .modal-content {
                width: 90%;
            }

            .modal-header h2 {
                font-size: 1.5em;
            }

            .modal-footer button {
                width: 100%;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        @include('components.archerHeader')
    </header>

    <!-- Main content section for calendar -->
    <div class="dashboard-container">
        <h2>Events:</h2>

        <!-- FullCalendar display -->
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal for event details -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Event Title</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <p><strong>Date:</strong> <span id="modalDate"></span></p>
                <p><strong>Start Time:</strong> <span id="modalStartTime"></span></p>
                <p><strong>End Time:</strong> <span id="modalEndTime"></span></p>
                <p><strong>Location:</strong> <span id="modalLocation"></span></p>
            </div>
            <div class="modal-footer">
                <button class="close-modal">Close</button>
            </div>
        </div>
    </div>

    <!-- FullCalendar and jQuery Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var modal = document.getElementById("eventModal");
        var closeModal = document.getElementsByClassName("close")[0];
        var closeFooterButton = document.querySelector(".close-modal");

        // FullCalendar initialization (view-only)
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: false, // Disable editing
            events: @json($events), // Load events from the server

            // Apply the event color dynamically from data
            eventDidMount: function(info) {
                info.el.style.backgroundColor = info.event.extendedProps.color;
            },

            // Open modal on event click
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // Prevent default action

                // Populate the modal with event details
                document.getElementById('modalTitle').innerText = info.event.title;
                document.getElementById('modalDate').innerText = info.event.start.toISOString().slice(0, 10);
                document.getElementById('modalStartTime').innerText = info.event.extendedProps.start_time;
                document.getElementById('modalEndTime').innerText = info.event.extendedProps.end_time;
                document.getElementById('modalLocation').innerText = info.event.extendedProps.location;

                // Show the modal
                modal.classList.add("show");
            }
        });

        calendar.render();

        // Close the modal when the close button is clicked
        closeModal.onclick = function() {
            modal.classList.remove("show");
        }

        // Close modal with footer button
        closeFooterButton.onclick = function() {
            modal.classList.remove("show");
        }

        // Close the modal when clicking outside of the modal content
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.remove("show");
            }
        }
    });
    </script>
</body>
</html>
