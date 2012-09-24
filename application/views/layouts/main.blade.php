<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Apartment Management Portal</title>
        {{ Asset::styles() }}
        {{ Asset::scripts() }}
    </head>

    <body>
        <h1>Welcome to apartment management system {{ Auth::user()->name }}</h1>
        <div class="navbar">
            <ul class="app-navbar">
                <li>{{HTML::link('home/members', 'Members');}}</li>
                <li>{{HTML::link('home/flats', 'Flats');}}</li>
                <li>{{HTML::link('home/logout', 'Logout');}}</li>
            </ul>
        </div><!-- .navbar -->
        <div class="main-container">
            @yield('content')
        </div><!-- .main-container -->

</html>