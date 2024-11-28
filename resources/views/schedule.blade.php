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

    <div class="container my-5">
        <h2 class="text-center mb-4">Crear Nuevo Horario</h2>
        <form action="{{ route('schedule.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="startIime">Hora de Inicio</label>
                <input type="time" class="form-control" name="startIime" id="startIime"
                    value="{{ request('startIime') }}">
            </div>
            <div class="form-group">
                <label for="endIime">Hora de Fin</label>
                <input type="time" class="form-control" name="endIime" id="endIime"
                    value="{{ request('endIime') }}">
            </div>

            <div class="form-group">
                <label for="day">Fecha</label>
                <input type="date" class="form-control" name="day" id="day" value="{{ request('day') }}">
            </div>
            <div class="form-group">
                <label for="institutionSelect">Seleccionar Institución</label>
                <select class="form-control" id="institutionId" name="institutionId" required>
                    <option value="">Seleccione una institución</option>
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="buildingSelect">Seleccionar Edificio</label>
                <select class="form-control" id="buildingId" name="buildingId" required>
                    <option value="">Seleccione un edificio</option>
                    @foreach ($buildings as $building)
                        <option value="{{ $building->id }}">{{ $building->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="spaceSelect">Seleccionar Salon</label>
                <select class="form-control" id="spaceSelect" name="spaceId" required>
                    <option value="">Seleccione un salon</option>
                    @foreach ($spaces as $space)
                        <option value="{{ $space->id }}">{{ $space->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="subjectId">Seleccionar materia</label>
                <select class="form-control" id="subjectId" name="subjectId" required>
                    <option value="">Seleccione una materia</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>

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
