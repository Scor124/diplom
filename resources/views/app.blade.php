<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bitter&display=swap" rel="stylesheet">
        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

        @routes

        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])

        @inertiaHead
    </head>
    <body class="font-sans antialiased justify-content-center bg-color-#424242">
            <div class="container-fluid bg-gray-800">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link" href="https://og-ti.ru/sveden"> Сведения об образовательной организации</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://og-ti.ru/institut/novosti"> Новости</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://og-ti.ru/biblioteka/elektronnyj-katalog">Электронный каталог</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3"></div>
                </div>
        </div>
        @inertia
    </body>
</html>
