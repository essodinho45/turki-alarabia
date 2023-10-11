<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased" dir="rtl">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        <img src="{{ asset('images/watermark.png') }}"
            class="fixed z-0 h-5/6 top-6 mx-auto my-auto inset-x-0 inset-y-0">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-transparent text-blue-700">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="z-10 relative">
            {{ $slot }}
        </main>
    </div>

    <img src="{{ asset('images/bottom-logo.png') }}" class="fixed bottom-8 right-8">
    @stack('modals')

    @livewireScripts
</body>

</html>
