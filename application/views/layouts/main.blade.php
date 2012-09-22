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
        <ul class="app-navbar">
            <li><a href="members">members</a></li>
            <li><a href="flats">flats</a></li>
            <li><a href="logout">logout</a></li>
        </ul>
</html>