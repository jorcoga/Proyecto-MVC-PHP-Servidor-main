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
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
                    ('Iago', '\$2y\$10\$r26P/FdxKODDTqCrSEC5.ulud087DGWmKg4CJwguTQB3lnol5i3OS', 'usuario'),
                    ('profe', '\$2y\$10\$GiynSpUzFYAOsjLVTK5l6uB8h/ziThKGak0u2Ihpl1K803fw5GIoq', 'administrador'),
                    ('jorge', '\$2y\$10\$asrc7AhggEWFXjAI.enWBuMy3JpvUSbmB8TYxwMQ6.XCFix1Y4JNy', 'administrador');

                INSERT IGNORE INTO EventosGenerales (nombre, fecha, descripcion) VALUES
                    ('Conferencia IAPA', '2024-09-12', 'Conferencia sobre el futuro de las montañas rusas.'),
                    ('Expo de Parques de Diversiones', '2024-10-15', 'Exposición de nuevos productos y montañas rusas.');

                INSERT IGNORE INTO MontañasRusas (nombre, fabricante, altura, velocidad, tipo, ubicacion, fecha_inauguracion, Valido) VALUES
                    ('Batman: Gotham City Escape', 'Intamin', 43, 105, 'Multi-launch', 'Parque Warner Madrid, España', '2023-05-13', 'Si'),
                    ('Hakugei', 'Intamin', 63, 100, 'Coaster de lanzamiento', 'Nagashima Spa Land, Japón', '2021-03-20', 'Si'),
                    ('Kingda Ka', 'Intamin', 139, 206, 'Coaster de lanzamiento', 'Six Flags Great Adventure, USA', '2005-05-21', 'Si'),
                    ('Shambhala', 'Bolliger & Mabillard', 249, 134, 'Coaster de acero', 'PortAventura Park, España', '2012-05-12', 'Si'),
                    ('Nemesis', 'Bolliger & Mabillard', 12, 80, 'Coaster invertido', 'Alton Towers, Reino Unido', '1994-03-19', 'Si');
            ";
            $pdo->exec($sqlInserts);

        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

$bda = new BDA();
$bda->bda_creacion();
