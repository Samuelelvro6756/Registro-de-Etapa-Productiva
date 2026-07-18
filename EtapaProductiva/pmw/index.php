<?php
session_start();

$error = "";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: modulos/estudiante/estudiantes.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('config/db.php');

    try {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        $stm = $pdo->prepare("CALL ValidadorrCredenciales(?, ?)");
        $stm->bindParam(1, $usuario, PDO::PARAM_STR);
        $stm->bindParam(2, $contrasena, PDO::PARAM_STR);
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['Mensaje'] === 'Credenciales válidas') {
            $_SESSION['logged_in'] = true;

            // Mostrar alerta cuando el acceso sea concedido
            echo '<script type="text/javascript">alert("Acceso concedido. ¡Bienvenido!"); window.location.href="modulos/inicio/inicio.php";</script>';
            exit();
        } else {
            $error = "Credenciales inválidas";
        }
    } catch (PDOException $e) {
        $error = "Error al procesar las credenciales";
        echo "ERROR: " . $e->getMessage();
    }
}
?>

<head>
    <title>Iniciar Sesión</title>
    <link rel="shorcut icon" href="css/imagenes/logo_politecnicomasterweb.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <?php if (!empty($error)) { ?>
            <div class="error-message">
                <i class="fa-solid fa-circle-xmark"></i>
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form id="login-form" method="post" action="">
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" id="username" name="usuario" placeholder="Nombre de usuario" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" name="contrasena" placeholder="Contraseña" required>
            </div>
            <button type="submit">Iniciar Sesión<i class="fa-solid fa-arrow-right"></i></button>
        </form>
    </div>
    <img src="css/imagenes/logo_politecnicomasterweb.png" alt="LogoPMW" class="logo-pmw">
</body>
