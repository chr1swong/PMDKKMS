
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

    /* Custom styles for the login page */
    .authentication-card {
        width: 100%;
        max-width: 1200px !important; /* Adjusted max width to fit content */
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
        padding: 6rem;
        
    }

    .right-panel .text-center h2 {
        font-size: 2rem; /* Adjust font size */
        font-weight: bold;
        color: #5f4bb6;
        margin-bottom: 1rem;
    }

    .right-panel img {
        margin-bottom: 2rem;
    }

    .block {
        margin-bottom: 0.5rem !important;
    }

    .block input {
        padding: 0.75rem;
        border-radius: 4px;
        width: 100%;
        margin-bottom: 0.5rem;
    }

    /* Targeting and resizing the checkbox */
    .form-checkbox {
        width: 16px !important;  /* Fixed width */
        height: 16px !important; /* Fixed height */
        margin-right: 0.5rem;
        appearance: none;        /* Remove default styling */
        border: 2px solid #718096; /* Custom border color */
        border-radius: 3px;      /* Slightly rounded corners */
        vertical-align: middle;
    }   

    .form-checkbox:checked {
        background-color: #4c51bf; /* Checked background color */
        border-color: #4c51bf;      /* Checked border color */
    }

    /* Adjust text label alignment */
    label[for="remember_me"] {
        display: flex;
        align-items: center;
    }

    .login-button {
        width: 100%;
        padding: 0.75rem;
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
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Log in</h2>
                <img src="{{ asset('images/loginLogo.png') }}" alt="Login Illustration">
            </div>

            <!-- Right Panel -->
    <div class="right-panel">
        <div class="flex items-center mb-6">
            <h2 class="text-2xl font-bold text-purple-700 mr-4">Welcome to PMDKK!</h2>
            <img src="{{ asset('images/pmdkkLogo.png') }}" alt="Logo" class="w-20 h-20">
    </div>

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

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="block">
            <x-label for="email" value="{{ __('Email') }}" />
            <input id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        </div>

        <div class="block">
            <x-label for="password" value="{{ __('Password') }}" />
            <input id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
        </div>

        <div class="block flex items-center justify-between">
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-red-600 hover:text-red-500 link" href="{{ route('password.request') }}">
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
            <span class="text-sm text-gray-600">Not a member? <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-800 link">Register Now</a></span>
        </div>
    </form>
</div>

        </div>
    </div>

