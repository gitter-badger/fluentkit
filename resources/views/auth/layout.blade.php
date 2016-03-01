<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page_title }}</title>


        <meta name="url" content="{{ url('') }}">
        <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">

        @yield('meta')

        <!-- Add to homescreen for Chrome on Android -->
        <!--<meta name="mobile-web-app-capable" content="yes">
        <link rel="icon" sizes="192x192" href="images/android-desktop.png">-->

        <!-- Add to homescreen for Safari on iOS -->
        <!--<meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Material Design Lite">
        <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">-->

        <!-- Tile icon for Win8 (144x144 + tile color) -->
        <!--<meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
        <meta name="msapplication-TileColor" content="#3372DF">-->

        <link rel="shortcut icon" href="favicon.ico">

        <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
        <!--
        <link rel="canonical" href="http://www.example.com/">
        -->

        <link rel="stylesheet" href="{{ url('css/auth.css') }}">

    </head>
    <body class="overlay">

        <img src="http://www.mvgen.com/loader.gif" id="loading" v-show="loading"/>

        @yield('content')

        <notifications></notifications>

        @yield('scripts')
    </body>
</html>