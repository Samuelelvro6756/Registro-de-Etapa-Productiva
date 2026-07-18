<?php
    $pagina = 'inicio';
    include('../../vistas/header.php'); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Plataforma de Etapa Productiva</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../../css/inicio/inicio.css">
  <link rel="shorcut icon" href="../../css/imagenes/logo_politecnicomasterweb.ico">
</head>
    <body>

    <header>
    <h1>Plataforma Etapa Productiva</h1>
    </header>

    <section class="hero" id="inicio">
    <h1>Gestión Eficiente de la Etapa Productiva</h1>
    <p>Accede, administra y supervisa el proceso de prácticas, asesorías y seguimientos en un solo lugar.</p>
    <a href="../estudiante/estudiantes.php" id="btn">Inicia ahora<i class="fa-solid fa-arrow-right"></i></a>
    </section>

    <section class="features" id="funciones">
    <div class="feature">
        <h3>Registro de Estudiantes</h3>
        <p>Administra información personal y académica de los estudiantes en práctica.</p>
    </div>
    <div class="feature">
        <h3>Agendamiento de Citas</h3>
        <p>Coordina asesorías y seguimientos de manera sencilla y eficiente.</p>
    </div>
    <div class="feature">
        <h3>Reportes y Seguimiento</h3>
        <p>Genera informes sobre el desempeño y progreso del estudiante en su etapa productiva.</p>
    </div>
    </section>

    <section class="about" id="sobre">
    <h2>¿Qué es esta plataforma?</h2>
    <p>Es una herramienta desarrollada para facilitar el control y monitoreo de los procesos relacionados con la etapa productiva de estudiantes. Aquí, tanto estudiantes como asesores pueden llevar un seguimiento estructurado y transparente de las actividades y resultados.</p>
    </section>

    </body>
</html>
