@extends('layouts.app')

<main class="p-[4vw]">
    @yield('content')
</main>

<div class="relative min-h-screen flex flex-col justify-center items-center bg-pink-100 dark:bg-gray-900 text-gray-900 dark:text-white">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('images/hijab_background.jpg') }}');"></div>

    <div class="relative w-full max-w-3xl px-6 py-12 text-center">
        <h1 class="text-5xl font-extrabold tracking-tight text-pink-700 dark:text-pink-300">Welcome to Hijabi Store</h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
            Your destination for elegant and modest fashion. Explore our latest hijabs and accessories tailored for the modern woman.
        </p>

        <div class="flex justify-center space-x-4 mt-6">
            @auth
                <div>
                    <p class="text-lg text-gray-700 dark:text-gray-300">Hello, {{ Auth::user()->name }}! 💖</p>
                    <a href="{{ url('/dashboard') }}" class="px-5 py-3 bg-pink-600 text-white rounded-lg shadow-md hover:bg-pink-700 transition">
                        Go to Dashboard
                    </a>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-5 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-5 py-3 bg-gray-600 text-white rounded-lg shadow-md hover:bg-gray-700 transition">
                    Register
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
