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
        }

        /* Container for the entire nav section */
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: auto;
            margin: 0;
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

        /* Hover Effects for Attendance and Performance */
        .dropdown-menu a[href="/committee/member/attendance"]:hover {
            background-color: #1a73e8;
        }

        .dropdown-menu a[href="/committee/member/performance"]:hover {
            background-color: #34a853;
        }

        /* Dropdown menu opens when hovering over the link or icon */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Dropdown arrow styling */
        .dropdown > a i {
            margin-left: 2px;
            color: white; /* Make the arrow white */
            transition: transform 0.3s ease;
        }

        /* Rotate the dropdown icon on hover */
        .dropdown:hover > a i {
            transform: rotate(180deg);
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
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <div class="nav-container">
                <a href="/" class="logo-container">
                    <img src="{{ asset('images/pmdkkLogo.png') }}" alt="Logo" class="headerLogo">
                </a>
                <ul class="nav-links">
                    <li>
                        <a href="/committee/dashboard" class="{{ request()->is('coach.dashboard') ? 'active' : '' }}">Home</a>
                    </li>
                    <li>
                        <a href="/committee/events" class="{{ request()->is('committee.events') ? 'active' : '' }}">Events</a>
                    </li>
                    <!-- Members Dropdown with Icon -->
                    <li class="dropdown">
                        <a href="/committee/member" class="{{ request()->is('member.events') ? 'active' : '' }}">
                            Members
                            <i class="fas fa-chevron-down"></i> <!-- Dropdown arrow icon -->
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/committee/attendance">Attendance</a>
                            </li>
                            <li>
                                <a href="/committee/performance">Performance</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="/committee/profile" class="{{ request()->is('committee.profile') ? 'active' : '' }}">Profile</a>
                    </li>
                </ul>
            </div>

            <div class="login-container">
                @auth
                    <a href="{{ route('account.logout') }}" class="header-login-button"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('account.logout') }}" method="GET" style="display: none;">
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
</body>
</html>
