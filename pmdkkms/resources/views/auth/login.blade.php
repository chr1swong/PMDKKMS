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

        /* Flexbox to center content vertically and horizontally */
        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(85vh); /* Adjusted height minus header height */
            background-color: #f4f4f4;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Custom styles for the login page */
        .authentication-card {
            width: 100%;
            max-width: 1200px; /* Adjusted max width to fit content */
            margin: auto;
            padding: 0;
            background-color: #ffffff;
            border-radius: 10px;
            display: flex;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .left-panel {
            background: linear-gradient(135deg, #6EC1E4 0%, #1F69C3 100%);
            color: #fff;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            width: 40%;
            position: relative;
        }

        .left-panel h2 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            position: absolute;
            top: 20px;
            left: 20px;
            color: black; /* Change text color to black */
        }

        .left-panel img {
            max-width: 80%;
            height: auto;
            margin-bottom: 2rem;
            position: absolute;
            bottom: 20px;
            left: 20px;
            transition: transform 0.3s ease;
        }

        .left-panel img:hover {
            transform: scale(1.05);
        }

        .right-panel {
            width: 60%;
            padding: 4rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
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

        .block {
            margin-bottom: 1.5rem;
        }

        /* Make labels bold */
        .block label {
            font-weight: bold;
        }

        .block input {
            padding: 0.75rem;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 0.5rem;
            border: 1px solid #ccc;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .block input:focus {
            border-color: #5f4bb6;
            box-shadow: 0 0 8px rgba(95, 75, 182, 0.2);
            outline: none;
        }

        .remember-me-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 2rem;
        }

        .form-checkbox {
            width: 20px;
            height: 20px;
            margin-right: 0.5rem;
            appearance: none;
            background-color: #fff;
            border: 2px solid #718096;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
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
        }

        label[for="remember_me"] {
            display: flex;
            align-items: center;
            margin-right: auto;
            cursor: pointer;
        }

        /* Make the login button taller */
        .login-button {
            width: 100%;
            padding: 1.5rem 0.75rem; /* Increased vertical padding for a taller button */
            color: black;
            border: none;
            border-radius: 4px;
            background: linear-gradient(135deg, #5f4bb6 0%, #483a99 100%);
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
            margin-bottom: 1rem;
            font-size: 1.1rem; /* Slightly larger font size */
        }

        .login-button:hover {
            background: linear-gradient(135deg, #483a99 0%, #5f4bb6 100%);
            box-shadow: 0 6px 18px rgba(95, 75, 182, 0.3);
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-center {
            text-align: center;
        }

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
            color: #5f4bb6;
            font-weight: bold;
            transition: color 0.3s;
        }

        .text-center .link:hover {
            color: #483a99;
        }

    </style>
</head>
<body>
    <header>
        @include('components.header')
    </header>

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

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="block">
                        <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                        <input id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="block">
                        <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                        <input id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="remember-me-container">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('forgot-password'))
                            <a class="text-sm text-red-600 hover:text-red-500 link" href="{{ route('forgot-password') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="login-button">
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
</body>
</html>
