<?php

ob_start();

$pagina = 'crearEstudiantes';
include('../../config/db.php');
include("../../vistas/header.php");

try {
    $stmt = $pdo->prepare("SELECT * FROM tecnico");
    $stmt->execute();
    $tecnico = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$exitoMessage = isset($_SESSION['exito']) ? $_SESSION['exito'] : '';
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Destruye la sesión después de obtener los mensajes
unset($_SESSION['exito']);
unset($_SESSION['error']);
?>

<head>
    <title>Crear Estudiantes</title>
    <link rel="shorcut icon" href="../../css/imagenes/logo_politecnicomasterweb.ico">
    <link rel="stylesheet" href="../../css/estudiante/crearE.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Define las variables de éxito y error en JavaScript
        var exitoMessage = '<?php echo $exitoMessage; ?>';
        var errorMessage = '<?php echo $errorMessage; ?>';

        document.addEventListener('DOMContentLoaded', function () {
            // Verifica y muestra la alerta de éxito
            if (exitoMessage) {
                Swal.fire({
                    title: 'Éxito',
                    text: exitoMessage,
                    icon: 'success',
                }).then(() => {
                    window.location.href = 'estudiantes.php';
                });
            }

            // Verifica y muestra la alerta de error
            if (errorMessage) {
                Swal.fire({
                    title: 'Error',
                    text: errorMessage,
                    icon: 'error',
                });
            }
        });
    </script>
</head>

<body>
    <div class="formulario_estudiantes">
        <h1>Formulario de Estudiantes</h1>

        <form id="estudianteForm" action="" method="post">
            <label for="ident_Estudiante">Identificación del Estudiante:</label>
            <input class="estilo" type="text" id="ident_Estudiante" name="ident_Estudiante" required maxlength="15"><br><br>

            <label for="primer_Nombre">Primer Nombre:</label>
            <input class="estilo" type="text" id="primer_Nombre" name="primer_Nombre" required maxlength="20"><br><br>

            <label for="segundo_Nombre">Segundo Nombre:</label>
            <input class="estilo" type="text" id="segundo_Nombre" name="segundo_Nombre" maxlength="20"><br><br>

            <label for="primer_Apellido">Primer Apellido:</label>
            <input class="estilo" type="text" id="primer_Apellido" name="primer_Apellido" required maxlength="20"><br><br>

            <label for="segundo_Apellido">Segundo Apellido:</label>
            <input class="estilo" type="text" id="segundo_Apellido" name="segundo_Apellido" maxlength="20"><br><br>

            <label for="telefono">Teléfono:</label>
            <input class="estilo" type="tel" id="telefono" name="telefono" maxlength="10"><br><br>

            <label for="semestre">Semestre</label>
            <input class="estilo" type="text" name="semestre" class="estilo">

            <label for="cod_Tecnico_Est">Técnico al que pertenece:</label>
            <select class="estilo" id="cod_Tecnico_Est" name="cod_Tecnico_Est">
                <?php foreach ($tecnico as $t) { ?>
                    <option value="<?php echo $t['cod_Tecnico']; ?>">
                        <?php echo $t['nombre_Tecnico']; ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Enviar</button>
        </form>
    </div>
</body>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $iden_Estudiante = isset($_POST["ident_Estudiante"]) ? $_POST["ident_Estudiante"] : "";
        $primer_nombre = isset($_POST["primer_Nombre"]) ? $_POST["primer_Nombre"] : "";
        $segundo_nombre = isset($_POST["segundo_Nombre"]) ? $_POST["segundo_Nombre"] : "";
        $primer_apellido = isset($_POST["primer_Apellido"]) ? $_POST["primer_Apellido"] : "";
        $segundo_apellido = isset($_POST["segundo_Apellido"]) ? $_POST["segundo_Apellido"] : "";
        $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
        $cod_tecnico = isset($_POST["cod_Tecnico_Est"]) ? $_POST["cod_Tecnico_Est"] : "";
        $semestre = isset($_POST["semestre"]) ? $_POST["semestre"] : "";

        $stm = $pdo->prepare("CALL insertarestudiante(?,?,?,?,?,?,?,?,?)");
        $codRandom = rand(1, 10000);
        $stm->bindParam(1, $codRandom, PDO::PARAM_INT);
        $stm->bindParam(2, $iden_Estudiante, PDO::PARAM_STR);
        $stm->bindParam(3, $primer_nombre, PDO::PARAM_STR);
        $stm->bindParam(4, $segundo_nombre, PDO::PARAM_STR);
        $stm->bindParam(5, $primer_apellido, PDO::PARAM_STR);
        $stm->bindParam(6, $segundo_apellido, PDO::PARAM_STR);
        $stm->bindParam(7, $telefono, PDO::PARAM_STR);
        $stm->bindParam(8, $semestre, PDO::PARAM_STR);
        $stm->bindParam(9, $cod_tecnico, PDO::PARAM_INT);
        $stm->execute();

        // Configura la sesión y la alerta de éxito
        session_start();
        $_SESSION['exito'] = "Estudiante creado correctamente";

        // Redirección a estudiantes.php después de la inserción exitosa
        header('Location: crearEstudiante.php');
        exit();
    } catch (Exception $e) {
        // Configura la sesión y la alerta de error
        session_start();
        $_SESSION['error'] = "Error al crear el estudiante: " . $e->getMessage();

        header('Location: crearEstudiante.php');
        exit();
    }
}

include("../../vistas/footer.php");
?>
