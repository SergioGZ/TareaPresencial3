<div class="container bg-light" style="height: 100vh;">
    <div class="row <?php if (isset($_COOKIE['color'])) { echo $_COOKIE['color']; } else { echo 'bg-black';} ?>" style="height:95px;">
        <div class="col-6">
            <h2 class="text-light m-4 pt-1 float-start">Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h2>
            <img class="img-fluid pt-3 float-start position-absolute" src="monitor.png" style="width: 50px;" />
        </div>
        <div class="col-6">
            <a class="float-end m-4 pt-1 btn btn-secondary" href="logout.php"><i class="bi bi-door-open-fill"></i> Cerrar sesión</a>
        </div>
    </div>