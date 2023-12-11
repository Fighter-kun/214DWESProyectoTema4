<?php
/**
 * @author Carlos García Cachón
 * @version 1.0
 * @since 30/11/2023
 * @copyright Todos los derechos reservados Carlos García 
 * 
 * @Annotation Scrip de carga inicial de la base de datos en Explotación
 * 
 */
try {
    define('DSN', 'mysql:host=db5014806801.hosting-data.io;dbname=dbs12302455'); // Host y nombre de la base de datos
    define('USERNAME','dbu132588'); // Nombre de usuario de la base de datos
    define('PASSWORD','daw2_Sauces'); // Contraseña de la base de datos
    // Crear conexión
    $conn = new PDO(DSN, USERNAME, PASSWORD);

    // Cargamos los valores a la tabla T02_Departamento
    $consulta = <<<CONSULTA
            INSERT INTO dbs12302455.T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES
                ('AAA', 'Departamento de Ventas', NOW(), 100000.50, NULL),
                ('AAB', 'Departamento de Marketing', NOW(), 50089.50, NULL),
                ('AAC', 'Departamento de Finanzas', NOW(), 600.50, '2023-11-13 13:06:00');
            CONSULTA;
    $consultaPreparada = $conn->prepare($consulta);
    $consultaPreparada->execute();

    echo "<span style='color:green;'>Valores cargados correctamente</span>"; // Mostramos el mensaje si la consulta se a ejecutado correctamente
} catch (PDOException $miExcepcionPDO) {
    $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
    $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

    echo "<span style='color:red;'>Error: </span>" . $mensajeExcepcion . "<br>"; // Mostramos el mensaje de la excepción
    echo "<span style='color:red;'>Código del error: </span>" . $errorExcepcion; // Mostramos el código de la excepción
    die($miExcepcionPDO);
} finally {
    // Cerrar la conexión
    if (isset($conn)) {
        $conn = null;
    }
}



