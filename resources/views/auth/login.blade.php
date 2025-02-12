<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LG-BackOffice</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/hola.js'])
</head>

<body class="h-screen w-screen flex items-center justify-center bg-gray-900 bg-cover bg-no-repeat"
    style="background-image:url('https://source.unsplash.com/1920x1080/?technology,nature')">
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
        <div class="h-screen w-screen flex items-center justify-center bg-gray-900 bg-cover bg-no-repeat"
            style="background-image:url('https://as1.ftcdn.net/v2/jpg/03/15/67/18/1000_F_315671889_obi7zBaYWHwzDRkHP4Tg92QTeSg0sLVW.jpg')">
            <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
                <div class="text-white">
                    <div class="mb-8 flex flex-col items-center">
                        <img src="https://www.logo.wine/a/logo/Instagram/Instagram-Glyph-Color-Logo.wine.svg" width="150"
                            alt="Instagram Logo" />
                        <h1 class="mb-2 text-2xl font-semibold">Instagram</h1>
                        <span class="text-gray-300">Enter Login Details</span>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                            <x-text-input id="email"
                                class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500"
                                type="email" name="email" :value="old('email')" required autofocus
                                autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                            <x-text-input id="password"
                                class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500"
                                type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-600 bg-gray-700 text-indigo-500 shadow-sm focus:ring-indigo-500"
                                    name="remember">
                                <span class="ms-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-400 hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button
                                class="ms-3 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth

</body>
