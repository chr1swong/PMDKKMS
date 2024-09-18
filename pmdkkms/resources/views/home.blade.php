<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Add your external CSS and JS files here -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    
    <style>
    /* Hero Section */
    .hero {
        position: relative;
        background-size: cover;
        background-position: center;
        padding: 5vw 2vw;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 20vh;
        color: white;
    }

    .hero-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 90vw;
    }

    .hero-text {
        flex: 1;
        margin-right: 20px;
        text-align: left;
    }

    .hero-text h1 {
        font-size: 3vw;
        font-weight: bold;
        margin-bottom: 2vw;
    }

    .hero-text p {
        font-size: 1.5vw;
        margin-top: 10px;
    }

    .hero-image img {
        max-width: 15vw;
        height: auto;
        border-radius: 50%;
        border: 5px solid white;
        margin-left: 2vw;
    }

    @media (max-width: 1024px) {
        .hero {
            flex-direction: column;
            text-align: center;
            height: 60vh;
        }

        .hero-text h1 {
            font-size: 6vw;
        }

        .hero-text p {
            font-size: 3vw;
        }

        .hero-image img {
            max-width: 30vw;
            margin: 20px 0;
        }
    }

    @media (max-width: 768px) {
        .hero {
            height: auto;
            padding: 5vw;
        }

        .hero-text h1 {
            font-size: 7vw;
            margin-bottom: 10px;
        }

        .hero-text p {
            font-size: 4vw;
        }

        .hero-image img {
            max-width: 40vw;
        }
    }

    /* Highlights */
    .highlights {
        display: flex;
        flex-direction: column;
        padding: 50px 20px;
        background-color: #fff;
    }

    .highlights .highlight {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 40px;
        position: relative;
        flex-wrap: wrap;
    }

    .highlight .slideshow-container {
        position: relative;
        width: 100%;
        max-width: 800px;
        height: 500px;
        overflow: hidden;
        border-radius: 8px;
        background-color: #f0f0f0;
        border: 3px solid #333;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .highlight img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        transition: opacity 1s ease-in-out;
    }

    .highlight img.active {
        opacity: 1;
    }

    .highlight-text {
        flex: 1;
        margin-left: 20px;
        margin-right: 20px;
        margin-top: 0;
        text-align: justify;
    }

    .highlights .highlight h2 {
        font-size: 2.5em;
        color: #000000;
        margin-bottom: 10px;
    }

    .highlights .highlight p {
        font-size: 1.5em;
        color: #555;
        text-align: justify;
    }

    .highlights .highlight:nth-child(odd) {
        flex-direction: row;
    }

    .highlights .highlight:nth-child(even) {
        flex-direction: row-reverse;
    }

    @media (max-width: 768px) {
        .highlights .highlight {
            flex-direction: column;
        }

        .highlight-text {
            margin-left: 0;
            text-align: justify;
        }
    }

    /* Info Section */
    .info-section {
        display: flex;
        justify-content: space-around;
        padding: 50px 20px;
        background-color: #e7f0fa;
        border-radius: 8px;
        margin: 50px 0;
    }

    .news-updates, .upcoming-events {
        width: 45%;
        padding: 10px;
    }

    .news-updates h3, .upcoming-events h3 {
        font-size: 1.75rem;
        margin-bottom: 20px;
        color: #333;
        font-weight: bold;
    }

    .news-updates img {
        width: 100%;
        height: auto;
        margin-top: 10px;
    }

    .upcoming-events ul {
        list-style-type: none;
        padding-left: 0;
    }

    .upcoming-events ul li {
        margin-bottom: 10px;
        font-size: 1.2rem;
        color: #333;
    }

    .facebook-feed, .instagram-feed {
        width: 100%;
        height: 600px;
        margin-bottom: 20px;
    }

    .instagram-feed {
        max-width: 500px;
        margin: 0 auto;
    }

    .upcoming-events ul li span {
        font-weight: bold;
        color: #00aaff;
    }

    @media (max-width: 1024px) {
        .info-section {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .info-section {
            flex-direction: column;
        }
    }
    </style>
</head>

<header>
    @include('components.header')
</header>

<div class="hero" style="background-image: url('{{ asset('images/homePageImages/homeBanner1.png') }}');">
    <div class="hero-content">
        <div class="hero-text">
            <h1>Welcome To Kota Kinabalu Archery Association</h1>
            <p>Energizing Archery to the highest level</p>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/pmdkkLogo.png') }}" alt="PMDKK Logo">
        </div>
    </div>
</div>

<div class="highlights">
    <div class="highlight">
        <div class="slideshow-container">
            <img src="{{ asset('/images/homePageImages/highlight1.png') }}" class="active" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.2.jpg') }}" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.3.jpg') }}" alt="Highlight 1">
            <img src="{{ asset('images/homePageImages/highlight1.4.jpg') }}" alt="Highlight 1">
        </div>
        <div class="highlight-text">
            <h2>HIGHLIGHT 1:</h2>
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."</p>
        </div>
    </div>
    <div class="highlight">
        <div class="slideshow-container">
            <img src="{{ asset('images/homePageImages/highlight2.png') }}" class="active" alt="Highlight 2">
            <img src="{{ asset('images/homePageImages/highlight2.2.jpg') }}" alt="Highlight 2">
            <img src="{{ asset('images/homePageImages/highlight2.3.jpg') }}" alt="Highlight 2">
        </div>
        <div class="highlight-text">
            <h2>HIGHLIGHT 2:</h2>
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."</p>
        </div>
    </div>
</div>

<div class="info-section">
    <div class="news-updates">
        <h3>News & Updates</h3>
        
        <!-- Facebook Feed -->
        <div class="facebook-feed">
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0" nonce="ABC123"></script>
            <div class="fb-page" data-href="https://www.facebook.com/profile.php?id=100063573754394" data-tabs="timeline" data-width="500" data-height="600" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/profile.php?id=100063573754394" class="fb-xfbml-parse-ignore">
                    <a href="https://www.facebook.com/profile.php?id=100063573754394">Kota Kinabalu Archery Association</a>
                </blockquote>
            </div>
        </div>
    </div>

    <div class="upcoming-events">
        <h3>Upcoming Events</h3>
        <ul>
            @if($upcomingEvents->isEmpty())
                <!-- Display this message when there are no events -->
                <li>No upcoming events available.</li>
            @else
                @foreach($upcomingEvents as $event)
                    <li>
                        <span>{{ \Carbon\Carbon::parse($event->event_date)->format('d M') }}:</span> {{ $event->title }} <br>
                        <i class="fa fa-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }} <br>
                        <i class="fa fa-map-marker"></i> {{ $event->location }}
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const highlights = document.querySelectorAll('.highlight');
    highlights.forEach((highlight) => {
        const images = highlight.querySelectorAll('img');
        let currentIndex = 0;

        setInterval(() => {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }, 3000);
    });
});
</script>

<footer>
    @include('components.footer')
</footer>
</html>
