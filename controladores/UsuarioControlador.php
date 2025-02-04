<?php

/**
 * Controlador para la gestión de usuarios.
 * Este controlador maneja acciones relacionadas con el login, logout y registro de usuarios.
 */
require_once __DIR__ . '/../modelos/Usuario.php';

class UsuarioControlador
{
    /**
     * Muestra el formulario de inicio de sesión (login).
     *
     * Si la solicitud es POST, se valida el usuario con las credenciales ingresadas.
     * Finalmente, muestra la vista del formulario de login.
     *
     * @return void
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar credenciales del usuario
            Usuario::verificar($_POST['nombreUsuario'], $_POST['contrasena']);
        }

        // Mostrar formulario de login
        require_once __DIR__ . '/../vistas/usuario/login.php';
    }

    /**
     * Cierra la sesión del usuario (logout).
     *
     * Llama al método del modelo para finalizar la sesión activa del usuario.
     *
     * @return void
     */
    public function logout()
    {
        Usuario::logout();
    }

    /**
     * Muestra el formulario de registro de usuario y procesa el registro.
     *
     * Si la solicitud es POST, guarda los datos del nuevo usuario, encriptando
     * la contraseña para mayor seguridad. Finalmente, muestra la vista del
     * formulario de registro.
     *
     * @return void
     */
    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Encriptar la contraseña para almacenarla de forma segura
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

            // Guardar los datos del nuevo usuario
            Usuario::guardar($_POST['nombreUsuario'], $contrasena, $_POST['rol']);
        }

        // Mostrar formulario de registro
        require_once __DIR__ . '/../vistas/usuario/registrar.php';
    }
}
