<?php

/**
 * Controlador para la gestión de montañas rusas.
 * Este controlador maneja acciones como listar, agregar, eliminar y validar montañas rusas.
 */
require_once __DIR__ . '/../modelos/MontanaRusa.php';

class MontañaRusaControlador
{
    /**
     * Muestra las listas de montañas rusas.
     *
     * Llama al modelo para obtener y mostrar las listas de montañas rusas
     * correspondientes.
     *
     * @return void
     */
    public function index()
    {
        MontanaRusa::mostrarListas();
    }

    /**
     * Agrega una nueva montaña rusa al sistema.
     *
     * Si la solicitud es POST, recoge los datos enviados desde el formulario,
     * verifica si el usuario tiene permisos para agregar, y guarda la nueva
     * montaña rusa.
     * Finalmente, muestra la vista del formulario para agregar montañas rusas.
     *
     * @return void
     */
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar permisos según el rol del usuario
            $valido = ($_SESSION["user"]["rol"] == "fabricante" || $_SESSION["user"]["rol"] == "administrador") ? "Si" : "No";

            // Crear el array con los datos de la nueva montaña rusa
            $nuevaMontaña = [
                'nombre' => $_POST['nombre'],
                'velocidad' => $_POST['velocidad'],
                'altura' => $_POST['altura'],
                'fabricante' => $_POST['fabricante'],
                'tipo' => $_POST['tipo'],
                'ubicacion' => $_POST['ubicacion'],
                'fecha_inauguracion' => $_POST['fecha_inauguracion'],
                'Valido' => $valido
            ];

            // Guardar la nueva montaña rusa
            MontanaRusa::guardar($nuevaMontaña);
        }

        // Mostrar el formulario para agregar una nueva montaña rusa
        require_once __DIR__ . '/../vistas/montanas_rusas/agregar_montana.php';
    }

    /**
     * Elimina una montaña rusa específica del sistema.
     *
     * Recoge el identificador de la montaña rusa desde los parámetros GET
     * y la elimina del sistema.
     *
     * @return void
     */
    public function eliminar()
    {
        MontanaRusa::eliminar($_GET['atraccion']);
    }

    /**
     * Valida una montaña rusa.
     *
     * Llama al modelo para marcar como válida la montaña rusa
     * identificada por el parámetro `atraccion`.
     *
     * @return void
     */
    public function validar()
    {
        MontanaRusa::validar($_GET['atraccion']);
    }
}
