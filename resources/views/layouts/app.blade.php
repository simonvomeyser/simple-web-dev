<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700|Sanchez" rel="stylesheet">

    <title>Simple Web Dev - Just a blog about web development</title>
    <meta name="description" content="This site is a small diary of the things I learn while on this intimidating journey through web development land.">

    <link rel="stylesheet" href="{{mix('css/app.css')}}">

    <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#8798FD">
    <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#8798FD">

</head>

<body>
    <div id="app">
        <header class="header">
            <div class="header__inner container">

                <a class="header__logo" href="{{route('index')}}">
                    <img src="{{asset('images/logo.svg')}}" alt="The page's logo, looking all fancy and stuff">
                </a>
                <nav class="header__nav">
                    <ul>
                        <li><a href="{{route('about')}}">About</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main">
            @yield('main')
        </main>
        <footer class="footer container">
            <ul>
                <li><a href="{{route('legal-notice')}}">Legal Notice</a></li>
                <li><a href="{{route('privacy')}}">Privacy</a></li>
            </ul>
        </footer>
    </div>

    @stack('footer-scripts')
    <script src="{{mix('js/app.js')}}"></script>

</body>

</html>
