create database EtapaProductiva;
use EtapaProductiva;
drop database EtapaProductiva; 


create table administrador (
nombre_Admin varchar (30) default 'Admin' primary key,
contrasenia varchar (255) not null
); 

insert into administrador values ("Admin", "12345");
insert into administrador values ("Flor", "12345");

select * from administrador;
 call ValidadorrCredenciales ("Admin", "12345");

DELIMITER //
CREATE PROCEDURE ValidadorrCredenciales(
    IN p_nombre_Admin VARCHAR(30),
    IN p_contrasenia VARCHAR(255)
)
BEGIN
    DECLARE contador INT;

    SELECT COUNT(*) INTO contador
    FROM administrador
    WHERE nombre_Admin = p_nombre_Admin AND contrasenia = p_contrasenia;

    IF contador > 0 THEN
        SELECT 'Credenciales válidas' AS Mensaje;
    ELSE
        SELECT 'Credenciales inválidas' AS Mensaje;
    END IF;
END //
DELIMITER ;
 
/*Creacion de tabla para Almacenar Tecnicos */
create table tecnico (
cod_Tecnico int primary key,
nombre_Tecnico varchar(90)
);


	select * from tecnico;
-- Creacion de Procedimiento de almacenaodo para Tecnico

delimiter //
create procedure Insertar__tecnicos(
    in cod_Tecnico_ int,
    in nombre varchar(90)
)
begin
    insert into tecnico (cod_Tecnico, nombre_tecnico) values (cod_Tecnico_, nombre);
end //
delimiter ;





-- creacion tabla De Estudiante 
	
    create table estudiante (
	codigo_Est bigint primary key,
    ident_Estudiante char (15) not null,
    primer_Nombre varchar (20) not null,
    segundo_Nombre varchar (20) default '',
    primer_Apellido varchar (20) not null,
    segundo_Apellido varchar (20) default '',
    telefono char (10),
    semestre varchar (10) not null,
	cod_Tecnico_Est int,
    foreign key (cod_Tecnico_Est) references tecnico (cod_Tecnico)
    );
    
    select * from estudiante;
    delete from estudiante where codigo_Est = 6094;

-- Creacion de procediento de Estudiante con sus validaciones 

delimiter //
create procedure insertarestudiante(
    in codigoestudiante bigint,
    in identificacionestudiante char(15),
    in primernombre varchar(20),
    in segundonombre varchar(20),
    in primerapellido varchar(20),
    in segundoapellido varchar(20),
    in telefono char(10),
    in semestre varchar(10),
    in codtecnicoestudiante int
)
begin
    declare existetecnico int;


    select count(*) into existetecnico from tecnico where cod_tecnico = codtecnicoestudiante;

   
    if existetecnico > 0 then
        insert into estudiante (codigo_est, ident_estudiante, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, telefono, semestre, cod_tecnico_est)
        values (codigoestudiante, identificacionestudiante, primernombre, segundonombre, primerapellido, segundoapellido, telefono, semestre, codtecnicoestudiante);
        
        select 'estudiante insertado correctamente' as resultado;
    else
        select 'el técnico no existe, no se puede insertar el estudiante' as resultado;
    end if;
end //

delimiter ;




DELIMITER //
	
CREATE PROCEDURE actualizar_estudiante(
    IN codigo_est_input bigint,
    IN identificacion_input char(15),
    IN primer_nombre_input varchar(20),
    IN segundo_nombre_input varchar(20),
    IN primer_apellido_input varchar(20),
    IN segundo_apellido_input varchar(20),
    IN telefono_input char(10),
    IN semestre_ varchar (10),
    IN cod_tecnico_est_input int
)
BEGIN
    DECLARE tecnico_existente INT;

    SELECT COUNT(*) INTO tecnico_existente FROM tecnico WHERE cod_tecnico = cod_tecnico_est_input;

    IF tecnico_existente = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El código de técnico no existe en la tabla "tecnico".';
    ELSE
        UPDATE estudiante
        SET ident_estudiante = identificacion_input,
            primer_nombre = primer_nombre_input,
            segundo_nombre = segundo_nombre_input,
            primer_apellido = primer_apellido_input,
            segundo_apellido = segundo_apellido_input,
            telefono = telefono_input,
            semestre = semestre_,
            cod_tecnico_est = cod_tecnico_est_input
        WHERE codigo_est = codigo_est_input;
    END IF;
