<?php
/**
 * @author Carlos García Cachón
 * @version 1.0
 * @since 27/11/2023
 * @copyright Todos los derechos reservados Carlos García 
 * 
 * @Annotation Scrip de creación de la base de datos en PHP
 * 
 */
// Configuración de conexión con la base de datos
require_once '../config/confDB.php';

try {
    // Crear conexión
    $conn = new PDO(DSN, USERNAME, PASSWORD);
    
    // Eliminar tabla de la base de datos en caso de que exista
    $query1 = "DROP TABLE IF EXISTS T02_Departamento;";
    
    // Utilizamos la base de datos 
    $query2 = "USE dbs12302455";
    
    // Creamos la tabla Departamento
    $query3 = "CREATE TABLE T02_Departamento (
        T02_CodDepartamento CHAR(3) PRIMARY KEY,
        T02_DescDepartamento VARCHAR(255),
        T02_FechaCreacionDepartamento DATETIME,
        T02_VolumenDeNegocio FLOAT,
        T02_FechaBajaDepartamento DATETIME
    )";

    // Ejecutar consultas SQL
    $sql_queries = [$query1, $query2, $query3];

    foreach ($sql_queries as $query) {
        if ($conn->query($query) === FALSE) {
            throw new Exception("Error al ejecutar la consulta: $query - " . $conn->error);
        }
        echo "Consulta ejecutada con éxito: $query<br>";
    }
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



