<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TechStore') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header personnalisé -->
    @include('layouts.header')

    <!-- Contenu principal -->
    <main class="pt-20">
        {{ $slot }}
    </main>

    <!-- Footer personnalisé -->
    @include('layouts.footer')

    <!-- WhatsApp flottant -->
    @include('components.whatsapp-float')

    @vite(['resources/js/app.js'])
</body>
</html>
