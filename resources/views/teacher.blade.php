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
            <h3 class="display-3 font-weight-bold text-white">Asignar Maestros</h3>
            <div class="d-inline-flex text-white">
                <a href="{{ route('index') }}" class="text-white">Inicio</a>
                <i class="fas fa-chevron-right px-3"></i>
                <p class="text-white">Maestros</p>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Asignar Maestros</h2>
        <form action="/assign-teachers" method="POST">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Maestro</th>
                            <th>Materia</th>
                            <th>Salón</th>
                            <th>Edificio</th>
                            <th>Institución</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-control" name="teacher_id">
                                    <option value="">Seleccione un maestro</option>
                                    <!-- Iterar maestros -->
                                    <option value="1">Juan Pérez</option>
                                    <option value="2">Ana Gómez</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="subject_id">
                                    <option value="">Seleccione una materia</option>
                                    <!-- Iterar materias -->
                                    <option value="1">Matemáticas</option>
                                    <option value="2">Historia</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="classroom_id">
                                    <option value="">Seleccione un salón</option>
                                    <!-- Iterar salones -->
                                    <option value="1">Aula 101</option>
                                    <option value="2">Aula 202</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="building_id">
                                    <option value="">Seleccione un edificio</option>
                                    <!-- Iterar edificios -->
                                    <option value="1">Edificio A</option>
                                    <option value="2">Edificio B</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="institution_id">
                                    <option value="">Seleccione una institución</option>
                                    <!-- Iterar instituciones -->
                                    <option value="1">Universidad Nacional</option>
                                    <option value="2">Instituto Técnico</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Asignar</button>
            </div>
        </form>
    </div>
    @include('footer')

    <!-- Back to Top -->
    <a href="{{ route('teacher') }}" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
