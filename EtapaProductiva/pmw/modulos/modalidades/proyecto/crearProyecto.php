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
    <h2>Formulario De Proyecto Para
      <?php echo $e['primer_Nombre'] . "  " . $e['primer_Apellido'] ?>
    </h2>
    <form action="" method="post">
      <label for="">Codigo Estudiante : </label>
      <input class="estilo" type="text" id="" name="" value="<?php echo $cod_Est ?>" readonly required
        maxlength="15"><br><br>

      <label for="">Nombre del proyecto</label>
      <input class="estilo" type="text" id="" name="nombreP" required maxlength="20"><br><br>

      <label for="">Docente de asesorias</label>
      <input class="estilo" type="text" id="" name="docente" maxlength="20"><br><br>

      <label for="">Fecha de presentacion trabajo escrito</label>
      <input class="estilo" type="date" id="" name="fechaTE"><br><br>

      <label for="">Fecha de sustentacion </label>
      <input class="estilo" type="date" id="" name="fechaST"><br><br>

      <label for="">Nota Final </label>
      <input class="estilo" type="text" step="0.01" id="" name="notaF"><br><br>

      <textarea class="estilo" name="observacion" rows="6" cols="40" placeholder="OBSERVACION...."></textarea><br><br>

      <button type="submit" value="Enviar" onclick="mostrarAlerta('Proyecto insertado exitosamente.');">Enviar</button>
    </form>
    <?php $estudiante = 0;
  } ?>
</div>

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

    $stm = $pdo->prepare("CALL InsertarProyectoYEstudiante(?,?,?,?,?,?,?,?)");
    $stm->bindParam(1, $nombreP, PDO::PARAM_STR);
    $stm->bindParam(2, $docente, PDO::PARAM_STR);
    $stm->bindParam(3, $fechaTe, PDO::PARAM_STR);
    $stm->bindParam(4, $fechaST, PDO::PARAM_STR);
    $stm->bindParam(5, $notaFinal, PDO::PARAM_STR);
    $stm->bindParam(6, $observacion, PDO::PARAM_STR);
    $stm->bindParam(7, $cod_Est, PDO::PARAM_INT);
    $codProyecto = rand(1, 1000);
    $stm->bindParam(8, $codProyecto, PDO::PARAM_INT);
    $stm->execute();

    echo '<script>';
    echo 'mostrarAlerta("Proyecto insertado exitosamente.");';
    echo 'window.location.href = "../../estudiante/vestudiante.php?id=' . $cod_Est . '";';
    echo '</script>';
    exit;

  } catch (Exception $e) {
    echo "Error" . $e->getMessage() . "";
  }
}
?>
