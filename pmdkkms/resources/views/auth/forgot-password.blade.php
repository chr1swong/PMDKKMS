<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - PMDKK</title>
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
            min-height: calc(100vh - 100px);
            background-color: #f4f4f4;
        }

        .authentication-card {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            padding: 0;
            background-color: #ffffff;
            border-radius: 12px;
            display: flex;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        /* Left Panel Styling */
        .left-panel {
            background-color: #6EC1E4;
            color: #fff;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            width: 40%;
            position: relative;
            text-align: left;
        }

        .left-panel h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 2rem;
        }

        .left-panel img {
            max-width: 100%;
            height: auto;
            margin-top: 2rem;
            border-radius: 8px;
        }

        /* Right Panel Styling */
        .right-panel {
            width: 60%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .block label {
            font-weight: bold; /* Make the label bold */
            margin-top: 1rem;  /* Add margin-top for spacing */
            display: block;    /* Ensure the label takes up full width */
        }

        .block input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 1rem;
            box-sizing: border-box; /* Ensure padding and borders are included in the element's total width */
        }

        .reset-button {
            width: 100%; /* Full width for button */
            padding: 1rem;
            background-color: #5f4bb6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .reset-button:hover {
            background-color: #483a99;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-center {
            text-align: center;
        }

        .link {
            color: #000; /* Set the color to black */
            text-decoration: none;
            font-weight: bold;
        }

        .link:hover {
            text-decoration: underline;
        }

        /* Error Messages */
        .text-red-600 {
            color: #e3342f;
        }

        .text-green-600 {
            color: #38c172;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .authentication-card {
                flex-direction: column;
            }

            .left-panel, .right-panel {
                width: 100%;
                padding: 2rem;
            }

            .left-panel img {
                margin-top: 1rem;
                margin-bottom: 1rem;
            }

            .left-panel h2 {
                font-size: 2rem;
            }
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
                <h2>Forgot Password</h2>
                <img src="{{ asset('images/forgotPasswordLogo.png') }}" alt="Forgot Password Illustration">
            </div>

            <!-- Right Panel -->
            <div class="right-panel">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address, and we will email you a password reset link.') }}
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="block">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="reset-button">
                            {{ __('Reset Password') }}
                        </button>
                    </div>

                    <div class="mt-4 text-center">
                        <span class="text-sm text-gray-600">Already a member? <a href="{{ route('login') }}" class="link">Log in</a></span>
                    </div>

                    <div class="mt-2 text-center">
                        <span class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="link">Register Now</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
