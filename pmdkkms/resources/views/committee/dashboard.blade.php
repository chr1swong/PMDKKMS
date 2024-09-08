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
            gap: 30px; /* Increase gap between the cards */
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            min-width: 220px; /* Minimum width for small screens */
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: white;
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            justify-content: space-between;
            gap: 30px; /* Add a gap between events and application card */
        }

        .event-card,
        .application-card {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 45%;
        }

        .event-card{
            padding-left: 30px;
        }

        .application-card {
            padding-right: 30px;
        }

        .event-details,
        .application-details {
            font-size: 16px;
        }

        .event-details i,
        .application-details i {
            margin-right: 8px;
        }

        .event-action,
        .application-action {
            text-align: right;
        }

        .edit-btn,
        .view-btn {
            background-color: #5A67D8;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover,
        .view-btn:hover {
            background-color: #434190;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .cards {
                flex-direction: column;
            }

            .event-card,
            .application-card {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }

            .event-action,
            .application-action {
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
            <div class="card archers">
                <i class="fas fa-bullseye"></i>
                <h3>Archers</h3>
                <span>32</span>
            </div>
            <div class="card coaches">
                <i class="fas fa-user-tie"></i>
                <h3>Coaches</h3>
                <span>5</span>
            </div>
            <div class="card committee">
                <i class="fas fa-users"></i>
                <h3>Committee</h3>
                <span>8</span>
            </div>
            <div class="card payments">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Payments</h3>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="upcoming-events">
            <div class="event-card">
                <div class="event-details">
                    <p><i class="fas fa-calendar-alt"></i> Sabah Open</p>
                    <p><i class="fas fa-clock"></i> 13 January 2024, 8:00am - 11:00am</p>
                    <p><i class="fas fa-map-marker-alt"></i> Padang Sukma Likas</p>
                </div>
                <div class="event-action">
                    <a href="#" class="edit-btn">Edit</a>
                </div>
            </div>
        
            <div class="application-card">
                <div class="application-details">
                    <p>Pending Request: <span style="color: #FFD700; font-weight: bold;">3</span></p>
                </div>
                <div class="application-action">
                    <a href="#" class="view-btn">View Applications</a>
                </div>
            </div>
        </div>

        <div class="upcoming-events">
            <div class="event-card">
                <div class="event-details">
                    <p><i class="fas fa-calendar-alt"></i> Sabah Open</p>
                    <p><i class="fas fa-clock"></i> 14 January 2024, 8:00am - 11:00am</p>
                    <p><i class="fas fa-map-marker-alt"></i> Padang Sukma Likas</p>
                </div>
                <div class="event-action">
                    <a href="#" class="edit-btn">Edit</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
