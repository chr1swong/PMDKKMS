<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership</title>
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
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #f4f4f9;
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 40px;
            background-color: #e7f0fa;
            color: #333;
            border-bottom: 1px solid #ccc;
        }

        .hero-content {
            flex: 1;
            padding: 20px;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 600;
            color: #0b1647;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.25rem;
            color: #555;
            margin-bottom: 20px;
        }

        .hero-image img {
            max-width: 300px;
            height: auto;
        }

        /* Membership Cards */
        .membership-section {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            gap: 20px;
        }

        .membership-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            width: 45%;
            text-align: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #ddd;
        }

        .membership-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        .membership-card h2 {
            font-size: 1.75rem;
            margin-bottom: 15px;
            color: #0b1647;
            font-weight: 700;
        }

        .membership-card ul {
            list-style-type: disc;
            padding-left: 20px;
            text-align: left;
            color: #555;
        }

        .membership-card ul li {
            margin-bottom: 10px;
        }

        /* Register Link */
        .hero-content a {
            font-size: 1.25rem;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .hero-content a:hover {
            text-decoration: underline;
        }

        /* Centered Contact Section */
        .contact-section, .find-us-section {
            padding: 60px 20px; /* Consistent padding for both sections */
            background-color: #f9f9f9;
            text-align: center;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .contact-section h2, .find-us-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: 600;
            color: #0b1647;
        }

        .contact-card-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: nowrap;
            max-width: 800px;
            margin-top: 20px;
        }

        .contact-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            width: 48%;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .contact-card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #007bff;
            margin-bottom: 15px;
        }

        .contact-card p {
            margin: 10px 0;
            color: #333;
            font-size: 1.1rem;
        }

        /* Find Us Section */
        .find-us-section p {
            font-size: 1.25rem;
            color: #555;
            margin-bottom: 20px;
        }

        .location-section {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 20px;
        }

        .location-section img {
            width: 100%;
            height: auto;
            max-width: 600px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Footer Styles */
        footer {
            background-color: #0b1647;
            color: white;
            padding: 20px 0;
            text-align: center;
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
        }

        .footer-section h4 {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .footer-section p {
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icons a {
            font-size: 1.5rem;
            color: white;
            transition: transform 0.3s;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .footer-bottom {
            font-size: 0.8rem;
            padding-top: 10px;
            border-top: 1px solid #333;
        }

         /* Responsive Styles for Hero Content */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 1.7rem;
        }

        .membership-card h2 {
            font-size: 1.5rem;
        }
        
        .hero-content p,
        .membership-card ul li {
            font-size: 1.0rem;
        }

        .hero {
            flex-direction: column;
            padding: 20px;
        }

        .hero-content {
            padding: 10px;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .hero-content p {
            font-size: 1rem;
        }

        .hero-image {
            display: none;
        }

        .membership-section {
            flex-direction: column;
            align-items: center;
        }

        .membership-card {
            width: 100%;
            max-width: 400px;
        }

        .location-section {
            flex-direction: column;
            align-items: center;
        }

        .location-section img {
            max-width: 100%;
            margin-bottom: 20px;
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
            <h1>Membership Information</h1>
            <div class="membership-section">
                <div class="membership-card">
                    <h2>Non-Member</h2>
                    <ul>
                        <li>Walk-In</li>
                        <li>RM30/Month</li>
                        <li>No access to <br> - PMDKK Events <br> - Attendance <br> - Scoring <br> - Training Analytics
                        </li>
                    </ul>
                </div>
                <div class="membership-card">
                    <h2>Member</h2>
                    <ul>
                        <li>Membership Fee - RM30/Month</li>
                        <li>Membership Renewal can be done through online banking</li>
                        <li>Access to <br> - PMDKK Events <br> - Attendance <br> - Scoring <br> - Training Analytics
                    </ul>
                </div>
            </div>
            <p style="margin-top: 20px; font-size: 1.25rem;">
                To register, please <a href="{{ route('register') }}">click here</a>.
            </p>
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
                <p><strong>Shiu Vay Leung (Secretary)</strong><br>019-850 7682</p>
            </div>
            <div class="contact-card">
                <img src="{{ asset('images/fillerimage.png') }}" alt="Treasurer">
                <p><strong>Stephanie Chin (Treasurer)</strong><br>016-832 2509</p>
            </div>
        </div>
    </div>

    <div class="find-us-section">
        <h2>How to find Us:</h2>
        <p>Location: Likas Archery Range, 88400, Kota Kinabalu, Sabah</p>
        <div class="location-section">
            <img src="{{ asset('images/memberPageImages/likasrange2.png') }}" alt="Map" class="map-image">
            <img src="{{ asset('images/memberPageImages/likasrange1.jpg') }}" alt="Location">
        </div>
    </div>

    <footer>
        @include('components.footer')
    </footer>
</body>
</html>
