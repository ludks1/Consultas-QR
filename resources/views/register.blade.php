<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CodeFlow - Registro</title>
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

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4 shadow" style="width: 400px;">
            <h3 class="text-center mb-4">Registrarse</h3>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="name" class="form-control" id="name" name="name"
                        placeholder="Ingrese su nombre" required>
                </div>
                <div class="form-group">
                    <label for="accountId">Numero de Cuenta</label>
                    <input type="accountId" class="form-control" id="accountId" name="accountId"
                        placeholder="Ingrese su numero de cuenta" required>
                </div>
                <div class="form-group">
                    <label for="type">Tipo de Usuario</label>
                    <select name="type" id="ype" class="form-control">
                        @foreach ($userTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="career">Carrera</label>
                    <select name="career" id="career" class="form-control">
                        @foreach ($userCareers as $career)
                            <option value="{{ $career }}">{{ $career }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Ingrese su correo" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Ingrese su contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Crear Cuenta</button>
            </form>
        </div>
    </div>

    @include('footer')
</body>

</html>
