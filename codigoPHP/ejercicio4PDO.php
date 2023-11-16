<!DOCTYPE html>
<!--
        Descripción: CodigoEjercicio4PDO
        Autor: Carlos García Cachón
        Fecha de creación/modificación: 06/11/2023
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Carlos García Cachón">
        <meta name="description" content="CodigoEjercicio4PDO">
        <meta name="keywords" content="CodigoEjercicio, 4PDO">
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
            .error {
                color: red;
                width: 450px;
            }
            input[name="DescDepartamento"] {
                width: 255px;
            }
            form {
                position: fixed; 
                top: 200px; 
                width: 70%;
            }
            .tablaMuestra {
                position: fixed;
                top: 40%;
                width: 70%;
            }
        </style>
    </head>

    <body>
        <header class="text-center">
            <h1>4. Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos):</h1>
        </header>
        <main>
            <div class="container mt-3">
                <div class="row text-center">
                    <div class="col">
                        <?php
                        /**
                         * @author Carlos García Cachón
                         * @version 1.1
                         * @since 08/11/2023
                         */
                        //Incluyo las librerias de validación para comprobar los campos
                        require_once '../core/231018libreriaValidacion.php';
                        // Incluyo la configuración de conexión a la BD
                        require_once '../config/confDB.php';

                        //Declaración de constantes por OBLIGATORIEDAD
                        define('OPCIONAL', 0);
                        define('OBLIGATORIO', 1);

                        //Declaración de variables de estructura para validar la ENTRADA de RESPUESTAS o ERRORES
                        //Valores por defecto
                        $entradaOK = true; //Indica si todas las respuestas son correctas
                        $aRespuestas = [
                            'DescDepartamento' => '',
                        ]; //Almacena las respuestas
                        $aErrores = [
                            'DescDepartamento' => '',
                        ]; //Almacena los errores
                        //Comprobamos si se ha enviado el formulario
                        if (isset($_REQUEST['enviar'])) {
                            //Introducimos valores en el array $aErrores si ocurre un error
                            $aErrores = [
                                'DescDepartamento' => validacionFormularios::comprobarAlfabetico($_REQUEST['DescDepartamento'], 255, 1, 0),
                            ];

                            //Recorremos el array de errores
                            foreach ($aErrores as $campo => $error) {
                                if ($error == !null) {
                                    //Limpiamos el campos
                                    $entradaOK = false;
                                    $_REQUEST[$campo] = '';
                                    //Si ha dado un error la respuesta pasa a valer el valor que ha introducido el usuario
                                } else {
                                    $aRespuestas['DescDepartamento'] = $_REQUEST['DescDepartamento'];
                                }
                            }
                        } else {
                            $entradaOK = false; //Si no ha pulsado el botón de enviar la validación es incorrecta.
                        }

                        //Si la entrada es Ok almacenamos el valor de la respuesta del usuario en el array $aRespuestas
                        if ($entradaOK) {
                            //Almacenamos el valor en el array
                            $aRespuestas = [
                                'DescDepartamento' => $_REQUEST['DescDepartamento'],
                            ];

                            try {
                                //Establecimiento de la conexion
                                /*
                                  Instanciamos un objeto PDO y establecemos la conexión
                                  Construccion de la cadena PDO: (ej. 'mysql:host=localhost; dbname=midb')
                                  host – nombre o dirección IP del servidor
                                  dbname – nombre de la base de datos
                                 */
                                $miDB = new PDO(DSN, USERNAME, PASSWORD);

                                //Preparamos la consulta
                                $resultadoConsulta = $miDB->query("select * from T02_Departamento where T02_DescDepartamento like'%$aRespuestas[DescDepartamento]%';");
                                // Ejecutando la declaración SQL
                                if ($resultadoConsulta->rowCount() == 0) {
                                    $aErrores['DescDepartamento'] = "No existen departamentos con esa descripcion";
                                }
                                // Creamos una tabla en la que mostraremos la tabla de la BD
                                echo ("<div class='list-group text-center tablaMuestra'>");
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
                                while ($oDepartamento = $resultadoConsulta->fetchObject()) {
                                    echo ("<tr>");
                                    echo ("<td>" . $oDepartamento->T02_CodDepartamento . "</td>");
                                    echo ("<td>" . $oDepartamento->T02_DescDepartamento . "</td>");
                                    echo ("<td>" . $oDepartamento->T02_FechaCreacionDepartamento . "</td>");
                                    echo ("<td>" . $oDepartamento->T02_VolumenDeNegocio . "</td>");
                                    echo ("<td>" . $oDepartamento->T02_FechaBajaDepartamento . "</td>");
                                    echo ("</tr>");
                                }

                                echo ("</tbody>");
                                /* Ahora usamos la función 'rowCount()' que nos devuelve el número de filas afectadas por la consulta y 
                                 * almacenamos el valor en la variable '$numeroDeRegistros'
                                 */
                                $numeroDeRegistrosConsulta = $resultadoConsulta->rowCount();
                                // Y mostramos el número de registros
                                echo ("<tfoot ><tr style='background-color: #666; color:white;'><td colspan='5'>Número de registros en la tabla Departamento: " . $numeroDeRegistrosConsulta . '</td></tr></tfoot>');
                                echo ("</table>");
                                echo ("</div>");
                                //Mediante PDOExprecion controlamos los errores
                            } catch (PDOException $excepcion) {
                                echo 'Error: ' . $excepcion->getMessage() . "<br>"; //Obtiene el valor de un atributo
                                echo 'Código de error: ' . $excepcion->getCode() . "<br>"; // Establece el valor de un atributo
                            } finally {
                                unset($miDB);
                            }
                        } //Despues de que se ejecute el codigo anterior mostramos pase lo que pase el formulario
                        ?>

                        <form name="insercionValoresTablaDepartamento" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <fieldset>
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="rounded-top" colspan="4"><legend>Creación de Departamento</legend></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!-- CodDepartamento Obligatorio -->
                                            <td class="d-flex justify-content-start">
                                                <label for="DescDepartamento">Codigo de Departamento:</label>
                                            </td>
                                            <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                                comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                                que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                                <input class="d-flex justify-content-start" type="text" name="DescDepartamento" value="<?php echo (isset($_REQUEST['DescDepartamento']) ? $_REQUEST['DescDepartamento'] : ''); ?>">
                                            </td>
                                            <td><button type="submit" name="enviar">Buscar</button></td>
                                            <td class="error">
                                                <?php
                                                if (!empty($aErrores['DescDepartamento'])) {
                                                    echo $aErrores['DescDepartamento'];
                                                }
                                                ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </fieldset>
                        </form>
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