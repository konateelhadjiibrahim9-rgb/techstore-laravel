<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TechStore') }}</title>
    
    <!-- Police Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --color-primary: #1e293b;      /* Bleu marine */
            --color-secondary: #64748b;    /* Gris anthracite */
            --color-accent: #f97316;       /* Orange dynamique */
            --color-accent-hover: #ea580c; /* Orange hover */
            --color-bg: #f8fafc;           /* Gris très clair */
            --color-white: #ffffff;
            --color-text: #1e293b;
            --color-text-light: #64748b;
            --border-radius-sm: 0.375rem;
            --border-radius-md: 0.5rem;
            --border-radius-lg: 0.75rem;
            --border-radius-xl: 1rem;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
        }
        
        .btn-primary {
            background-color: var(--color-accent);
            color: var(--color-white);
            border-radius: var(--border-radius-md);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--color-accent-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }
        
        .card {
            background-color: var(--color-white);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header personnalisé -->
    @include('layouts.header')

    <!-- Contenu principal -->
    <main class="pt-[72px] min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer personnalisé -->
    @include('layouts.footer')

    <!-- WhatsApp flottant -->
    @include('components.whatsapp-float')

    @vite(['resources/js/app.js'])
</body>
</html>
