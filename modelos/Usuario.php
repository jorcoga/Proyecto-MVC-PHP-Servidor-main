<?php

/**
 * Clase Usuario
 *
 * Esta clase maneja las operaciones relacionadas con los usuarios,
 * como obtener todos los usuarios, guardar nuevos usuarios, verificar
 * credenciales y cerrar sesión.
 */
class Usuario
{
    /**
     * Obtiene todos los usuarios almacenados.
     *
     * @return array Lista de todos los usuarios.
     */
    public static function obtenerContraseña($nombre)
    {
        return (new BDA)->buscarContrasena($nombre);
    }

    public static function obtenerUsuario($nombre)
    {
        return (new BDA)->buscarUsuario($nombre);
    }

    /**
     * Guarda un nuevo usuario en el sistema.
     *
     * @param string $nombre Nombre del usuario.
     * @param string $contrsena Contraseña del usuario (ya encriptada).
     * @param string $rol Rol del usuario (e.g., administrador, fabricante, usuario).
     * @return void
     */
    public static function guardar($nombre, $contrsena, $rol)
    {
        (new BDA)->introducirUsuarios($nombre, $contrsena, $rol);

        // Redirigir al formulario de login
        header('Location: index.php?accion=login');
        exit();
    }

    /**
     * Verifica si las credenciales del usuario son correctas.
     *
     * Si las credenciales son válidas, se inicia una sesión y se redirige al índice.
     * Si no, se muestra un mensaje de error.
     *
     * @param string $nombre Nombre del usuario.
     * @param string $contrasena Contraseña proporcionada por el usuario.
     * @return void
     */
    public static function verificar($nombre, $contrasena)
    {
       
        $contrasenaComprobar = self::obtenerContraseña($nombre);    
        print_r($contrasenaComprobar);
        // Verificar si el usuario existe y si la contraseña es correcta
        if (password_verify($contrasena, $contrasenaComprobar[0])) {
            $_SESSION['user'] = self::obtenerUsuario($nombre);
            header('Location: index.php?accion=index');
            exit();
        }

        // Mostrar mensaje de error si las credenciales no son válidas
        echo "<p id='error'>Usuario o contraseña incorrecta<p>";
    }

    /**
     * Cierra la sesión actual del usuario.
     *
     * Destruye la sesión y redirige al formulario de login.
     *
     * @return void
     */
    public static function logout()
    {
        session_destroy();
        header('Location: index.php?accion=login');
        exit();
    }
}
