<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PMDKK</title>
    <!-- Add your external CSS and JS files here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- Inline CSS -->
<style>
    /* Flexbox to center content vertically and horizontally */
    .flex-center {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(90vh); /* Increased height */
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

    /* Slide-in effect for the left panel */
    @keyframes slideInLeft {
        from {
            transform: translateX(-100%); /* Slide in from the left */
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Custom styles for the register page */
    .authentication-card {
        width: 100%;
        max-width: 1200px;
        margin: auto;
        padding: 0;
        background-color: #ffffff;
        border-radius: 8px;
        display: flex;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        min-height: 700px; /* Increased height */
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
        animation: slideInLeft 0.8s ease-out; /* Applying the slide-in effect */
    }

    .left-panel h2 {
        font-size: 3.5rem;
        font-weight: bold;
        margin-bottom: 2rem;
        color: black;
    }

    .left-panel img {
        max-width: 80%;
        height: auto;
        margin-bottom: 2rem;
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

    /* Radio buttons */
    .radio-group {
        display: flex;
        justify-content: flex-start; /* Align radio buttons to the left */
        gap: 6rem; /* Space between radio buttons */
        margin-bottom: 1.5rem;
    }

    .radio-group label {
        display: flex;
        align-items: center;
        font-weight: bold;
        cursor: pointer;
    }

    .radio-group input[type="radio"] {
        margin-right: 0.25rem; /* Reduced spacing for closer radios */
        width: 18px;
        height: 18px;
        appearance: none;
        border: 2px solid #718096;
        border-radius: 50%;
        background-color: #fff;
        display: inline-block;
        position: relative;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .radio-group input[type="radio"]:checked {
        background-color: #5f4bb6;
        border-color: #5f4bb6;
    }

    .radio-group input[type="radio"]::before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: white;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .radio-group input[type="radio"]:checked::before {
        background-color: white;
    }

    /* Register button */
    .register-button {
        width: 100%;
        padding: 1rem 0.75rem;
        background-color: #5f4bb6;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
        font-size: 1.1rem;
    }

    .register-button:hover {
        background-color: #483a99;
        box-shadow: 0 6px 18px rgba(95, 75, 182, 0.3);
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .text-center {
        text-align: center;
        padding-top: 1rem; /* Added padding-top */
    }

    .link {
        color: black; /* Changed to black */
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .link:hover {
        color: #ff3b30;
        text-decoration: underline;
    }

    .text-center .link {
        color: black; /* Changed to black */
        font-weight: bold;
        transition: color 0.3s;
    }

    .text-center .link:hover {
        color: #483a99;
    }
</style>
</head>

<header>
    @include('components.header')
</header>
<div class="flex-center">
    <div class="authentication-card">
        <!-- Left Panel -->
        <div class="left-panel">
            <h2 class="text-3xl font-bold">Sign Up</h2>
            <img src="{{ asset('images/signUpIllustration.png') }}" alt="Sign Up Illustration">
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            @if ($errors->any())
                <div {{ $attributes }}>
                    <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="radio-group">
                    <label>
                        <input type="radio" name="role" value="1" required>
                        Archer
                    </label>
                    <label>
                        <input type="radio" name="role" value="2" required>
                        Coach
                    </label>
                    <label>
                        <input type="radio" name="role" value="3" required>
                        Committee Member
                    </label>
                </div>

                <div class="block">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <input id="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="name" :value="old('name')" required autofocus />
                </div>

                <div class="block">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <input id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required />
                </div>

                <div class="block">
                    <x-label for="contact_number" value="{{ __('Contact Number') }}" />
                    <input id="contact_number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="contact_number" :value="old('contact_number')" required />
                </div>

                <div class="block">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <input id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="block">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <input id="password_confirmation" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="mt-6">
                    <button type="submit" class="register-button">
                        {{ __('Register') }}
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <span class="text-sm text-gray-600">Already a member? <a href="{{ route('login') }}" class="link">Log in</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
