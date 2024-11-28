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
    @include('opnavbar')

    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-3 font-weight-bold text-white">Asignar Salones</h3>
            <div class="d-inline-flex text-white">
                <a href="{{ route('index') }}" class="text-white">Inicio</a>
                <i class="fas fa-chevron-right px-3"></i>
                <p class="text-white">Salones</p>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Crear Nuevo Salón</h2>
        <form action="{{ route('space.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="classroomName">Nombre o Código del Salón</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ej. Aula 101"
                    required>
            </div>
            <div class="form-group">
                <label for="capacity">Capacidad del salón</label>
                <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Ej. 30 personas"
                    required>
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
                <label for="floorSelect">Seleccionar Piso</label>
                <select class="form-control" id="floorSelect" name="floor" required>
                    <option value="">Seleccione un piso</option>
                    @foreach ($floors as $floor)
                        <option value="{{ $floor }}">{{ $floor }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="spaceTypeSelect">Seleccionar tipo</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="">Seleccione un tipo</option>
                    @foreach ($spaceTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
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
    <a href="{{ route('space') }}" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