END //

DELIMITER ;


-- creacion de tablas de modalidades (contrato, pasantias,homologacion y proyecto)

create table contrato_Aprendizaje (
	cod_ContratoA int primary key
);

create table pasantias (
	cod_Pasantia int primary key
);

create table proyecto (
	cod_Proyecto int primary key
);

create table homologacion (
cod_homolg int primary key
);
    

-- Creacion de tabla Estudiante con Contrato de Aprendizaje

create table contrato_Estudiante (
cod_Est_Cont bigint,
cod_ContratoA_Est int,
empresa_Vinculada varchar (90),
fecha_Incio datetime not null,
fecha_Final datetime null,
horarios varchar (100),
copia_Contrato boolean,
constancia boolean,
foreign key (cod_Est_Cont) references estudiante (codigo_Est),
foreign key (cod_ContratoA_Est) references contrato_Aprendizaje (cod_ContratoA)
);

select * from contrato_Estudiante ;
select * from contrato_Aprendizaje;



-- Creacion de procedimiento de almacenado de Estudiante con Contrato de Aprendizaje

delimiter //
create procedure insertar_Contrato_Estudiante(
    in cod_contrato_es int,
    in cod_contratoa_est int, 
    in empresa_vinculada varchar(90),
    in fecha_inicio datetime,
    in fecha_final datetime,
    in horarios varchar(100),
    in copia_contrato boolean,
    in constancia boolean
)
begin
    declare estudiante_existente int;
    declare contratoa_est_existente int;

    select count(*) into estudiante_existente from estudiante where codigo_Est = cod_contrato_es;

    if estudiante_existente = 0 then
        signal sqlstate '45000'
        set message_text = 'El código de estudiante no existe en la tabla "estudiante".';
    else
        insert into contrato_Aprendizaje (cod_ContratoA) values (cod_contratoa_est);
        select count(*) into contratoa_est_existente from contrato_Aprendizaje where cod_ContratoA = cod_contratoa_est;

        if contratoa_est_existente = 0 then
            signal sqlstate '45000'
            set message_text = 'El código de contrato de aprendizaje no existe en la tabla "contrato_aprendizaje".';
        else
            insert into contrato_estudiante (cod_Est_Cont,cod_ContratoA_Est, empresa_Vinculada, fecha_Incio, fecha_Final, horarios, copia_Contrato, constancia)
            values (cod_contrato_es, cod_contratoa_est,empresa_vinculada, fecha_inicio, fecha_final, horarios, copia_contrato, constancia);
        end if;
    end if;
end //
delimiter ;

-- Creacion de procedimiento de almacenado para actualizar contrato Con Estudiante 

DELIMITER //

CREATE PROCEDURE ActualizarContratoEstudiante (
    IN p_cod_Est_Cont BIGINT,
    IN p_cod_ContratoA_Est INT,
    IN p_empresa_Vinculada VARCHAR(90),
    IN p_fecha_Inicio DATETIME,
    IN p_fecha_Final DATETIME,
    IN p_horarios VARCHAR(100),
    IN p_copia_Contrato BOOLEAN,
    IN p_constancia BOOLEAN
)
BEGIN
    DECLARE FOREIGN_KEY_ERROR CONDITION FOR SQLSTATE '23000';
    
    DECLARE EXIT HANDLER FOR FOREIGN_KEY_ERROR
    BEGIN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Error: Clave foránea no encontrada';
    END;

    START TRANSACTION;
    
   
    SELECT COUNT(*) INTO @estudiante_exists FROM estudiante WHERE codigo_Est = p_cod_Est_Cont;
    SELECT COUNT(*) INTO @contrato_exists FROM contrato_Aprendizaje WHERE cod_ContratoA = p_cod_ContratoA_Est;
    
    IF @estudiante_exists = 0 OR @contrato_exists = 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Error: Clave foránea no encontrada en una o ambas tablas referenciadas';
    ELSE
       
        UPDATE contrato_Estudiante
        SET
            empresa_Vinculada = p_empresa_Vinculada,
            fecha_Incio = p_fecha_Inicio,
            fecha_Final = p_fecha_Final,
            horarios = p_horarios,
            copia_Contrato = p_copia_Contrato,
            constancia = p_constancia
        WHERE
            cod_Est_Cont = p_cod_Est_Cont
            AND cod_ContratoA_Est = p_cod_ContratoA_Est;
    END IF;

    COMMIT;
