<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Application')</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    @vite('resources/js/app.js')
</body>
</html>

