<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Kota Kinabalu Archery Association</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f8f8f8;
        }

        /* Hero Section */
        .hero {
            background-image: url('{{ asset('images/homePageImages/homeBanner1.png') }}');
            background-size: cover;
            background-position: center;
            text-align: center;
            color: white;
            padding: 100px 20px;
            position: relative;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .cta-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        /* Highlights Section */
        .highlights {
            padding: 60px 20px;
            background-color: #fff;
            text-align: center;
        }

        .highlight {
            margin-bottom: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .highlight img {
            display: none;
            width: 1200px; /* Set fixed width */
            height: 800px; /* Set fixed height */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            object-fit: cover; /* Ensures images fill the space nicely */
        }

        .highlight img.active {
            display: block;
            margin: 0 auto; /* Centers the image */
        }

        .highlight h2 {
            font-size: 2rem;
            color: #0b1647;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .highlight p {
            font-size: 1rem;
            color: #555;
            max-width: 80%; /* Centers text with the image width */
        }

        /* Info Section */
        .info-section {
            padding: 60px 20px;
            background-color: #e7f0fa;
            text-align: center;
        }

        .info-section h3 {
            font-size: 2rem;
            color: #0b1647;
            margin-bottom: 20px;
        }

        .info-section .content {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* News & Updates Section */
        .news-updates {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            min-width: 350px;
            max-width: 550px;
            text-align: center;
        }

        .news-updates h3 {
            font-size: 1.8rem;
            color: #0b1647;
            text-align: center;
            margin-bottom: 15px;
        }

        .facebook-feed {
            margin-top: 10px;
        }

        /* Upcoming Events Section */
        .upcoming-events {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            min-width: 350px;
            max-width: 550px;
            text-align: left;
        }

        .upcoming-events h3 {
            font-size: 1.8rem;
            color: #0b1647;
            text-align: center;
            margin-bottom: 15px;
        }

        .upcoming-events ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .upcoming-events li {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .upcoming-events li:last-child {
            border-bottom: none;
        }

        .upcoming-events li .event-date {
            font-weight: bold;
            color: #007bff;
            display: block;
            margin-bottom: 5px;
        }

        .upcoming-events li .event-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }

        .upcoming-events li .event-time {
            font-size: 0.9rem;
            color: #555;
            display: flex;
            align-items: center;
            margin-bottom: 2px;
        }

        .upcoming-events li .event-location {
            font-size: 0.9rem;
            color: #777;
            display: flex;
            align-items: center;
        }

        .upcoming-events li i {
            margin-right: 5px;
        }

    /* General Mobile Adjustments */
    @media (max-width: 768px) {
        /* Adjust Hero Section for Mobile */
        .hero {
            padding: 40px 15px;
        }

        .hero h1 {
            font-size: 2rem;
        }

        .hero p {
            font-size: 1rem;
        }

        /* Stack Highlights Section */
        .highlights {
            padding: 25px 10px;
            display: block;
        }

        .highlight {
            margin-bottom: 20px;
        }

        /* Adjust Info Section for Mobile */
        .info-section {
            padding: 15px 10px;
        }

        .info-section .content {
            flex-direction: column;
            gap: 10px;
            padding: 0 8px;
        }

        /* Ensure consistent width for News & Updates and Upcoming Events */
        .news-updates,
        .upcoming-events {
            width: 100%; /* Full width on mobile */
            max-width: 550px; /* Set a consistent max width */
            margin: 0 auto 15px; /* Centered and with bottom margin */
            padding: 12px;
            box-sizing: border-box;
        }

        /* Facebook Feed Fix */
        .facebook-feed {
            width: 100%;
            overflow: hidden;
        }

        .facebook-feed .fb-page {
            width: 100% !important;
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }

        /* Update Upcoming Events Styles */
        .upcoming-events ul {
            padding: 0;
            margin: 0;
        }

        /* Adjust Image Sizes for Mobile */
        .highlight img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
    }

    /* Extra Small Screen Adjustments */
    @media (max-width: 480px) {
        .hero h1 {
            font-size: 1.6rem;
        }

        .hero p {
            font-size: 0.85rem;
        }

        /* Reduce Padding for Smaller Screens */
        .hero {
            padding: 25px 10px;
        }

        .highlights {
            padding: 10px 8px;
        }

        .info-section {
            padding: 15px 8px;
        }

        .upcoming-events li {
            font-size: 0.75rem;
        }

        .upcoming-events li .event-date {
            font-size: 0.8rem;
        }

        .upcoming-events li .event-title {
            font-size: 0.9rem;
        }

        .upcoming-events li .event-time,
        .upcoming-events li .event-location {
            font-size: 0.7rem;
        }
    }


    </style>
</head>
<body>
    <header>
        @include('components.header')
    </header>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Welcome to Kota Kinabalu Archery Association</h1>
            <p>Energizing Archery to the Highest Level</p>
            <a href="/register" class="cta-button">Join Us Now</a>
        </div>
    </div>

    <!-- Highlights Section -->
    <div class="highlights">
        <div class="highlight event-highlight">
            <img src="{{ asset('/images/homePageImages/highlight1.png') }}" class="active" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.2.jpg') }}" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.3.jpg') }}" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.4.jpg') }}" alt="Highlight 1">
            <h2>Event Highlights</h2>
            <p>Discover our key archery events, achievements, and memorable moments.</p>
        </div>
        <div class="highlight practice-highlight">
            <img src="{{ asset('images/homePageImages/highlight2.png') }}" class="active" alt="Highlight 2">
            <img src="{{ asset('images/homePageImages/highlight2.2.jpg') }}" alt="Highlight 2">
            <img src="{{ asset('images/homePageImages/highlight2.3.jpg') }}" alt="Highlight 2">
            <h2>Practice & Training</h2>
            <p>Our training sessions are tailored to improve your archery skills and performance.</p>
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="content">
            <!-- News & Updates -->
            <div class="news-updates">
                <h3>News & Updates</h3>
                <div id="fb-root"></div>
                <script async defer crossorigin="anonymous"
                    src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v16.0"></script>
                <div class="facebook-feed">
                    <div class="fb-page"
                        data-href="https://www.facebook.com/profile.php?id=100063573754394"
                        data-tabs="timeline"
                        data-width="500"
                        data-height="400"
                        data-small-header="false"
                        data-adapt-container-width="true"
                        data-hide-cover="false"
                        data-show-facepile="true">
                        <blockquote cite="https://www.facebook.com/profile.php?id=100063573754394" class="fb-xfbml-parse-ignore">
                            <a href="https://www.facebook.com/profile.php?id=100063573754394">Kota Kinabalu Archery Association</a>
                        </blockquote>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="upcoming-events">
                <h3>Upcoming Events</h3>
                <ul>
                    @if($upcomingEvents->isEmpty())
                        <li>No upcoming events available.</li>
                    @else
                        @foreach($upcomingEvents as $event)
                            <li>
                                <span class="event-date">{{ \Carbon\Carbon::parse($event->event_date)->format('d M') }}</span>
                                <span class="event-title">{{ $event->title }}</span>
                                <div class="event-time">
                                    <i class="fa fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                </div>
                                <div class="event-location">
                                    <i class="fa fa-map-marker"></i>
                                    {{ $event->location }}
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <footer>
        @include('components.footer')
    </footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Rotate images for Event Highlights
        let eventImages = document.querySelectorAll('.event-highlight img');
        let eventIndex = 0;

        function rotateEventImages() {
            eventImages[eventIndex].classList.remove('active');
            eventIndex = (eventIndex + 1) % eventImages.length;
            eventImages[eventIndex].classList.add('active');
        }

        setInterval(rotateEventImages, 3000); // Change Event Highlights image every 3 seconds

        // Rotate images for Practice & Training
        let practiceImages = document.querySelectorAll('.practice-highlight img');
        let practiceIndex = 0;

        function rotatePracticeImages() {
            practiceImages[practiceIndex].classList.remove('active');
            practiceIndex = (practiceIndex + 1) % practiceImages.length;
            practiceImages[practiceIndex].classList.add('active');
        }

        setInterval(rotatePracticeImages, 5000); // Change Practice & Training image every 5 seconds
    });
</script>
</body>
</html>
