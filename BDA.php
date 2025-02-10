<?php
class BDA{
    function bda_creacion()
    {
        $host = "localhost";
        $rootUser = "root";  // Usuario root de phpMyAdmin en XAMPP/MAMP
        $rootPass = "";      // Contraseña vacía en XAMPP por defecto
    
        // Datos de la nueva base de datos y usuario
        $dbname = "CoasterMania";
        $usuario = "admin";
        $contrasena = "123";
    
        try {
            // Conectar como root para poder crear la base de datos y usuario
            $pdo = new PDO("mysql:host=$host", $rootUser, $rootPass);
    
            // Crear la nueva base de datos si no existe
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    
            // Crear un nuevo usuario y darle permisos si no existe
            $pdo->exec("
            CREATE USER IF NOT EXISTS '$usuario'@'%' IDENTIFIED BY '$contrasena';
            GRANT ALL PRIVILEGES ON $dbname.* TO '$usuario'@'%';
            FLUSH PRIVILEGES;
        ");
    
    
            // Conectar con el nuevo usuario a la base de datos
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $usuario, $contrasena);
    
    
            // Crear la base de datos si no existe
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname;");
    
            // Conectar a la nueva base de datos
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $usuario, $contrasena);
    
            // Crear las tablas
            $sql = "
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
            fabricante VARCHAR(25),
            altura INT,
            velocidad INT,
            tipo VARCHAR(50),
            ubicacion VARCHAR(200),
            fecha_inauguracion DATE,
            Valido ENUM('Si', 'No'),
            FOREIGN KEY (fabricante) REFERENCES Usuarios(idUsuario) 
                ON DELETE SET NULL ON UPDATE CASCADE
        );
        
        
        
        CREATE DATABASE IF NOT EXISTS ParqueAtracciones;
    USE ParqueAtracciones;
    
    
    SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'ParqueAtracciones';
    IF FOUND_ROWS() THEN
        INSERT IGNORE INTO Usuarios (nombreUsuario, contrasena, rol) VALUES
            ('Collado', '\$2y\$10\$l/FTXsBPknRP7ki3RX2Uaedck7luyfxyhXxcFGU8LkJYEo1khvzEm', 'administrador'),
            ('David', `\$2y\$10\$CPGJPYGEDObIUgGn7y2SVeW8iWBrjViR9Ae4OcVS1ydddiyXfWRCK`, 'usuario'),
            ('Intamin', '\$2y\$10\$VtBRGwSTfw.4kN2lDFq9ZOe2zRwxPwuBdZsLu/b4DKD8xwlNbzJz6', 'fabricante'),
            ('Iago', '\$2y\$10\$r26P/FdxKODDTqCrSEC5.ulud087DGWmKg4CJwguTQB3lnol5i3OS', 'usuario'),
            ('profe', '\$2y\$10\$GiynSpUzFYAOsjLVTK5l6uB8h/ziThKGak0u2Ihpl1K803fw5GIoq', 'administrador'),
            ('jorge', '\$2y\$10\$asrc7AhggEWFXjAI.enWBuMy3JpvUSbmB8TYxwMQ6.XCFix1Y4JNy', 'administrador');
    
        INSERT IGNORE INTO EventosGenerales (nombre, fecha, descripcion) VALUES
            ('Conferencia IAPA', '2024-09-12', 'Conferencia sobre el futuro de las montañas rusas.'),
            ('Expo de Parques de Diversiones', '2024-10-15', 'Exposición de nuevos productos y montañas rusas.'),
            ('Feria Internacional de Parques de Diversiones', '2024-11-05', 'Feria sobre las últimas innovaciones en parques de diversiones y entretenimiento.'),
            ('Simposio de Ingeniería en Entretenimiento', '2024-12-01', 'Simposio donde se presentan nuevos proyectos de ingeniería para parques de diversiones.');
    END IF;
    
    INSERT IGNORE INTO Usuarios (nombreUsuario, contrasena, rol) VALUES
        ('Intamin', 'default_password', 'fabricante'),
        ('Rocky Mountain Construction', 'default_password', 'fabricante'),
        ('Bolliger & Mabillard', 'default_password', 'fabricante'),
        ('Custom Coasters International', 'default_password', 'fabricante'),
        ('John Allen', 'default_password', 'fabricante'),
        ('Dinn Corporation', 'default_password', 'fabricante')
    
    
            
