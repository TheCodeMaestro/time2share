<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Time2share</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/time2share.js'])
    </head>
    <body style="background-color: #f5f5f5">
        <header>
        </header>
        <main>
            <section class="welcome-box">
                <h2>Welcome to Time2share</h2>
                <p>The place to share products!</p>
                <nav style="padding-top: 2rem">
                    <a class="secondary-button" href="{{ route('register') }}">{{ __('Register') }}</a>
                    <a class="primary-button" style="margin-left: 2rem" href="{{ route('login') }}">{{ __('Login') }}</a>
                </nav>
            </section>
        </main>
        <footer>

        </footer>
    </body>
</html>
