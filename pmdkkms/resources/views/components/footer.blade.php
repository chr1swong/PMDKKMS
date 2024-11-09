<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archery Association</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        /* Footer Styles */
        footer {
            background-color: #0b1647;
            color: #fff;
            padding: 30px 0;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            gap: 40px;
        }

        .footer-section {
            flex: 1;
            min-width: 220px;
        }

        .footer-section h4 {
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .footer-section p, .footer-section a {
            font-size: 14px;
            line-height: 1.6;
            color: #fff;
        }

        .footer-section a {
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #00aaff;
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .social-icons a {
            font-size: 24px;
            color: #fff;
            transition: transform 0.3s, color 0.3s;
        }

        .social-icons a:hover {
            transform: scale(1.2);
            color: #00aaff;
        }

        .footer-bottom {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
            border-top: 1px solid #333;
            padding-top: 15px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                align-items: center;
                gap: 30px;
                padding: 0 10px;
            }

            .footer-section {
                text-align: center;
            }

            .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h4>Contact Us</h4>
            <p><strong>Address:</strong> Peti Surat 16536, 88700 Kota Kinabalu, Sabah, Malaysia</p>
            <p><strong>Email:</strong> <a href="mailto:pmdkk2015@gmail.com">pmdkk2015@gmail.com</a></p>
            <p><strong>Phone:</strong> <a href="tel:088794327">088-794 327</a></p>
        </div>
        <div class="footer-section">
            <h4>Follow Us</h4>
            <div class="social-icons">
                <a href="https://www.facebook.com/profile.php?id=100063573754394" aria-label="Facebook">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/pmdkk_sabaharchery" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Kota Kinabalu Archery Association. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
