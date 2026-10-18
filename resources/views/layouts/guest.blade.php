<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'U-Sea') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Brand panel -->
            <div class="relative flex items-center justify-center bg-gradient-to-br from-[#0B1F3A] via-[#0B1F3A] to-[#087EA4] px-6 py-10 lg:w-5/12 lg:min-h-screen">
                <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
                    <svg class="absolute -bottom-10 -left-10 w-[120%] text-[#18AEE5] opacity-20" viewBox="0 0 1440 320" fill="currentColor" preserveAspectRatio="none">
                        <path d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                    <svg class="absolute bottom-0 left-0 w-[120%] text-[#DDF7F5] opacity-10" viewBox="0 0 1440 320" fill="currentColor" preserveAspectRatio="none">
                        <path d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,208C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>

                <div class="relative z-10 max-w-md text-center lg:text-left">
                    <a href="{{ route('home') }}" class="inline-block">
                        <x-application-logo class="h-16 w-auto mx-auto lg:mx-0" />
                    </a>
                    <h1 class="mt-6 text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                        U-Sea Marketplace
                    </h1>
                    <p class="mt-4 text-lg text-[#DDF7F5]">
                        From the Sea, Direct to You.
                    </p>
                    <p class="mt-2 text-sm text-[#18AEE5]">
                        Belanja hasil laut segar langsung dari nelayan dan UMKM pesisir Indonesia.
                    </p>
                </div>
            </div>

            <!-- Form panel -->
            <div class="flex flex-1 items-center justify-center bg-[#f0f9ff] px-4 py-10 sm:px-6 lg:px-8">
                <div class="w-full max-w-md space-y-6">
                    <div class="bg-white px-6 py-8 shadow-xl sm:rounded-2xl sm:px-10 border border-[#DDF7F5]">
                        {{ $slot }}
                    </div>

                    <p class="text-center text-sm text-[#64748b]">
                        &copy; {{ date('Y') }} U-Sea. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
