<?php

/**
 * Clase Evento
 *
 * Esta clase gestiona las operaciones relacionadas con los eventos, tales como
 * obtener, guardar, compartir, eliminar, marcar asistencia y actualizar eventos.
 */
// spl_autoload_register(function ($clase) {
//     echo $clase;
//     require_once __DIR__ . "../controladores/$clase.php";
// });

class Evento
{
    /**
     * Obtiene todos los eventos generales almacenados.
     *
     * @return array Lista de todos los eventos generales.
     */
    public static function obtenerTodos()
    {
         return (new BDA())->obtenerEventos();    
    }

    /**
     * Obtiene los eventos generales disponibles.
     *
     * @return array Lista de eventos generales.
     */
    public static function obtenerEventosPersonales()
    {
        return (new BDA())->obtenerEventosPersonales();
    }
    /**
     * Guarda un nuevo evento en el sistema.
     *
     * Valida que la fecha del evento no sea una fecha pasada antes de guardarlo.
     *
     * @param string $nombreEvento Nombre del evento.
     * @param array $evento Datos del evento.
     * @return void
     */
    public static function guardar($nombre, $fecha, $descripcion, $asistencia)
    {
        $fechaEvento = strtotime($fecha);
        $fechaActual = strtotime(date('Y-m-d'));

        if ($fechaEvento < $fechaActual) {
            echo "No se pueden añadir eventos con fechas pasadas.";
            return;
        }
        
        (new BDA)->añadirEventoPersonal($nombre, $fecha, $descripcion, $asistencia);
       
    }

    /**
     * Comparte un evento con otro usuario.
     *
     * Valida que el evento y el usuario destino existan antes de realizar la acción.
     *
     * @param string $nEvetno Nombre del evento.
     * @param string $nUsuario Nombre del usuario con quien se compartirá el evento.
     * @return void
     */
    public static function compartir($nombreEvento, $nombreUsuario)
    {
        // Llamar a la función compartirEvento para manejar la lógica con la base de datos
        (new BDA)->compartirEvento($nombreEvento, $nombreUsuario);
    }
    
    

    /**
     * Elimina un evento del usuario actual.
     *
     * @param string $nombre Nombre del evento a eliminar.
     * @return void
     */
    public static function eliminar($nombre)
    {
        (new BDA)->eliminarEvento($nombre);
    }

    /**
     * Marca la asistencia de un usuario a un evento.
     *
     * @param string $nombre Nombre del evento.
     * @return void
     */
    public static function asistir($nombre)
    {
       (new BDA)->asistir($nombre);
        header('Location: index.php?accion=listar_eventos');
        exit();
    }

    /**
     * Actualiza la lista de eventos de un usuario eliminando aquellos con fechas pasadas.
     *
     * @return array Lista actualizada de eventos del usuario.
     */
    public static function actualizarEventosUsuario($nombre)
    {
        $data = Usuario::obtenerUsuario($nombre);
        $fechaActual = strtotime(date('Y-m-d'));
        $usuario = $_SESSION['user']['nombreUsuario'];

        foreach ($data[$usuario]['eventos'] as $key => $value) {
            if (strtotime($value['fecha']) < $fechaActual) {
                unset($data[$usuario]['eventos'][$key]);
            }
        }

        file_put_contents(__DIR__ . '/../data/usuarios.json', json_encode($data, JSON_PRETTY_PRINT));

        return $data[$usuario]['eventos'];
    }

}
