@extends('layouts.app')

@section('content')
<div class="relative min-h-screen flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
    <div class="w-full max-w-3xl px-6 py-12 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Welcome to Laravel</h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">A powerful PHP framework for web artisans.</p>
    </div>
    <div class="flex space-x-4 mt-6">
        @auth
            <a href="{{ url('/dashboard') }}" class="px-5 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="px-5 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition">Login</a>
            <a href="{{ route('register') }}" class="px-5 py-3 bg-gray-600 text-white rounded-lg shadow-md hover:bg-gray-700 transition">Register</a>
        @endauth
    </div>
</div>
@endsection
