<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    @vite('resources/sass/app.scss')

    @yield('js_footer')
</head>
<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <header class="bg-blue-500 h-16 min-h-16">
            <div class="mx-auto h-full flex items-center justify-between px-8">
                <div class="text-white text-lg font-bold">Test project</div>
                <nav>
                    <ul class="flex space-x-4 text-white">
                        <li><a href="{{ route('welcome') }}" class="@if (Route::is('welcome')) bg-blue-600 rounded @else hover:underline @endif px-2 py-1">Welcome</a></li>
                        <li><a href="{{ route('register') }}" class="@if (Route::is('register')) bg-blue-600 rounded @else hover:underline @endif px-2 py-1">Register</a></li>
                        <li><a href="{{ route('login') }}" class="@if (Route::is('login')) bg-blue-600 rounded @else hover:underline @endif px-2 py-1">Login</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main class="flex-grow flex items-center justify-center">
            @yield('content')
        </main>
    </div>
</body>
</html>
