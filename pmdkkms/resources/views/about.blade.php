<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About PMDKK | Kota Kinabalu Archery Association</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #f8f8f8;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background-image: url('{{ asset('images/aboutPageImages/aboutBanner3.png') }}');
            background-size: cover;
            background-position: center;
            text-align: center;
            color: white;
            padding: 50px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 20vh;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        /* About Description Section */
        .about-description {
            text-align: center;
            padding: 20px 40px;
            color: #555;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Main Content Section */
        .content-section {
            padding: 60px 20px;
            display: flex;
            flex-direction: column;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .content-block {
            display: flex;
            gap: 30px;
            align-items: center;
            flex-direction: row; /* Ensures text on the left and image on the right */
        }

        .content-block:nth-child(even) {
            flex-direction: row; /* Remove the reverse styling for the even sections */
        }

        .text-block {
            flex: 1;
            padding: 20px;
        }

        .text-block h2 {
            font-size: 1.75rem;
            font-weight: bold;
            color: #0b1647;
            margin-bottom: 10px;
        }

        .text-block p {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
        }

        .image-block {
            flex: 1;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .image-block img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Presidents and Coaches Sections */
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            margin: 40px 0 20px;
            text-align: center;
            color: #000000;
        }

        .team-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 40px 20px;
        }

        .team-member {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            margin: 20px;
            width: 200px;
            transition: transform 0.3s;
        }

        .team-member:hover {
            transform: translateY(-10px);
        }

        .team-member img {
            width: 100%;
            height: auto;
            border-radius: 50%;
            max-width: 120px;
            margin-bottom: 15px;
            border: 3px solid #0b1647;
        }

        .team-member h3 {
            font-size: 1.25rem;
            color: #0b1647;
            margin-bottom: 5px;
        }

        .team-member p {
            font-size: 0.95rem;
            color: #555;
        }

        /* President Message Section */
        .president-message-section {
            display: flex;
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
            gap: 10px; /* Reduce the gap for a tighter layout */
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .team-member {
            text-align: center; /* Center-align the president's image and text */
            margin-bottom: 5px; /* Optional: fine-tune spacing below the team member */
        }

        .message-block {
            text-align: center; /* Center-align the message text */
            max-width: 1700px;
            margin-top: 0; /* Remove any extra top margin */
        }

        .message-block h3 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0b1647;
            margin-bottom: 5px; /* Tighten space below the title */
        }

        .message-block p {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
        }

        /* Organizational Chart */
        .org-chart {
            text-align: center;
            padding: 40px 20px;
        }

        .org-chart img {
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Button */
        .cta-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 20px;
            display: block;
            width: max-content;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .text-block h2 {
                font-size: 1.5rem;
            }

            .content-section {
                flex-direction: column;
                align-items: center;
            }

            .image-block {
                height: 200px; /* Adjust height for smaller screens */
            }

            .team-section {
                gap: 10px;
            }

            .team-member {
                width: 140px;
                padding: 10px;
            }

            .team-member img {
                width: 70px;
                height: 70px;
            }

            .president-message-section {
                gap: 10px;
            }

            .message-block {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 1.8rem;
            }

            .content-section {
                padding: 20px 10px;
                gap: 15px;
            }

            .team-member {
                width: 120px;
                padding: 8px;
            }

            .team-member img {
                width: 60px;
                height: 60px;
            }

            .message-block p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <header>
        @include('components.header')
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>About PMDKK</h1>
        </div>
    </section>

     <!-- Main Content Section -->
     <section class="content-section">
        <!-- Block 1 -->
        <div class="content-block">
            <div class="image-block">
                <img src="{{ asset('images/aboutPageImages/aboutImage3.jpg') }}" alt="Archery training at PMDKK">
            </div>
            <div class="text-block">
                <h2>What is PMDKK?</h2>
                <p>PMDKK is a regional sports organization that focuses on fostering archery skills among its members. We provide structured training programs, organize tournaments, and offer a platform for both amateur and professional archers to improve their abilities.</p>
            </div>
        </div>

        <!-- Block 2 -->
        <div class="content-block">
            <div class="text-block">
                <h2>Our Vision</h2>
                <p>Our vision is to create a strong archery community in Kota Kinabalu that supports and nurtures both new and seasoned archers, providing high-quality training sessions and competitive opportunities.</p>
            </div>
            <div class="image-block">
                <img src="{{ asset('images/aboutPageImages/aboutImage1.jpg') }}" alt="PMDKK training session">
            </div>
        </div>
    </section>

    <!-- Presidents Section -->
    <section>
        <h2 class="section-title">Our Esteemed President</h2>
        <div class="president-message-section">
            <div class="team-member">
                <img src="{{ asset('images/fillerimage.png') }}" alt="President 1">
                <h3>Ram Singh</h3>
                <p>2022 - Present</p>
            </div>
            <div class="message-block">
                <h3>President's Message</h3>
                <p>At PMDKK, we strive to build a nurturing environment for archers of all skill levels. We believe in fostering a spirit of excellence and community through structured training, friendly competitions, and shared passion. Together, we can reach new heights and strengthen the archery community in Kota Kinabalu.</p>
            </div>
        </div>
    </section>

    <!-- Organizational Chart Section -->
    <section class="org-chart">
        <h2 class="section-title">Organizational Chart</h2>
        <img src="{{ asset('images/aboutPageImages/orgChart.png') }}" alt="Organizational Chart">
    </section>

    <!-- Coaches Section -->
    <section>
        <h2 class="section-title">Meet Our Coaches</h2>
        <div class="team-section">
            <div class="team-member">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 1">
                <h3>Paul Leong</h3>
                <p>Head Coach</p>
            </div>
            <div class="team-member">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 2">
                <h3>Gabriel Liew</h3>
                <p>Compound Coach</p>
            </div>
            <div class="team-member">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 3">
                <h3>Otto Wong Co Wan</h3>
                <p>Compound & Recurve</p>
            </div>
            <div class="team-member">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 4">
                <h3>Kenneth Ho </h3>
                <p>Recurve Coach</p>
            </div>
            <div class="team-member">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Coach 5">
                <h3>Sunny Tan</h3>
                <p>Equipment Supervisor</p>
            </div>
        </div>
    </section>

    <footer>
        @include('components.footer')
    </footer>
</body>
</html>
