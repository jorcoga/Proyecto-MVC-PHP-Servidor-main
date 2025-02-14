<?php
class BDA
{
    function bda_creacion()
    {
        $host = "localhost";
        $dbname = "CoasterMania";
        $usuario = "CoasterMania";  // Cambia a "CoasterMania" solo si el usuario ya tiene permisos adecuados
        $contrasena = "123";    // En XAMPP, la contraseña de root suele ser vacía

        try {
            // Conectar con root para crear la base de datos y asignar permisos
            $pdo = new PDO("mysql:host=$host;", $usuario, $contrasena);

            // Crear la base de datos si no existe
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

            // Conectar a la base de datos
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;", $usuario, $contrasena);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear las tablas
            $sql = "
                USE $dbname;

                CREATE TABLE IF NOT EXISTS Usuarios (
                    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
                    nombreUsuario VARCHAR(100) UNIQUE NOT NULL,
                    contrasena VARCHAR(255) NOT NULL,
                    rol ENUM('administrador', 'usuario', 'fabricante') NOT NULL
                );

                CREATE TABLE IF NOT EXISTS EventosGenerales (
                    idEvento INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL,
                    fecha DATE NOT NULL,
                    descripcion TEXT
                );

                CREATE TABLE IF NOT EXISTS EventosPersonales (
                    idEvento INT AUTO_INCREMENT PRIMARY KEY,
                    idUsuario INT NOT NULL,
                    nombre VARCHAR(100) NOT NULL,
                    fecha DATE NOT NULL,
                    descripcion TEXT,
                    asistencia BOOLEAN,
                    FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario) ON DELETE CASCADE
                );

                CREATE TABLE IF NOT EXISTS MontañasRusas (
                    idMontaña INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL UNIQUE,
                    fabricante VARCHAR(50),
                    altura INT,
                    velocidad INT,
                    tipo VARCHAR(50),
                    ubicacion VARCHAR(200),
                    fecha_inauguracion DATE,
                    Valido ENUM('Si', 'No'),
                    FOREIGN KEY (fabricante) REFERENCES Usuarios(nombreUsuario) ON DELETE SET NULL ON UPDATE CASCADE
                );";
            $pdo->exec($sql);

            // Insertar datos
            $sqlInserts = "
                INSERT IGNORE INTO Usuarios (nombreUsuario, contrasena, rol) VALUES
                    ('Collado', '\$2y\$10\$l/FTXsBPknRP7ki3RX2Uaedck7luyfxyhXxcFGU8LkJYEo1khvzEm', 'administrador'),
                    ('David', '\$2y\$10\$CPGJPYGEDObIUgGn7y2SVeW8iWBrjViR9Ae4OcVS1ydddiyXfWRCK', 'usuario'),
                    ('Intamin', '\$2y\$10\$VtBRGwSTfw.4kN2lDFq9ZOe2zRwxPwuBdZsLu/b4DKD8xwlNbzJz6', 'fabricante'),
                    ('Bolliger & Mabillard', '\$2y\$10\$VtBRGwSTfw.4kN2lDFq9ZOe2zRwxPwuBdZsLu/b4DKD8xwlNbzJz6', 'fabricante'),
                    ('Rocky Mountain Construction', '\$2y\$10\$VtBRGwSTfw.4kN2lDFq9ZOe2zRwxPwuBdZsLu/b4DKD8xwlNbzJz6', 'fabricante'),
                    ('Arrow Dynamics', '\$2y\$10\$VtBRGwSTfw.4kN2lDFq9ZOe2zRwxPwuBdZsLu/b4DKD8xwlNbzJz6', 'fabricante'),
                    ('Iago', '\$2y\$10\$r26P/FdxKODDTqCrSEC5.ulud087DGWmKg4CJwguTQB3lnol5i3OS', 'usuario'),
                    ('profe', '\$2y\$10\$GiynSpUzFYAOsjLVTK5l6uB8h/ziThKGak0u2Ihpl1K803fw5GIoq', 'administrador'),
                    ('jorge', '\$2y\$10\$asrc7AhggEWFXjAI.enWBuMy3JpvUSbmB8TYxwMQ6.XCFix1Y4JNy', 'administrador');


                -- Insertar eventos solo si no existen ya
                    INSERT INTO EventosGenerales (nombre, fecha, descripcion)
                    SELECT * FROM (SELECT 'Conferencia IAPA', '2024-09-12', 'Conferencia sobre el futuro de las montañas rusas.') AS tmp
                    WHERE NOT EXISTS (SELECT 1 FROM EventosGenerales WHERE nombre = 'Conferencia IAPA')
                    LIMIT 1;

                    INSERT INTO EventosGenerales (nombre, fecha, descripcion)
                    SELECT * FROM (SELECT 'Expo de Parques de Diversiones', '2024-10-15', 'Exposición de nuevos productos y montañas rusas.') AS tmp
                    WHERE NOT EXISTS (SELECT 1 FROM EventosGenerales WHERE nombre = 'Expo de Parques de Diversiones')
                    LIMIT 1;



INSERT IGNORE INTO MontañasRusas (nombre, fabricante, altura, velocidad, tipo, ubicacion, fecha_inauguracion, Valido) 
VALUES
    ('Batman: Gotham City Escape', 'Intamin', 43, 105, 'Multi-launch', 'Parque Warner Madrid, España', '2023-05-13', 'Si'),
    ('Hakugei', 'Intamin', 63, 100, 'Híbrida de lanzamiento', 'Nagashima Spa Land, Japón', '2021-03-20', 'Si'),
    ('Kingda Ka', 'Intamin', 139, 206, 'Coaster de lanzamiento', 'Six Flags Great Adventure, USA', '2005-05-21', 'Si'),
    ('Shambhala', 'Bolliger & Mabillard', 76, 134, 'Coaster de acero', 'PortAventura Park, España', '2012-05-12', 'Si'),
    ('Nemesis', 'Bolliger & Mabillard', 12, 80, 'Coaster invertida', 'Alton Towers, Reino Unido', '1994-03-19', 'Si'),
    ('Steel Vengeance', 'Rocky Mountain Construction', 62, 119, 'Híbrida de madera y acero', 'Cedar Point, USA', '2018-05-05', 'Si'),
    ('Formula Rossa', 'Intamin', 52, 240, 'Coaster de lanzamiento', 'Ferrari World, Emiratos Árabes', '2010-11-04', 'Si'),
    ('Fury 325', 'Bolliger & Mabillard', 99, 153, 'Giga coaster', 'Carowinds, USA', '2015-03-28', 'Si'),
    ('Top Thrill 2', 'Intamin', 128, 193, 'Coaster de lanzamiento', 'Cedar Point, USA', '2024-05-01', 'Si'),
    ('The Ride to Happiness', 'Mack Rides', 33, 90, 'Coaster de lanzamiento giratoria', 'Plopsaland De Panne, Bélgica', '2021-07-01', 'Si'),
    ('Zadra', 'Rocky Mountain Construction', 62, 121, 'Híbrida de madera y acero', 'Energylandia, Polonia', '2019-08-22', 'Si'),
    ('Intimidator 305', 'Intamin', 93, 145, 'Giga coaster', 'Kings Dominion, USA', '2010-04-02', 'Si'),
    ('Lightning Rod', 'Rocky Mountain Construction', 50, 117, 'Coaster híbrida de lanzamiento', 'Dollywood, USA', '2016-06-13', 'Si'),
    ('Millennium Force', 'Intamin', 94, 150, 'Giga coaster', 'Cedar Point, USA', '2000-05-13', 'Si'),
    ('Taron', 'Intamin', 30, 117, 'Multi-launch coaster', 'Phantasialand, Alemania', '2016-06-30', 'Si'),
    ('Expedition GeForce', 'Intamin', 53, 120, 'Mega coaster', 'Holiday Park, Alemania', '2001-06-18', 'Si'),
    ('El Toro', 'Intamin', 55, 112, 'Wooden coaster', 'Six Flags Great Adventure, USA', '2006-06-11', 'Si'),
    ('X2', 'Arrow Dynamics', 53, 122, '4D coaster', 'Six Flags Magic Mountain, USA', '2002-01-12', 'Si'),
    ('VelociCoaster', 'Intamin', 47, 112, 'Multi-launch coaster', 'Universal’s Islands of Adventure, USA', '2021-06-10', 'Si'),
    ('Skyrush', 'Intamin', 61, 121, 'Hyper coaster', 'Hersheypark, USA', '2012-05-26', 'Si'),
    ('Hyperion', 'Intamin', 77, 142, 'Mega coaster', 'Energylandia, Polonia', '2018-07-14', 'Si'),
    ('Storm Coaster', 'Intamin', 50, 77, 'Launch coaster', 'Dubai Hills Mall, Emiratos Árabes', '2022-03-01', 'Si'),
    ('Silver Star', 'Bolliger & Mabillard', 73, 127, 'Hyper coaster', 'Europa-Park, Alemania', '2002-03-23', 'Si'),
    ('Maverick', 'Intamin', 32, 112, 'Multi-launch coaster', 'Cedar Point, USA', '2007-05-26', 'Si'),
    ('Monster', 'Bolliger & Mabillard', 40, 90, 'Invertida', 'Gröna Lund, Suecia', '2021-06-04', 'Si'),
    ('Orion', 'Bolliger & Mabillard', 87, 146, 'Giga coaster', 'Kings Island, USA', '2020-07-02', 'Si'),
    ('The Smiler', 'Gerstlauer', 30, 85, 'Infinity coaster', 'Alton Towers, Reino Unido', '2013-05-31', 'Si'),
    ('Time Traveler', 'Mack Rides', 30, 80, 'Launch spinning coaster', 'Silver Dollar City, USA', '2018-03-14', 'Si'),
    ('Copperhead Strike', 'Mack Rides', 25, 82, 'Multi-launch coaster', 'Carowinds, USA', '2019-03-23', 'Si');
";
            $pdo->exec($sqlInserts);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    function conexion()
    {
        try {
            // Configurar la conexión a la base de datos
            $host = "localhost";
            $dbname = "CoasterMania";
            $usuario = "CoasterMania"; // Cambia esto si usas otro usuario
            $contrasena = "123";

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $usuario, $contrasena);

            return $pdo;
        } catch (Exception $e) {
            die("Error al conectar la base de datos " . $e->getMessage());
        }
    }
    function obtenerEventos()
    {
        try {
            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();

            $sql = "SELECT idEvento, nombre, fecha, descripcion FROM EventosGenerales";
            // Preparar y ejecutar la consulta
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            // Obtener los resultados como un array asociativo
            $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $eventos;
        } catch (PDOException $e) {
            die("Error al obtener Eventos: " . $e->getMessage());
        }
    }

