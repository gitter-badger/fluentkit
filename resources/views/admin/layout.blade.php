<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="url" content="{{ url('') }}">
    <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">
    <meta name="api_token" content="{{ $user->api_token }}">
    <meta name="user" content='{{ $user->toJson() }}'>
    @yield('meta')

    <title>{{ $page_title }}</title>

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

    <link rel="stylesheet" href="{{ url('css/admin.css') }}">
</head>
<body>
<div class="app-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <header class="app-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">{{ $page_title }}</span>
            <div class="mdl-layout-spacer"></div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
                <label class="mdl-button mdl-js-button mdl-button--icon" for="search">
                    <i class="material-icons">search</i>
                </label>
                <div class="mdl-textfield__expandable-holder">
                    <input class="mdl-textfield__input" type="text" id="search">
                    <label class="mdl-textfield__label" for="search">Enter your query...</label>
                </div>
            </div>
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
                <i class="material-icons">more_vert</i>
            </button>
            <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
                <li><a class="mdl-menu__item" href="#">{{ trans('admin.help') }}</a></li>
            </ul>
        </div>
    </header>
    <div class="app-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="app-drawer-header">
            <img src="http://www.getmdl.io/templates/dashboard/images/user.jpg" class="app-avatar">
            <div class="app-avatar-dropdown">
                <span>{{ $user->email }}</span>
                <div class="mdl-layout-spacer"></div>
                <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons" role="presentation">arrow_drop_down</i>
                    <span class="visuallyhidden">Account</span>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                    <li><a href="{{ route('login') }}" class="mdl-menu__item"><i class="material-icons">person</i> View Profile</a></li>
                    <li><a href="{{ route('logout') }}" class="mdl-menu__item"><i class="material-icons">exit_to_app</i> Logout</a></li>
                </ul>
            </div>
        </header>
        <nav class="app-navigation mdl-navigation mdl-color--blue-grey-800">
            <a class="mdl-navigation__link @if(Request::route()->getName() == 'admin.dashboard') is-active @endif" href="{{ route('admin.dashboard') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{ trans('admin.dashboard_title') }}</a>
            <a class="mdl-navigation__link js-dropdown" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>{{ trans('admin.users_title') }}</a>
            <div class="mdl-navigation__dropdown">
                <a class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">pageview</i>{{ trans('global.view_all') }}</a>
                <a class="mdl-navigation__link" href="#"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person_add</i>{{ trans('global.add_new') }}</a>
                <a class="mdl-navigation__link @if(Request::route()->getName() == 'admin.roles') is-active @endif" href="{{ route('admin.roles') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">lock</i>{{ trans('admin.roles_title') }}</a>
            </div>
            <a class="mdl-navigation__link @if(Request::route()->getName() == 'admin.settings') is-active @endif" href="{{ route('admin.settings') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">settings</i>{{ trans('admin.settings_title') }}</a>
            <div class="mdl-layout-spacer"></div>
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i><span class="visuallyhidden">Help</span></a>
        </nav>
    </div>
    <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid app-content">
            <img src="http://www.mvgen.com/loader.gif" id="loading" v-show="loading"/>
            @yield('content')
        </div>
    </main>
</div>

<notifications></notifications>
</body>
</html>
