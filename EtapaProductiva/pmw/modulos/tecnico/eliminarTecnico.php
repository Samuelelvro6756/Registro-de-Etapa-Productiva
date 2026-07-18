<?php include ("../../config/db.php");

if (isset($_GET["id"])) {

    try {
        $cod_TecnicoE = (isset($_GET["id"])) ? $_GET["id"] : "";
        $stm = $pdo->prepare("DELETE FROM tecnico WHERE cod_Tecnico = $cod_TecnicoE");
        $stm->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
header("Location: tecnico.php");


?>