END //

DELIMITER ;

create table  citas_Seguimientos_Contratos (
cod_Cita_Cont int primary key,
fecha_Realizada datetime,
responsable_Cita varchar (50) not null,
Estado varchar (20),
nota float,
observaciones varchar (900),
cod_Cita_Est bigint, 
foreign key (cod_Cita_Est) references contrato_Estudiante (cod_Est_Cont)
);

DELIMITER //

CREATE PROCEDURE InsertarCitasContrato(
    IN p_codCitaCont INT,
    IN p_fechaRealizada DATETIME,
    IN p_responsableCita VARCHAR(50),
    IN p_estado VARCHAR(20),
    IN p_nota FLOAT,
    IN p_observaciones VARCHAR(900),
    IN p_codCitaEst BIGINT
)
BEGIN
    DECLARE error_message VARCHAR(200);

   
    IF EXISTS (SELECT 1 FROM citas_Seguimientos_Contratos WHERE cod_Cita_Cont = p_codCitaCont) THEN
        SET error_message = 'El código de cita ya existe.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

    
    INSERT INTO citas_Seguimientos_Contratos (cod_Cita_Cont, fecha_Realizada, responsable_Cita, Estado, nota, observaciones, cod_Cita_Est)
    VALUES (p_codCitaCont, p_fechaRealizada, p_responsableCita, p_estado, p_nota, p_observaciones, p_codCitaEst);
END //

DELIMITER ;



DELIMITER //

CREATE PROCEDURE ActualizarCitaContrato(
    IN p_codCitaCont INT,
    IN p_fechaRealizada DATETIME,
    IN p_responsableCita VARCHAR(50),
    IN p_estado VARCHAR(20),
    IN p_nota FLOAT,
    IN p_observaciones VARCHAR(900),
    IN p_codCitaEst BIGINT
)
BEGIN
    DECLARE error_message VARCHAR(200);

    
    IF NOT EXISTS (SELECT 1 FROM citas_Seguimientos_Contratos WHERE cod_Cita_Cont = p_codCitaCont) THEN
        SET error_message = 'La cita que intenta actualizar no existe.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

   
    IF NOT EXISTS (SELECT 1 FROM contrato_Estudiante WHERE cod_Est_Cont = p_codCitaEst) THEN
        SET error_message = 'El valor de la clave foránea no existe en la tabla referenciada.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

    UPDATE citas_Seguimientos_Contratos
    SET fecha_Realizada = p_fechaRealizada,
        responsable_Cita = p_responsableCita,
        Estado = p_estado,
        nota = p_nota,
        observaciones = p_observaciones,
        cod_Cita_Est = p_codCitaEst
    WHERE cod_Cita_Cont = p_codCitaCont;
END //

DELIMITER ;



--  procedimientos de almacenado de cita Contrato

delimiter //
create procedure insertar_cita_seguimiento_contrato(
    in fecha_realizada datetime,
    in responsable_cita varchar(50),
    in estado boolean,
    in nota float,
    in cod_cita_est bigint
)
begin
    declare contrato_existente int;

    select count(*) into contrato_existente from contrato_estudiante where cod_est_cont = cod_cita_est;

    if contrato_existente = 0 then
        signal sqlstate '45000'
        set message_text = 'el código de contrato de estudiante no existe en la tabla "contrato_estudiante".';
    else
        insert into citas_seguimiento_contrato (fecha_realizada, responsable_cita, estado, nota, cod_cita_est)
        values (fecha_realizada, responsable_cita, estado, nota, cod_cita_est);
    end if;
end //
delimiter ;











-- Creacion de la tabla de Homologacion Para Estudiante 

create table homologacion_Estudiante (
 empresa_Homolog varchar (60) not null,
 fecha_Aprobacion datetime ,
 fecha_Solicitud datetime,
 estado_Homomlogacion varchar (20),
 observaciones_Homolog varchar (300),
 cod_Est_Homolog bigint,
 cod_Homolog_Est int ,
 foreign key (cod_Est_Homolog) references estudiante (codigo_Est),
 foreign key (cod_Homolog_Est) references homologacion (cod_homolg)
);

