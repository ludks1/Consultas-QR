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

    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-3 font-weight-bold text-white">Asignar Edificios</h3>
            <div class="d-inline-flex text-white">
                <a href="{{ route('index') }}" class="text-white">Inicio</a>
                <i class="fas fa-chevron-right px-3"></i>
                <p class="text-white">Edificios</p>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Crear Nuevo Edificio</h2>
        <form action="{{ route('building.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre o Código del Edificio</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ej. Edificio F"
                    required>
            </div>
            <div class="form-group">
                <label for="address">Dirección del Edificio</label>
                <input type="text" class="form-control" id="address" name="address"
                    placeholder="Ej. Frente a dirección, a un lado de control escolar" required>
            </div>
            <div class="form-group">
                <label for="numberOfFloors">Número de pisos del Edificio</label>
                <input type="number" class="form-control" id="numberOfFloors" name="numberOfFloors" placeholder="Ej. 3"
                    required>
            </div>
            <div class="form-group">
                <label for="institutionId">Seleccionar Institución</label>
                <select class="form-control" id="institutionId" name="institutionId" required>
                    <option value="">Seleccione una institución</option>
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>


    @include('footer')
    <!-- Back to Top -->
    <a href="{{ route('building') }}" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
