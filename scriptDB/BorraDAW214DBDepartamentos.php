<?php
/**
 * @author Carlos García Cachón
 * @version 1.0
 * @since 30/11/2023
 * @copyright Todos los derechos reservados Carlos García 
 * 
 * @Annotation Scrip de borrado de la base de datos en Explotación
 * 
 */
define('DSN', 'mysql:host=db5014806801.hosting-data.io;dbname=dbs12302455'); // Host y nombre de la base de datos
define('USERNAME','dbu132588'); // Nombre de usuario de la base de datos
define('PASSWORD','daw2_Sauces'); // Contraseña de la base de datos

try {
    // Crear conexión
    $conn = new PDO(DSN, USERNAME, PASSWORD);

    // Eliminamos la tabla T02_Departamento
    $consulta = <<<CONSULTA
            DROP TABLE  dbs12302455.T02_Departamento;
            CONSULTA;
    $consultaPreparada = $conn->prepare($consulta);
    $consultaPreparada->execute();

    echo "<span style='color:green;'>Valores borrados correctamente</span>"; // Mostramos el mensaje si la consulta se a ejecutado correctamente
} catch (PDOException $miExcepcionPDO) {
    $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
    $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

    echo "<span class='errorException'>Error: </span>" . $mensajeExcepcion . "<br>"; // Mostramos el mensaje de la excepción
    echo "<span class='errorException'>Código del error: </span>" . $errorExcepcion; // Mostramos el código de la excepción
    die($miExcepcionPDO);
} finally {
    // Cerrar la conexión
    if (isset($conn)) {
        $conn = null;
    }
}



