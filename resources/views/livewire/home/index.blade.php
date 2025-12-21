<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sayabantu - Platform Bantuan Sosial</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white overflow-hidden">
    <div class="max-w-sm mx-auto h-screen flex flex-col overflow-hidden">

        <!-- Logo and Description Section -->
        <div class="flex-1 flex flex-col items-center justify-center px-6 py-12">

            <!-- Logo Icon -->
            <div class="mb-6">
                <svg class="w-32 h-32 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <!-- Hands Helping Icon -->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>

            <!-- App Name -->
            <h1 class="text-4xl font-bold text-primary-500 mb-3">sayabantu</h1>

            <!-- Description -->
            <p class="text-center text-gray-600 text-sm max-w-xs px-4">
                Platform berbagi bantuan sosial. Saling membantu untuk Indonesia yang lebih baik.
            </p>

        </div>

        <!-- Buttons Section -->
        <div class="px-6 pb-12 space-y-3">

            <!-- Log In Button -->
            <a href="{{ route('login') }}"
                class="block w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-4 rounded-full text-center transition shadow-lg">
                Log In
            </a>

            <!-- Sign Up Button -->
            <a href="{{ route('register') }}"
                class="block w-full bg-white hover:bg-gray-100 text-gray-700 font-bold py-4 rounded-full text-center transition shadow-sm border border-gray-200">
                Sign Up
            </a>

            <!-- Forgot Password Link -->
            @if (Route::has('password.request'))
                <div class="text-center pt-2">
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-gray-700 hover:text-gray-900 font-semibold">
                        Forgot Password?
                    </a>
                </div>
            @endif

        </div>

    </div>
</body>

</html>