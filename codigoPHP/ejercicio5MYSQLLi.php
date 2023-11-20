<!DOCTYPE html>
<!--
        Descripción: CodigoEjercicio5MYSQLLI
        Autor: Carlos García Cachón
        Fecha de creación/modificación: 20/11/2023
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Carlos García Cachón">
        <meta name="description" content="CodigoEjercicio5MYSQLLI">
        <meta name="keywords" content="CodigoEjercicio, 5MYSQLLI">
        <meta name="generator" content="Apache NetBeans IDE 19">
        <meta name="generator" content="60">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Carlos García Cachón</title>
        <link rel="icon" type="image/jpg" href="../webroot/media/images/favicon.ico"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../webroot/css/style.css">
        <style>
            .respuestaCorrecta {
                color:#4CAF50;
                font-weight:bold;
            }
        </style>
    </head>

    <body>
        <header class="text-center">
            <h1>5. Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno:</h1>
        </header>
        <main>
            <div class="container mt-3">
                <div class="row d-flex justify-content-start">
                    <div class="col">
                        <?php
                        /**
                         * @author Carlos García Cachón
                         * @version 1.0
                         * @since 20/11/2023
                         */
                        // Incluyo la configuración de conexión a la BD
                        require_once '../config/confDB_MySQLLi.php';

                        try {
                            // CONEXION CON LA BD
                            // Establecemos la conexión por medio de mysqli
                            $mysqli = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);
                            echo ("<div class='respuestaCorrecta'>CONEXIÓN EXITOSA POR MYSQLI</div><br><br>"); // Mensaje si la conexión es exitosa
                            // CONSULTAS Y TRANSACCION
                            $mysqli->autocommit(false); // Deshabilitamos el modo autocommit
                            // Consultas SQL de inserción 
                            $consultaInsercion1 = "INSERT INTO T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES ('AAD', 'Departamento de Cobro', now(), 300, NULL)";
                            $consultaInsercion2 = "INSERT INTO T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES ('AAE', 'Departamento de I+D', now(), 10000, NULL)";
                            $consultaInsercion3 = "INSERT INTO T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES ('AAF', 'Departamento de Inmuebles', now(), 30, NULL)";

                            // Preparamos las consultas
                            $resultadoconsultaInsercion1 = $mysqli->prepare($consultaInsercion1);
                            $resultadoconsultaInsercion2 = $mysqli->prepare($consultaInsercion2);
                            $resultadoconsultaInsercion3 = $mysqli->prepare($consultaInsercion3);

                            // Ejecuto las consultas preparadas y mostramos la tabla en caso 'true' o un mensaje de error en caso de 'false'.
                            // (La función 'execute()' devuelve un valor booleano que indica si la consulta se ejecutó correctamente o no.)
                            if ($resultadoconsultaInsercion1->execute() && $resultadoconsultaInsercion2->execute() && $resultadoconsultaInsercion3->execute()) {
                                $mysqli->commit(); // Confirma los cambios y los consolida
                                echo ("<div class='respuestaCorrecta'>Los datos se han insertado correctamente en la tabla Departamento.</div>");

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
                                    echo ("<td>" . $oDepartamento->T02_CodDepartamento . "</td>");
                                    echo ("<td>" . $oDepartamento->T02_DescDepartamento . "</td>");
                                    echo ("<td>" . $oDepartamento->T02_FechaCreacionDepartamento . "</td>");
                                    echo ("<td>" . $oDepartamento->T02_VolumenDeNegocio . "</td>");
                                    echo ("<td>" . $oDepartamento->T02_FechaBajaDepartamento . "</td>");
                                    echo ("</tr>");
                                }

                                echo ("</tbody>");
                                /* Usamos la función 'num_rows' para obtener el número de filas afectadas por la consulta */
                                $numeroDeRegistrosResultado = $resultado->num_rows;
                                // Y mostramos el número de registros
                                echo ("<tfoot ><tr style='background-color: #666; color:white;'><td colspan='5'>Número de registros en la tabla Departamento: " . $numeroDeRegistrosResultado . '</td></tr></tfoot>');
                                echo ("</table>");
                                echo ("</div>");
                            }
                        } catch (mysqli_sql_exception $ex) {
                            $mysqli->rollback();
                            echo ("<div style='color: red' class='fs-4 text'>" . $ex->getCode() . " : " . $ex->getMessage()."</div>");
                        } finally {
                            unset($miDB); // Para cerrar la conexión
                        }
                        ?>
                    </div>
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