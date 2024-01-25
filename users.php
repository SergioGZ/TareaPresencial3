<?php
session_start();
require_once 'config.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

    <?php include 'includes/header.php'; ?>

    <div class="row">
        <div class="col-12 w-50 my-5">
            <?php $iniciosUsers = $_COOKIE['iniciosUsers'];
            echo "<div class='alert alert-info'>Inicios de sesión: $iniciosUsers</div>";

            $nick = $_SESSION['nick'];
            $ultimoInicio = $_COOKIE['ultimoLoginUser'];
            if ($iniciosUsers == 1) {
                echo "<div class='alert alert-warning'>¡Bienvenido! $nick Este es tu primer inicio de sesión.</div>";
            } else {
                echo "<div class='alert alert-warning'>Hola de nuevo, $nick :)!!  tu última visita fue el $ultimoInicio</div>";
            }
            ?>

            <div class="menu">
                <a href="c.php" class="btn btn-primary">Ir a C</a>
                <a href="d.php" class="btn btn-primary">Ir a D</a>
            </div>
        </div>
    </div>
</body>

</html>