    function obtenerEventosPersonales()
    {
        try {
            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();

            $sql = "SELECT ep.idEvento, ep.nombre, ep.fecha, ep.descripcion, ep.asistencia 
        FROM EventosPersonales ep
        INNER JOIN Usuarios u ON ep.idUsuario = u.idUsuario
        WHERE u.nombreUsuario = :nombreUsuario";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":nombreUsuario", $_SESSION["user"]["nombreUsuario"], PDO::PARAM_STR);
            $stmt->execute();
            $eventosUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $eventosUsuario;
        } catch (PDOException $e) {
            die("Error al obtener Eventos: " . $e->getMessage());
        }
    }

    function obtenerMontanasRusas()
    {
        try {
            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();

            // Consulta SQL para obtener las montañas rusas
            $sql = "SELECT * FROM MontañasRusas";

            // Preparar y ejecutar la consulta
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            // Obtener los resultados como un array asociativo
            $montanasRusas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $montanasRusas;
        } catch (PDOException $e) {
            die("Error al obtener Montañas Rusas: " . $e->getMessage());
        }
    }


    function añadirMontañaRusa($nuevaMontaña)
    {
        try {
            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();
            $sql = "INSERT INTO MontañasRusas (nombre, velocidad, altura, tipo, ubicacion, fecha_inauguracion, fabricante, valido) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            // Vinculamos los valores a los signos de interrogación
            $stmt->bindParam(1, $nuevaMontaña['nombre']);
            $stmt->bindParam(2, $nuevaMontaña['velocidad']);
            $stmt->bindParam(3, $nuevaMontaña['altura']);
            $stmt->bindParam(4, $nuevaMontaña['tipo']);
            $stmt->bindParam(5, $nuevaMontaña['ubicacion']);
            $stmt->bindParam(6, $nuevaMontaña['fecha_inauguracion']);
            $stmt->bindParam(7, $nuevaMontaña['fabricante']);
            $stmt->bindParam(8, $nuevaMontaña['valido']);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error al obtener Montañas Rusas: " . $e->getMessage());
        }
    }

