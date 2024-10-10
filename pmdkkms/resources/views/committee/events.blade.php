<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Events</title>

    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
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

        .add-event-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-right: 20px;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 0.9em;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9em;
            min-width: 180px;
        }

        /* Make the color input a small square */
        .form-group input[type="color"],
        .modal-content input[type="color"] {
            padding: 0;
            border: none;
            height: 30px;
            width: 10px;
            border-radius: 5px;
            cursor: pointer;
            background-color: transparent;
        }

        /* Align color picker and label */
        .form-group.color-picker-group {
            display: flex;
            align-items: left;
            gap: 0px;
        }

        /* Center buttons below event color picker */
        .modal-content .action-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 15px;
        }

        .modal-content .action-buttons button {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .update-btn {
            background-color: #48BB78;
            color: white;
            transition: background-color 0.3s ease;
        }

        .update-btn:hover {
            background-color: #38A169;
        }

        .delete-btn {
            background-color: #E53E3E;
            color: white;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #C53030;
        }

        .calendar-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            display: none;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 600px;
            position: relative;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            transform: scale(0.95);
            animation: modalOpen 0.3s forwards;
        }

        @keyframes modalOpen {
            to {
                transform: scale(1);
            }
        }

        .modal-content h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #333;
        }

        .modal-content input,
        .modal-content label {
            width: 100%;
            margin-bottom: 10px;
            font-size: 1em;
        }

        .modal-content input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 15px;
            cursor: pointer;
            font-size: 1.5em;
            color: #aaa;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #555;
        }

        /* Style for the Add Event Button */
        .add-event-btn {
            padding: 12px 25px;
            background-color: #483EA8; 
            color: white; /* White text */
            border: none;
            border-radius: 5px; /* Rounded corners */
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .add-event-btn:hover {
            background-color: #627DFF; 
            transform: scale(1.05); /* Grow slightly when hovered */
        }

        .add-event-btn:active {
            background-color: #483EA8; /* New active color */
            transform: scale(1); /* Return to original size when clicked */
        }

    </style>
</head>
<body>
    <!-- Header -->
    <header>
        @include('components.committeeHeader')
    </header>

    <!-- Main content section for dashboard and calendar -->
    <div class="dashboard-container">
        <h2>Add Event</h2>

        <!-- Add Event Form (Aligned horizontally with labels) -->
        <form id="add-event-form" class="add-event-form">
            @csrf
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" name="title" id="title" placeholder="Event Title" required>
            </div>

            <div class="form-group">
                <label for="event_date">Date</label>
                <input type="date" name="event_date" id="event_date" required>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" id="start_time" required>
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" id="end_time" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" placeholder="Event Location" required>
            </div>

            <div class="form-group color-picker-group">
                <label for="color">Choose Color</label>
                <input type="color" id="color" name="color" value="#5A67D8" required>
            </div>

            <!-- Updated button style -->
            <button type="submit" class="add-event-btn">Add Event</button>
        </form>

        <!-- FullCalendar display -->
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal for editing or deleting event -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Event Details</h2>

            <!-- Event Details Form inside the modal -->
            <form id="edit-event-form">
                @csrf
                <input type="hidden" name="event_id" id="modalEventId">
                <label for="modalTitleInput">Title:</label>
                <input type="text" name="title" id="modalTitleInput" required>
                <label for="modalDate">Date:</label>
                <input type="date" name="event_date" id="modalDate" required>
                <label for="modalStartTime">Start Time:</label>
                <input type="time" name="start_time" id="modalStartTime" required>
                <label for="modalEndTime">End Time:</label>
                <input type="time" name="end_time" id="modalEndTime" required>
                <label for="modalLocation">Location:</label>
                <input type="text" name="location" id="modalLocation" required>

                <!-- Event Color Picker with alignment -->
                <div class="form-group color-picker-group">
                    <label for="modalColor">Event Color:</label>
                    <input type="color" name="color" id="modalColor" required>
                </div>

                <!-- Action Buttons centered below the color picker -->
                <div class="action-buttons">
                    <button type="submit" class="update-btn">Update Event</button>
                    <button type="button" id="delete-event" class="delete-btn">Delete Event</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var modal = document.getElementById('eventModal');
    var closeModal = document.getElementsByClassName('close')[0];

    // FullCalendar initialization
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        eventResizableFromStart: true,
        events: @json($events), // Load events from server

        // Apply the event color dynamically from data
        eventDidMount: function(info) {
            info.el.style.backgroundColor = info.event.extendedProps.color;
        },

        // Open modal on event click and set default color
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            openEventModal(info.event);
        },

        // Handle event dragging to update event date
        eventDrop: function(info) {
            updateEventDate(info.event);
        },

        // Handle event resizing to update event duration
        eventResize: function(info) {
            updateEventDuration(info.event);
        }
    });

    calendar.render();

    // Function to open the event modal with the event data
    function openEventModal(event) {
        modal.classList.add('show'); // Add 'show' class for smooth opening

        // Adjust date for timezone offset before displaying
        var eventStart = new Date(event.start.getTime() - (event.start.getTimezoneOffset() * 60000));

        document.getElementById('modalTitleInput').value = event.title;
        document.getElementById('modalDate').value = eventStart.toISOString().slice(0, 10);
        document.getElementById('modalStartTime').value = event.extendedProps.start_time;
        document.getElementById('modalEndTime').value = event.extendedProps.end_time;
        document.getElementById('modalLocation').value = event.extendedProps.location;
        document.getElementById('modalColor').value = event.extendedProps.color;
        document.getElementById('modalEventId').value = event.id;
    }

    // Function to update event date via AJAX
    function updateEventDate(event) {
        var eventId = event.id;
        var newDate = new Date(event.start.getTime() - (event.start.getTimezoneOffset() * 60000))
                    .toISOString().split("T")[0];  // Get date part only

        $.ajax({
            url: "/events/" + eventId + "/update-date",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                event_date: newDate
            },
            success: function(response) {
                alert(response.status);

                // Reload the dashboard to ensure the correct event order
                window.location.reload();  // Automatically reload the dashboard page
            },
            error: function() {
                alert('Could not update event date.');
            }
        });
    }

    // Function to update event duration via AJAX
    function updateEventDuration(event) {
        var eventId = event.id;
        var newEndTime = event.extendedProps.end_time;

        $.ajax({
            url: "/events/" + eventId + "/update-duration",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                end_time: newEndTime
            },
            success: function(response) {
                alert(response.status);
            },
            error: function() {
                alert('Could not update event duration.');
            }
        });
    }

    // Close modal functionality
    closeModal.onclick = function() {
        modal.classList.remove('show'); // Remove 'show' class for smooth closing
    };

    // Close modal on outside click
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.remove('show'); // Remove 'show' class for smooth closing
        }
    };

    // Handle communication from dashboard to open modal with specific event
    window.addEventListener('message', function (event) {
        if (event.data.type === 'openModal') {
            // Simulate a FullCalendar event click
            var matchingEvent = calendar.getEventById(event.data.eventId);
            if (matchingEvent) {
                // Fill in event data to ensure it syncs properly
                matchingEvent.setProp('title', event.data.title);
                matchingEvent.setStart(event.data.eventDate);
                matchingEvent.setExtendedProp('start_time', event.data.startTime);
                matchingEvent.setExtendedProp('end_time', event.data.endTime);
                matchingEvent.setExtendedProp('location', event.data.location);
                matchingEvent.setExtendedProp('color', event.data.color);

                // Open the modal
                openEventModal(matchingEvent);
            }
        }
    });

    // AJAX for adding a new event
    $('#add-event-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('events.store') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                alert(response.status);

                // Reload the page to show the new event in the calendar
                window.location.reload();  // Automatically reload the page after the event is added
            },
            error: function() {
                alert('Could not add the event.');
            }
        });
    });

    // AJAX for updating an existing event
    $('#edit-event-form').on('submit', function(e) {
        e.preventDefault();
        
        var eventId = $('#modalEventId').val();

        // Directly retrieve the date value from the input field
        var eventDate = $('#modalDate').val(); // This is already in the correct YYYY-MM-DD format

        var formData = {
            _token: '{{ csrf_token() }}',
            title: $('#modalTitleInput').val(),
            event_date: eventDate, // Directly use the date input value
            start_time: $('#modalStartTime').val(),
            end_time: $('#modalEndTime').val(),
            location: $('#modalLocation').val(),
            color: $('#modalColor').val(),
        };

        $.ajax({
            url: "/events/" + eventId + "/update",
            method: 'POST',
            data: formData,
            success: function(response) {
                alert(response.status);
                calendar.refetchEvents(); // Refresh calendar to reflect updated event
                modal.classList.remove('show'); // Close modal
            },
            error: function() {
                alert('Could not update event.');
            }
        });
    });

    // AJAX for deleting an event
    $('#delete-event').on('click', function() {
        var eventId = $('#modalEventId').val();

        if (confirm('Are you sure you want to delete this event?')) {
            $.ajax({
                url: "/events/" + eventId,
                method: "DELETE",
                data: {_token: '{{ csrf_token() }}'},
                success: function(response) {
                    alert(response.status);
                    calendar.refetchEvents(); // Refresh calendar after event deletion
                    modal.classList.remove('show'); // Close modal
                }
            });
        }
    });

    // Function to send event from dashboard to FullCalendar
    function sendEventToCalendar(eventId, title, eventDate, startTime, endTime, location, color) {
        // Post message to the events page
        window.postMessage({
            type: 'openModal',
            eventId: eventId,
            title: title,
            eventDate: eventDate,
            startTime: startTime,
            endTime: endTime,
            location: location,
            color: color
        }, '*');  // Replace '*' with the origin if security concerns exist.
    }
});
</script>

</body>
</html>
