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
            <h3 class="display-3 font-weight-bold text-white">Crear Institucion</h3>
            <div class="d-inline-flex text-white">
                <a href="{{ route('index') }}" class="text-white">Inicio</a>
                <i class="fas fa-chevron-right px-3"></i>
                <p class="text-white">Institucion</p>
            </div>
        </div>
    </div>

    <body>
        <div class="container my-5">
            <h2 class="text-center mb-4">Crear Nueva Institucion</h2>
            <form action="/create-classroom" method="POST">
                @csrf
                <div class="form-group">
                    <label for="classroomName">Nombre de la Institucion</label>
                    <input type="text" class="form-control" id="classroomName" name="classroom_name"
                        placeholder="Ej. Instituto Tecnologico de Toluca" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Crear Institucion</button>
                </div>
            </form>
        </div>
    </body>


    @include('footer')
    <!-- Back to Top -->
    <a href="{{ route('institution') }}" class="btn btn-primary p-3 back-to-top"><i
            class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
