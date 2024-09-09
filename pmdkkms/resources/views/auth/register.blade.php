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
        min-height: calc(90vh);
        background-color: #f4f4f4;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Slide-in effect for the left panel */
    @keyframes slideInLeft {
        from { transform: translateX(-100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Custom styles for the register page */
    .authentication-card {
        width: 100%;
        max-width: 1200px;
        margin: auto;
        background-color: #ffffff;
        border-radius: 8px;
        display: flex;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        min-height: 700px;
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
        animation: slideInLeft 0.8s ease-out;
    }

    .left-panel h2 {
        font-size: 3.5rem;
        font-weight: bold;
        margin-bottom: 2rem;
        color: black;
    }

    .left-panel img {
        max-width: 100%;
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
        justify-content: flex-start;
        gap: 6rem;
        margin-bottom: 1.5rem;
    }

    .radio-group label {
        display: flex;
        align-items: center;
        font-weight: bold;
        cursor: pointer;
    }

    .radio-group input[type="radio"] {
        margin-right: 0.25rem;
        width: 18px;
        height: 18px;
        appearance: none;
        border: 2px solid #718096;
        border-radius: 50%;
        background-color: #fff;
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
        position: relative;
    }

    .register-button:disabled {
        background-color: #999;
        cursor: not-allowed;
    }

    .register-button.loading::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 20px;
        width: 20px;
        height: 20px;
        border: 3px solid #fff;
        border-top: 3px solid #5f4bb6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .text-center {
        text-align: center;
        padding-top: 1rem;
    }

    .link {
        color: black;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .link:hover {
        color: #ff3b30;
        text-decoration: underline;
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
            <div>
                <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form method="POST" action="{{ route('account.register') }}" onsubmit="handleSubmit(event)">
                @csrf

                <div class="radio-group">
                    <label>
                        <input type="radio" name="account_role" value="1" required>
                        Archer
                    </label>
                    <label>
                        <input type="radio" name="account_role" value="2" required>
                        Coach
                    </label>
                    <label>
                        <input type="radio" name="account_role" value="3" required>
                        Committee Member
                    </label>
                </div>

                <div class="block">
                    <label for="full_name" class="block font-medium text-sm text-gray-700">Name</label>
                    <input id="full_name" type="text" name="account_full_name" :value="old('name')" required autofocus />
                </div>

                <div class="block">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" type="email" name="account_email_address" :value="old('email')" required />
                </div>

                <div class="block">
                    <label for="contact_number" class="block font-medium text-sm text-gray-700">Contact Number</label>
                    <input id="contact_number" type="text" name="account_contact_number" :value="old('contact_number')" required />
                </div>

                <div class="block">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                    <input id="password" type="password" name="account_password" required autocomplete="new-password" />
                </div>

                <div class="block">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="account_password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="mt-6">
                    <button type="submit" class="register-button" id="register-button">
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

<script>
    function handleSubmit(event) {
        const button = document.getElementById('register-button');
        button.classList.add('loading');
        button.disabled = true;
    }
</script>
</html>
