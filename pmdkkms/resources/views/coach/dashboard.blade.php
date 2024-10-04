<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard</title>
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

        .card.attendance {
            background-color: #F56565;
        }

        .card.scoring {
            background-color: #48BB78;
        }

        .card.payment {
            background-color: #ED8936;
        }

        .announcements-container {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .announcement-card {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .announcement-details h4 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .announcement-details p {
            margin-top: 10px;
        }

        .announcement-details hr {
            border: 1px solid #ddd;
            margin: 15px 0;
        }

        /* Upcoming Events Section */
        .upcoming-events {
            margin-top: 30px;
        }

        .event-card {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .event-details h4 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .event-details hr {
            border: 1px solid #ddd;
            margin: 15px 0;
        }

        .event-details p {
            font-size: 16px;
        }

        .event-details i {
            margin-right: 8px;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .cards {
                flex-direction: column;
            }

            .event-card,
            .announcement-card {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <!-- Header is included here -->
    <header>
        @include('components.coachHeader')
    </header>

    <!-- Main Dashboard Content -->
    <div class="dashboard-container">
        <h2>Coach Dashboard</h2>

        <!-- Cards Section -->
        <div class="cards">
            <div class="card archers">
                <i class="fas fa-bullseye"></i>
                <h3>Archers</h3>
                <span>{{ $enrolledArcherCount }}</span> <!-- Dynamic count of archer -->
            </div>
            
            <div class="card attendance">
                <a href="{{ route('coach.attendanceList') }}" style="text-decoration: none; color: white; display: block; width: 100%; height: 100%;">
                    <i class="fas fa-users"></i>
                    <h3>Attendance</h3>
                </a>
            </div>
            
            <div class="card scoring">
                <i class="fas fa-chart-line"></i>
                <h3>Scoring History</h3>
            </div>
            <div class="card payment">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Payment History</h3>
            </div>
        </div>

        <!-- Announcements Section -->
        <div class="announcements-container">
            <h3>Announcements</h3>
            @if($announcements->isEmpty())
                <div class="announcement-card">
                    <p>No announcements available.</p>
                </div>
            @else
                @foreach($announcements as $announcement)
                    <div class="announcement-card">
                        <div class="announcement-details">
                            <h4>{{ $announcement->title }}</h4>
                            <hr>
                            <p>{{ $announcement->content }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
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
                            <h4>{{ $event->title }}</h4> <!-- Event title with larger font size -->
                            <hr> <!-- Horizontal line after the title -->
                            <p><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
                            <p><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>
