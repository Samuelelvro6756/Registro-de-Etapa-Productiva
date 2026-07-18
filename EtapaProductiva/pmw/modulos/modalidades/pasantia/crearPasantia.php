<?php
include("../../../config/db.php");
include("../../../vistas/header.php");

if (isset($_GET['id'])) {
    $cod_Est = $_GET['id'];

    $stm = $pdo->prepare("SELECT * FROM estudiante WHERE codigo_Est = $cod_Est");
    $stm->execute();
    $estudiante = $stm->fetchAll(PDO::FETCH_ASSOC);
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

<div class="formulario_estudiantes">
    <?php foreach ($estudiante as $e) { ?>
        <h2>Formulario De Pasantia Para
            <?php echo $e['primer_Nombre'] . "  " . $e['primer_Apellido'] ?>
        </h2>
        <form method="post" action="">
            <label for="cod_Est_Past">Código Estudiante:</label>
            <input class="estilo" type="text" value="<?php echo $e['codigo_Est'] ?>" name="cod_Est_Past" readonly required><br>

            <label for="">Fecha de presentacion hoja de vida </label>
            <input class="estilo" type="datetime-local" id="" name="hojaV"><br><br>

            <label for="">Empresa</label>
            <input class="estilo" type="text" id="" name="empresaV" required maxlength="20"><br><br>

            <label for="">Horas a realizar</label>
            <input class="estilo" type="number" id="" name="horasR" required maxlength="20"><br><br>

            <label for="">Horarios</label>
            <input class="estilo" type="text" id="" name="horarios" required maxlength="20"><br><br>

            <label for="">Fecha de iniciacion </label>
            <input class="estilo" type="datetime-local" id="" name="fechaI" required><br><br>

            <label for="">Fecha final</label>

            <input type="datetime-local" class="estilo" name="fechaF" id="" class="estilo">


            <label for="">Carta de presentacion</label>
            <input type="checkbox" name="cartaP">
            <br>
            <br>

            <label for="">ARL</label>
            <input type="checkbox" name="arl" id="">
            <br>
            <br>

            <label for="">Acuerdo de pasantia</label>
            <input type="checkbox" name="acuerdoP" id="">
            <br>
            <br>

            <label for="">planillas</label>
            <input type="checkbox" name="planillas" id="">
            <br><br>

            <label for="">Constancia</label>
            <input type="checkbox" name="constancia" id="">
            <br><br>
        <?php } ?>
        <!-- Botón de enviar fuera del bucle -->
        <button type="submit" value="Enviar" onclick="mostrarAlerta('Pasantía insertada exitosamente.');">Enviar</button>
        </form>
</div>

<?php

if ($_POST) {
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

        $stm = $pdo->prepare("CALL InsertarPasantiaEstudiantessss(?,?,?,?,?,?,?,?,?,?,?,?,?)");
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
        $cod_pasantia = rand(1, 1000);
        $stm->bindParam(13, $cod_pasantia, PDO::PARAM_INT);
        $stm->execute();

        echo '<script>';
        echo 'mostrarAlerta("Pasantía insertada exitosamente.");';
        echo 'window.location.href = "../../estudiante/vestudiante.php?id=' . $cod_Est . '";';
        echo '</script>';
        exit;
    } catch (Exception $e) {
        echo '<script>';
        echo 'mostrarAlerta("Error al insertar la pasantía. Por favor, inténtalo de nuevo.");';
        echo '</script>';
    }
}
?>
