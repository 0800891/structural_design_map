<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Structural Design Map</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" >
        <div class="min-h-screen" style="background-color:rgb(236,230,198)">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header  style="background-color:rgb(236,230,198)">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer style="background-color:rgb(236,230,198)" class="py-16 text-center text-sm text-black dark:text-gray-500">
                <small>&copy; 2024 Kohsaku Mitsuhashi</small>
            </footer>
        </div>
    </body>
</html>
