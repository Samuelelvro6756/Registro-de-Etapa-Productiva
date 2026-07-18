<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Cerrando sesión</title>
        <script>
            window.onload = function () {
            alert("Acabas de cerrar sesión.");
            window.location.href = "index.php"; // Redirección automática después del mensaje
            }
        </script>
    </head>
</html>