select * from estudiante;
-- creacion del procedimiento de almacenado de homogacion con Estudiante 
DELIMITER //

CREATE PROCEDURE InsertarHomologacion_Estudiantes(
    IN empresa_Homolog_param VARCHAR(60),
    IN fecha_Aprobacion_param DATETIME,
    IN fecha_Solicitud_param DATETIME,
    IN estado_Homomlogacion_param VARCHAR(20),
    IN observaciones_Homolog_param VARCHAR(300),
    IN cod_Est_Homolog_param BIGINT,
    IN cod_Homolog_Est_param INT
)
BEGIN
    DECLARE homolog_exists INT;
    DECLARE estudiante_exists INT;

   
    SELECT COUNT(*) INTO homolog_exists FROM homologacion WHERE cod_homolg = cod_Homolog_Est_param;

   
    SELECT COUNT(*) INTO estudiante_exists FROM estudiante WHERE codigo_Est = cod_Est_Homolog_param;

   
    IF homolog_exists = 0 THEN
        INSERT INTO homologacion (cod_homolg) VALUES (cod_Homolog_Est_param);
    END IF;

  
    IF estudiante_exists > 0 THEN
        INSERT INTO homologacion_Estudiante (
            empresa_Homolog,
            fecha_Aprobacion,
            fecha_Solicitud,
            estado_Homomlogacion,
            observaciones_Homolog,
            cod_Est_Homolog,
            cod_Homolog_Est
        ) VALUES (
            empresa_Homolog_param,
            fecha_Aprobacion_param,
            fecha_Solicitud_param,
            estado_Homomlogacion_param,
            observaciones_Homolog_param,
            cod_Est_Homolog_param,
            cod_Homolog_Est_param
        );
    ELSE
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El código de estudiante no existe en la tabla estudiante.';
    END IF;
END //

DELIMITER ;

-- Creacion del procedimiento de actualizar homologacion de Estudiante

DELIMITER //

CREATE PROCEDURE ActualizarHomologacionEstudiantes(
    IN empresa_Homolog_param VARCHAR(60),
    IN fecha_Aprobacion_param DATETIME,
    IN fecha_Solicitud_param DATETIME,
    IN estado_Homomlogacion_param VARCHAR(20),
    IN observaciones_Homolog_param VARCHAR(300),
    IN cod_Homolog_Est_param INT
)
BEGIN
   
    SELECT COUNT(*) INTO @homolog_exists FROM homologacion WHERE cod_homolg = cod_Homolog_Est_param;

    
    IF @homolog_exists > 0 THEN
      
        SELECT COUNT(*) INTO @estudiante_exists FROM homologacion_Estudiante WHERE cod_Homolog_Est = cod_Homolog_Est_param;

      
        IF @estudiante_exists > 0 THEN
            UPDATE homologacion_Estudiante
            SET empresa_Homolog = empresa_Homolog_param,
                fecha_Aprobacion = fecha_Aprobacion_param,
                fecha_Solicitud = fecha_Solicitud_param,
                estado_Homomlogacion = estado_Homomlogacion_param,
                observaciones_Homolog = observaciones_Homolog_param
            WHERE cod_Homolog_Est = cod_Homolog_Est_param;
        ELSE
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El registro con el código especificado no existe en la tabla homologacion_Estudiante.';
        END IF;
    ELSE
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El registro con el código especificado no existe en la tabla homologacion.';
    END IF;
END //

DELIMITER ;


select * from homologacion;


SELECT h.empresa_Homolog, h.fecha_Aprobacion, h.fecha_Solicitud, h.estado_Homomlogacion, h.observaciones_Homolog, h.cod_Est_Homolog, h.cod_Homolog_Est, e.primer_Nombre, e.primer_Apellido  FROM homologacion_Estudiante h INNER JOIN estudiante e ON h.cod_Est_Homolog = e.codigo_Est WHERE cod_Est_Homolog = 7069;

-- Creacion de Pasantias


