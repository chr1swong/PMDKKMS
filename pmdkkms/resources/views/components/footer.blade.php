<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archery Association</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: white;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Footer Styles */
        footer {
            background-color: #0b1647;
            color: white;
            padding: 20px 0;
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
            gap: 30px; /* Adjusts the space between the icons */
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
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h4>Contact Us</h4>
            <p><b>Address:</b> Likas Archery Range, 88400, Kota Kinabalu, Sabah, Malaysia</p>
            <p><b>Email:</b> info@archeryassociation.com</p>
            <p><b>Phone:</b> +60 123 456 789</p>
        </div>
        <div class="footer-section social-icons">
            <h4>Find Us At</h4>
            <div class="social-icons">
                <a href="https://www.facebook.com/profile.php?id=100063573754394" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/pmdkk_sabaharchery?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Kota Kinabalu Archery Association. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
