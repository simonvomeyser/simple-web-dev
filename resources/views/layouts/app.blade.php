<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700|Sanchez" rel="stylesheet">

    <title>Simple Web Dev - A simple blog about web development</title>
    <meta name="description" content="This site is a small diary of the things I learn while on an intimidating journey through web development land.">

    <link rel="stylesheet" href="{{mix('css/app.css')}}">

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