create table Pasantias_Estudiantess (
    fecha_Inicio datetime,
    fecha_Final datetime,
    Empresa_Vinculada varchar (100),
    Horas_Realizadas bigint, 
    hojaVida datetime,
    horario varchar (150),
    constancia_Pasantia boolean,
    carta_Presentacion boolean, 
    arl boolean,
    acuerdo_Pasantia boolean,
    planilla boolean,
    cod_Pas_Est bigint,
    cod_pasantia int,
    foreign key (cod_Pas_Est) references estudiante (codigo_Est),
    foreign key (cod_pasantia) references pasantias (cod_Pasantia)
    );
    
    SELECT * FROM Pasantias_Estudiantess p INNER JOIN estudiante e ON p.cod_Pas_Est = e.codigo_Est LEFT JOIN pasantias pa ON p.cod_Pas_Est = pa.cod_Pasantia WHERE p.cod_Pas_Est = 2207 ;
    select * from Pasantias_Estudiantess ;
    -- procedimeitno de insertar de pasantias con estudiante 
 DELIMITER //

CREATE PROCEDURE InsertarPasantiaEstudiantessss(
    IN fechaInicioParam DATETIME,
    IN fechaFinalParam DATETIME,
    IN empresaVinculadaParam VARCHAR(100),
    IN horasRealizadasParam BIGINT,
    IN hojaVidaParam DATETIME,
    IN horarioParam VARCHAR(150),
    IN constanciaPasantiaParam BOOLEAN,
    IN cartaPresentacionParam BOOLEAN,
    IN arlParam BOOLEAN,
    IN acuerdoPasantiaParam BOOLEAN,
	IN   planillaParam boolean,
    IN codPasEstParam BIGINT,
    IN codPasantiaParam INT
)
BEGIN
    DECLARE existePasantia INT;
    DECLARE existeEstudiante INT;

    
    SELECT COUNT(*) INTO existePasantia FROM pasantias WHERE cod_Pasantia = codPasantiaParam;

    
    IF existePasantia = 0 THEN
        INSERT INTO pasantias (cod_Pasantia) VALUES (codPasantiaParam);
    END IF;

    
    SELECT COUNT(*) INTO existeEstudiante FROM estudiante WHERE codigo_Est = codPasEstParam;

    
    IF existeEstudiante = 0 THEN
        SELECT 'El código de estudiante no existe en la tabla estudiante';
    ELSE
       
        INSERT INTO Pasantias_Estudiantess (
            fecha_Inicio,
            fecha_Final,
            Empresa_Vinculada,
            Horas_Realizadas,
            hojaVida,
            horario,
            constancia_Pasantia,
            carta_Presentacion,
            arl,
            acuerdo_Pasantia,
            planilla,
            cod_Pas_Est,
            cod_pasantia
        ) VALUES (
            fechaInicioParam,
            fechaFinalParam,
            empresaVinculadaParam,
            horasRealizadasParam,
            hojaVidaParam,
            horarioParam,
            constanciaPasantiaParam,
            cartaPresentacionParam,
            arlParam,
            acuerdoPasantiaParam,
            planillaParam,
            codPasEstParam,
            codPasantiaParam
        );

        SELECT 'Inserción exitosa en pasantias_Estudiante';
    END IF;
END //

DELIMITER ;


-- Procedimiento para actualizar pasantia con Estudianbte 
DELIMITER //

