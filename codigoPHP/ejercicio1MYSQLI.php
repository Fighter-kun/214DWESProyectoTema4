<!DOCTYPE html>
<!--
	Descripción: CodigoEjercicio1MYSQLLI
	Autor: Carlos García Cachón
	Fecha de creación/modificación: 02/11/2023
-->
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Carlos García Cachón">
  <meta name="description" content="CodigoEjercicio1MYSQLLI">
  <meta name="keywords" content="CodigoEjercicio, 1MYSQLLI">
  <meta name="generator" content="Apache NetBeans IDE 19">
  <meta name="generator" content="60">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Carlos García Cachón</title>
  <link rel="icon" type="image/jpg" href="../webroot/media/images/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../webroot/css/style.css">
</head>

<body>
    <header class="text-center">
        <h1>1. Conexión a la base de datos con la cuenta usuario y tratamiento de errores:</h1>
    </header>
    <main>
        <div class="container mt-3">
            <div class="row d-flex justify-content-start">
                <div class="col">
                    <h2>CONEXION POR MEDIO DE MYSQLLI:</h2>
                    <?php
                    /**
                     * @author Carlos García Cachón
                     * @version 1.1
                     * @since 03/11/2023
                     */
                    // Incluyo el fichero que guarda la cofiguración de la conexión por MySQLLi
                    require_once '../config/confDBMySQLi.php';

                    try {
                        $mysqli = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);

                        echo ("<div style='color: green' class='fs-4 text'>Conexión exitosa a MySQL</div>" . $mysqli->host_info);
                    } catch (mysqli_sql_exception $ex) {
                        echo ("<div style='color: red' class='fs-4 text'>Fallo al conectar a MySQL (" . $mysqli->connect_errno . ")</div>" . $mysqli->connect_error);
                    } finally {
                        // Cerramos la conexión si está abierta
                        if ($mysqli && $mysqli->connect_errno === 0) {
                            $mysqli->close();
                        }
                    }
                    ?>
                    <h2>CONEXION FALLIDA POR MEDIO DE MYSQLLI:</h2>
                    <?php
                    // Incluyo el fichero que guarda la cofiguración de la conexión por MySQLLi
                    require_once '../config/confDBMySQLi.php';

                    try {
                        $mysqli = new mysqli(DSN, USERNAME, 'PASSWORD', DBNAME);

                        echo ("<div style='color: green' class='fs-4 text'>Conexión exitosa a MySQL</div>" . $mysqli->host_info);
                    } catch (Exception $ex) {
                        echo ("<div style='color: red' class='fs-4 text'>Fallo al conectar a MySQL (" . $mysqli->connect_errno . ")</div>" . $mysqli->connect_error);
                    } finally {
                        // Comprobamos si no hay ningun error de conexión con la BD
                        if ($mysqli && $mysqli->connect_errno === 0) {
                            $mysqli->close(); // Cerramos la conexión
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <footer class="position-fixed bottom-0 end-0">
        <div class="row text-center">
            <div class="footer-item">
                <address>© <a href="../../index.html" style="color: white; text-decoration: none; background-color: #666">Carlos García Cachón</a>
                    IES LOS SAUCES 2023-24 </address>
            </div>
            <div class="footer-item">
                <a href="../indexProyectoTema4.html" style="color: white; text-decoration: none; background-color: #666"> Inicio</a>
            </div>
            <div class="footer-item">
                <a href="https://github.com/Fighter-kun?tab=repositories" target="_blank"><img
                        src="../webroot/media/images/github.png" alt="LogoGitHub" class="pe-5"/></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>