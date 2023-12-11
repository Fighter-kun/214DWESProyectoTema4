<!DOCTYPE html>
<!--
        Descripción: CodigoEjercicio7JSON
        Autor: Carlos García Cachón
        Fecha de creación/modificación: 16/11/2023
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Carlos García Cachón">
        <meta name="description" content="CodigoEjercicio7JSON">
        <meta name="keywords" content="CodigoEjercicio, 7JSON">
        <meta name="generator" content="Apache NetBeans IDE 19">
        <meta name="generator" content="60">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Carlos García Cachón</title>
        <link rel="icon" type="image/jpg" href="../webroot/media/images/favicon.ico"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../webroot/css/style.css">
        <style>
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
            <h1>7. Página web que toma datos de un fichero json y los añade a la tabla T02_Departamento de nuestra base de datos. El fichero importado se encuentra en el directorio .../tmp/ del servidor:</h1>
        </header>
        <main>
            <div class="container mt-3">
                <div class="row d-flex justify-content-start">
                    <div class="col">
                        <?php
                        /**
                         * @author Carlos García Cachón
                         * @version 1.0
                         * @since 16/11/2023
                         */
                        // Incluyo la configuración de conexión a la BD
                        require_once '../config/confDBPDO.php';

                        /*                         * Funciones para tener un mayor control sobre nuestros errores
                         *
                         * La función ini_set('display_errors', 1); es una instrucción de configuración en PHP que se utiliza para activar la visualización de 
                          errores en tiempo de ejecución en el navegador web.
                         * Mostrará los errores directamente en la página web si ocurren durante la ejecución del script PHP.
                         */
                        ini_set('display_errors', 1);

                        /*                         * Se utiliza para activar la visualización de errores que ocurren durante 
                         * el inicio del script, es decir, durante la fase de arranque (startup) del proceso PHP. */
                        ini_set('display_startup_errors', 1);

                        /**
                         * Establece el nivel de error que se informará durante la ejecución de un script PHP. 
                         * En este caso, E_ALL es una constante que representa todos los tipos de errores posibles en PHP.
                         */
                        error_reporting(E_ALL);

                        // Declaro una variable de entrada para mostrar o no la tabla con los valores de la BD
                        $bEntradaOK = true;

                        //Abro un bloque try catch para tener un mayor control de los errores
                        try {
                            // CONEXION CON LA BD
                            /**
                             * Establecemos la conexión por medio de PDO
                             * DSN -> IP del servidor y Nombre de la base de datos
                             * USER -> Usuario con el que se conecta a la base de datos
                             * PASSWORD -> Contraseña del usuario
                             * */
                            $miDB = new PDO(DSN, USERNAME, PASSWORD);

                            // Indicamos la ruta del archivo y la guardamos en una variable
                            $rutaArchivoJSON = '../tmp/departamentos.json';
                            
                            // Leemos el contenido del archivo JSON
                            $contenidoArchivoJSON = file_get_contents($rutaArchivoJSON);

                            // Decodificamos el JSON a un array asociativo
                            $aContenidoDecodificadoArchivoJSON = json_decode($contenidoArchivoJSON, true);
                            
                            // Verificamos si la decodificación fue exitosa
                            if ($aContenidoDecodificadoArchivoJSON === null && json_last_error() !== JSON_ERROR_NONE) {
                                // En caso negativo "matamos" la ejecución del script
                                die('Error al decodificar el archivo JSON.');
                            }
                            
                            // CONSULTAS Y TRANSACCION
                            $miDB->beginTransaction(); // Deshabilitamos el modo autocommit

                            // Consultas SQL de inserción 
                            $consultaInsercion = "INSERT IGNORE INTO T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) "
                                    . "VALUES (:CodDepartamento, :DescDepartamento, :FechaCreacionDepartamento, :VolumenDeNegocio, :FechaBajaDepartamento)";

                            // Preparamos las consultas
                            $resultadoconsultaInsercion = $miDB->prepare($consultaInsercion);
 
                            foreach ($aContenidoDecodificadoArchivoJSON as $departamento) { 
                                // Recorremos los registros que vamos a insertar en la tabla
                                $codDepartamento = $departamento['codDepartamento'];
                                $descDepartamento = $departamento['descDepartamento'];
                                $fechaCreacionDepartamento = $departamento['fechaCreacionDepartamento'];
                                $volumenNegocio = $departamento['volumenNegocio'];
                                $fechaBajaDepartamento = $departamento['fechaBajaDepartamento'];

                                // Si la fecha de baja está vacía asignamos el valor 'NULL'
                                if (empty($fechaBajaDepartamento)) {
                                    $fechaBajaDepartamento = NULL;
                                }

                                $aRegistros = [
                                    ':CodDepartamento' => $codDepartamento,
                                    ':DescDepartamento' => $descDepartamento,
                                    ':FechaCreacionDepartamento' => $fechaCreacionDepartamento,
                                    ':VolumenDeNegocio' => $volumenNegocio,
                                    ':FechaBajaDepartamento' => $fechaBajaDepartamento
                                ];

                                $resultadoconsultaInsercion->execute($aRegistros);
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

                            //Controlamos las excepciones mediante la clase PDOException
                        } catch (PDOException $miExcepcionPDO) {
                            /**
                             * Revierte o deshace los cambios
                             * Esto solo se usara si estamos usando consultas preparadas
                             */
                            $miDB->rollback();

                            //Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
                            $errorExcepcion = $miExcepcionPDO->getCode();

                            // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'
                            $mensajeExcepcion = $miExcepcionPDO->getMessage();

                            // Mostramos el mensaje de la excepción
                            echo "<span style='color: red'>Error: </span>" . $mensajeExcepcion . "<br>";

                            // Mostramos el código de la excepción
                            echo "<span style='color: red'>Código del error: </span>" . $errorExcepcion;

                            //En culaquier cosa cerramos la sesion
                        } finally {
                            // El metodo unset sirve para cerrar la sesion con la base de datos
                            unset($miDB);
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