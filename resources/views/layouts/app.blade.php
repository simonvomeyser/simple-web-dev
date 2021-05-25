<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700|Sanchez&display=swap" rel="stylesheet">

    <title>@hasSection('title')@yield('title')@else{{'Simple Web Dev - Just a blog about web development'}}@endif</title>

    <meta name="description" content="@hasSection('meta_description')@yield('meta_description')@else{{'A small diary of the things I learn on this journey in web development land.'}}@endif">

    <link rel="stylesheet" href="{{mix('css/app.css')}}">

    <meta property="og:title" content="@hasSection('title')@yield('title')@else{{'Simple Web Dev - Just a blog about web development'}}@endif">
    <meta property="og:description" content="@hasSection('meta_description')@yield('meta_description')@else{{'This site is a small diary of the things I learn while on this intimidating journey through web development land'}}@endif">
    <meta property="og:type" content="@hasSection('og_type')@yield('og_type')@else{{'website'}}@endif" />
    <meta
        property="og:image"
        content="@hasSection('og_image')@yield('og_image')@else{{URL::to('images/default-og-image.png')}}@endif"
    />

    <link rel="apple-touch-icon" sizes="57x57" href="{{ URL::to('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ URL::to('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ URL::to('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ URL::to('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ URL::to('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ URL::to('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ URL::to('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ URL::to('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::to('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ URL::to('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ URL::to('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ URL::to('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#8798FD">
    <meta name="msapplication-TileImage" content="{{ URL::to('favicon/ms-icon-144x144.png') }}">
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
