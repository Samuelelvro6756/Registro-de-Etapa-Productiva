# Documentación del Proyecto: Etapa Productiva

## Descripción General
El proyecto **Etapa Productiva** es una aplicación web orientada a la gestión y seguimiento de las prácticas profesionales o etapa productiva de estudiantes. De acuerdo con los recursos gráficos, parece estar desarrollado para una institución educativa ("Politécnico Master Web"). La plataforma permite administrar la información de los aprendices, gestionar sus diferentes modalidades de práctica (pasantías, contratos de aprendizaje), y registrar tutorías y evaluaciones.

## Lenguajes y Tecnologías
Basado en la estructura de directorios y archivos extraídos, el proyecto está construido con el siguiente *stack* tecnológico:

*   **Backend:** PHP. Se evidencia a través del archivo de configuración `db.php`, encargado de gestionar la lógica del servidor y la conexión a los datos.
*   **Base de Datos:** MySQL / MariaDB. El archivo `etapa.sql` contiene el esquema, las tablas y probablemente los datos iniciales necesarios para levantar el modelo relacional del sistema.
*   **Frontend (Estilos):** CSS3. El proyecto tiene una arquitectura modular para el diseño, separando las hojas de estilo según la vista o componente (ej. `header.css`, módulos de estudiantes, citas y buscador).
*   **Frontend (Estructura e Interacción):** HTML y JavaScript. Aunque no se listan explícitamente en el volcado, son tecnologías implícitas necesarias para estructurar las vistas y manejar la interactividad del lado del cliente.

## Módulos y Funcionamiento
El sistema se divide en varios módulos clave, cada uno con interfaces dedicadas:

### 1. Gestión de Estudiantes (`/css/estudiante/`)
Módulo encargado del CRUD (Crear, Leer, Actualizar, Borrar) de los alumnos que se encuentran en su etapa práctica.
*   **Creación:** Registro de nuevos perfiles (`crearE.css`).
*   **Actualización:** Modificación de datos existentes (`actualizarE.css`).
*   **Consulta:** Paneles para ver la información detallada de cada estudiante (`conEstu.css`, `estudiante.css`).

### 2. Control de Citas y Procesos (`/css/citas/`)
Este es el núcleo operativo de la aplicación. Permite hacer un seguimiento de las diferentes etapas y modalidades en las que participa el estudiante:
*   **Pasantías:** Gestión de prácticas corporativas (`pasantia.css`, `pasantiaA.css`).
*   **Contratos:** Seguimiento administrativo de contratos de aprendizaje (`contrato.css`, `contratoA.css`).
*   **Asesorías:** Registro de reuniones, tutorías o seguimientos entre el docente/asesor y el estudiante (`asesoria.css`, `asesoriaA.css`).
*   **Evaluación:** Interfaz para calificar el desempeño del alumno al finalizar o durante su etapa (`evaluacion.css`).

### 3. Componentes Transversales
*   **Buscador (`/css/buscador/`):** Herramienta para localizar rápidamente estudiantes, contratos o procesos dentro del sistema (`buscador.css`).
*   **Interfaz y Branding (`/css/imagenes/`):** Recursos visuales como fondos (`bg.jpg`), íconos (`lapiz.jpg`) y la identidad gráfica de la institución (`logo_politecnicomasterweb.png`).
*   **Configuración (`/config/`):** Mantiene separada la capa de conexión y bases de datos por seguridad y buenas prácticas.

Usuario: AdminPMW
contraseña: pmw123
