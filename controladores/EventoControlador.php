<?php

/**
 * Controlador para la gestión de eventos.
 * Este controlador maneja acciones como listar, agregar, compartir,
 * asistir y eliminar eventos.
 */
require_once __DIR__ . '/../modelos/Evento.php';

class EventoControlador
{
    /**
     * Muestra la lista de eventos para el usuario actual.
     *
     * Obtiene los eventos del usuario y los eventos generales,
     * y los envía a la vista correspondiente.
     *
     * @return void
     */
    public function listar()
    {
        $eventosUsuario = Evento::obtenerEventosPersonales();
        $eventosGenerales = Evento::obtenerTodos();

        require_once __DIR__ . '/../vistas/evento/lista.php';
    }

    /**
     * Agrega un nuevo evento.
     *
     * Si la solicitud es POST, recoge los datos enviados desde el formulario,
     * crea un nuevo evento y lo guarda en el sistema.
     * Luego muestra la vista del formulario para agregar eventos.
     *
     * @return void
     */
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Evento::guardar($_POST['nombre'], $_POST['fecha'], $_POST['descripcion'], true);
        }

        require_once __DIR__ . '/../vistas/evento/agregar.php';
    }

    /**
     * Comparte un evento con otro usuario.
     *
     * Si la solicitud es POST, recoge el nombre del evento y el usuario
     * con el que se compartirá, y realiza la acción de compartir.
     *
     * @return void
     */
    public function compartir()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Evento::compartir($_POST['nombre'], $_POST['usuario']);
        }

        require_once __DIR__ . '/../vistas/evento/agregar.php';
    }

    /**
     * Marca un evento como "asistido" por el usuario actual.
     *
     * Recoge el nombre del evento desde los parámetros GET y realiza
     * la acción correspondiente.
     *
     * @return void
     */
    public function asistir()
    {
        // Llamar a la función asistir
        Evento::asistir($_GET['id']);
    }

    /**
     * Elimina un evento específico.
     *
     * Recoge el nombre del evento desde los parámetros GET y lo elimina
     * del sistema.
     *
     * @return void
     */
    public function eliminarEvento()
    {
        // Verificar si se pasa el 'id' del evento en la URL
        if (isset($_GET['id'])) {
            $idEvento = $_GET['id']; // Obtenemos el idEvento desde la URL

            // Llamamos al modelo para eliminar el evento
            Evento::eliminar($idEvento);
        } else {
            // Si no se pasa el 'id', mostramos un error
            echo "No se ha proporcionado un ID de evento.";
        }
    }
}
