<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Add your external CSS and JS files here -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background-size: cover;
            background-position: center;
            padding: 0;
            display: flex;
            align-items: stretch;
            justify-content: flex-start;
            height: 40vh;
            color: #000;
            background-color: #e7f0fa;
            overflow: hidden; /* Ensure content fits within the bounds */
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2vw;
            background-color: #A7C7E7;
            max-height: 100%; /* Ensures it fits the container */
            overflow: auto; /* Adds scrolling if content overflows */
            width: 0; /* Width of the content area */
            flex-grow: 1;
        }

        .hero-content h1 {
            font-size: clamp(1.5rem, 4vw, 2.5rem); /* Dynamic scaling for heading */
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
        }

        .hero-content p {
            color: #000;
            text-align: justify;
            line-height: 1.6;
            word-wrap: break-word; /* Ensures long words break and wrap */
            overflow-wrap: break-word; /* Supports older browsers */
            font-size: clamp(1rem, 2vw, 1.25rem); /* Dynamic scaling for paragraph */
            max-height: fit-content; /* Ensures the content fits without overflowing */
        }

        .hero-image {
            flex: 1;
            background-size: cover;
            background-position: center;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Section Titles */
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            margin: 40px 0 20px;
            text-align: left;
            color: #000000;
            padding-left: 2vw;
        }

        /* President and Coaches Section */
        .presidents-section, .coaches-section {
            display: flex;
            justify-content: space-around;
            padding: 2vw;
            flex-wrap: wrap;
        }

        .president, .coach {
            text-align: center;
            margin: 20px;
        }

        .president img, .coach img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #007bff;
            margin-bottom: 10px;
        }

        .president p, .coach p {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000000;
        }

        /* Organizational Chart Section */
        .org-chart {
            text-align: center;
            padding: 2vw;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .org-chart img {
            width: 80%;
            max-width: 600px;
            height: auto;
            border: 2px solid #000000;
            border-radius: 8px;
        }

        /* Media Queries for Adaptability */
        @media (max-width: 1024px) {
            .hero {
                height: 35vh;
            }
            .hero-content {
                width: 40%;
            }
            .section-title {
                padding-left: 4vw;
            }
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                height: auto;
            }
            .hero-content {
                width: 100%;
                text-align: center;
                padding: 5vw;
            }
            .hero-image {
                height: 30vh;
            }
            .hero-content p {
                font-size: clamp(1rem, 2vw, 1rem); /* Smaller font size for tablets */
            }
            .section-title {
                padding-left: 5vw;
            }
            .presidents-section, .coaches-section {
                padding-left: 0;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: clamp(1rem, 4vw, 1.5rem); /* Smaller scaling for mobile */
            }
            .hero-content p {
                font-size: clamp(0.85rem, 2vw, 1rem); /* Smaller scaling for mobile */
                line-height: 1.4;
            }
            .section-title {
                padding-left: 5vw;
                text-align: center;
            }
            .presidents-section, .coaches-section {
                flex-direction: column;
                align-items: center;
            }
            .president img, .coach img {
                width: 120px; /* Smaller image for mobile */
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <header>
        @include('components.header')
    </header>

    <div class="hero">
        <div class="hero-content">
            <h1>About PMDKK</h1>
            <p>"The Kota Kinabalu Archery Association (Persatuan Memanah Daerah Kota Kinabalu or PMDKK) is a regional sports organization dedicated to promoting the sport of archery in Kota Kinabalu, Malaysia. PMDKK focuses on fostering archery skills among its members, offering structured training programs, organizing tournaments, and providing a platform for both amateur and professional archers to improve their abilities. The association plays a vital role in building a community around the sport, encouraging participation at all levels while upholding the values of discipline, focus, and sportsmanship."</p>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/aboutPageImages/aboutBanner1.png') }}" alt="About PMDKK">
        </div>
    </div>

    <div class="section-title">Explore Our Esteemed Presidents</div>
    <div class="presidents-section">
        <div class="president">
            <img src="{{ asset('images/fillerimage.png') }}" alt="President 1">
            <p>President 1</p>
        </div>
        <div class="president">
            <img src="{{ asset('images/fillerimage.png') }}" alt="President 2">
            <p>President 2</p>
        </div>
        <div class="president">
            <img src="{{ asset('images/fillerimage.png') }}" alt="President 3">
            <p>President 3</p>
        </div>
    </div>

    <div class="section-title">Organizational Chart</div>
    <div class="org-chart">
        <img src="{{ asset('images/aboutPageImages/orgChart.png') }}" alt="Organizational Chart">
    </div>

    <div class="section-title">Our Coaches</div>
    <div class="coaches-section">
        <div class="coach">
            <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 1">
            <p>Coach 1</p>
        </div>
        <div class="coach">
            <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 2">
            <p>Coach 2</p>
        </div>
        <div class="coach">
            <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 3">
            <p>Coach 3</p>
        </div>
        <div class="coach">
            <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 4">
            <p>Coach 4</p>
        </div>
        <div class="coach">
            <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 5">
            <p>Coach 5</p>
        </div>
        <div class="coach">
            <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 6">
            <p>Coach 6</p>
        </div>
        <div class="coach">
            <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 7">
            <p>Coach 7</p>
        </div>
        <div class="coach">
            <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 8">
            <p>Coach 8</p>
        </div>
    </div>

    <footer>
        @include('components.footer')
    </footer>
</body>
</html>
