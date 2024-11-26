<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CodeFlow - Horarios</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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
            <h3 class="display-3 font-weight-bold text-white">Mis Horarios</h3>
            <div class="d-inline-flex text-white">
                <a href="{{ route('index') }}" class="text-white">Inicio</a>
                <i class="fas fa-chevron-right px-3"></i>
                <p class="text-white">Clases</p>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Gallery Start -->
    <form action="{{ route('schedule') }}" method="GET">
        <div class="row">
            <div class="col-md-4 mb-4">
                <label for="start_time">Hora de Inicio</label>
                <input type="time" class="form-control" name="start_time" id="start_time"
                    value="{{ request('start_time') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="end_time">Hora de Fin</label>
                <input type="time" class="form-control" name="end_time" id="end_time"
                    value="{{ request('end_time') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="date">Fecha</label>
                <input type="date" class="form-control" name="date" id="date" value="{{ request('date') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="subject">Materia</label>
                <input type="text" class="form-control" name="subject" id="subject"
                    value="{{ request('subject') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="room">Salón</label>
                <input type="text" class="form-control" name="room" id="room" value="{{ request('room') }}">
            </div>
            <div class="col-md-12 mb-3">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    <!-- Resultados de la búsqueda -->
    @if (isset($schedules) && count($schedules) > 0)
        <div class="row">
            @foreach ($schedules as $schedule)
                <div class="col-md-6 col-lg-3 text-center mb-5">
                    <div class="schedule-item">
                        <h5>{{ $schedule->subject }}</h5>
                        <p><strong>Hora:</strong> {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                        <p><strong>Fecha:</strong> {{ $schedule->date }}</p>
                        <p><strong>Salón:</strong> {{ $schedule->room }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No se encontraron horarios para la búsqueda.</p>
    @endif
    <!-- Gallery End -->


    <!-- Footer Start -->
    @include('footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="{{ route('schedule') }}" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
