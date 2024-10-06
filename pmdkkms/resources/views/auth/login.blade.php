<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PMDKK</title>
    <!-- Add your external CSS and JS files here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Main content wrapper (for background blur) */
        .main-content {
            transition: filter 0.3s ease;
        }

        /* Flexbox to center content vertically and horizontally */
        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(70vh); /* Shorter height */
            background-color: #f4f4f4;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Authentication card (adjust height) */
        .authentication-card {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            display: flex;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            min-height: 450px; /* Shorter minimum height */
        }

        /* Left panel design */
        .left-panel {
            background: linear-gradient(135deg, #6EC1E4 0%, #1F69C3 100%);
            color: #fff;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 40%;
            min-height: 100%; /* Adjust this for panel height */
        }

        .left-panel h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            color: black;
        }

        /* Ensure image is visible */
        .left-panel img {
            max-width: 60%; /* Adjust image size */
            height: auto;
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }

        .left-panel img:hover {
            transform: scale(1.05);
        }

        /* Right panel design */
        .right-panel {
            width: 60%;
            padding: 4rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }

        .text-center {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-bottom: 30px;
            gap: 1rem;
        }

        .text-center h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0;
            color: #333;
        }

        .text-center h2 span {
            color: #5f4bb6;
        }

        .right-panel img {
            max-width: 15%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .right-panel img:hover {
            transform: rotate(5deg);
        }

        /* Input block */
        .block {
            margin-bottom: 0.5rem;
        }

        .block label {
            font-weight: bold;
        }

        .block input {
            padding: 0.75rem;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-sizing: border-box;
        }

        .block input:focus {
            border-color: #5f4bb6;
            box-shadow: 0 0 8px rgba(95, 75, 182, 0.2);
            outline: none;
        }

        /* Remember me checkbox */
        .remember-me-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            width: 100%;
            margin-bottom: 1.5rem;
        }

        .form-checkbox {
            width: 20px;
            height: 20px;
            margin-right: 0.5rem;
            vertical-align: middle;
            appearance: none;
            background-color: #fff;
            border: 2px solid #718096;
            border-radius: 4px;
            position: relative;
            transition: background-color 0.3s, border-color 0.3s;
            cursor: pointer;
        }

        .form-checkbox:checked {
            background-color: #5f4bb6;
            border-color: #5f4bb6;
        }

        .form-checkbox:checked::after {
            content: '✓';
            color: #fff;
            font-size: 14px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Login button */
        .login-button {
            width: 100%;
            padding: 1.5rem 0.75rem;
            color: black;
            border: none;
            border-radius: 4px;
            background: linear-gradient(135deg, #5f4bb6 0%, #483a99 100%);
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .login-button:hover {
            background: linear-gradient(135deg, #483a99 0%, #5f4bb6 100%);
            box-shadow: 0 6px 18px rgba(95, 75, 182, 0.3);
        }

        .text-sm {
            font-size: 0.875rem;
        }

        /* Links styling */
        .link {
            color: #ff5f56;
            text-decoration: none;
            font-weight: bold;
            margin-left: auto;
            transition: color 0.3s;
        }

        .link:hover {
            color: #ff3b30;
            text-decoration: underline;
        }

        .text-center .link {
            color: #000000;
            font-weight: bold;
            transition: color 0.3s;
        }

        .text-center .link:hover {
            color: #483a99;
        }

        /* Popup message styles */
        .popup-message {
            background-color: #007BFF;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
            color: white;
            text-align: center;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1001; /* Higher z-index than the blurred content */
            max-width: 90%;
            width: 400px;
            border: 2px solid #0056b3;
        }

        .popup-message h2 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
            color: white;
        }

        .popup-message p {
            font-size: 1rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .popup-message button {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            background-color: white;
            color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .popup-message button:hover {
            background-color: #e2e6ea;
        }

        /* Overlay to block interaction with blurred background */
        .blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1000; /* Just below the popup */
            display: none; /* Hidden by default */
        }

        /* Popup fade-in animation */
        @keyframes popupFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20%);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .authentication-card {
                flex-direction: column;
            }

            .left-panel, .right-panel {
                width: 100%;
            }

            .left-panel {
                padding: 2rem 1rem;
                text-align: center;
                align-items: center;
                min-height: 30vh; /* Smaller height on mobile */
                justify-content: center;
            }

            .left-panel h2 {
                font-size: 2rem;
            }

            .left-panel img {
                max-width: 50%; /* Adjust image size for smaller screens */
                position: relative; /* Ensure proper positioning */
                bottom: 0;
                left: 0;
                margin: 0 auto;
                display: block; /* Ensure it's visible */
            }

            .right-panel {
                padding: 2rem 1rem;
            }

            .right-panel img {
                max-width: 20%;
            }

            .popup-message {
                width: 90%;
                max-width: 90%;
            }
        }

        @media (max-width: 576px) {
            .authentication-card {
                padding: 1rem;
            }

            .left-panel h2 {
                font-size: 2rem;
            }

            .popup-message h2 {
                font-size: 1.5rem;
            }

            .popup-message p {
                font-size: 0.875rem;
            }

            .block input {
                font-size: 0.9rem;
            }

            .login-button {
                padding: 1rem 0.75rem;
                font-size: 1rem;
            }

            .left-panel img {
                max-width: 40%; /* Adjust image size for very small screens */
            }

            .right-panel img {
                max-width: 25%;
            }
        }

        /* Blur effect applied only to the main content */
        .main-content.blur-background {
            filter: blur(8px);
            transition: filter 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="main-content"> <!-- Main content wrapper -->
        <header>
            @include('components.header')
        </header>

        @if (!Auth::user()) 
            INTENDED! NOT LOGGED IN!
        @else 
            FORBIDDEN! LOGGED IN WITH ID {{ Auth::user()->account_id }} AND ROLE {{ Auth::user()->account_role }}
        @endif

        <div class="flex-center">
            <div class="authentication-card">
                <!-- Left Panel -->
                <div class="left-panel">
                    <h2 class="text-3xl font-bold">Log in</h2>
                    <img src="{{ asset('images/loginLogo.png') }}" alt="Login Illustration">
                </div>

                <!-- Right Panel -->
                <div class="right-panel">
                    <div class="text-center">
                        <h2>Welcome to <span>PMDKK!</span></h2>
                        <img src="{{ asset('images/pmdkkLogo.png') }}" alt="Logo">
                    </div>

                    <!-- Error messages -->
                    @if ($errors->any())
                        <div>
                            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Login form -->
                    <form method="POST" action="{{ route('login') }}" onsubmit="handleSubmit(event)">
                        @csrf

                        <div class="block">
                            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                            <input id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="account_email_address" :value="old('email')" required autofocus autocomplete="username" />
                        </div>

                        <div class="block">
                            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                            <input id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="account_password" required autocomplete="current-password" />
                        </div>

                        <div class="remember-me-container">
                            <label for="remember_me" class="flex items-center">
                                <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" name="account_remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('forgot-password'))
                                <a class="text-sm text-red-600 hover:text-red-500 link" href="{{ route('forgot-password') }}">
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="login-button" id="login-button">
                                {{ __('Login') }}
                            </button>
                        </div>

                        <div class="mt-4 text-center">
                            <span class="text-sm text-gray-600">Not a member? <a href="{{ route('register') }}" class="link">Register Now</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- End of main-content -->

    <!-- Overlay to block interaction with the blurred background -->
    <div class="blur-overlay" id="blurOverlay"></div>

    <!-- Popup for successful registration -->
    @if (session('success'))
        <div class="popup-message" id="popupMessage">
            <h2>Success!</h2>
            <p>{{ session('success') }}</p>
            <button id="closePopup">OK</button>
        </div>
    @endif

    <script>
        // Handle form submission
        function handleSubmit(event) {
            const button = document.getElementById('login-button');
            button.classList.add('loading');
            button.disabled = true;
        }

        // Handle popup message close and apply blur
        document.addEventListener('DOMContentLoaded', function () {
            const popupMessage = document.getElementById('popupMessage');
            const closePopup = document.getElementById('closePopup');
            const mainContent = document.querySelector('.main-content');
            const blurOverlay = document.getElementById('blurOverlay'); // Overlay element

            if (popupMessage) {
                // Show the popup and apply blur to the content
                popupMessage.style.display = 'block';
                mainContent.classList.add('blur-background');
                blurOverlay.style.display = 'block'; // Show overlay

                // Close the popup when the button is clicked
                closePopup.addEventListener('click', function () {
                    popupMessage.style.display = 'none';
                    mainContent.classList.remove('blur-background');
                    blurOverlay.style.display = 'none'; // Hide overlay
                });
            }
        });
    </script>
</body>
</html>
