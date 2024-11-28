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
            <h3 class="display-3 font-weight-bold text-white">Crear Materia </h3>
            <div class="d-inline-flex text-white">
                <a href="{{ route('index') }}" class="text-white">Inicio</a>
                <i class="fas fa-chevron-right px-3"></i>
                <p class="text-white">Materias</p>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Crear Nueva Materia</h2>
        <form action="{{ route('subject.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre de la Materia</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ej. Matematicas"
                    required>
            </div>
            <div class="form-group">
                <label for="description">Descripcion de la Materia</label>
                <input type="text" class="form-control" id="description" name="description"
                    placeholder="Ej. Ciencia que estudia las características y vínculos en valores abstractos como los números, geométricas y aritméticas."
                    required>
            </div>
            <div class="form-group">
                <label for="code">Codigo de la materia</label>
                <input type="number" class="form-control" id="code" name="code" placeholder="Ej. 001" required>
            </div>
            <div class="form-group">
                <label for="semester">Semestre</label>
                <select class="form-control" id="semester" name="semester" required>
                    <option value="">Seleccione un Semestre</option>
                    <option value="1">Primer</option>
                    <option value="2">Segundo</option>
                    <option value="3">Tercer</option>
                    <option value="4">Cuarto</option>
                    <option value="5">Quinto</option>
                    <option value="6">Sexto</option>
                    <option value="7">Septimo</option>
                    <option value="8">Octavo</option>
                    <option value="9">Noveno</option>
                    <option value="10">Decimo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="career">Carera</label>
                <select class="form-control" id="career" name="career" required>
                    <option value="">Seleccione una Carrera</option>
                    @foreach ($careers as $career)
                        <option value="{{ $career }}">{{ $career }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>

    </div>

    @include('footer')
    <!-- Back to Top -->
    <a href="{{ route('subject') }}" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
