<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CodeFlow - Buscar</title>

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    @if (auth()->check())
        @php
            $type = auth()->user()->type;
        @endphp
        @if ($type == \App\Enums\UserType::ADMIN)
            <!-- Navbar para Usuarios -->
            @include('opnavbar')
        @else
            <!-- Navbar para Administradores -->
            @include('usernavbar')
        @endif
    @else
        <!-- Navbar para Invitados -->
        @include('navbar')
    @endif
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-3 font-weight-bold text-white">Buscar</h3>
            <div class="d-inline-flex text-white">
                <a href="{{ route('index') }}" class="text-white">Inicio</a>
                <i class="fas fa-chevron-right px-3"></i>
                <p class="text-white">Buscar</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center pb-4">
                <p class="section-title px-5"><span class="px-2">Busca tus horarios</span></p>
                <h1 class="mb-4">Filtrar Resultados</h1>
            </div>
            <form class="bg-light shadow-sm p-4 rounded">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="teacher" class="font-weight-bold">Maestro</label>
                        <input type="text" id="teacher" class="form-control" placeholder="Nombre del maestro">
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="room" class="font-weight-bold">Salón</label>
                        <input type="text" id="room" class="form-control" placeholder="Número de salón">
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="subject" class="font-weight-bold">Materia</label>
                        <input type="text" id="subject" class="form-control" placeholder="Nombre de la materia">
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="time" class="font-weight-bold">Horario</label>
                        <input type="time" id="time" class="form-control">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5"><span class="px-2">Resultados de Búsqueda</span></p>
                <h1 class="mb-4">Materias Encontradas</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 bg-light shadow-sm pb-2">
                        <img class="card-img-top mb-2" src="img/class-1.jpg" alt="">
                        <div class="card-body text-center">
                            <h4 class="card-title">Física</h4>
                        </div>
                        <div class="card-footer bg-transparent py-4 px-5">
                            <div class="row border-bottom">
                                <div class="col-6 py-1 text-right border-right"><strong>Maestro</strong></div>
                                <div class="col-6 py-1">Mauro Sánchez Sánchez</div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-6 py-1 text-right border-right"><strong>Salón</strong></div>
                                <div class="col-6 py-1">11</div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-6 py-1 text-right border-right"><strong>Edificio</strong></div>
                                <div class="col-6 py-1">F</div>
                            </div>
                            <div class="row">
                                <div class="col-6 py-1 text-right border-right"><strong>Horario</strong></div>
                                <div class="col-6 py-1">De 9:00 a 11:00</div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary px-4 mx-auto mb-4">Ver Más</a>
                    </div>
                </div>
                <!-- Repite esta tarjeta para cada resultado -->
            </div>
        </div>
    </div>
    <!-- Results End -->

    <!-- Footer Start -->
    @include('footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="{{ route('search') }}" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
