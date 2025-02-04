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
        $eventosUsuario = Evento::obtenerTodos();
        $eventosGenerales = Evento::obtenerEventosGenerales();

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
            $nuevoEvento = [
                'nombre' => $_POST['nombre'],
                'fecha' => $_POST['fecha'],
                'descripcion' => $_POST['descripcion'],
                'asistencia' => true
            ];

            Evento::guardar($_POST['nombre'], $nuevoEvento);
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
        Evento::asistir($_GET['nombre']);
    }

    /**
     * Elimina un evento específico.
     *
     * Recoge el nombre del evento desde los parámetros GET y lo elimina
     * del sistema.
     *
     * @return void
     */
    public function eliminar()
    {
        Evento::eliminar($_GET['nombre']);
    }
}
