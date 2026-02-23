<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LG-BackOffice</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/hola.js'])
</head>

<body class="h-screen w-screen flex items-center justify-center bg-gray-900 bg-no-repeat bg-center"
    style="background-image:url('{{ asset('assets/images/hijabbg.png') }}'); background-size: cover; background-position: center;">
    {{-- <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('images/hijab_background.jpg') }}');"></div> --}}

    @auth
        <!-- If the user is authenticated -->
        <div class="text-center text-white">
            <h1 class="text-4xl font-bold mb-4">Welcome back, {{ Auth::user()->name }}! 🎉</h1>
            <p class="text-gray-300 mb-6">You are successfully logged in. Explore your dashboard or continue working.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('dashboard') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg">
                    Go to Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    @else
        <!-- If the user is NOT authenticated (Show Login Form) -->
        <div class="h-screen w-screen flex items-center justify-center">
            <div class="rounded-xl bg-white bg-opacity-90 backdrop-blur-sm px-10 py-6 shadow-xl max-sm:px-6 w-full max-w-sm -mt-16">
                <div>
                    <div class="mb-6 flex flex-col items-center">
                        <img src="{{ asset('assets/images/hijabilogo.png') }}" width="120"
                            alt="Hijab Store Logo" />
                        <h2 class="mt-1 text-xl font-semibold text-amber-800" style="font-family: 'Dancing Script', cursive;">Hijab store islamic</h2>
                        <span class="mt-1 text-xs text-gray-600">Enter Login Details</span>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-gray-700 text-sm" />
                            <x-text-input id="email"
                                class="block mt-1 w-full rounded-lg border-gray-300 bg-amber-50 text-gray-800 placeholder-amber-200 focus:border-amber-500 focus:ring-amber-500 text-sm py-2"
                                type="email" name="email" :value="old('email')" required autofocus
                                autocomplete="username" placeholder="Email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
                        </div>

                        <!-- Password -->
                        <div class="mt-3">
                            <x-input-label for="password" :value="__('Password')" class="text-gray-700 text-sm" />
                            <x-text-input id="password"
                                class="block mt-1 w-full rounded-lg border-gray-300 bg-amber-50 text-gray-800 placeholder-amber-200 focus:border-amber-500 focus:ring-amber-500 text-sm py-2"
                                type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-3">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 bg-amber-50 text-amber-600 shadow-sm focus:ring-amber-500"
                                    name="remember">
                                <span class="ms-2 text-xs text-gray-700">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            @if (Route::has('password.request'))
                                <a class="underline text-xs text-amber-700 hover:text-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button
                                class="ms-3 bg-amber-700 hover:bg-amber-800 focus:ring-amber-500 text-white font-semibold py-2 px-5 rounded-lg uppercase text-sm">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth

</body>
