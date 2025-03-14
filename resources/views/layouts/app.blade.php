<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/hola.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex bg-teta">
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        @include('layouts.sidebare')
        <div class="flex flex-col w-full overflow-y-auto h-screen bg-beta">

            @isset($header)

                <header class=" shadow flex  justify-between items-center w-full transition-all duration-300 bg-teta">
                    <div class="py-[1.25rem] flex items-center gap-x-2 px-4 sm:px-6 lg:px-8 w-full">

                        <div class="flex justify-between items-center w-full">
                            @if (isset($title))
                                <h2 class=" leading-tight capitalize font-bold text-xl">
                                    {{ $title }}
                                </h2>
                            @endif
                            @if (isset($button))
                                {{ $button }}
                            @endif
                            {{ $header }}
                        </div>
                        <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 font-bold lg:hidden">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>

                    </div>
                    <div class="px-5 pt-2" x-data="{ showNotif: false }">
                        <button class="relative">
                            <svg id="visite_icon" x-on:click="showNotif = !showNotif" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="size-6 cursor-pointer " id="notif_bell">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        </button>


                    </div>



                    {{-- drop down --}}
                    <div class="hidden mr-4 sm:flex {{ isset($header) ? '' : 'sm:ml-auto' }}">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex  items-center  text-sm leading-4 font-medium  focus:outline-none transition ease-in-out duration-150 ms-1 bg-gray-100 rounded-full p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="#000000" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="px-3 pt-2 pb-1 border-gray-200 border-b-2">
                                    <p class="font-bold m-0 capitalize">{{ Auth::user()->name }}</p>
                                    <p class="m-0">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')" class="no-underline">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="#000000" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        <p class="m-0 font-semibold ">
                                            {{ __('Profile') }}
                                        </p>
                                    </div>
                                </x-dropdown-link>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="no-underline"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="#000000" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                            </svg>
                                            <p class="m-0 font-semibold">
                                                {{ __('Log Out') }}
                                            </p>
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                        <!-- Settings Dropdown -->
                    </div>
                </header>
            @endisset
            <main class="p-[4vw]">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
