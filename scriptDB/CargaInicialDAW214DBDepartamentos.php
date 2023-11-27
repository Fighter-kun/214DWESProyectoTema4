<?php
/**
 * @author Carlos García Cachón
 * @version 1.0
 * @since 27/11/2023
 * @copyright Todos los derechos reservados Carlos García 
 * 
 * @Annotation Scrip de carga inicial de la base de datos en PHP
 * 
 */
// Configuración de conexión con la base de datos
require_once '../config/confDB.php';

try {
    // Crear conexión
    $conn = new PDO(DSN, USERNAME, PASSWORD);

    // Me posiciono en la base de datos
    $query1 = "USE dbs12302455";

    // Inserto los datos iniciales en la tabla Departamento
    $query2 = "INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES
    ('AAA', 'Departamento de Ventas', '2023-11-13 13:06:00', 100000.50, NULL),
    ('AAB', 'Departamento de Marketing', '2023-11-13 13:06:00', 50089.50, NULL),
    ('AAC', 'Departamento de Finanzas', '2022-11-13 13:06:00', 600.50, '2023-11-13 13:06:00')";

    // Ejecutar consultas SQL
    $sql_queries = [$query1, $query2];

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



