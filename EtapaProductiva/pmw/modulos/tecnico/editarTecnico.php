<?php
include("../../vistas/header.php");
include("../../config/db.php");

if (isset($_GET["id"])) {
    $cod_TecnicoE = $_GET["id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            $nombreTecnico = $_POST["nombreTecnico"];
            $stm = $pdo->prepare("UPDATE tecnico SET nombre_Tecnico = :nombre WHERE cod_Tecnico = :codigo");
            $stm->bindParam(':nombre', $nombreTecnico);
            $stm->bindParam(':codigo', $cod_TecnicoE);
            $stm->execute();

            // Muestra una alerta de éxito utilizando JavaScript
            echo "<script>alert('Actualización realizada correctamente'); window.location.href='tecnico.php';</script>";
            exit();
        } catch (PDOException $e) {
            // Muestra una alerta de error utilizando JavaScript
            echo "<script>alert('Error al actualizar: " . $e->getMessage() . "'); window.location.href='tecnico.php';</script>";
            exit();
        }
    }
}
?>

<head>
    <title>Editar Tecnico</title>
    <link rel="shorcut icon" href="../../css/imagenes/logo_politecnicomasterweb.ico">
    <link rel="stylesheet" href="../../css/tecnico/actualizar.css">
</head>

<div class="formulario_estudiantes">
    <form action="" method="post">
        <h1><?php echo $cod_TecnicoE; ?></h1>
        <input class="estilo" type="text" name="nombreTecnico">
        <button type="submit">Actualizar</button>
        <button><a href="tecnico.php">CANCELAR</a></button>
    </form>
</div>

<?php include("../../vistas/footer.php"); ?>
