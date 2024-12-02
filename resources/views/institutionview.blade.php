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
            <h3 class="display-3 font-weight-bold text-white">Ver Instituciones </h3>
            <div class="d-inline-flex text-white">
                <a href="{{ route('index') }}" class="text-white">Inicio</a>
                <i class="fas fa-chevron-right px-3"></i>
                <p class="text-white">Instituciones</p>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-5">
        <div class="container">
            <div class="row">
                <!-- Bucle para mostrar las tarjetas -->
                @foreach ($institutions as $institution)
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $institution->name }}</h4>
                            </div>
                            <div class="card-footer bg-transparent py-4 px-5">
                                <form action="{{ route('institution.update', ['id' => $institution->id]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row border-bottom">
                                        <div class="col-6 py-1 text-right border-right"><strong>Nombre</strong></div>
                                        <div class="col-6 py-1">
                                            <input type="text" name="name"class="form-control" required
                                                value="{{ $institution->name }}" />
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col-6 py-1 text-right border-right"><strong>Direccion</strong></div>
                                        <div class="col-6 py-1">
                                            <input type="text" name="address"class="form-control" required
                                                value="{{ $institution->address }}" />
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col-6 py-1 text-right border-right"><strong>Telefono</strong></div>
                                        <div class="col-6 py-1">
                                            <input type="numer" name="phone"class="form-control" required
                                                value="{{ $institution->phone }}" />
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col-6 py-1 text-right border-right"><strong>Email</strong></div>
                                        <div class="col-6 py-1">
                                            <input type="email" name="email"class="form-control" required
                                                value="{{ $institution->email }}" />
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col-6 py-1 text-right border-right"><strong>Logo</strong></div>
                                        <div class="col-6 py-1">
                                            <img src="{{ asset('storage/' . $institution->logo) }}" alt="Logo actual"
                                                class="img-fluid mb-2">
                                            <input type="file" name="logo" />
                                        </div>
                                    </div>
                                    <!-- Botón de actualización -->
                                    <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
                                </form>
                                <form action="{{ route('institution.delete', ['id' => $institution->id]) }}"
                                    method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    @include('footer')
    <!-- Back to Top -->
    <a href="{{ route('institution.view') }}" class="btn btn-primary p-3 back-to-top"><i
            class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