CREATE PROCEDURE ActualizarPasantiaEstudiante (
    IN fecha_Inicio DATETIME,
    IN fecha_Final DATETIME,
    IN Empresa_Vinculada VARCHAR(100),
    IN Horas_Realizadas BIGINT,
    IN hojaVida DATETIME,
    IN horario VARCHAR(150),
    IN constancia_Pasantia BOOLEAN,
    IN carta_Presentacion BOOLEAN,
    IN arl BOOLEAN,
    IN acuerdo_Pasantia BOOLEAN,
    IN planilla BOOLEAN,
    IN codPasEstParam BIGINT,
	IN codPasantiaParam INT
)
BEGIN
    DECLARE estudiante_exist INT;
    DECLARE pasantia_exist INT;
    
    SELECT COUNT(*)
    INTO estudiante_exist
    FROM estudiante
    WHERE codigo_Est = codPasEstParam;

    SELECT COUNT(*)
    INTO pasantia_exist
    FROM pasantias
    WHERE cod_Pasantia = codPasantiaParam ;

    IF estudiante_exist = 1 AND pasantia_exist = 1 THEN
        UPDATE Pasantias_Estudiantess
        SET 
            fecha_Inicio = fecha_Inicio,
            fecha_Final = fecha_Final,
            Empresa_Vinculada = Empresa_Vinculada,
            Horas_Realizadas = Horas_Realizadas,
            hojaVida = hojaVida,
            horario = horario,
            constancia_Pasantia = constancia_Pasantia,
            carta_Presentacion = carta_Presentacion,
            arl = arl,
            acuerdo_Pasantia = acuerdo_Pasantia,
            planilla = planilla,
            cod_Pas_Est = codPasEstParam,
            cod_pasantia = codPasantiaParam
        WHERE cod_Pas_Est = codPasEstParam;

        SELECT 'Registro actualizado correctamente' AS Mensaje;
    ELSE
        SELECT 'Error: Una o ambas claves foráneas no existen' AS Mensaje;
    END IF;
END //

DELIMITER ;


    
create table  citas_Seguimiento_Pasantia (
cod_Cita_Cont int primary key,
fecha_Realizada datetime,
responsable_Cita varchar (50) not null,
Estado varchar (20),
nota float,
observaciones varchar (900),
cod_Pas_Est bigint, 
foreign key (cod_Pas_Est) references Pasantias_Estudiantess(cod_Pas_Est)
);

-- Procedimietno de almacenado de citas_Pasanias
DELIMITER //

CREATE PROCEDURE InsertarCitasPasantias(
    IN p_codCitaCont INT,
    IN p_fechaRealizada DATETIME,
    IN p_responsableCita VARCHAR(50),
    IN p_estado VARCHAR(20),
    IN p_nota FLOAT,
    IN p_observaciones VARCHAR(900),
    IN p_codPasEst BIGINT
)
BEGIN
    DECLARE error_message VARCHAR(200);


    IF EXISTS (SELECT 1 FROM citas_Seguimiento_Pasantia WHERE cod_Cita_Cont = p_codCitaCont) THEN
        SET error_message = 'El código de cita ya existe.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

    INSERT INTO citas_Seguimiento_Pasantias (cod_Cita_Cont, fecha_Realizada, responsable_Cita, Estado, nota, observaciones, cod_Pas_Est)
    VALUES (p_codCitaCont, p_fechaRealizada, p_responsableCita, p_estado, p_nota, p_observaciones, p_codPasEst);
END //

DELIMITER ;

-- Actualizacion de citas pasantias

DELIMITER //

CREATE PROCEDURE ActualizarCitaPasantia(
    IN p_codCitaCont INT,
    IN p_fechaRealizada DATETIME,
    IN p_responsableCita VARCHAR(50),
    IN p_estado VARCHAR(20),
    IN p_nota FLOAT,
    IN p_observaciones VARCHAR(900),
    IN p_codPasEst BIGINT
)
BEGIN
    DECLARE error_message VARCHAR(200);


    IF NOT EXISTS (SELECT 1 FROM citas_Seguimiento_Pasantias WHERE cod_Cita_Cont = p_codCitaCont) THEN
        SET error_message = 'La cita que intenta actualizar no existe.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

   
    IF NOT EXISTS (SELECT 1 FROM Pasantias_Estudiantess WHERE cod_Pas_Est = p_codPasEst) THEN
        SET error_message = 'El valor de la clave foránea no existe en la tabla referenciada.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

    UPDATE citas_Seguimiento_Pasantias
    SET fecha_Realizada = p_fechaRealizada,
        responsable_Cita = p_responsableCita,
        Estado = p_estado,
        nota = p_nota,
        observaciones = p_observaciones,
        cod_Pas_Est = p_codPasEst
    WHERE cod_Cita_Cont = p_codCitaCont;
END //

DELIMITER ;





SELECT p.nombre_proyecto, p.docente_Asesoria, p.fecha_P_Trabajo, p.fecha_Sustentacion, p.nota_Final, p.observacion_Proyecto, p.cod_Est_Pr, p.cod_Pro_Est, e.primer_Nombre, e.primer_Apellido FROM proyecto_Estudiante p INNER JOIN estudiante e ON p.cod_Est_Pr = e.codigo_Est WHERE p.cod_Est_Pr =  9598;


