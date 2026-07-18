<?php
include('../../config/db.php');
include("../../vistas/header.php");

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /pmw/index.php");
    exit();
}

if (isset($_GET['id'])) {
    $cod_Est = $_GET['id'];

    $stm = $pdo->prepare("SELECT * FROM estudiante WHERE codigo_Est = $cod_Est");
    $stm->execute();
    $estudiante = $stm->fetchAll(PDO::FETCH_ASSOC);

    $stm = $pdo->prepare("SELECT * FROM tecnico t INNER JOIN estudiante e ON e.cod_Tecnico_Est = t.cod_Tecnico WHERE e.codigo_Est = $cod_Est");
    $stm->execute();
    $tecnico = $stm->fetchAll(PDO::FETCH_ASSOC);

    $stm = $pdo->prepare("SELECT * FROM tecnico");
    $stm->execute();
    $tecnicos = $stm->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $iden_Estudiante = (isset($_POST["ident_Estudiante"])) ? $_POST["ident_Estudiante"] : "";
            $primer_nombre = (isset($_POST["primer_Nombre"])) ? $_POST["primer_Nombre"] : "";
            $segundo_nombre = (isset($_POST["segundo_Nombre"])) ? $_POST["segundo_Nombre"] : "";
            $primer_apellido = (isset($_POST["primer_Apellido"])) ? $_POST["primer_Apellido"] : "";
            $segundo_apellido = (isset($_POST["segundo_Apellido"])) ? $_POST["segundo_Apellido"] : "";
            $telefono = (isset($_POST["telefono"])) ? $_POST["telefono"] : "";
            $cod_tecnico = (isset($_POST["cod_Tecnico_Est"])) ? $_POST["cod_Tecnico_Est"] : "";
            $semestre = (isset($_POST["semestre"])) ? $_POST["semestre"] : "";

            $stm = $pdo->prepare('CALL actualizar_estudiante(?,?,?,?,?,?,?,?,?)');
            $stm->bindParam(1, $cod_Est, PDO::PARAM_INT);
            $stm->bindParam(2, $iden_Estudiante, PDO::PARAM_STR);
            $stm->bindParam(3, $primer_nombre, PDO::PARAM_STR);
            $stm->bindParam(4, $segundo_nombre, PDO::PARAM_STR);
            $stm->bindParam(5, $primer_apellido, PDO::PARAM_STR);
            $stm->bindParam(6, $segundo_apellido, PDO::PARAM_STR);
            $stm->bindParam(7, $telefono, PDO::PARAM_INT);
            $stm->bindParam(8, $semestre, PDO::PARAM_STR);
            $stm->bindParam(9, $cod_tecnico, PDO::PARAM_INT);
            $stm->execute();

            echo '<script>';
            echo 'alert("Estudiante actualizado exitosamente.");';
            echo 'window.location.href = "vestudiante.php?id=' . $cod_Est . '";';
            echo '</script>';
            exit;
        } catch (PDOException $e) {
            echo '<script>';
            echo 'alert("Error al actualizar el estudiante. Por favor, inténtalo de nuevo.");';
            echo '</script>';
            
        }
    }
}
?>

<head>
    <title>Actualizar Estudiante</title>
    <link rel="shorcut icon" href="../../css/imagenes/logo_politecnicomasterweb.ico">
    <link rel="stylesheet" href="../../css/estudiante/crearE.css">
    <script>
        function mostrarAlerta(mensaje) {
            alert(mensaje);
        }
    </script>
</head>

<body>
  

<div class="formulario_estudiantes">
  <h1>Formulario de Estudiantes</h1>

  <?php foreach ($estudiante as $e) { ?>
  <form action="" method="post">
    <label for="">Identificación del Estudiante:</label>
    <input class="estilo" type="text" value = "<?php echo $e['ident_Estudiante']?>"id="ident_Estudiante" readonly name="ident_Estudiante" required maxlength="15"><br><br>

    <label for="">Primer Nombre:</label>
    <input class="estilo" type="text"  value = "<?php echo $e['primer_Nombre']?>" id="primer_Nombre" name="primer_Nombre" required maxlength="20"><br><br>

    <label for="">Segundo Nombre:</label>
    <input class="estilo" type="text"  value = "<?php echo $e['segundo_Nombre']?>" id="segundo_Nombre" name="segundo_Nombre" maxlength="20"><br><br>

    <label for="">Primer Apellido:</label>
    <input class="estilo" type="text" value = "<?php echo $e['primer_Apellido']?>" id="primer_Apellido" name="primer_Apellido" required maxlength="20"><br><br>

    <label for="">Segundo Apellido:</label>
    <input class="estilo" type="text" value = "<?php echo $e['segundo_Apellido']?>" id="segundo_Apellido" name="segundo_Apellido" maxlength="20"><br><br>

    <label for="">Teléfono:</label>
    <input class="estilo" type="tel" value = "<?php echo $e['telefono']?>" id="telefono" name="telefono" maxlength="10"><br><br>


    <label class="estilo" for="">Semestre</label>
    <input type="text" name ="semestre" class="estilo" value = "<?php echo $e['semestre']?>">

    <?php foreach ($tecnico as $r) { ?>
    <label class="estilo" for="">Técnico: <?php echo $r['nombre_Tecnico']?></label>
    <?php $tecnico = 0; } ?>

    <select class="estilo" id="cod_Tecnico_Est" name="cod_Tecnico_Est" >
      <?php foreach ($tecnicos as $t) { ?>
        <option value="<?php echo $t['cod_Tecnico']; ?>">
          <?php echo $t['nombre_Tecnico']; ?>
        </option>
      <?php } ?>
    </select>
    <button type="submit" value="Enviar">Enviar</button>
  </form>

    <?php $estudiantes = 0; } ?>

</div>
</body>