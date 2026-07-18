<?php
include("../../../config/db.php");
include("../../../vistas/header.php");
?>

<?php

if (isset($_GET['id'])) {
    $cod_Est = $_GET['id'];

    $stm = $pdo->prepare("SELECT h.empresa_Homolog, h.fecha_Aprobacion, h.fecha_Solicitud, h.estado_Homomlogacion, h.observaciones_Homolog, h.cod_Est_Homolog, h.cod_Homolog_Est, e.primer_Nombre, e.primer_Apellido  FROM homologacion_Estudiante h INNER JOIN estudiante e ON h.cod_Est_Homolog = e.codigo_Est WHERE cod_Est_Homolog = $cod_Est");
    $stm->execute();
    $homologacion = $stm->fetchAll(PDO::FETCH_ASSOC);
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
  <?php foreach ($homologacion as $h) { ?>
    <h2>Formulario De Homologacion Para
      <?php echo $h['primer_Nombre'] . "  " . $h['primer_Apellido'] ?>
    </h2>
    <form action="" method="post">

    <label for="">Código Homologacion</label>
      <input class="estilo" type="text" value="<?php echo $h['cod_Homolog_Est'] ?>" name="cod_Homolog_Est" readonly required><br>
      
      <label for="">Código Estudiante:</label>
      <input class="estilo" type="text" value="<?php echo $cod_Est ?>" name="cod_Est_Past" readonly required><br>
      
      <label for="">Fecha de solicitud : <?php echo $h['fecha_Solicitud']; ?></label>
      <input class="estilo" type="datetime-local" id="" value="<?php echo $h['fecha_Solicitud']?>" name="fecha_S" required maxlength="15"><br><br>

      <label for="">Nombre de la empresa</label>
      <input class="estilo" type="text" id="" name="empresa" value="<?php echo $h['empresa_Homolog'] ?>"  required maxlength="20"><br><br>

      <label for="">Estado de aprobado: <?php echo $h['estado_Homomlogacion'] ?></label>
      <select class="estilo" type="text" id="" name="estado" maxlength="20">
        <option value="si">Si</option>
        <option value="no">No</option>
        <option value="espera">Espera</option>
      </select><br><br>

      <label for="">fecha en el que fue aprobado : <?php echo $h['fecha_Aprobacion']?></label>
      <input class="estilo" type="datetime-local" id="" value="<?php echo $h['fecha_Aprobacion'] ?>" name="fechaA"><br><br>

      <textarea class="estilo" name="observacion" rows="6" value="<?php echo $h['observaciones_Homolog'] ?>" cols="40" placeholder="OBSERVACION...."> <?php echo $h['observaciones_Homolog']?></textarea><br><br>

      <button type="submit" value="Enviar">Enviar</button>
    </form>
  <?php } ?>
</div>


<?php

    
if ($_POST) {

  try {

      $empresa = $_POST['empresa'];
      $fechaA = $_POST['fechaA'];
      $fechaS = $_POST['fecha_S'];
      $estado = $_POST['estado'];
      $observacion = $_POST['observacion'];
      $codHomolog = $_POST['cod_Homolog_Est'];

      $stm = $pdo->prepare("CALL ActualizarHomologacionEstudiantes(?,?,?,?,?,?)");

      $stm->bindParam(1, $empresa, PDO::PARAM_STR);
      $stm->bindParam(2, $fechaA, PDO::PARAM_STR);
      $stm->bindParam(3, $fechaS, PDO::PARAM_STR);
      $stm->bindParam(4, $estado, PDO::PARAM_STR);
      $stm->bindParam(5, $observacion, PDO::PARAM_STR);
      $stm->bindParam(6, $codHomolog, PDO::PARAM_INT);
      $stm->execute();

      echo '<script>';
      echo 'mostrarAlerta("Homologación actualizada exitosamente.");';
      echo 'window.location.href = "../../estudiante/vestudiante.php?id=' . $cod_Est . '";';
      echo '</script>';
      exit;
  } catch (Exception $e) {
      echo '<script>';
      echo 'mostrarAlerta("Error al actualizar la homologación. Por favor, inténtalo de nuevo.");';
      echo '</script>';
      // Puedes agregar más detalles del error si es necesario, como: echo 'mostrarAlerta("Error: ' . $e->getMessage() . '");';
  }
}
?>