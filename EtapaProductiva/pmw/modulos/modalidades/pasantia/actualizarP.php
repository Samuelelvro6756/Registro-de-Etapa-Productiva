<?php
include("../../../config/db.php");

if (isset($_GET["id"])) {
    $cod_Est = $_GET['id'];

    $stm = $pdo->prepare("SELECT p.fecha_Inicio, p.fecha_Final, p.empresa_Vinculada, p.Horas_Realizadas, p.hojaVida, p.horario, p.constancia_Pasantia, p.carta_Presentacion, p.arl, p.acuerdo_Pasantia, p.planilla, p.cod_Pas_Est, p.cod_Pasantia, e.primer_Nombre, e.primer_Apellido FROM Pasantias_Estudiantess p INNER JOIN estudiante e ON p.cod_Pas_Est = e.codigo_Est WHERE p.cod_Pas_Est = :cod_Est");
    $stm->bindParam(":cod_Est", $cod_Est, PDO::PARAM_INT);
    $stm->execute();
    $pasantia = $stm->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $codE = $_POST["cod_Est_Past"];
        $hojaV = $_POST["hojaV"];
        $empresaV = $_POST["empresaV"];
        $horasR = $_POST["horasR"];
        $horarios = $_POST["horarios"];
        $fechaI = $_POST["fechaI"];
        $fechaFinal = $_POST["fechaF"];
        $cartaP = isset($_POST["cartaP"]) ? 1 : 0;
        $arl = isset($_POST["arl"]) ? 1 : 0;
        $acuerdoP = isset($_POST["acuerdoP"]) ? 1 : 0;
        $planillas = isset($_POST["planillas"]) ? 1 : 0;
        $constancia = isset($_POST["constancia"]) ? 1 : 0;
        $cod_pasantia = $_POST["cod_pasantia"];

        $stm = $pdo->prepare("CALL ActualizarPasantiaEstudiante(?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stm->bindParam(1, $fechaI, PDO::PARAM_STR);
        $stm->bindParam(2, $fechaFinal, PDO::PARAM_STR);
        $stm->bindParam(3, $empresaV, PDO::PARAM_STR);
        $stm->bindParam(4, $horasR, PDO::PARAM_INT);
        $stm->bindParam(5, $hojaV, PDO::PARAM_STR);
        $stm->bindParam(6, $horarios, PDO::PARAM_STR);
        $stm->bindParam(7, $constancia, PDO::PARAM_BOOL);
        $stm->bindParam(8, $cartaP, PDO::PARAM_BOOL);
        $stm->bindParam(9, $arl, PDO::PARAM_BOOL);
        $stm->bindParam(10, $acuerdoP, PDO::PARAM_BOOL);
        $stm->bindParam(11, $planillas, PDO::PARAM_BOOL);
        $stm->bindParam(12, $cod_Est, PDO::PARAM_INT);
        $stm->bindParam(13, $cod_pasantia, PDO::PARAM_INT);
        $stm->execute();

        echo '<script>';
        echo 'alert("Pasantía actualizada exitosamente.");';
        echo 'window.location.href = "../../estudiante/vestudiante.php?id=' . $cod_Est . '";';
        echo '</script>';
        exit;
    } catch (Exception $e) {
        echo '<script>';
        echo 'alert("Error al actualizar la pasantía. Por favor, inténtalo de nuevo.");';
        echo '</script>';
    }
}
?>

<head>
    <link rel="stylesheet" href="../../../css/estudiante/crearE.css">
</head>

<body>
    <div class="formulario_estudiantes">
        <?php foreach ($pasantia as $e) { ?>
            <h2>Formulario Actualización De Pasantía Para
                <?php echo $e['primer_Nombre'] . "  " . $e['primer_Apellido'] ?>
            </h2>
            <form method="post" action="">
                <label for="cod_Est_Past">Código Estudiante:</label>
                <input class="estilo" type="text" value="<?php echo $e['cod_Pas_Est'] ?>" name="cod_Est_Past" readonly required><br>

                <label for="">Codigo Pasantía: </label>
                <input type="text" class="estilo" name="cod_pasantia" value="<?php echo $e['cod_Pasantia'] ?>" id=""><br><br>

                <label for="">Fecha de presentación hoja de vida: <?php echo $e['hojaVida'] ?> </label>
                <input class="estilo" type="datetime-local" id="" value="<?php echo $e['hojaVida'] ?>" name="hojaV"><br><br>

                <label for="">Empresa</label>
                <input class="estilo" type="text" id="" value=" <?php echo $e['empresa_Vinculada'] ?>" name="empresaV" required maxlength="20"><br><br>

                <label for="">Horas a realizar</label>
                <input class="estilo" type="text" id="" name="horasR" value=" <?php echo $e['Horas_Realizadas'] ?>" required maxlength="20"><br><br>

                <label for="">Horarios</label>
                <input class="estilo" type="text" id="" name="horarios" value=" <?php echo $e['horario'] ?>" required maxlength="20"><br><br>

                <label for="">Fecha de iniciación:  <?php echo $e['hojaVida'] ?> </label>
                <input class="estilo" type="datetime-local" id="" name="fechaI" value="<?php echo $e['fecha_Inicio'] ?>" required><br><br>

                <label for="">Fecha final: <?php echo $e['fecha_Final'] ?></label>
                <input type="datetime-local" name="fechaF" id="" value="<?php echo $e['fecha_Final'] ?>" class="estilo">

                <label for="">Carta de presentación:  <?php echo $e['carta_Presentacion'] ?></label>
                <input type="checkbox" name="cartaP" <?php echo $e['carta_Presentacion'] ? 'checked' : ''; ?>>
                <br>
                <br>

                <label for="">ARL:  <?php echo $e['arl'] ?></label>
                <input type="checkbox" value=" <?php echo $e['arl'] ?>" name="arl" <?php echo $e['arl'] ? 'checked' : ''; ?>>
                <br>
                <br>

                <label for="">Acuerdo de pasantía:  <?php echo $e['acuerdo_Pasantia'] ?></label>
                <input type="checkbox" value=" <?php echo $e['acuerdo_Pasantia'] ?>" name="acuerdoP" <?php echo $e['acuerdo_Pasantia'] ? 'checked' : ''; ?>>
                <br>
                <br>

                <label for="">Planillas:  <?php echo $e['planilla'] ?></label>
                <input type="checkbox" value=" <?php echo $e['planilla'] ?>" name="planillas" <?php echo $e['planilla'] ? 'checked' : ''; ?>>
                <br><br>

                <label for="">Constancia:  <?php echo $e['constancia_Pasantia'] ?></label>
                <input type="checkbox" name="constancia" value=" <?php echo $e['constancia_Pasantia'] ?>" <?php echo $e['constancia_Pasantia'] ? 'checked' : ''; ?>>
                <br><br>
                <button type="submit" value="Enviar">Enviar</button>
            </form>
        <?php } ?>
    </div>
</body>
