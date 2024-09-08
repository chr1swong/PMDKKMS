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
        }

        /* Container for the entire nav section */
        .container {
            display: flex;
            justify-content: space-between; /* Space between logo/nav links and login button */
            align-items: center;
            width: auto;
            margin: 0;
            padding: 10px 10px; /* Smaller padding for a smaller header */
        }

        /* Navigation container for logo and links */
        .nav-container {
            display: flex;
            align-items: center;
        }

        /* Style for the logo */
        .logo-container {
            flex-shrink: 0; /* Prevents the logo from shrinking */
        }

        .headerLogo {
            height: 80px; /* Adjust the height to make the header smaller */
            width: auto; /* Maintains aspect ratio */
            margin-right: 30px; /* Adds space between logo and nav links */
        }

        /* Navigation links */
        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-links li {
            margin-left: 0px; /* Space between links */
        }

        .nav-links li a {
            color: white; /* Set the link color */
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
            font-size: 20px; /* Increase the font size */
        }

        .nav-links li a:hover, .nav-links li a.active {
            background-color: #0056b3; /* Change background color on hover and active */
        }

        .header-login-button {
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s;
            font-size: 20px;
            align-items: center; /* Aligns icon and text */
        }

        /* Login Button Styles */
        .login-container {
            margin-left: auto; /* Pushes the login button to the right */
        }

        .login-button {
            color: white;
            background-color: #072AC8;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s;
            align-items: center; /* Aligns icon and text */
        }

        .login-button i {
            margin-right: 8px; /* Space between icon and text */
            font-size: 16px; /* Adjust icon size if needed */
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
                        <a href="/archer/dashboard" class="{{ request()->is('archer.dashboard') ? 'active' : '' }}">Home</a>
                    </li>
                    <li>
                        <a href="/about" class="{{ request()->is('about') ? 'active' : '' }}">Events</a>
                    </li>
                    <li>
                        <a href="/member" class="{{ request()->is('member') ? 'active' : '' }}">Performance</a>
                    </li>
                    <li>
                        <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">Profile</a>
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
