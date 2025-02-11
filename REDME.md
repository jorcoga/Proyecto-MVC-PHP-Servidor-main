# Cambiar permisos
> Necesitamos cambiar los permisos de la carpeta padre del proyecto.
```
sudo chmod 666 ./
```

# Crear Usuario
> Crear un usaurio para la creacion de la base de datos
```
CREATE USER 'CoasterMania'@'localhost' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON *.* TO 'CoasterMania'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```