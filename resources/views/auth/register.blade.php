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
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/hola.js'])
</head>    <!-- Full-Screen Background -->
    <div class="h-screen w-screen flex items-center justify-center bg-gray-900 bg-cover bg-no-repeat" 
        style="background-image:url('https://images.unsplash.com/photo-1499123785106-343e69e68db1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlbnR8fGVufDB8fHx8&auto=format&fit=crop&w=1748&q=80')">
        <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
            <div class="text-white">
                <div class="mb-8 flex flex-col items-center">
                    <img src="https://www.logo.wine/a/logo/Instagram/Instagram-Glyph-Color-Logo.wine.svg" width="150" alt="Instagram Logo" />
                    <h1 class="mb-2 text-2xl font-semibold">Instagram</h1>
                    <span class="text-gray-300">Create Your Account</span>
                </div>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-gray-300" />
                        <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500" 
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                    </div>
                    
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                        <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500" 
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                    </div>
                    
                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500" 
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-300" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500" 
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <a class="underline text-sm text-gray-400 hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                            href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                        
                        <x-primary-button class="ms-4 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
