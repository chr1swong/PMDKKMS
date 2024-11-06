<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archery Association</title>
    <!-- Font Awesome for dropdown arrow icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
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
            position: relative;
            margin-bottom: 0; /* Ensure header margin matches the coachHeader */
        }

        /* Container for the entire nav section */
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin: 0;
            padding: 10px; /* Updated padding to match the coachHeader */
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
            margin-left: 0px;
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

        .nav-links li a:hover, .nav-links li a.active {
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

        /* Dropdown Menu Styles */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #0056b3;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 0;
            z-index: 100;
            list-style: none;
        }

        .dropdown-menu li {
            border-bottom: 1px solid #ffffff;
        }

        .dropdown-menu li:last-child {
            border-bottom: none;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            text-transform: none;
            font-size: 16px;
            color: white;
            transition: background-color 0.3s;
        }

        /* Hover Effects for Attendance and Scoring */
        .dropdown-menu a:hover {
            background-color: #1a73e8;
        }

        /* Dropdown opens on hover */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Dropdown arrow styling */
        .dropdown > a i {
            margin-left: 2px;
            color: white;
            transition: transform 0.3s ease;
        }

        /* Rotate the dropdown icon on hover */
        .dropdown:hover > a i {
            transform: rotate(180deg);
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
            top: 100%; /* Align just below the header */
            left: 0;
            width: 100%;
            background-color: #0b1647;
            z-index: 999;
            padding: 0;
            margin: 0;
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

        /* Responsive Styles */
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

        /* Slide down animation */
        .show-menu {
            display: flex;
            animation: slideDown 0.3s ease-in-out;
        }

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
                    <li><a href="/archer/dashboard" class="{{ request()->is('archer.dashboard') ? 'active' : '' }}">Home</a></li>
                    <li><a href="/archer/events" class="{{ request()->is('archer.events') ? 'active' : '' }}">Events</a></li>
                    <!-- Dropdown with Icon -->
                    <li class="dropdown">
                        <a href="/archer/attendance" class="{{ request()->is('archer.attendance') ? 'active' : '' }}">
                            Attendance <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/archer/scoring">Scoring</a></li>
                            <li><a href="{{ route('archer.performanceAnalytics') }}">Analytics</a></li>
                            <li><a href="{{ route('archer.paymentHistory') }}">Transactions</a></li>
                        </ul>
                    </li>
                    <li><a href="/archer/profile" class="{{ request()->is('archer.profile') ? 'active' : '' }}">Profile</a></li>
                </ul>
                <!-- Navigation Links for Mobile -->
                <ul class="nav-links-mobile" id="mobile-menu">
                    <li><a href="/archer/dashboard">Home</a></li>
                    <li><a href="/archer/events">Events</a></li>
                    <li><a href="/archer/attendance">Attendance</a></li>
                    <li><a href="/archer/scoring">Scoring</a></li>
                    <li><a href="{{ route('archer.paymentHistory') }}">Transactions</a></li>
                    <li><a href="/archer/profile">Profile</a></li>
                </ul>
            </div>

            <div class="login-container">
                @auth
                    <a href="{{ route('account.logout') }}" class="header-login-button"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('account.logout') }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="header-login-button">
                        <i class="fas fa-sign-in-alt"></i> Login
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
