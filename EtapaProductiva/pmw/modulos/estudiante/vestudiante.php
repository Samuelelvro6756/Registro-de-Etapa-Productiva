<?php include("../../config/db.php");
include("../../vistas/header.php"); ?>

<?php

if (isset($_GET['id'])) {
    $cod_Est = $_GET['id'];

    $stm = $pdo->prepare("SELECT e.codigo_Est, e.ident_Estudiante, e.primer_Nombre, e.segundo_Nombre, e.primer_Apellido, e.segundo_Apellido, e.telefono, e.semestre, t.nombre_Tecnico  FROM estudiante e  LEFT JOIN tecnico t ON e.cod_Tecnico_Est = t.cod_Tecnico WHERE e.codigo_Est = $cod_Est;");
    $stm->execute();
    $est = $stm->fetchAll(PDO::FETCH_ASSOC);
}




?>


<?php

$stm = $pdo->prepare("SELECT * FROM contrato_Estudiante ce INNER JOIN estudiante e ON ce.cod_Est_Cont = e.codigo_Est INNER JOIN contrato_Aprendizaje ca ON ce.cod_ContratoA_Est = ca.cod_ContratoA  WHERE ce.cod_Est_Cont = $cod_Est ");
$stm->execute();
$contrato = $stm->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("SELECT * FROM Pasantias_Estudiantess p INNER JOIN estudiante e ON p.cod_Pas_Est = e.codigo_Est LEFT JOIN pasantias pa ON p.cod_Pas_Est = pa.cod_Pasantia WHERE p.cod_Pas_Est = $cod_Est;");
$stm->execute();
$pasantia = $stm->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("SELECT * FROM proyecto_Estudiante pr INNER JOIN estudiante e ON pr.cod_Est_Pr = e.codigo_Est LEFT JOIN proyecto p ON pr.cod_Pro_Est = p.cod_Proyecto WHERE pr.cod_Est_Pr = $cod_Est");
$stm->execute();
$proyecto = $stm->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("SELECT * FROM homologacion_Estudiante ho INNER JOIN estudiante e ON ho.cod_Est_Homolog = e.codigo_Est LEFT JOIN homologacion h ON ho. cod_Homolog_Est = h.cod_homolg WHERE ho.cod_Est_Homolog = $cod_Est;");
$stm->execute();
$homologacion = $stm->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("SELECT * FROM citas_Seguimiento_Pasantias WHERE cod_Pas_Est =  $cod_Est");
$stm->execute();
$citaPasantia = $stm->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("SELECT * FROM citas_Seguimientos_Contratos WHERE cod_Cita_Est =  $cod_Est");
$stm->execute();
$citaContrato = $stm->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("SELECT * FROM asesoria_Proyecto WHERE cod_Cita_Est =  $cod_Est");
$stm->execute();
$asesoria= $stm->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("SELECT * FROM evaluacionPasantia WHERE cod_Pas_Est =  $cod_Est");
$stm->execute();
$evPasantia= $stm->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("SELECT * FROM evaluacionPasantiaContrato WHERE cod_Contrato_Est =  $cod_Est");
$stm->execute();
$evContrato= $stm->fetchAll(PDO::FETCH_ASSOC);


?>

<head>
    <link rel="stylesheet" href="../../css/estudiante/v.css">
</head>

