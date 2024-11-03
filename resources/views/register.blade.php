<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Registro</title>
</head>
<body>
<section>
    <img src="logo" alt="Logo de la empresa">
    <h1>Registrarse</h1>
    <form>
        <div class="input-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="input-group">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" required>
        </div>
        <div class="input-group">
            <label for="nCuenta">Numero de cuenta</label>
            <input type="number" id="nCuenta" name="nCuenta" required>
        </div>
        <button type="button" class="signUp ">Crear Cuenta</button>
    </form>
</section>
</body>
</html>
