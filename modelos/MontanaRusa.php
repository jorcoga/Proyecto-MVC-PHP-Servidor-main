<?php

/**
 * Clase que maneja las operaciones relacionadas con las montañas rusas.
 */
class MontanaRusa
{
    /**
     * Obtiene todas las montañas rusas desde el archivo JSON.
     *
     * @return array Devuelve un arreglo asociativo con los datos de todas las montañas rusas.
     */
    public static function obtenerTodas()
    {
        return (new BDA())->obtenerMontanasRusas();
    }

    /**
     * Muestra las listas de montañas rusas según el rol del usuario.
     * 
     * Los usuarios con rol de "fabricante" verán una vista, los administradores otra
     * y los usuarios normales tendrán una vista diferente.
     */
    public static function mostrarListas()
    {
        // Leer el archivo JSON con las montañas rusas
        $data = self::obtenerTodas();

        // Asignar las montañas rusas a la variable
        $montanasRusasGenerales = $data ?? [];

        // Cargar la vista correspondiente según el rol del usuario
        if ($_SESSION['user']['rol'] == "fabricante") {
            require_once __DIR__ . '/../vistas/montanas_rusas/lista_fabricantes.php';
        } elseif ($_SESSION['user']['rol'] == "administrador") {
            require_once __DIR__ . '/../vistas/montanas_rusas/lista_administrador.php';
        } else {
            require_once __DIR__ . '/../vistas/montanas_rusas/lista_usuarios.php';
        }
    }

    /**
     * Guarda una nueva montaña rusa.
     *
     * @param array $nuevaMontaña Datos de la nueva montaña rusa que se desea agregar.
     */
    public static function guardar($nuevaMontaña)
    {
        (new BDA)->añadirMontañaRusa($nuevaMontaña);

        
    }

    /**
     * Almacena los datos de las montañas rusas en el archivo JSON.
     *
     * @param array $data Datos de las montañas rusas que se van a guardar.
     */
    public static function almacenar($data)
    {
        // Guardar las montañas rusas actualizadas en el archivo JSON
        file_put_contents(__DIR__ . '/../data/montanas_rusas.json', json_encode($data, JSON_PRETTY_PRINT));

        // Redirigir a la página de inicio de las montañas rusas
        header('Location: index.php?accion=index');
        exit();
    }

    /**
     * Elimina una montaña rusa por su nombre.
     *
     * @param string $nombre El nombre de la montaña rusa a eliminar.
     */
    public static function eliminar($nombre)
    {
        (new BDA)->eliminarMontanaRusa($nombre);
        header('Location: index.php?accion=index');
    }

    /**
     * Marca una montaña rusa como válida.
     *
     * @param string $nombre El nombre de la montaña rusa a validar.
     */
    public static function validar($nombre)
    {
        // Obtener las montañas rusas existentes
        $data = self::obtenerTodas();

        // Marcar la montaña rusa como válida
        $data[$nombre]['Valido'] = 'Si';

        // Almacenar los datos actualizados
        self::almacenar($data);
    }
}
