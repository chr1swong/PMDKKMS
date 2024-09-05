
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
        min-height: calc(80vh); /* Adjusted height minus header height */
        background-color: #f4f4f4;
    }

    /* Custom styles for the page */
    .authentication-card {
        width: 100%;
        max-width: 1200px !important; /* Adjusted max width to fit content */
        min-height: 600px; /* Added min-height to increase vertical size */
        margin: auto;
        padding: 0;
        background-color: #ffffff;
        border-radius: 8px;
        display: flex;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .left-panel {
        background-color: #e7f0fa;
        padding: 3rem; /* Increased padding to make the panel larger */
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
        font-size: 3.5rem; /* Adjust font size */
        font-weight: bold;
        color: #333;
        margin-bottom: 2rem;
        position: absolute;
        top: 20px;
        left: 20px;
    }

    .left-panel img {
        max-width: 80%;
        height: auto;
        margin-bottom: 2rem;
        position: absolute;
        bottom: 20px;
        left: 20px;
    }

    .right-panel {
        width: 60%;
        padding: 6rem; /* Increased padding to make the panel larger */
    }

    .block {
        margin-bottom: 1.5rem; /* Increased margin to add more spacing */
    }

    .block input {
        padding: 0.75rem;
        border-radius: 4px;
        width: 100%;
        margin-bottom: 1rem;
    }

    .reset-button {
        width: 100%;
        padding: 0.75rem;
        background-color: #5f4bb6;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .login-button:hover {
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
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Forgot Password</h2>
                <img src="{{ asset('images/forgotPasswordLogo.png') }}" alt="Forgot Password Illustration">
            </div>

            <!-- Right Panel -->
            <div class="right-panel">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

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

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="block">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <input id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="reset-button">
                            {{ __('Reset Password') }}
                        </button>
                    </div>

                    <div class="mt-4 text-center">
                        <span class="text-sm text-gray-600">Already a member? <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-800 link">Log in</a></span>
                    </div>

                    <div class="mt-2 text-center">
                        <span class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-800 link">Register Now</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

