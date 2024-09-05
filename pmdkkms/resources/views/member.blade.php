<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership</title>
    <!-- Add your external CSS and JS files here -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
        <style>
            /* General Styles */
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                margin: 0;
                padding: 0;
            }

            .content-wrapper {
                flex: 1;
            }

            /* Hero Section */
            .hero {
                position: relative;
                background-size: cover;
                background-position: center;
                padding: 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                height: auto; /* Adjust height to fit content */
                background-color: #e7f0fa;
                color: white;
            }

            .hero-content {
                flex: 1;
                padding: 20px;
            }

            .hero-content h1 {
                font-size: 2.5rem;
                font-weight: bold;
                color: #333;
                margin-bottom: 20px; /* Add margin below the title */
            }

            .hero-content p {
                font-size: 1.5rem;
                color: #333;
                margin-bottom: 20px; /* Add margin below the paragraph */
            }

            .hero-image img {
                max-width: 20vw;
                height: auto;
            }

            /* Membership Cards */
            .membership-section {
                display: flex;
                justify-content: start;
                margin-bottom: 10px;
                gap: 40px; /* Added gap between membership cards */
            }

            .membership-card {
                background-color: #d3d3d3;
                border-radius: 8px;
                padding: 20px;
                width: 40%; /* Adjust width for two cards side by side */
                text-align: center;
                font-size: 1.25rem;
            }

            .membership-card h2 {
                font-size: 1.5rem;
                margin-bottom: 10px;
                color: #000;
                font-weight: 900;
            }

            .membership-card ul {
                list-style-type: disc;
                padding-left: 20px;
                text-align: left;
                color: #333;
            }

            .membership-card ul li {
                margin-bottom: 5px;
            }

            /* Contact Section */
            .contact-section {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                padding: 2vw;
                background-color: #f9f9f9;
                text-align: left;
                padding: 30px;
            }

            .contact-section h2 {
                font-size: 1.5rem;
                margin-bottom: 10px;
                font-weight: bold;
                color: #000;
                flex: 1;
            }

            .contact-card-container {
                display: flex;
                justify-content: flex-start;
                gap: 40px;
                flex-wrap: wrap;
                margin-top: 20px;
                width: 50%;
            }

            .contact-card {
                background-color: #d3d3d3;
                border-radius: 8px;
                padding: 20px;
                width: 45%; /* Adjust width to fit two cards */
                text-align: left;
            }

            .contact-card img {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background-color: #007bff;
                margin-bottom: 10px;
            }

            .contact-card p {
                margin: 5px 0;
                color: #000;
                font-size: 1.25rem;
            }

            /* Find Us Section */
            .find-us-section {
                padding: 30px;
                background-color: #f9f9f9;
            }

            .find-us-section h2 {
                font-size: 1.5rem;
                font-weight: bold;
                color: #000;
                margin-bottom: 20px;
            }

            .find-us-section p {
                font-size: 1.25rem;
                font-weight: bold;
                color: #000;
                margin-bottom: 20px;
            }

            .location-section {
                display: flex;
                justify-content: flex-start;
                gap: 20px;
            }

            .location-section {
                display: flex;
                justify-content: left; /* Center the images horizontally */
                gap: 50px;
            }

            .location-section img, .map-image {
                width: 100%;
                height: auto;
                max-width: 50vh;
                border-radius: 8px;
                border: 3px solid #333; /* Add a stroke (border) around the images */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow for a 3D effect */
            }

            /* Footer Styles */
            footer {
                background-color: #0b1647;
                color: white;
                padding: 20px 0;
                text-align: left;
            }

            .footer-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                max-width: 1200px;
                margin: 0 auto;
            }

            .footer-section {
                flex: 1;
                min-width: 250px;
                margin: 10px;
                text-align: left;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .footer-section h4 {
                font-weight: 900;
                font-size: 30px;
            }

            .footer-section p {
                margin: 0;
                line-height: 1.5;
            }

            .social-icons {
                display: flex;
                justify-content: center;
                gap: 30px;
            }

            .social-icons a {
                font-size: 40px;
                color: white;
                transition: transform 0.3s;
                margin-top: -10px;
            }

            .social-icons a:hover {
                transform: scale(1.2);
            }

            .footer-bottom {
                text-align: center;
                font-size: 13px;
                padding-top: 20px;
                border-top: 1px solid #333;
            }

            .footer-section .social-icons {
                font-size: 20px;
                text-align: center;
            }
        </style>
    </head>
    <header>
            @include('components.header')
        </header>

        <div class="hero">
            <div class="hero-content">
                <h1>Membership</h1>
                <p>Membership information</p>
                
                <!-- Membership Cards -->
                <div class="membership-section">
                    <div class="membership-card">
                        <h2>Non-Member</h2>
                        <ul>
                            <li>Walk-In</li>
                            <li>RM30/Month</li>
                            <li>Not eligible for PMDKK Events</li>
                        </ul>
                    </div>
                    <div class="membership-card">
                        <h2>Member</h2>
                        <ul>
                            <li>Student - RM10/Month</li>
                            <li>Adults - RM30/Month</li>
                            <li>Eligible for PMDKK Events</li>
                            <li>Monthly or Annual membership renewal is available</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/memberPageImages/membershipBanner.png') }}" alt="Membership Illustration">
            </div>
        </div>

        <div class="contact-section">
            <h2>For more information, please contact our treasurer</h2>
            <div class="contact-card-container">
                <div class="contact-card">
                    <img src="{{ asset('images/fillerimage.png') }}" alt="Secretary">
                    <p><strong>Secretary Name</strong><br>Secretary Contact</p>
                </div>
                <div class="contact-card">
                    <img src="{{ asset('images/fillerimage.png') }}" alt="Treasurer">
                    <p><strong>Treasurer Name</strong><br>Treasurer Contact</p>
                </div>
            </div>
        </div>

        <!-- Find Us Section -->
        <div class="find-us-section">
            <h2>How to find Us:</h2>
            <p>Location: Likas Archery Range, 88400, Kota Kinabalu, Sabah</p>
            <div class="location-section">
                <img src="{{ asset('images/memberPageImages/likasrange2.png') }}" alt="Map" class="map-image">
                <img src="{{ asset('images/memberPageImages/likasrange1.jpg') }}" alt="Location Image">
            </div>
        </div>

        <footer>
            @include('components.footer')
        </footer>
    </div>

