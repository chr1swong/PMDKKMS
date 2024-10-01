<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Dashboard</title>
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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

        .card {
            flex: 1;
            min-width: 220px;
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: white;
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .card i {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .card h3 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .card span {
            font-size: 24px;
            font-weight: bold;
        }

        .card.archers {
            background-color: #5A67D8;
        }

        .card.coaches {
            background-color: #48BB78;
        }

        .card.committee {
            background-color: #F56565;
        }

        .card.payments {
            background-color: #ED8936;
        }

        .upcoming-events {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .event-card {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .event-details {
            font-size: 16px;
        }

        .event-details i {
            margin-right: 8px;
        }

        .event-action {
            text-align: right;
        }

        .edit-btn {
            background-color: #5A67D8;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover {
            background-color: #434190;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .cards {
                flex-direction: column;
            }

            .event-card {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }

            .event-action {
                margin-top: 10px;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <!-- Header is included here -->
    <header>
        @include('components.committeeHeader')
    </header>

     <!-- Main Dashboard Content -->
     <div class="dashboard-container">
        <h2>Committee Dashboard</h2>

        <!-- Cards Section -->
        <div class="cards">
            <a href="{{ route('committee.member', ['role' => 'archer']) }}" class="card-link">
                <div class="card archers">
                    <i class="fas fa-bullseye"></i>
                    <h3>Archers</h3>
                    <span>{{ $archerCount }}</span> <!-- Dynamic count of archers -->
                </div>
            </a>

            <a href="{{ route('committee.member', ['role' => 'coach']) }}" class="card-link">
                <div class="card coaches">
                    <i class="fas fa-user-tie"></i>
                    <h3>Coaches</h3>
                    <span>{{ $coachCount }}</span> <!-- Dynamic count of coaches -->
                </div>
            </a>

            <a href="{{ route('committee.member', ['role' => 'committee']) }}" class="card-link">
                <div class="card committee">
                    <i class="fas fa-users"></i>
                    <h3>Committee</h3>
                    <span>{{ $committeeCount }}</span> <!-- Dynamic count of committee members -->
                </div>
            </a>

            <div class="card payments">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Payments</h3>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="upcoming-events">
            <h3>Upcoming Events</h3>
            @if($upcomingEvents->isEmpty())
                <p>No upcoming events available.</p>
            @else
                @foreach($upcomingEvents as $event)
                    <div class="event-card">
                        <div class="event-details">
                            <p><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
                            <p><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        </div>
                        <div class="event-action">
                            <!-- Link to the events.index route -->
                            <a href="{{ route('events.index', ['event_id' => $event->id]) }}" class="edit-btn">Edit</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editButtons = document.querySelectorAll('.edit-btn');
            
            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var eventId = this.getAttribute('data-event-id');
                    var eventTitle = this.getAttribute('data-event-title');
                    var eventDate = this.getAttribute('data-event-date');
                    var startTime = this.getAttribute('data-event-start-time');
                    var endTime = this.getAttribute('data-event-end-time');
                    var location = this.getAttribute('data-event-location');
                    var color = this.getAttribute('data-event-color');

                    window.postMessage({
                        type: 'openModal',
                        eventId: eventId,
                        title: eventTitle,
                        eventDate: eventDate,
                        startTime: startTime,
                        endTime: endTime,
                        location: location,
                        color: color
                    }, '*');
                });
            });
        });
    </script>
</body>
</html>
