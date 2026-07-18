<?php
$pagina = 'crearTecnico';
include("../../vistas/header.php");
include("../../config/db.php");

$exitoMessage = $errorMessage = "";

if ($_POST) {
    try {
        $nombreTecnico = (isset($_POST["nombreTecnico"])) ? $_POST["nombreTecnico"] : "";
        $stm = $pdo->prepare("CALL Insertar__Tecnicos(?,?)");
        $codRandom = rand(1, 100);
        $stm->bindParam(1, $codRandom, PDO::PARAM_INT);
        $stm->bindParam(2, $nombreTecnico, PDO::PARAM_STR);
        $stm->execute();

        // Configurar mensaje de éxito
        $exitoMessage = "Técnico creado correctamente: $nombreTecnico";

    } catch (PDOException $e) {
        // Configurar mensaje de error
        $errorMessage = "Error al crear el técnico: " . $e->getMessage();
    }
}

// ...

?>

<head>
    <title>Crear Tecnico</title>
    <link rel="shorcut icon" href="../../css/imagenes/logo_politecnicomasterweb.ico">
    <link rel="stylesheet" href="../../css/tecnico/crearTecnico.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Define las variables de éxito y error en JavaScript
        var exitoMessage = '<?php echo $exitoMessage; ?>';
        var errorMessage = '<?php echo $errorMessage; ?>';

        document.addEventListener('DOMContentLoaded', function () {
            // Verificar y mostrar alerta de éxito
            if (exitoMessage) {
                Swal.fire({
                    title: 'Éxito',
                    text: exitoMessage,
                    icon: 'success',
                }).then(()=> {  
                    window.location.href = 'tecnico.php'
                });
            }

            // Verificar y mostrar alerta de error
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
    <div class="formulario_tecnico">
        <h1>Crear Técnico</h1>
        <form action="" method="post">
            <label for="nombreTecnico">Nombre del técnico</label>
            <input class="estilo" type="text" name="nombreTecnico">
            <button type="submit">Crear técnico</button>
        </form>
    </div>
</body>

<?php include("../../vistas/footer.php"); ?>
