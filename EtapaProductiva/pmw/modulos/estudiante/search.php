<?php
include('../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = isset($_POST['searchTerm']) ? '%' . $_POST['searchTerm'] . '%' : '';

    $stm = $pdo->prepare("SELECT e.codigo_Est, e.ident_Estudiante, e.primer_Nombre, e.segundo_Nombre, e.primer_Apellido, e.segundo_Apellido, e.telefono, t.nombre_Tecnico FROM estudiante e LEFT JOIN tecnico t ON e.cod_Tecnico_Est = t.cod_Tecnico WHERE e.ident_Estudiante LIKE :searchTerm OR e.primer_Nombre LIKE :searchTerm OR e.segundo_Nombre LIKE :searchTerm OR e.primer_Apellido LIKE :searchTerm OR e.segundo_Apellido LIKE :searchTerm");
    $stm->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $stm->execute();
    $results = $stm->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}


?>
