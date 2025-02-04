<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Montañas Rusas - Registro</title>
</head>

<body id="loginRegister">
    <h2>REGISTRARSE</h2>
    <form action="index.php?accion=registrar" method="POST">
        <label for="nombreUsuario">Nombre de Usuario</label>
        <input type="text" name="nombreUsuario" required><br>

        <label for="contrasena">Contraseña</label>
        <input type="password" name="contrasena" required><br>

        <div>
            <label for="rol">Rol</label>
            <select name="rol">
                <option value="fabricante">Fabricante</option>
                <option value="usuario">Usuario</option>
                <option value="administrador">Administrador</option>
            </select>
        </div>
        <br>
        <input type="submit" value="Registrarse"></input>
        <p>¿Ya tienes cuenta? Logueate <a href="index.php?accion=login">aquí</a></p>
    </form>
</body>

</html>