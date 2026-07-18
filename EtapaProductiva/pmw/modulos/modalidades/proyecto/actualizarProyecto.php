<?php
include("../../../config/db.php");

if (isset($_GET["id"])) {
    $cod_Est = $_GET['id'];

    $stm = $pdo->prepare("SELECT p.nombre_proyecto, p.docente_Asesoria, p.fecha_P_Trabajo, p.fecha_Sustentacion, p.nota_Final, p.observacion_Proyecto, p.cod_Est_Pr, p.cod_Pro_Est, e.primer_Nombre, e.primer_Apellido FROM proyecto_Estudiante p INNER JOIN estudiante e ON p.cod_Est_Pr = e.codigo_Est WHERE p.cod_Est_Pr =  $cod_Est;");
    $stm->execute();
    $proyecto = $stm->fetchAll(PDO::FETCH_ASSOC);
}

?>

<head>
    <link rel="stylesheet" href="../../../css/estudiante/crearE.css">
    <script>
        function mostrarAlerta(mensaje) {
            alert(mensaje);
        }
    </script>
</head>

<body>

    <div class="formulario_estudiantes">
        <?php foreach ($proyecto as $e) { ?>
            <h2>Formulario Actualizacion  De Proyecto Para
                <?php echo $e['primer_Nombre'] . "  " . $e['primer_Apellido'] ?>
            </h2>

            <form action="" method="post">
                <label for="">Codigo Proyecto: </label>
                <input class="estilo" type="text" id="" name="cod_proyecto" value="<?php echo $e['cod_Pro_Est'] ?>" readonly required maxlength="15"><br><br>

                <label for="">Codigo Estudiante : </label>
                <input class="estilo" type="text" id="" name="" value="<?php echo $cod_Est ?>" readonly required maxlength="15"><br><br>

                <label for="">Nombre del proyecto</label>
                <input class="estilo" type="text" id="" value="<?php echo $e['nombre_proyecto'] ?>" name="nombreP" required maxlength="20"><br><br>

                <label for="">Docente de asesorias</label>
                <input class="estilo" type="text" id="" required value="<?php echo $e['docente_Asesoria'] ?>" name="docente" maxlength="20"><br><br>

                <label for="">fecha de presentacion trabajo escrito : <?php echo $e['fecha_P_Trabajo'] ?></label>
                <input class="estilo" type="datetime-local" id="" value="<?php echo $e['fecha_P_Trabajo'] ?>" required name="fechaTE"><br><br>

                <label for="">fecha de sustentacion : <?php echo $e['fecha_Sustentacion'] ?></label>
                <input class="estilo" type="datetime-local" id="" value="<?php echo $e['fecha_Sustentacion'] ?>" name="fechaST" required><br><br>

                <label for="">Nota Final </label>
                <input class="estilo" type="text" value="<?php echo $e['nota_Final'] ?>" step="0.01" id="" name="notaF"><br><br>

                <textarea class="estilo" name="observacion" rows="6" cols="40" placeholder="OBSERVACION...."><?php echo $e['observacion_Proyecto'] ?></textarea><br><br>

                <button type="submit" value="Enviar" onclick="mostrarAlerta('Proyecto actualizado exitosamente.');">Enviar</button>
            </form>
        <?php } ?>
    </div>
</body>

<?php

if ($_POST) {

    try {

        $nombreP = $_POST['nombreP'];
        $docente = $_POST['docente'];
        $fechaTe = $_POST['fechaTE'];
        $fechaST = $_POST['fechaST'];
        $notaF = $_POST['notaF'];
        $notaFinal = floatval($notaF);
        $observacion = $_POST['observacion'];
        $codProyecto = $_POST['cod_proyecto'];

        $stm = $pdo->prepare("CALL ActualizarProyectoEstudiante(?,?,?,?,?,?,?,?)");
        $stm->bindParam(1, $nombreP, PDO::PARAM_STR);
        $stm->bindParam(2, $docente, PDO::PARAM_STR);
        $stm->bindParam(3, $fechaTe, PDO::PARAM_STR);
        $stm->bindParam(4, $fechaST, PDO::PARAM_STR);
        $stm->bindParam(5, $notaFinal, PDO::PARAM_STR);
        $stm->bindParam(6, $observacion, PDO::PARAM_STR);
        $stm->bindParam(7, $cod_Est, PDO::PARAM_INT);
        $stm->bindParam(8, $codProyecto, PDO::PARAM_INT);
        $stm->execute();

        echo '<script>';
        echo 'mostrarAlerta("Proyecto actualizado exitosamente.");';
        echo 'window.location.href = "../../estudiante/vestudiante.php?id=' . $cod_Est . '";';
        echo '</script>';
        exit;
    } catch (Exception $e) {
        echo "Error" . $e->getMessage() . "";
    }
}

?>