<body>

    <div class="c">

        <div class="info-Est">
            <?php foreach ($est as $e) { ?>

                <h2>
                    <?php echo $e['primer_Nombre'] . ' ' . $e['primer_Apellido'] ?>
                </h2>
                <div class="detalles">

                    <ul></ul>
                    <li><strong>Codigo : </strong>
                        <?php echo $e['codigo_Est'] ?>
                    </li>
                    <li><strong>N° Identificacion : </strong>
                        <?php echo $e['ident_Estudiante'] ?>
                    </li>
                    <li><strong>Nombres : </strong>
                        <?php echo $e['primer_Nombre'] . ' ' . $e['segundo_Nombre'] ?>
                    </li>
                    <li><strong>Apellidos : </strong>
                        <?php echo $e['primer_Apellido'] . ' ' . $e['segundo_Apellido'] ?>
                    </li>
                    <li><strong>Telefono : </strong>
                        <?php echo $e['telefono'] ?>
                    </li>
                    <li><strong>Semestre : </strong>
                        <?php echo $e['semestre'] ?>
                    </li>
                    <li><strong>Carrera : </strong>
                        <?php echo $e['nombre_Tecnico'] ?>
                    </li>
                    
                    <li><a href="actualizarEstudiante.php?id=<?php echo $cod_Est?>">Actualizar Información</a></li>
                </div>
            <?php } ?>
        </div>
        <div class="citas">

            <?php
            if ($contrato) { ?>
                <div class="crear">
                    <a href="../seguimiento/citas_Contrato/crearC_Contrato.php?id=<?php echo $cod_Est ?>">Crear Cita </a>

                    <a href="../seguimiento/form_evaluacion/evaluacion_contrato.php?id=<?php echo $cod_Est ?>">Evaluacion</a>

                </div>
                <div class="cita-info">
                    <?php foreach ($citaContrato as $c) { ?>
                        <ul>
                            <li>
                                <?php echo $c["cod_Cita_Cont"] ?>
                            </li>
                            <li>
                                <?php echo $c["fecha_Realizada"] ?>
                            </li>
                            <li>
                                <?php echo $c["Estado"] ?>
                            </li>
                            <li><a
                                    href="../seguimiento/citas_Contrato/actualizarC_Contrato.php?id=<?php echo $cod_Est ?>&cod=<?php echo $c["cod_Cita_Cont"] ?>">Ver
                                    mas</a></li>

                                    
                        </ul>

                    <?php } ?>


                <?php } else if ($pasantia) { ?>

                        <div class="crear">
                            <a href="../seguimiento/citas_Pasantia/crearC_Pasantia.php?id=<?php echo $cod_Est ?>">Crear Cita
                            </a>

                            <a href="../seguimiento/form_evaluacion/evaluacion.php?id=<?php echo $cod_Est ?>">Evaluacion</a>
                        </div>
                        <div class="cita-info">
                        <?php foreach ($citaPasantia as $c) { ?>
                                <ul>
                                    <li>
                                    <?php echo $c["cod_Cita_Cont"] ?>
                                    </li>
                                    <li>
                                    <?php echo $c["fecha_Realizada"] ?>
                                    </li>
                                    <li>
                                    <?php echo $c["Estado"] ?>
                                    </li>
                                    <li><a
                                            href="../seguimiento/citas_Pasantia/actualizarC_Pasantia.php?id=<?php echo $cod_Est ?>&cod=<?php echo $c["cod_Cita_Cont"] ?>">Ver
                                            mas</a></li>
 
                                </ul>
                                



                        <?php } ?>
                    <?php } else if ($homologacion) { ?>

                                <h2>Homologacion</h2>

                    <?php } else if ($proyecto) { ?>

                                    <div class="crear">
                                        <a href="../seguimiento/asesorias_Proyecto/crear_Asesoria.php?id=<?php echo $cod_Est ?>">Crear Cita
                                        </a>

                                    </div>
                                    <div class="cita-info">
                            <?php foreach ($asesoria as $c) { ?>
                                            <ul>
                                                <li>
                                        <?php echo $c["cod_Cita_Cont"] ?>
                                                </li>
                                                <li>
                                        <?php echo $c["fecha_Realizada"] ?>
                                                </li>
                                                <li>
                                        <?php echo $c["Estado"] ?>
                                                </li>
                                                <li><a
                                                        href="../seguimiento/asesorias_Proyecto/actualizar_Asesoria.php?id=<?php echo $cod_Est ?>&cod=<?php echo $c["cod_Cita_Cont"] ?>">Ver
                                                        mas</a></li>
                                            </ul>

                            <?php } ?>

                        <?php } else { ?>

                                        <h2>Elija una modalidad para ver sus citas</h2>

                        <?php } ?>

                    </div>

                </div>

                <div class="etapa">


                    <?php if ($contrato) { ?>
                        <!-- <div class="etapa"> -->
                        <?php foreach ($contrato as $c) { ?>
                            <ul>
                                <li><strong>CODIGO DE CONTRATO : </strong>
                                    <?php echo $c['cod_ContratoA_Est'] ?>
                                </li>
                                <li><strong>EMPRESA : </strong>
                                    <?php echo $c['empresa_Vinculada'] ?>
                                </li>
                                <li><strong>FECHA INICIO : </strong>
                                    <?php echo $c['fecha_Incio'] ?>
                                </li>
                                <li><strong>FECHA FINAL : </strong>
                                    <?php echo $c['fecha_Final'] ?>
                                </li>
                                <li><a href="../modalidades/contrato/actualizarC.php?id=<?php echo $cod_Est ?>">Actualizar
                                        Datos</a>
                                </li>
                            </ul>

                        <?php }
                        $contrato = 0; ?>

                        <?php foreach ($evContrato as $e) { ?>

                        <ul>
                            <h1>Evaluacion</h1>

                            <li><strong>Fecha:</strong>
                            <?php echo $e['fecha_Evaluacion'] ?>
                            </li>

                            <li><strong>Responsable de la evaluacion:</strong>
                            <?php echo $e['quien_Realizo'] ?>
                            </li>

                            <li><strong>Nota:</strong>
                            <?php echo $e['nota'] ?>
                            </li>

                            <li><strong>Estado Practicas:</strong>
                            <?php echo $e['estado_p'] ?>
                            </li>
                            
                            <li><strong>Estado Documentos:</strong>
                            <?php echo $e['estado_d'] ?>
                            </li>
                            
                            <li><strong>Observaciones:</strong>
                            <?php echo $e['observaciones'] ?>
                            </li>
                        </ul>


                        <?php }
                        
                        $evContrato = 0; ?>
                                                <!-- </div> -->

                    <?php } else if ($pasantia) { ?>
                        <?php foreach ($pasantia as $p) { ?>
                                <!-- <div class="etapa"> -->

                                <ul>
                                    <li><strong>CODIGO DE PASANTIA: </strong>
                                    <?php echo $p['cod_pasantia'] ?>
                                    </li>
                                    <li><strong>EMPRESA : </strong>
                                    <?php echo $p['Empresa_Vinculada'] ?>
                                    </li>
                                    <li><strong>FECHA INICIO : </strong>
                                    <?php echo $p['fecha_Inicio'] ?>
                                    </li>
                                    <li><strong>FECHA FINAL : </strong>
                                    <?php echo $p['fecha_Final'] ?>
                                    </li>
                                    <li><strong>HORAS REALIZADAS : </strong>
                                    <?php echo $p['Horas_Realizadas'] ?>
                                    </li>
                                    <li><strong>HOJA DE VIDA : </strong>
                                    <?php echo $p['hojaVida'] ?>
                                    </li>
                                    <li><strong>HORARIOS : </strong>
                                    <?php echo $p['horario'] ?>
                                    </li>
                                    <li><strong>CONSTANCIA DE PASANTIA : </strong>
                                    <?php echo $p['constancia_Pasantia'] ?>
                                    </li>
                                    <li><strong>CARTA DE PRESENTACION : </strong>
                                    <?php echo $p['carta_Presentacion'] ?>
                                    </li>
                                    <li><strong>ARL : </strong>
                                    <?php echo $p['arl'] ?>
                                    </li>
                                    <li><strong>ACUERDO PASANTIA : </strong>
                                    <?php echo $p['acuerdo_Pasantia'] ?>
                                    </li>
                                    <li><strong>PLANILLAS : </strong>
                                    <?php echo $p['planilla'] ?>
                                    </li>
                                    <li> <a href="../modalidades/pasantia/actualizarP.php?id=<?php echo $cod_Est ?>">Actualizar
                                            Pasantia</a>
                                    </li>

                        </ul>  
                                
                                <!-- </div> -->

                        <?php }

                        $pasantia = 0; ?>

                        
                        <?php foreach ($evPasantia as $d) { ?>

                           <ul>
                                <h1>Evaluacion</h1>

                                <li><strong>Fecha:</strong>
                                <?php echo $d['fecha_Evaluacion'] ?>
                                </li>

                                <li><strong>Responsable de la evaluacion:</strong>
                                <?php echo $d['quien_Realizo'] ?>
                                </li>

                                <li><strong>Nota:</strong>
                                <?php echo $d['nota'] ?>
                                </li>

                                <li><strong>Estado Practicas:</strong>
                                <?php echo $d['estado_p'] ?>
                                </li>
                                
                                <li><strong>Estado Documentos:</strong>
                                <?php echo $d['estado_d'] ?>
                                </li>
                                
                                <li><strong>Observaciones:</strong>
                                <?php echo $d['observaciones'] ?>
                                </li>

                            </ul>


                            <?php }
                            
                            $evPasantia = 0; ?>

                        </div>
                <?php } else if ($proyecto) { ?>
                            <!-- <div class="etapa"> -->

                    <?php foreach ($proyecto as $p) { ?>

                                <ul>
                                    <li><strong>Codigo Proyecto : </strong>
                                <?php echo $p['cod_Pro_Est'] ?>
                                    </li>
                                    <li><strong>Nombre Del Proyecto : </strong>
                                <?php echo $p['nombre_proyecto'] ?>
                                    </li>
                                    <li><strong>Fecha Presentacion De Trabajo Escrito : </strong>
                                <?php echo $p['fecha_P_Trabajo'] ?>
                                    </li>
                                    <li><strong>Fecha De Sustentacion : </strong>
                                <?php echo $p['fecha_Sustentacion'] ?>
                                    </li>
                                    <li><strong>Nota Final : </strong>
                                <?php echo $p['nota_Final'] ?>
                                    </li>
                                    <li><strong>Observaciones : </strong>
                                <?php echo $p['observacion_Proyecto'] ?>
                                    </li>
                                    <li><strong>Docente Asesoria : </strong>
                                <?php echo $p['docente_Asesoria'] ?>
                                    </li>
                                    <li><a href="../modalidades/proyecto/actualizarProyecto.php?id=<?php echo $cod_Est ?>">Actualizar
                                            Proyecto</a></li>
                                </ul>
                        <?php $proyecto = 0;
                    } ?>
                            <!-- </div> -->
                <?php } else if ($homologacion) { ?>
                                <!-- <div class="etapa"> -->
                    <?php foreach ($homologacion as $h) { ?>
                                    <ul>
                                        <li><strong>CODIGO DE HOMOLOGACION : </strong>
                                <?php echo $h['cod_Homolog_Est'] ?>
                                        </li>
                                        <li><strong>EMPRESA : </strong>
                                <?php echo $h['empresa_Homolog'] ?>
                                        </li>
                                        <li><strong>FECHA SOLICITUD : </strong>
                                <?php echo $h['fecha_Solicitud'] ?>
                                        </li>
                                        <li><strong>FECHA APROBACION : </strong>
                                <?php echo $h['fecha_Aprobacion'] ?>
                                        </li>
                                        <li><strong>ESTADO : </strong>
                                <?php echo $h['estado_Homomlogacion'] ?>
                                        </li>
                                        </li>
                                        <li><strong>OBSERVACION: </strong>
                                <?php echo $h['observaciones_Homolog'] ?>
                                        </li>
                                        <li><a href="../modalidades/homolog/actualizarH.php?id=<?php echo $cod_Est ?>">Actualizar Datos</a>
                                        </li>
                                    </ul>

                    <?php }
                    $contrato = 0; ?>
                                <!-- </div> -->

                <?php } else { ?>

                                <!-- <div class="etapa"> -->
                                <h3>No Hay Una Modalidad Asignada</h3>
                                <div class="modalidad">
                                    <a href="../modalidades/contrato/crearContrato.php?id=<?php echo $cod_Est; ?>">Contrato De Aprendizaje</a>
                                    <a href="../modalidades/pasantia/crearPasantia.php?id=<?php echo $cod_Est; ?>">Pasantias</a>
                                    <a href="../modalidades/homolog/crearHomolog.php?id=<?php echo $cod_Est; ?>">Homologacion</a>
                                    <a href="../modalidades/proyecto/crearProyecto.php?id=<?php echo $cod_Est; ?>">Proyecto</a>
                                </div>
                                <!-- </div> -->
                <?php }
                    $cod_Est = 0; ?>
            </div>

</body>