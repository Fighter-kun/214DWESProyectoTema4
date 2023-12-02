<!DOCTYPE html>
<!--
        Descripción: CodigoEjercicio6MYSQLLI
        Autor: Carlos García Cachón
        Fecha de creación/modificación: 08/11/2023
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Carlos García Cachón">
        <meta name="description" content="CodigoEjercicio6MYSQLLI">
        <meta name="keywords" content="CodigoEjercicio, 6MYSQLLI">
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
            <h1>6. Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada:</h1>
        </header>
        <main>
            <div class="container mt-3">
                <div class="row d-flex justify-content-start">
                    <div class="col">
                        <?php
                        /**
                         * @author Carlos García Cachón
                         * @version 1.1
                         * @since 15/11/2023
                         */
                        // Incluyo la configuración de conexión a la BD
                        require_once '../config/confDBMySQLi.php';

                        // Defino una constante para la fecha y hora actual
                        define('FECHA_ACTUAL', date('Y-m-d H:i:s'));
                        try {
                            // CONEXION CON LA BD
                            // Establecemos la conexión por medio de mysqli
                            $mysqli = new mysqli(DSN, USERNAME, PASSWORD, DBNAME);

                            // Verificar la conexión
                            if ($mysqli->connect_error) {
                                die("<span style='color:red;'>Error de conexión: " . $mysqli->connect_error . "</span>");
                            }

                            // Deshabilitar el modo autocommit
                            $mysqli->autocommit(false);

                            // ARRAY CON REGISTROS
                            $aDepartamentosNuevos = [
                                ['CodDepartamento' => 'AAG', 'DescDepartamento' => 'Departamento de Montaje', 'FechaCreacionDepartamento' => FECHA_ACTUAL, 'VolumenDeNegocio' => 50, 'FechaBajaDepartamento' => null],
                                ['CodDepartamento' => 'AAH', 'DescDepartamento' => 'Departamento de Desmontaje', 'FechaCreacionDepartamento' => FECHA_ACTUAL, 'VolumenDeNegocio' => 700, 'FechaBajaDepartamento' => null]
                            ];

                            foreach ($aDepartamentosNuevos as $departamento) {
                                // Consulta SQL de inserción 
                                $consultaInsercion = "INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) "
                                        . "VALUES (?, ?, ?, ?, ?)";

                                // Preparar la consulta
                                $resultadoconsultaInsercion = $mysqli->prepare($consultaInsercion);

                                // Vincular parámetros
                                $resultadoconsultaInsercion->bind_param("ssssi", $departamento['CodDepartamento'], $departamento['DescDepartamento'], $departamento['FechaCreacionDepartamento'], $departamento['VolumenDeNegocio'], $departamento['FechaBajaDepartamento']);

                                // Ejecutar la consulta
                                $resultadoconsultaInsercion->execute();

                                // Verificar si hubo un error en la inserción
                                if ($resultadoconsultaInsercion->errno) {
                                    throw new Exception("Error al insertar datos: " . $resultadoconsultaInsercion->error);
                                }

                                // Cerrar la consulta preparada
                                $resultadoconsultaInsercion->close();
                            }

                            // Confirmar los cambios y consolidar
                            $mysqli->commit();
                            echo "<div style='color:green;'>Los datos se han insertado correctamente en la tabla Departamento.</div>";

                            // Consultar y mostrar datos
                            $consulta = "SELECT * FROM T02_Departamento";
                            $resultadoConsulta = $mysqli->query($consulta);

                            // Crear una tabla para mostrar los datos
                            echo "<div class='list-group text-center'>";
                            echo "<table>
                                    <thead>
                                    <tr>
                                        <th>Codigo de Departamento</th>
                                        <th>Descripcion de Departamento</th>
                                        <th>Fecha de Creacion</th>
                                        <th>Volumen de Negocio</th>
                                        <th>Fecha de Baja</th>
                                    </tr>
                                    </thead>";

                            echo "<tbody>";
                            while ($oDepartamento = $resultadoConsulta->fetch_object()) {
                                echo "<tr>";
                                echo "<td>" . $oDepartamento->T02_CodDepartamento . "</td>";
                                echo "<td>" . $oDepartamento->T02_DescDepartamento . "</td>";
                                echo "<td>" . $oDepartamento->T02_FechaCreacionDepartamento . "</td>";
                                echo "<td>" . $oDepartamento->T02_VolumenDeNegocio . "</td>";
                                echo "<td>" . $oDepartamento->T02_FechaBajaDepartamento . "</td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            $numeroDeRegistrosConsulta = $resultadoConsulta->num_rows;
                            echo "<tfoot ><tr style='background-color: #666; color:white;'><td colspan='5'>Número de registros en la tabla Departamento: " . $numeroDeRegistrosConsulta . '</td></tr></tfoot>';
                            echo "</table>";
                            echo "</div>";
                        } catch (mysqli_sql_exception $ex) {
                            $mysqli->rollback();
                            echo ("<div style='color: red' class='fs-4 text'>" . $ex->getCode() . " : " . $ex->getMessage() . "</div>");
                        } finally {
                            // Cerramos la conexión
                            if ($mysqli && $mysqli->connect_errno === 0) {
                                $mysqli->close();
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