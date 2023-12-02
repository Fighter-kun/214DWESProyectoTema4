<!DOCTYPE html>
<!--
	Descripción: CodigoEjercicio2MYSQLLI
	Autor: Carlos García Cachón
	Fecha de creación/modificación: 13/11/2023
-->
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Carlos García Cachón">
  <meta name="description" content="CodigoEjercicio2MYSQLLI">
  <meta name="keywords" content="CodigoEjercicio, 2MYSQLLI">
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
        <h1>2. Mostrar el contenido de la tabla Departamento y el número de registros:</h1>
    </header>
    <main>
        <div class="container mt-3">
            <div class="row d-flex justify-content-start">
                <div class="col">
                    <h2>CONTENIDO POR MEDIO DE MYSQLLI:</h2>
                    <?php
                    /**
                     * @author Carlos García Cachón
                     * @version 1.0
                     * @since 20/11/2023
                     */
                    // Utilizamos el bloque 'try'
                    try {
                        require_once '../config/confDBMySQLi.php';
                        // Establecemos la conexión por medio de PDO
                        $mysqli = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);
                        echo ("<span style='color:green;'>CONEXIÓN EXITOSA POR MYSQLLI</span><br><br>"); // Mensaje si la conexión es exitosa

                        // Preparamos y ejecutamos la consulta SQL
                        $consulta = "SELECT * FROM T02_Departamento";
                        $resultadoConsultaPreparada = $mysqli->prepare($consulta);
                        $resultadoConsultaPreparada->execute();

                        // Obtenemos el resultado
                        $resultado = $resultadoConsultaPreparada->get_result();

                        // Creamos una tabla en la que mostraremos la tabla de la BD
                        echo ("<div class='list-group text-center'>");
                        echo ("<table>
                            <thead>
                            <tr>
                                <th>Codigo de Departamento</th>
                                <th>Descripcion de Departamento</th>
                                <th>Fecha de Creacion</th>
                                <th>Volumen de Negocio</th>
                                <th>Fecha de Baja</th>
                            </tr>
                            </thead>");

                        /* Recorremos todos los valores de la tabla, columna por columna */
                        echo ("<tbody>");
                        while ($oDepartamento = $resultado->fetch_object()) {
                            echo ("<tr>");
                            echo ("<td>".$oDepartamento->T02_CodDepartamento."</td>");
                            echo ("<td>".$oDepartamento->T02_DescDepartamento."</td>");
                            echo ("<td>".$oDepartamento->T02_FechaCreacionDepartamento."</td>");
                            echo ("<td>".$oDepartamento->T02_VolumenDeNegocio."</td>");
                            echo ("<td>".$oDepartamento->T02_FechaBajaDepartamento."</td>");
                            echo ("</tr>");
                        }

                        echo ("</tbody>");
                        /* Usamos la función 'num_rows' para obtener el número de filas afectadas por la consulta */
                        $numeroDeRegistrosResultado = $resultado->num_rows;
                        // Y mostramos el número de registros
                        echo ("<tfoot ><tr style='background-color: #666; color:white;'><td colspan='5'>Número de registros en la tabla Departamento: ".$numeroDeRegistrosResultado.'</td></tr></tfoot>');
                        echo ("</table>");
                        echo ("</div>");

                    } catch (Exception $ex) { // Si falla el 'try', mostramos el mensaje seguido del error correspondiente
                        echo ("<div style='color:red;' class='fs-4 text'>ERROR DE CONEXIÓN</div> ".$ex->getMessage());
                    } finally {
                        // Comprobamos si no hay ningún error de conexión con la BD
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