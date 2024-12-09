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
            background-color: #f4f4f4;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Header Styles */
        header {
            background-color: #0b1647;
            padding: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative; /* Added relative positioning for the header */
        }

        /* Container for the entire nav section */
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 10px;
        }

        /* Navigation container for logo and links */
        .nav-container {
            display: flex;
            align-items: center;
        }

        /* Style for the logo */
        .logo-container {
            flex-shrink: 0;
        }

        .headerLogo {
            height: 80px;
            width: auto;
            margin-right: 30px;
        }

        /* Navigation links */
        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-links li {
            margin-left: 20px;
        }

        .nav-links li a {
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
            font-size: 20px;
        }

        .nav-links li a:hover {
            background-color: #0056b3;
        }

        .header-login-button {
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s;
            font-size: 20px;
            align-items: center;
        }

        /* Login Button Styles */
        .login-container {
            margin-left: auto;
        }

        .login-button {
            color: white;
            background-color: #072AC8;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s;
            align-items: center;
        }

        .login-button i {
            margin-right: 8px;
            font-size: 16px;
        }

        .login-button:hover {
            background-color: #003f7f;
        }

        /* Hamburger Menu Styles */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .hamburger div {
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 5px;
            transition: all 0.3s ease;
        }

        /* Mobile Menu Styles */
        .nav-links-mobile {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 100%; /* Adjusted to appear directly below header */
            left: 0;
            width: 100%;
            background-color: #0b1647;
            z-index: 999;
            padding: 15px 0;
            margin: 0; /* Removed unnecessary margin */
            border-bottom: 1px solid #0056b3;
            animation: slideDown 0.3s ease-in-out;
        }

        .nav-links-mobile li {
            margin: 0;
            padding: 12px 0;
        }

        .nav-links-mobile li a {
            font-size: 18px;
            display: block;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .nav-links-mobile li a:hover {
            background-color: #0056b3;
            border-radius: 4px;
        }

        /* Smooth slide-down animation */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Show the menu when the class is toggled */
        .show-menu {
            display: flex;
        }

        /* Responsive Media Query */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .login-container {
                margin-right: 10px;
            }
        }

        @media (max-width: 480px) {
            .headerLogo {
                height: 60px;
            }

            .header-login-button {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <div class="nav-container">
                <a href="/" class="logo-container">
                    <img src="{{ asset('images/pmdkkLogo.png') }}" alt="Logo" class="headerLogo">
                </a>
                <!-- Hamburger Icon for Mobile -->
                <div class="hamburger" onclick="toggleMenu()">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <!-- Navigation Links for Desktop -->
                <ul class="nav-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/member">Membership Info</a></li>
                </ul>
                <!-- Navigation Links for Mobile -->
                <ul class="nav-links-mobile" id="mobile-menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/member">Membership Info</a></li>
                </ul>
            </div>

            <div class="login-container">
                @auth
                    <a href="{{ route('account.logout') }}" class="header-login-button"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('account.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="header-login-button">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <script>
        // Toggle mobile menu
        function toggleMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            // Toggle between show-menu class and hidden
            if (mobileMenu.classList.contains('show-menu')) {
                mobileMenu.style.display = 'none'; // Hide
                mobileMenu.classList.remove('show-menu');
            } else {
                mobileMenu.style.display = 'flex'; // Show
                mobileMenu.classList.add('show-menu');
            }
        }

        // Automatically close the mobile menu when the window is resized above 768px
        window.addEventListener('resize', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (window.innerWidth > 768) {
                mobileMenu.style.display = 'none'; // Ensure the menu is hidden
                mobileMenu.classList.remove('show-menu'); // Remove the show-menu class
            }
        });
    </script>
</body>
</html>