create table proyecto_Estudiante (
nombre_proyecto varchar (300) not null, 
docente_Asesoria varchar (90) not null,
fecha_P_Trabajo datetime,
fecha_Sustentacion datetime,
nota_Final float (10,2),
observacion_Proyecto varchar (1000),
cod_Est_Pr bigint,
cod_Pro_Est int,
foreign key (cod_Est_Pr) references estudiante (codigo_Est),
foreign key (cod_Pro_Est) references proyecto (cod_Proyecto)
);


create table  asesoria_Proyecto (
cod_Cita_Cont int primary key,
fecha_Realizada datetime,
responsable_Cita varchar (50) not null,
Estado varchar (20),
nota float,
observaciones varchar (900),
cod_Cita_Est bigint, 
foreign key (cod_Cita_Est) references proyecto_Estudiante (cod_Est_Pr)
);

DELIMITER //

CREATE PROCEDURE InsertarAsesoriaProyectos(
    IN p_codCitaCont INT,
    IN p_fechaRealizada DATETIME,
    IN p_responsableCita VARCHAR(50),
    IN p_estado VARCHAR(20),
    IN p_nota FLOAT,
    IN p_observaciones VARCHAR(900),
    IN p_codCitaEst BIGINT
)
BEGIN
    DECLARE error_message VARCHAR(200);

    
    IF EXISTS (SELECT 1 FROM asesoria_Proyecto WHERE cod_Cita_Cont = p_codCitaCont) THEN
        SET error_message = 'El código de cita ya existe.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

  
    IF NOT EXISTS (SELECT 1 FROM proyecto_Estudiante WHERE cod_Est_Pr = p_codCitaEst) THEN
        SET error_message = 'El valor de la clave foránea no existe en la tabla referenciada.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

   
    INSERT INTO asesoria_Proyecto (cod_Cita_Cont, fecha_Realizada, responsable_Cita, Estado, nota, observaciones, cod_Cita_Est)
    VALUES (p_codCitaCont, p_fechaRealizada, p_responsableCita, p_estado, p_nota, p_observaciones, p_codCitaEst);
END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE ActualizarAsesoriaProyectos(
    IN p_codCitaCont INT,
    IN p_fechaRealizada DATETIME,
    IN p_responsableCita VARCHAR(50),
    IN p_estado VARCHAR(20),
    IN p_nota FLOAT,
    IN p_observaciones VARCHAR(900),
    IN p_codCitaEst BIGINT
)
BEGIN
    DECLARE error_message VARCHAR(200);

    -- Verificar si la clave primaria a actualizar existe
    IF NOT EXISTS (SELECT 1 FROM asesoria_Proyecto WHERE cod_Cita_Cont = p_codCitaCont) THEN
        SET error_message = 'La cita que intenta actualizar no existe.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

    -- Verificar si el valor de la clave foránea existe en la tabla referenciada
    IF NOT EXISTS (SELECT 1 FROM proyecto_Estudiante WHERE cod_Est_Pr = p_codCitaEst) THEN
        SET error_message = 'El valor de la clave foránea no existe en la tabla referenciada.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;

    -- Actualizar los datos si las validaciones son exitosas
    UPDATE asesoria_Proyecto
    SET fecha_Realizada = p_fechaRealizada,
        responsable_Cita = p_responsableCita,
        Estado = p_estado,
        nota = p_nota,
        observaciones = p_observaciones,
        cod_Cita_Est = p_codCitaEst
    WHERE cod_Cita_Cont = p_codCitaCont;
END //

DELIMITER ;


select * from proyecto_Estudiante;
DELIMITER //

