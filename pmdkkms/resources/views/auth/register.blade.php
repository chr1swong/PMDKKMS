
    <header>
        @include('components.header')
    </header>

    <!-- Inline CSS -->
    <style>
    /* Flexbox to center content vertically and horizontally */
    .flex-center {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(80vh);
        background-color: #f4f4f4;
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .left-panel {
        background-color: #e7f0fa;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        width: 40%;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        position: relative;
    }

    .left-panel h2 {
        font-size: 3.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 2rem;
        text-align:centre;
    }

    .left-panel img {
        max-width: 80%;
        height: auto;
    }

    .right-panel {
        width: 60%;
        padding: 5rem;
    }

    .block {
        margin-bottom: 1rem;
    }

    .block input {
        padding: 0.75rem;
        border-radius: 4px;
        width: 100%;
        margin-bottom: 1rem;
    }

    .radio-group {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .radio-group label {
        display: flex;
        align-items: center;
        margin-right: 1rem;
        font-weight: bold;
    }

    .radio-group input[type="radio"] {
        margin-right: 0.5rem;
    }

    .register-button {
        width: 100%;
        padding: 0.75rem;
        background-color: #5f4bb6;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .register-button:hover {
        background-color: #483a99;
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
    }

    .link:hover {
        text-decoration: underline;
    }
    </style>

    <div class="flex-center">
        <div class="authentication-card">
            <!-- Left Panel -->
            <div class="left-panel">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Sign Up</h2>
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
                        <span class="text-sm text-gray-600">Already a member? <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-800 link">Log in</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

