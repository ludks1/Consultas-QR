<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>header</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px;">
                <i class="flaticon-043-teddy-bear"></i>
                <span class="text-primary">CodeFlow</span>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <a href="{{ route('index') }}" class="nav-item nav-link active">Inicio</a>
                    <a href="{{ route('about') }}" class="nav-item nav-link">Sobre Nosotros</a>
                    <a href="{{ route('schedule') }}" class="nav-item nav-link">Horarios</a>
                    <a href="{{ route('search') }}" class="nav-item nav-link">Buscar</a>
                </div>
                <a href="{{ route('login') }}" class="btn btn-primary px-4">Log in</a>
            </div>
        </nav>
    </div>
</body>

</html>