    function buscarUsuario($nombre)
    {
        try {
            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();


            $sql = "SELECT idUsuario, nombreUsuario, rol FROM Usuarios WHERE nombreUsuario = ?";

            // Preparar la consulta
            $stmt = $pdo->prepare($sql);

            // Vincular el parámetro de la consulta con el valor del ID
            $stmt->bindParam(1, $nombre);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el resultado como un array asociativo
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                return $usuario;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            die("Error al obtener Montañas Rusas: " . $e->getMessage());
        }
    }

    function buscarContrasena($nombre)
    {
        try {
            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();

            $sql = "SELECT contrasena FROM Usuarios WHERE nombreUsuario = ?";

            // Preparar la consulta
            $stmt = $pdo->prepare($sql);

            // Vincular el parámetro con el valor del nombre
            $stmt->bindValue(1, trim($nombre), PDO::PARAM_STR); // trim() elimina espacios extra        
            // Ejecutar la consulta
            $stmt->execute();

            // Obtener solo el valor de la contraseña
            $contrasena[] = $stmt->fetchColumn();

            return $contrasena;
        } catch (PDOException $e) {
            die("Error al obtener la contraseña: " . $e->getMessage());
        }
    }

    function introducirUsuarios($nombreUsuario, $contrasena, $rol)
    {
        try {
            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();


            $sql = "INSERT INTO Usuarios (nombreUsuario, contrasena, rol) VALUES (:nombreUsuario, :contrasena, :rol)";

            // Preparar la consulta
            $stmt = $pdo->prepare($sql);

            // Vincular el parámetro de la consulta con el valor del ID
            $stmt->bindParam(":nombreUsuario", $nombreUsuario);
            $stmt->bindParam(":contrasena", $contrasena);
            $stmt->bindParam(":rol", $rol);


            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el resultado como un array asociativo
            $contrasena = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function eliminarMontanaRusa($nombre)
    {
        try {
            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();


            $sql = "DELETE FROM MontañasRusas WHERE nombre = :nombre";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar la montaña rusa: " . $e->getMessage();
        }
    }
    function asistir($idEvento)
{
    
    try {
        // Configurar la conexión a la base de datos
        $pdo = (new BDA)->conexion();

        // Obtener el ID del usuario desde la sesión
        $idUsuario = $_SESSION['user']['idUsuario']; // Asegúrate de que la sesión tiene el ID del usuario

        // Consulta para actualizar la asistencia en la base de datos usando el idEvento
        $sql = "UPDATE EventosPersonales SET asistencia = 1 WHERE idUsuario = ? AND idEvento = ?";
        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta con el ID del usuario y el ID del evento
        $stmt->execute([$idUsuario, $idEvento]);
    } catch (PDOException $e) {
        // Manejo de errores si ocurre algún problema con la base de datos
        die("Error al actualizar la asistencia: " . $e->getMessage());
    }
}


    function añadirEventoPersonal($nombreEvento, $fecha, $descripcion, $asistencia)
    {
        try {
            // Validar la fecha
            if (!strtotime($fecha)) {
                throw new Exception("Fecha inválida.");
            }

            // Configurar la conexión a la base de datos
            $pdo = (new BDA)->conexion();

            // Consulta para insertar un nuevo evento
            $sql = "INSERT INTO EventosPersonales (idUsuario, nombre, fecha, descripcion, asistencia) 
                VALUES (:idUsuario, :nombre, :fecha, :descripcion, :asistencia)";

            $stmt = $pdo->prepare($sql);
     
            // Bind de parámetros con tipos correctos
            $stmt->bindValue(":idUsuario", $_SESSION['user']['idUsuario'], PDO::PARAM_INT);
            $stmt->bindValue(":nombre", $nombreEvento, PDO::PARAM_STR);
            $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
            $stmt->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(":asistencia", $asistencia, PDO::PARAM_BOOL);

            // Ejecutar la consulta
            $stmt->execute();

            return true; // Éxito
        } catch (Exception $e) {
            error_log("Error al añadir evento personal: " . $e->getMessage());
            return false; // Fallo
        }
    }



    function compartirEvento($nombreEvento, $nombreUsuario)
    {
        try {
            $pdo = (new BDA)->conexion();

            // ID del usuario actual desde la sesión
            $idUsuarioOrigen = $_SESSION['user']['idUsuario'];

            // Obtener ID del usuario destino
            $stmt = $pdo->prepare("SELECT idUsuario FROM Usuarios WHERE nombreUsuario = ?");
            $stmt->execute([$nombreUsuario]);
            $idUsuarioDestino = $stmt->fetchColumn();

            if (!$idUsuarioDestino) {
                echo "El usuario destino no existe.";
                return;
            }

            // Verificar si el evento pertenece al usuario actual
            $stmt = $pdo->prepare("SELECT nombre, fecha, descripcion FROM EventosPersonales WHERE idUsuario = ? AND nombre = ?");
            $stmt->execute([$idUsuarioOrigen, $nombreEvento]);
            $evento = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$evento) {
                echo "El evento no existe o no pertenece al usuario.";
                return;
            }

            // Insertar el evento para el nuevo usuario con asistencia en "false"
            $sql = "INSERT INTO EventosPersonales (idUsuario, nombre, fecha, descripcion, asistencia) 
                    VALUES (:idUsuario, :nombre, :fecha, :descripcion, 0)";
            $stmt = $pdo->prepare($sql);

            // Usar los valores extraídos del evento original
            $stmt->bindParam(":idUsuario", $idUsuarioDestino, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $evento['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(":fecha", $evento['fecha'], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $evento['descripcion'], PDO::PARAM_STR);

            $stmt->execute();

            echo "Evento compartido correctamente con $nombreUsuario.";
        } catch (PDOException $e) {
            die("Error al compartir el evento: " . $e->getMessage());
        }
    }


    function obtenerMontanasPorFabricante($nombreUsuario)
    {
        try {
            $pdo = (new BDA)->conexion();

            // Consulta para obtener montañas rusas fabricadas por el usuario actual
            $sql = "SELECT * FROM MontañasRusas WHERE fabricante = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombreUsuario]);

            // Obtener resultados como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener montañas rusas del fabricante: " . $e->getMessage());
            return [];
        }
    }

    public static function eliminarEvento($idEvento)
    {
        try {
            // Conexión a la base de datos
            $pdo = (new BDA)->conexion();

            // Obtener el ID del usuario desde la sesión
            $idUsuario = $_SESSION['user']['idUsuario'];  // Asegúrate de que esta clave esté en la sesión

            // Consulta SQL para eliminar el evento
            $sql = "DELETE FROM EventosPersonales WHERE idUsuario = ? AND idEvento = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(2, $idEvento, PDO::PARAM_INT);
            header('Location: index.php?accion=listar_eventos');
            // Ejecutar la consulta
            $stmt->execute();

        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al eliminar el evento: " . $e->getMessage());
        }
    }
    

}
// CREATE TABLE IF NOT EXISTS Usuarios (
//     idUsuario INT AUTO_INCREMENT PRIMARY KEY,
//     nombreUsuario VARCHAR(100) UNIQUE NOT NULL,
//     contrasena VARCHAR(255) NOT NULL,
//     rol ENUM('administrador', 'usuario', 'fabricante') NOT NULL
// );

// CREATE TABLE IF NOT EXISTS EventosGenerales (
//     idEvento INT AUTO_INCREMENT PRIMARY KEY,
//     nombre VARCHAR(100) NOT NULL,
//     fecha DATE NOT NULL,
//     descripcion TEXT
// );

// CREATE TABLE IF NOT EXISTS EventosPersonales (
//     idEvento INT AUTO_INCREMENT PRIMARY KEY,
//     idUsuario INT NOT NULL,
//     nombre VARCHAR(100) NOT NULL,
//     fecha DATE NOT NULL,
//     descripcion TEXT,
//     asistencia BOOLEAN,
//     FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario) ON DELETE CASCADE
// );
