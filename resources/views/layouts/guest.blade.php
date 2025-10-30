<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Auth styles -->
    @vite(['resources/css/app.css', 'resources/css/auth-theme.css', 'resources/js/app.js'])
    <!-- Fallback static auth stylesheet so design shows even if Vite/dev-server isn't running -->
    <link href="{{ asset('assets/css/auth-theme.css') }}" rel="stylesheet" />
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen auth-hero flex items-center">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="logo-column flex items-center justify-center">
                        <div class="logo-wrap">
                            {{-- Use brand logo image; place your SVG/PNG at public/assets/img/brand-logo.svg or .png --}}
                            <img src="{{ asset('assets/img/brand-logo.svg') }}" alt="brand logo" class="application-logo" />
                        </div>
                    </div>

                    <div class="form-column flex items-center justify-center">
                        <div class="auth-card w-full max-w-md">
                            <h2 class="text-2xl font-bold text-center mb-6">Welcome</h2>
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
