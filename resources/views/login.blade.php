<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Index</title>
</head>
<body>
<section>
    <img src="logo" alt="Logo de la empresa">
    <h1>Inicio de Sesion</h1>
    <form>
        <div class="input-group">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div class="input-group">
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required>
        </div>
        <button type="submit">Iniciar Sesión</button>
        <button type="button" class="register">Registrarse</button>
    </form>
</section>
</body>
</html>
