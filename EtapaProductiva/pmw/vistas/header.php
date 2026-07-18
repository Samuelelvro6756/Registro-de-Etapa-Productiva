<?php 
session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: logout.php"); // Redireccionar a la página de inicio de sesión si no ha iniciado sesión
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="stylesheet" href="/pmw/css/header.css">
    </head>

<nav class="navbar">
    <ul>
        <li><img src="../../css/imagenes/logo_politecnicomasterweb.png" alt="logo-politecnico" id="logo"></li>
        <li><a id="inicio" href="/pmw/modulos/inicio/inicio.php" class="<?= $pagina == 'inicio' ? 'active' : '' ?>"><i class="fa-solid fa-house"></i>Inicio</a></li>
        <li><a id="tecnico" href="/pmw/modulos/tecnico/tecnico.php" class="<?= $pagina == 'tecnico' ? 'active' : '' ?>"><i class="fa-solid fa-paperclip"></i>Tecnico</a></li>
        <li><a id="crear-tecnico" href="/pmw/modulos/tecnico/crearTecnico.php" class="<?= $pagina == 'crearTecnico' ? 'active' : '' ?>"><i class="fa-solid fa-square-plus"></i>Crear Tecnico</a></li>
        <li><a id="crear-estudiantes" href="/pmw/modulos/estudiante/crearEstudiante.php" class="<?= $pagina == 'crearEstudiantes' ? 'active' : '' ?>"><i class="fa-solid fa-user-plus"></i>Crear estudiantes</a></li>
        <li><a id="estudiantes" href="/pmw/modulos/estudiante/estudiantes.php" class="<?= $pagina == 'estudiantes' ? 'active' : '' ?>"><i class="fa-solid fa-user"></i>Estudiantes</a></li>
        <li><a id="logout" href="/pmw/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Cerrar sesión</a></li>
    </ul>
</nav>