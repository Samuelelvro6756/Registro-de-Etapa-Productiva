<?php
include("../../../config/db.php");
include("../../../vistas/header.php");
?>

<?php

if (isset($_GET['id'])) {
    $cod_Est = $_GET['id'];

    $stm = $pdo->prepare("SELECT * FROM estudiante WHERE codigo_Est = $cod_Est");
    $stm->execute();
    $estudiante = $stm->fetchAll(PDO::FETCH_ASSOC);
}
?>

<head>
    <link rel="stylesheet" href="../../../css/modalidades/contrato/contrato.css">
    <script>
        function mostrarAlerta(mensaje) {
            alert(mensaje);
        }
    </script>
</head>

<body>



<div class="formulario_estudiantes">
    <?php foreach ($estudiante as $e) { ?>
        <h2>Formulario Contrato De Aprendizaje Para <?php echo $e['primer_Nombre']. "  " . $e['primer_Apellido'] ?></h2>
        <form method="post" action="">
    <label for="cod_Est_Cont">Código Estudiante:</label>
    <input class="estilo" type="text" value ="<?php echo $e['codigo_Est']?>"name="cod_Est_Cont" readonly required><br>

    <label for="empresa_Vinculada">Empresa Vinculada:</label>
    <input class="estilo" type="text" name="empresa_Vinculada" required><br>

    <label for="fecha_Incio">Fecha Inicio:</label>
    <input class="estilo" type="datetime-local" name="fecha_Incio" required><br>

    <label for="fecha_Final">Fecha Final:</label>
    <input class="estilo" type="datetime-local" name="fecha_Final"><br>

    <label for="horarios">Horarios:</label>
    <input class="estilo" type="text" name="horarios" required><br>

    <label for="copia_Contrato">Copia Contrato:</label><br>

    <input type="checkbox" name="copia_Contrato"><br>
    
    <label for="constancia">Constancia:</label><br>
    <input type="checkbox" name="constancia"><br>
    
    <button type="submit" value="Insertar Datos">Enviar</button>
</form>
   <?php } ?>
</div>
</body>




<?php   

    
if ($_POST) {
    try {

        $cod_Est_Cont = $_POST["cod_Est_Cont"];
        $empresa_Vinculada = $_POST["empresa_Vinculada"];
        $fecha_Incio = $_POST["fecha_Incio"];
        $fecha_Final = $_POST["fecha_Final"];
        $horarios = $_POST["horarios"];
        $copia_Contrato = isset($_POST["copia_Contrato"]) ? 1 : 0;
        $constancia = isset($_POST["constancia"]) ? 1 : 0;

        $stm = $pdo->prepare("CALL insertar_contrato_estudiante(?,?,?,?,?,?,?,?)");
        $cod_ContratoA_Est = rand(1, 1000);
        $stm->bindParam(1, $cod_Est, PDO::PARAM_INT);
        $stm->bindParam(2, $cod_ContratoA_Est, PDO::PARAM_INT);
        $stm->bindParam(3, $empresa_Vinculada, PDO::PARAM_STR);
        $stm->bindParam(4, $fecha_Incio, PDO::PARAM_STR);
        $stm->bindParam(5, $fecha_Final, PDO::PARAM_STR);
        $stm->bindParam(6, $horarios, PDO::PARAM_STR);
        $stm->bindParam(7, $copia_Contrato, PDO::PARAM_BOOL);
        $stm->bindParam(8, $constancia, PDO::PARAM_STR);
        $stm->execute();

        echo '<script>';
        echo 'mostrarAlerta("Contrato insertado exitosamente.");';
        echo 'window.location.href = "../../estudiante/vestudiante.php?id=' . $cod_Est . '";';
        echo '</script>';
        exit;
    } catch (Exception $e) {
        echo '<script>';
        echo 'mostrarAlerta("Error al insertar el contrato. Por favor, inténtalo de nuevo.");';
        echo '</script>';
        // Puedes agregar más detalles del error si es necesario, como: echo 'mostrarAlerta("Error: ' . $e->getMessage() . '");';
    }
}
?>