CREATE PROCEDURE InsertarProyectoYEstudiante(
    IN nombre_proyecto_param VARCHAR(300),
    IN docente_Asesoria_param VARCHAR(90),
    IN fecha_P_Trabajo_param DATETIME,
    IN fecha_Sustentacion_param DATETIME,
    IN nota_Final_param FLOAT(10, 2),
    IN observacion_Proyecto_param VARCHAR(1000),
    IN cod_Est_Pr_param BIGINT,
    IN cod_Pro_Est_param INT
)
BEGIN
    DECLARE proyecto_exists INT;

  
    SELECT COUNT(*) INTO proyecto_exists FROM proyecto WHERE cod_Proyecto = cod_Pro_Est_param;

   
    IF proyecto_exists = 0 THEN
        INSERT INTO proyecto (cod_Proyecto) VALUES (cod_Pro_Est_param);
        SELECT 'Se ha insertado un nuevo proyecto en la tabla proyecto.';
    ELSE
        SELECT 'El proyecto ya existe en la tabla proyecto. No se requiere inserción.';
    END IF;

    -- Insertar en la tabla proyecto_Estudiante
    INSERT INTO proyecto_Estudiante (
        nombre_proyecto,
        docente_Asesoria,
        fecha_P_Trabajo,
        fecha_Sustentacion,
        nota_Final,
        observacion_Proyecto,
        cod_Est_Pr,
        cod_Pro_Est
    ) VALUES (
        nombre_proyecto_param,
        docente_Asesoria_param,
        fecha_P_Trabajo_param,
        fecha_Sustentacion_param,
        nota_Final_param,
        observacion_Proyecto_param,
        cod_Est_Pr_param,
        cod_Pro_Est_param
    );

    SELECT 'Se ha insertado un nuevo registro en la tabla proyecto_Estudiante.';
END //

DELIMITER ;





DELIMITER //

CREATE PROCEDURE ActualizarProyectoEstudiante(
    IN nombre_proyecto_param VARCHAR(300),
    IN docente_Asesoria_param VARCHAR(90),
    IN fecha_P_Trabajo_param DATETIME,
    IN fecha_Sustentacion_param DATETIME,
    IN nota_Final_param FLOAT(10, 2),
    IN observacion_Proyecto_param VARCHAR(1000),
    IN cod_Est_Pr_param BIGINT,
    IN cod_Pro_Est_param INT
)
BEGIN
    DECLARE proyecto_exists INT;

  
    SELECT COUNT(*) INTO proyecto_exists FROM proyecto WHERE cod_Proyecto = cod_Pro_Est_param;

  
    IF proyecto_exists = 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El código de proyecto especificado no existe en la tabla proyecto. No se puede realizar la actualización.';
    ELSE
       
        UPDATE proyecto_Estudiante
        SET nombre_proyecto = nombre_proyecto_param,
            docente_Asesoria = docente_Asesoria_param,
            fecha_P_Trabajo = fecha_P_Trabajo_param,
            fecha_Sustentacion = fecha_Sustentacion_param,
            nota_Final = nota_Final_param,
            observacion_Proyecto = observacion_Proyecto_param
        WHERE cod_Est_Pr = cod_Est_Pr_param AND cod_Pro_Est = cod_Pro_Est_param;

        IF ROW_COUNT() = 0 THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'No se encontró el registro a actualizar en la tabla proyecto_Estudiante.';
        ELSE
            SELECT 'Se ha actualizado el registro en la tabla proyecto_Estudiante.';
        END IF;
    END IF;
END //

DELIMITER ;


CREATE TABLE evaluacionPasantia (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nombreResponsable VARCHAR(100),
    fecha_Evaluacion datetime,
    quien_Realizo varchar (50) not null,
    nota DECIMAL(5, 2),
    estado_p VARCHAR(50),
    estado_d VARCHAR(50),
    observaciones varchar (900),
    cod_Pas_Est bigint,
    FOREIGN KEY (cod_Pas_Est) REFERENCES Pasantias_Estudiantess (cod_Pas_Est)
);

SELECT * FROM evaluacionPasantia WHERE cod_Pas_Est =  1488;

CREATE TABLE evaluacionPasantiaContrato (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nombreResponsable VARCHAR(100),
    fecha_Evaluacion datetime,
    quien_Realizo varchar (50) not null,
    nota DECIMAL(5, 2),
    estado_p VARCHAR(50),
    estado_d VARCHAR(50),
    observaciones varchar (900),
    cod_Contrato_Est int,
     FOREIGN KEY (cod_Contrato_Est) REFERENCES contrato_Estudiante (cod_ContratoA_Est)
);


SELECT * FROM evaluacionPasantiaContrato WHERE cod_Contrato_Est = 8692;

