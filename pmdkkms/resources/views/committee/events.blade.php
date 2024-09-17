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

        .cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 20px;
        }

        .event-card {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .calendar-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .add-event-form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .add-event-form input, .add-event-form button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        .add-event-form button {
            background-color: #5A67D8;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .add-event-form {
                flex-direction: column;
            }

            .add-event-form input, .add-event-form button {
                margin-bottom: 10px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        @include('components.committeeHeader')
    </header>

    <!-- Main Content -->
    <div class="dashboard-container">
        <h2>Committee Events</h2>

        <!-- Add Event Form -->
        <form id="add-event-form" class="add-event-form">
            @csrf
            <input type="text" name="title" placeholder="Event Title" required>
            <input type="date" name="event_date" required>
            <input type="time" name="start_time" required>
            <input type="time" name="end_time" required>
            <input type="text" name="location" placeholder="Event Location" required>
            <button type="submit">Add Event</button>
        </form>

        <!-- Calendar -->
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- FullCalendar and AJAX Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // FullCalendar initialization
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true, // Allow drag and drop
            eventResizableFromStart: true, // Allow resizing from start
            events: @json($events), // Load events from server

            // Allow dragging of events to another date
            eventDrop: function(info) {
                var eventId = info.event.id;
                var newDate = info.event.start.toISOString().slice(0, 10); // Format date

                $.ajax({
                    url: "/events/" + eventId + "/update-date",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        event_date: newDate
                    },
                    success: function(response) {
                        alert(response.status); // Show a message that the event was updated
                    },
                    error: function() {
                        alert('Could not update event date.');
                    }
                });
            },

            // Allow resizing of events
            eventResize: function(info) {
                var eventId = info.event.id;
                var newEnd = info.event.end.toISOString().slice(0, 10); // Format date

                $.ajax({
                    url: "/events/" + eventId + "/update-duration",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        end_time: newEnd
                    },
                    success: function(response) {
                        alert(response.status); // Show a message that the event was updated
                    },
                    error: function() {
                        alert('Could not update event duration.');
                    }
                });
            },

            // Handle event click to allow editing or deleting
            eventClick: function(info) {
                var eventId = info.event.id;
                if (confirm('Do you want to delete this event?')) {
                    $.ajax({
                        url: "/events/" + eventId,
                        method: "DELETE",
                        data: {_token: '{{ csrf_token() }}'},
                        success: function(response) {
                            info.event.remove(); // Remove event from calendar
                            alert(response.status); // Show a success message
                        },
                        error: function() {
                            alert('Could not delete the event.');
                        }
                    });
                }
            },

            // Allow clicking on a date to create an event
            dateClick: function(info) {
                const eventDate = info.dateStr;
                document.querySelector('input[name="event_date"]').value = eventDate;
            }
        });

        calendar.render();

        // AJAX for adding an event
        $('#add-event-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('events.store') }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert(response.status);
                    location.reload(); // Reload the page to reflect new events
                }
            });
        });
    });
    </script>
</body>
</html>