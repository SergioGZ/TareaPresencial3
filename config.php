<?php
// Conexión a la base de datos usando PDO
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "bdBlog";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $msjConexion = "<div class='alert alert-success text-center'>Conectado a la  base de datos</div>";
    

    // Iniciar la transacción
    $conexion->beginTransaction();
    
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nick VARCHAR(50) NOT NULL,
            nombre VARCHAR(50) NOT NULL,
            apellidos VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL,
            rol INT NOT NULL,
            imagen_avatar VARCHAR(255) DEFAULT NULL
        )";
    $conexion->exec($sql);
    // Commit de la transacción
    if ($conexion->inTransaction()) {
        $conexion->commit();
        echo "Transacción completada exitosamente.";
    }
} catch (PDOException $ex) {
    $conexion->rollBack();
    $msjConexion = "<div class='alert alert-danger'>Error al conectar con la base de datos<br/>" . $ex->getMessage() . "</div>";
}
