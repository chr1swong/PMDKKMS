<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archery Association</title>
    <style>
        /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
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
    gap: 20px; /* Add spacing between sections */
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
    font-size: 28px;
    margin-bottom: 10px;
    text-align: center;
}

.footer-section p {
    margin: 5px 0;
    line-height: 1.5;
    text-align: center;
    font-size: 16px; /* Adjust text size */
}

.social-icons {
    display: flex;
    justify-content: center;
    gap: 20px; /* Adjusts the space between the icons */
}

.social-icons a {
    font-size: 36px;
    color: white;
    transition: transform 0.3s;
    margin-top: -5px;
}

.social-icons a:hover {
    transform: scale(1.2);
}

.footer-bottom {
    text-align: center;
    font-size: 12px;
    padding-top: 20px;
    border-top: 1px solid #333;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
        gap: 30px; /* Increase spacing between sections on mobile */
    }

    .footer-section {
        width: 100%; /* Make sections take full width on mobile */
        text-align: center;
    }

    .footer-section h4 {
        font-size: 24px; /* Adjust font size for headers */
    }

    .footer-section p {
        font-size: 14px; /* Adjust text size for smaller screens */
    }

    .social-icons a {
        font-size: 32px; /* Scale icons for smaller screens */
    }

    .footer-bottom {
        font-size: 11px; /* Adjust bottom text size */
    }
}

@media (max-width: 576px) {
    .footer-container {
        padding: 10px; /* Reduce padding for small phones */
    }

    .footer-section h4 {
        font-size: 20px;
    }

    .footer-section p {
        font-size: 13px;
    }

    .social-icons a {
        font-size: 28px;
    }

    .footer-bottom {
        font-size: 10px;
    }
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
