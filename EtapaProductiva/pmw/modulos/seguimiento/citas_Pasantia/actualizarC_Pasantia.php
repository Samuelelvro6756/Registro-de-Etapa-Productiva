<?php include("../../../config/db.php");
include("../../../vistas/header.php");
?>

<head>
  <link rel="stylesheet" href="../../../css/citas/pasantiaA.css">
</head>

<?php 

if (isset($_GET['id']) && isset($_GET['cod']) ) {
    $cod_Est = $_GET['id'];
    $cod_P = $_GET['cod'];
    
    $stm = $pdo->prepare("SELECT * FROM citas_Seguimiento_Pasantias WHERE cod_Pas_Est =  $cod_Est AND cod_Cita_Cont = $cod_P");
    $stm->execute();
    $citaPasantia = $stm->fetchAll(PDO::FETCH_ASSOC);
    
  }

?>

<body>
  
  
  
  <h1>Visualizacion y Actulizacion de Cita de Seguimiento de Pasantía </h1>

  <?php foreach ($citaPasantia as $p){?>  

  <div class="info">

    <table>

    <thead>
      <tr>
        <th>Cita</th>
        <th>Fecha</th>
        <th>Responsable Cita</th>
        <th>Estado</th>
        <th>nota</th>
        <th>Observaciones</th>
        <th>Codigo estudiante</th>
      </tr>
    </thead>
      <tbody>
        <tr>
      <td><?php echo $p["cod_Cita_Cont"]?></td>
      <td><?php echo $p["fecha_Realizada"]?></td>
      <td><?php echo $p["responsable_Cita"]?></td>
      <td><?php echo $p["Estado"]?></td>
      <td><?php echo $p["nota"]?></td>
      <td><?php echo $p["observaciones"]?></td>
      <td><?php echo $p["cod_Pas_Est"]?></td>

        </tr>
      </tbody>
   
    </table>
<br>
  </div>

    <form action="" method="POST">
  <label for="codCita">Código de Cita:</label>
  <input type="number" value="<?php echo $p["cod_Cita_Cont"]?>" id="codCita" name="codCita" required><br>
  
  <label for="fechaRealizada">Fecha:<?php echo $p["fecha_Realizada"]?></label>
  <input type="datetime-local"  id="fechaRealizada" name="fecha" required><br>

  <label for="responsableCita">Responsable de la Cita:</label>
  <input type="text" id="responsableCita" value="<?php echo $p["responsable_Cita"]?>"name="responsable" required maxlength="50"><br>

  <label for="estado">Estado: <?php echo $p["Estado"]?></label>
  <select id="estado" name="estado" required>
    <option value="Pendiente">Pendiente</option>
    <option value="Realizada">Realizada</option>
  </select><br><br>

  <label for="nota">Nota:</label>
  <input type="number" id="nota" name="nota" value="<?php echo $p["nota"]?>" step="0.1"><br>

  <label for="observaciones">Observaciones:</label>
  <textarea id="observaciones" name="observaciones" rows="5" cols="40" maxlength="900"><?php echo $p["observaciones"]?></textarea>
  <input type="submit" value="Enviar">
</form>

    <?php }?>
</body>


<?php 



if ($_POST){

  try{

      $cod = $_POST['codCita'];
      $fecha = $_POST['fecha'];
      $responsable = $_POST['responsable'];
      $estado =$_POST['estado'];
      $n = $_POST['nota'];
      $nota = floatval($n);
      $observacion = $_POST['observaciones'];

      $stm = $pdo->prepare('CALL ActualizarCitaPasantia(?,?,?,?,?,?,?)');
      $stm->bindParam(1,$cod, PDO::PARAM_INT);
      $stm->bindParam(2,$fecha, PDO::PARAM_STR);
      $stm->bindParam(3,$responsable, PDO::PARAM_STR);
      $stm->bindParam(4, $estado, PDO::PARAM_STR);
      $stm->bindParam(5, $nota, PDO::PARAM_STR);
      $stm->bindParam(6, $observacion, PDO::PARAM_STR);
      $stm->bindParam(7, $cod_Est, PDO::PARAM_INT);
      $stm->execute();
      header("Location: ../../estudiante/vestudiante.php?id=$cod_Est");

  }
catch(PDOException $e) {
  echo"ERROR". $e->getMessage();
  
}
}

?>