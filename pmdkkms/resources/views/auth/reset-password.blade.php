<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - PMDKK</title>
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
            color: #000;
            margin-bottom: 2rem;
        }

        .left-panel img {
            max-width: 100%;
            height: auto;
            margin-top: 2rem;
            border-radius: 8px;
        }

        .right-panel {
            width: 60%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .block label {
            font-weight: bold;
            margin-top: 1rem;
            display: block;
        }

        .block input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 0.5rem;
            box-sizing: border-box;
        }

        .reset-button {
            width: 100%;
            padding: 1rem;
            background-color: #5f4bb6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 1.5rem;
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
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }

        .link:hover {
            text-decoration: underline;
        }

        .text-red-600 {
            color: #e3342f;
        }

        .text-green-600 {
            color: #38c172;
        }

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
                <h2>Reset Password</h2>
                <img src="{{ asset('images/reset_password_illustration.png') }}" alt="Reset Password Illustration">
            </div>

            <!-- Right Panel -->
            <div class="right-panel">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Fill in the details below to reset your password.') }}
                </div>

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

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="block">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="account_email_address" value="{{ old('account_email_address') }}" required autofocus />
                    </div>

                    <div class="block">
                        <label for="new-password">{{ __('New Password') }}</label>
                        <input id="new-password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="new_account_password" required />
                    </div>

                    <div class="block">
                        <label for="new-password-confirmation">{{ __('Confirm New Password') }}</label>
                        <input id="new-password-confirmation" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="new_account_password_confirmation" required />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="reset-button">
                            {{ __('Reset Password') }}
                        </button>
                    </div>

                    <div class="mt-4 text-center">
                        <span class="text-sm text-gray-600">Remembered your password? <a href="{{ route('login') }}" class="link">Log in</a></span>
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
