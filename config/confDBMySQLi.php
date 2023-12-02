<?php
/**
 * @author Carlos García Cachón
 * @version 1.2 
 * @since 01/12/2023
 * Archivo de configuración de la BD del Instituto para MySQLi
*/
// Archivo de configuración de la BD del Instituto
if ($_SERVER['SERVER_NAME'] == 'daw214.isauces.local') {
    define('DSN', '192.168.20.19'); // Dirección del servidor
    define('DBNAME', 'DB214DWESProyectoTema4'); // Nombre de la base de datos
    define('USERNAME', 'user214DWESProyectoTema4'); // Nombre de usuario de la base de datos
    define('PASSWORD', 'paso'); // Contraseña de la base de datos
    // Archivo de configuración de la BD de Explotación
    } elseif ($_SERVER['SERVER_NAME'] == 'daw214.ieslossauces.es') {
        define('DSN', 'db5014806801.hosting-data.io'); // Dirección del servidor
        define('DBNAME', 'dbs12302455'); // Nombre de la base de datos
        define('USERNAME','dbu132588'); // Nombre de usuario de la base de datos
        define('PASSWORD','daw2_Sauces'); // Contraseña de la base de datos
    }