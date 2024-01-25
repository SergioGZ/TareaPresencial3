<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = $_POST['nick'];
    $password = $_POST['password'];

    try {
        $query = "SELECT * FROM usuarios WHERE nick=:nick AND password=:password";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':nick', $nick);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            // Inicio de sesión exitoso
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['loggedin'] = true;
            $_SESSION['nick'] = $nick;
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['rol'] = $user['rol'];
            $recordar = $_POST['recordar'];
            // Guardar usuario y contraseña en cookies
            if ($recordar == true) {
                setcookie('nick', $nick, time() + (86400 * 30), '/'); // Cookie válida por 30 días
                setcookie('password', $password, time() + (86400 * 30), '/'); // Cookie válida por 30 días
                setcookie('color', 'bg-danger', time() + (86400 * 30), '/'); // Cookie válida por 30 días

                if (!isset($_COOKIE['iniciosAdmins']) && ($user['rol'] == 1)) {
                    setcookie('iniciosAdmins', 1, time() + (86400 * 30), '/');
                    setcookie('ultimoLoginAdmin', date('Y-m-d H:i:s'), time() + (86400 * 30), '/');   
                } else if (isset($_COOKIE['iniciosAdmins']) && ($user['rol'] == 1)) {
                    $iniciosAdmins = $_COOKIE['iniciosAdmins'] + 1;
                    setcookie('iniciosAdmins', $iniciosAdmins, time() + (86400 * 30), '/');
                    setcookie('ultimoLoginAdmin', date('Y-m-d H:i:s'), time() + (86400 * 30), '/');
                }

                if (!isset($_COOKIE['iniciosUsers']) && ($user['rol'] == 0)) {
                    setcookie('iniciosUsers', 1, time() + (86400 * 30), '/');
                    setcookie('ultimoLoginUser', date('Y-m-d H:i:s'), time() + (86400 * 30), '/');    
                } else if (isset($_COOKIE['iniciosUsers']) && ($user['rol'] == 0)) {
                    $iniciosUsers = $_COOKIE['iniciosUsers'] + 1;
                    setcookie('iniciosUsers', $iniciosUsers, time() + (86400 * 30), '/');
                    setcookie('ultimoLoginUser', date('Y-m-d H:i:s'), time() + (86400 * 30), '/');
                }
            }

            if ($user['rol'] == 1) {
                header('Location: admin.php');
            } else {
                header('Location: users.php');
            }

            exit;
        } else {
            $error = '<div class="alert alert-danger w-50 text-center m-auto">Debe iniciar sesión para acceder a la web</div>';
        }
    } catch (PDOException $e) {
        die("Error al ejecutar la consulta: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="stylesheet" href="login.css">
  <title>Blog</title>
</head>
<body>
    <?php if (isset($error)) {
        echo "<p>$error</p>";
    } ?>

    <?php
    // Verificar si existen cookies de "nick" y "password"
        if (isset($_COOKIE['nick']) && isset($_COOKIE['password'])) {
            $nick = $_COOKIE['nick'];
            $password = $_COOKIE['password'];
            $recordar = true;
        } else {
            $nick = '';
            $password = '';
            $recordar = false;
        }
    ?>
    <section>
        <div class="form-box">
            <div class="form-value">
            <h2>Tarea Presencial</h2>
                <form method="post" action="login.php">
                    <h2>Inicio de sesión</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" name="nick" value="<?php echo $nick ?>" required>
                        <label for="nick">Nick</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" value="<?php echo $password ?>" required>
                        <label for="password">Contraseña</label>
                    </div>
                    <div class="forget">
                        <label for=""><input type="checkbox" name="recordar" <?php if ($recordar == true) { echo 'checked'; } ?>>Recordar</label>
                        <label for=""><input type="checkbox" name="recordar" <?php //if ($recordar == true) { echo 'checked'; } ?>>Mantener sesión iniciada</label>            
                    </div>
                    <button type="submit">Iniciar sesión</button>
                    <div class="register">
                        <p>¿No tienes acceso? <a href="#">Regístrate</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>