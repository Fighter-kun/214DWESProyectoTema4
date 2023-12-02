<!DOCTYPE html>
<!--
        Descripción: CodigoEjercicio6PDO
        Autor: Carlos García Cachón
        Fecha de creación/modificación: 08/11/2023
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Carlos García Cachón">
        <meta name="description" content="CodigoEjercicio6PDO">
        <meta name="keywords" content="CodigoEjercicio, 6PDO">
        <meta name="generator" content="Apache NetBeans IDE 19">
        <meta name="generator" content="60">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Carlos García Cachón</title>
        <link rel="icon" type="image/jpg" href="../webroot/media/images/favicon.ico"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../webroot/css/style.css">
        <style>
            .obligatorio {
                background-color: #ffff7a;
            }
            .bloqueado:disabled {
                background-color: #665 ;
                color: white;
            }
            .error {
                color: red;
                width: 450px;
            }
            .errorException {
                color:#FF0000;
                font-weight:bold;
            }
            .respuestaCorrecta {
                color:#4CAF50;
                font-weight:bold;
            }
        </style>
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
                        // Incluyo la libreria de validación para comprobar los campos
                        require_once '../core/231018libreriaValidacion.php';
                        // Incluyo la configuración de conexión a la BD
                        require_once '../config/confDBPDO.php';
                        
                        // Defino una constante para la fecha y hora actual
                        define('FECHA_ACTUAL', date('Y-m-d H:i:s'));

                        try {
                            // CONEXION CON LA BD
                            // Establecemos la conexión por medio de PDO
                            $miDB = new PDO(DSN, USERNAME, PASSWORD);
                            echo ("<div class='respuestaCorrecta'>CONEXIÓN EXITOSA POR PDO</div><br><br>"); // Mensaje si la conexión es exitosa

                            // CONSULTAS Y TRANSACCION
                            $miDB->beginTransaction(); // Deshabilitamos el modo autocommit

                            // Consultas SQL de inserción 
                            $consultaInsercion = "INSERT T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) "
                                    . "VALUES (:CodDepartamento, :DescDepartamento, :FechaCreacionDepartamento, :VolumenDeNegocio, :FechaBajaDepartamento)";

                            // Preparamos las consultas
                            $resultadoconsultaInsercion = $miDB->prepare($consultaInsercion);
                            
                            // ARRAY CON REGISTROS
                            $aDepartamentosNuevos  = [
                                ['CodDepartamento' => 'AAG','DescDepartamento' => 'Departamento de Montaje', 'FechaCreacionDepartamento' => FECHA_ACTUAL, 'VolumenDeNegocio' => 50, 'FechaBajaDepartamento' => null],
                                ['CodDepartamento' => 'AAH','DescDepartamento' => 'Departamento de Desmontaje', 'FechaCreacionDepartamento' => FECHA_ACTUAL, 'VolumenDeNegocio' => 700, 'FechaBajaDepartamento' => null]
                                ];
                            
                            foreach($aDepartamentosNuevos as $departamento){ //Recorremos los registros que vamos a insertar en la tabla
                                $aResgistros = [':CodDepartamento' => $departamento['CodDepartamento'], 
                                               ':DescDepartamento' => $departamento['DescDepartamento'], 
                                               ':FechaCreacionDepartamento' => $departamento['FechaCreacionDepartamento'],
                                               ':VolumenDeNegocio' => $departamento['VolumenDeNegocio'],
                                               ':FechaBajaDepartamento' => $departamento['FechaBajaDepartamento']];
                            }

                            $miDB->commit(); // Confirma los cambios y los consolida
                                echo ("<div class='respuestaCorrecta'>Los datos se han insertado correctamente en la tabla Departamento.</div>");

                                // Preparamos y ejecutamos la consulta SQL
                                $consulta = "SELECT * FROM T02_Departamento";
                                $resultadoConsultaPreparada = $miDB->prepare($consulta);
                                $resultadoConsultaPreparada->execute();

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

                                /* Aqui recorremos todos los valores de la tabla, columna por columna, usando el parametro 'PDO::FETCH_ASSOC' , 
                                 * el cual nos indica que los resultados deben ser devueltos como un array asociativo, donde los nombres de las columnas de 
                                 * la tabla se utilizan como claves (keys) en el array.
                                 */
                                echo ("<tbody>");
                                while ($oDepartamento = $resultadoConsultaPreparada->fetchObject()) {
                                    echo ("<tr>");
                                    echo ("<td>".$oDepartamento->T02_CodDepartamento."</td>");
                                    echo ("<td>".$oDepartamento->T02_DescDepartamento."</td>");
                                     echo ("<td>".$oDepartamento->T02_FechaCreacionDepartamento."</td>");
                                      echo ("<td>".$oDepartamento->T02_VolumenDeNegocio."</td>");
                                      echo ("<td>".$oDepartamento->T02_FechaBajaDepartamento."</td>");
                                    echo ("</tr>");
                                }

                                echo ("</tbody>");
                                /* Ahora usamos la función 'rowCount()' que nos devuelve el número de filas afectadas por la consulta y 
                                 * almacenamos el valor en la variable '$numeroDeRegistros'
                                 */
                                $numeroDeRegistrosConsultaPreparada = $resultadoConsultaPreparada->rowCount();
                                // Y mostramos el número de registros
                                echo ("<tfoot ><tr style='background-color: #666; color:white;'><td colspan='5'>Número de registros en la tabla Departamento: ".$numeroDeRegistrosConsultaPreparada.'</td></tr></tfoot>');
                                echo ("</table>");
                                echo ("</div>");
                        } catch (PDOException $miExcepcionPDO) {
                            $miDB->rollback(); //  Revierte o deshace los cambios
                            $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
                            $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

                            echo ("<div class='errorException'>Hubo un error al insertar los datos en la tabla Departamento.<br></div>");
                            echo "<span class='errorException'>Error: </span>" . $mensajeExcepcion . "<br>"; // Mostramos el mensaje de la excepción
                            echo "<span class='errorException'>Código del error: </span>" . $errorExcepcion; // Mostramos el código de la excepción
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