    INSERT IGNORE INTO MontañasRusas (nombre, fabricante, altura, velocidad, tipo, ubicacion, fecha_inauguracion, Valido) VALUES
        ('Batman: Gotham City Escape', 'Intamin', 43, 105, 'Multi-launch', 'Parque Warner Madrid, Madrid, España', '2023-05-13', 'Si'),
        ('Hakugei', 'Intamin', 63, 100, 'Coaster de lanzamiento', 'Nagashima Spa Land, Japón', '2021-03-20', 'Si'),
        ('Taiga', 'Intamin', 52, 106, 'Coaster de lanzamiento', 'Linnanmäki, Finlandia', '2019-05-17', 'Si'),
        ('Lightning Rod', 'Rocky Mountain Construction', 67, 112, 'Coaster de madera', 'Dollywood, USA', '2016-06-13', 'Si'),
        ('El Toro', 'Intamin', 57, 113, 'Coaster de madera', 'Six Flags Great Adventure, NJ, USA', '2006-06-18', 'Si'),
        ('Kingda Ka', 'Intamin', 139, 206, 'Coaster de lanzamiento', 'Six Flags Great Adventure, NJ, USA', '2005-05-21', 'Si'),
        ('Steel Dragon 2000', 'Dinn Corporation', 97, 153, 'Coaster de acero', 'Nagashima Spa Land, Japón', '2000-08-01', 'Si'),
        ('Fury 325', 'Bolliger & Mabillard', 99, 153, 'Coaster de altura alta', 'Carowinds, Charlotte, NC, USA', '2015-03-28', 'Si'),
        ('Millennium Force', 'Intamin', 94, 150, 'Coaster de acero', 'Cedar Point, Ohio, USA', '2000-05-13', 'Si'),
        ('Shambhala', 'Intamin', 249, 134, 'Coaster de acero', 'PortAventura Park, Salou, España', '2012-05-12', 'Si'),
        ('Taron', 'Intamin', 40, 117, 'Coaster de lanzamiento', 'Phantasialand, Alemania', '2016-06-30', 'Si'),
        ('Maverick', 'Intamin', 57, 112, 'Coaster de acero', 'Cedar Point, Ohio, USA', '2007-05-13', 'Si'),
        ('Twisted Colossus', 'Rocky Mountain Construction', 39, 105, 'Coaster de madera híbrida', 'Six Flags Magic Mountain, CA, USA', '2015-06-26', 'Si'),
        ('Bizarro', 'Bolliger & Mabillard', 46, 121, 'Coaster invertido', 'Six Flags New England, MA, USA', '2000-06-29', 'Si'),
        ('The Beast', 'The Gravity Group', 38, 113, 'Coaster de madera', 'Kings Island, OH, USA', '1979-04-14', 'Si'),
        ('Wicked Cyclone', 'Rocky Mountain Construction', 46, 103, 'Coaster de madera híbrida', 'Six Flags New England, MA, USA', '2015-05-24', 'Si'),
        ('Intimidator', 'Bolliger & Mabillard', 75, 120, 'Coaster de acero', 'Carowinds, Charlotte, NC, USA', '2010-03-27', 'Si'),
        ('Raging Bull', 'Bolliger & Mabillard', 67, 120, 'Coaster de acero', 'Six Flags Great America, IL, USA', '1999-05-01', 'Si'),
        ('Tatsu', 'Bolliger & Mabillard', 53, 100, 'Coaster invertido', 'Six Flags Magic Mountain, CA, USA', '2006-05-13', 'Si'),
        ('Dragon Khan', 'Bolliger & Mabillard', 45, 105, 'Coaster de acero', 'PortAventura Park, Salou, España', '1995-05-06', 'Si'),
        ('Nemesis', 'Bolliger & Mabillard', 12, 80, 'Coaster invertido', 'Alton Towers, Reino Unido', '1994-03-19', 'Si'),
        ('Screamin\' Eagle', 'John Allen', 43, 103, 'Coaster de madera', 'Six Flags St. Louis, MO, USA', '1976-06-19', 'Si'),
        ('Shivering Timbers', 'Custom Coasters International', 61, 106, 'Coaster de madera', 'Michigan\'s Adventure, MI, USA', '1998-05-23', 'Si')";
    
            $pdo->exec($sql);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
}

}
