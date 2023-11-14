<!DOCTYPE html>
<!--
        Descripción: CodigoEjercicio3PDO
        Autor: Carlos García Cachón
        Fecha de creación/modificación: 13/11/2023
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Carlos García Cachón">
        <meta name="description" content="CodigoEjercicio3PDO">
        <meta name="keywords" content="CodigoEjercicio, 3PDO">
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
        </style>
    </head>

    <body>
        <header class="text-center">
            <h1>3. Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores:</h1>
        </header>
        <main>
            <div class="container mt-3">
                <div class="row text-center">
                    <div class="col">
                        <?php
                        /**
                         * @author Carlos García Cachón
                         * @version 1.4 
                         * @since 14/11/2023
                         */
                        // Incluyo la libreria de validación para comprobar los campos
                        require_once '../core/231018libreriaValidacion.php';
                        // Incluyo la configuración de conexión a la BD
                        require_once '../config/confDB.php';

                        // Declaración de constantes por OBLIGATORIEDAD
                        define('OPCIONAL', 0);
                        define('OBLIGATORIO', 1);

                        // Declaración de los limites para el metodo comprobar FLOAT
                        define('TAM_MAX_FLOAT', PHP_FLOAT_MAX);
                        define('TAM_MIN_FLOAT', PHP_FLOAT_MIN);
                        
                        // Variable DateTime
                        $fechaYHoraActualCreacion = new DateTime('now',new  DateTimeZone('Europe/Madrid'));
                        // Y formateo la variable '$fechaYHoraActualCreacion' para que aparezca en el input 'YYYY-mm-dd'
                        $fechaYHoraActualCreacionFormateada = $fechaYHoraActualCreacion->format('Y-m-d');

                        // Declaración de variables de estructura para validar la ENTRADA de RESPUESTAS o ERRORES
                        // Valores por defecto
                        $entradaOK = true;

                        $aRespuestas = [
                            'CodDepartamento' => "",
                            'DescDepartamento' => "",
                            'FechaCreacionDepartamento' => "",
                            'VolumenDeNegocio' => "",
                            'FechaBajaDepartamento' => ""
                        ];

                        $aErrores = [
                            'CodDepartamento' => "",
                            'DescDepartamento' => "",
                            'FechaCreacionDepartamento' => "",
                            'VolumenDeNegocio' => "",
                            'FechaBajaDepartamento' => ""
                        ];
                        //En el siguiente if pregunto si el '$_REQUEST' recupero el valor 'enviar' que enviamos al pulsar el boton de enviar del formulario.
                        if (isset($_REQUEST['enviar'])) {
                            /*
                             * Ahora inicializo cada 'key' del ARRAY utilizando las funciónes de la clase de 'validacionFormularios' , la cuál 
                             * comprueba el valor recibido (en este caso el que recibe la variable '$_REQUEST') y devuelve 'null' si el valor es correcto,
                             * o un mensaje de error personalizado por cada función dependiendo de lo que validemos.
                             */
                            //Introducimos valores en el array $aErrores si ocurre un error
                            $aErrores['CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['CodDepartamento'], 3, 3, OBLIGATORIO);

                            // Ahora validamos que el codigo introducido no exista en la BD, haciendo una consulta 
                            if ($aErrores['CodDepartamento'] == null) {
                                try {
                                    // CONEXION BASE DE DATOS
                                    // Iniciamos la conexión con la BD
                                    $miDB = new PDO(DNS, USERNAME, PASSWORD);
                                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configuramos las excepciones
                                    // CONSULTA
                                    // En esta línea utilizo 'quote()' se utiliza para escapar y citar el valor del $_REQUEST['CodDepartamento'], ayudando a prevenir la inyección de SQL.
                                    $codDepartamento = $miDB->quote($_REQUEST['CodDepartamento']);
                                    // Utilizamos una consulta simple para comprobar el codigo del departamento
                                    $consultaComprobarCodDepartamento = $miDB->query("SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = $codDepartamento");
                                    // Y obtenemos el resultado de la consulta como un objeto.
                                    $departamentoExistente = $consultaComprobarCodDepartamento->fetchObject();

                                    // COMPROBACION DE ERROR
                                    if ($departamentoExistente) {
                                        $aErrores['CodDepartamento'] = "El código de departamento ya existe";
                                    }
                                } catch (PDOException $miExcepcionPDO) {
                                    $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
                                    $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

                                    echo "<span style='color: red;'>Error: </span>" . $mensajeExcepcion . "<br>"; //Mostramos el mensaje de la excepción
                                    echo "<span style='color: red;'>Código del error: </span>" . $errorExcepcion; //Mostramos el código de la excepción
                                } finally {
                                    unset($miDB); //Para cerrar la conexión
                                }
                            }
                            $aErrores['DescDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['DescDepartamento'], 255, 1, OBLIGATORIO);
                            $aErrores['FechaCreacionDepartamento'] = NULL;
                            $aErrores['VolumenDeNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['VolumenDeNegocio'], TAM_MAX_FLOAT, TAM_MIN_FLOAT, OBLIGATORIO);
                            $aErrores['FechaBajaDepartamento'] = NULL;

                            /*
                             * En este foreach recorremos el array buscando que exista NULL (Los metodos anteriores si son correctos devuelven NULL)
                             * y en caso negativo cambiara el valor de '$entradaOK' a false y borrara el contenido del campo.
                             */
                            foreach ($aErrores as $campo => $error) {
                                if ($error != null) {
                                    $_REQUEST[$campo] = "";
                                    $entradaOK = false;
                                }
                            }
                        } else {
                            $entradaOK = false;
                        }
                        //En caso de que '$entradaOK' sea true, cargamos las respuestas en el array '$aRespuestas'
                        if ($entradaOK) {

                            // Utilizamos el bloque 'try'
                            try {
                                // CONEXION CON LA BD
                                // Establecemos la conexión por medio de PDO
                                $miDB = new PDO(DNS, USERNAME, PASSWORD);
                                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configuramos las excepciones
                                echo ("CONEXIÓN EXITOSA POR PDO<br><br>"); // Mensaje si la conexión es exitosa

                                // Cargo el array con las respuestas
                                $aRespuestas['CodDepartamento'] = strtoupper($_REQUEST['CodDepartamento']);
                                $aRespuestas['DescDepartamento'] = $_REQUEST['DescDepartamento'];
                                $aRespuestas['FechaCreacionDepartamento'] = 'now()'; // Cargo la fecha actual y hora actual formateada
                                $aRespuestas['VolumenDeNegocio'] = $_REQUEST['VolumenDeNegocio'];
                                $aRespuestas['FechaBajaDepartamento'] = 'NULL';

                                // CONSULTA CON QUERY()
                                // Se ejecuta la consulta de insercion                    
                                $numeroFilas = $miDB->exec("INSERT INTO T02_Departamento VALUES ('". $aRespuestas['CodDepartamento'] . "','" . $aRespuestas['DescDepartamento'] . "'," . $aRespuestas['FechaCreacionDepartamento'] . "," . $aRespuestas['VolumenDeNegocio'] . "," . $aRespuestas['FechaBajaDepartamento'] . ");");
  
                                // Ejecutando la declaración SQL y mostramos un mensaje en caso de que se inserte u ocurra un error.
                                if ($numeroFilas > 0) {
                                    echo "Los datos se han insertado correctamente en la tabla Departamento.";

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
                                    while ($oDepartartamento = $resultadoConsultaPreparada->fetchObject()) {
                                        echo ("<tr>");
                                        echo ("<td>".$oDepartartamento->T02_CodDepartamento."</td>");
                                        echo ("<td>".$oDepartartamento->T02_DescDepartamento."</td>");
                                         echo ("<td>".$oDepartartamento->T02_FechaCreacionDepartamento."</td>");
                                          echo ("<td>".$oDepartartamento->T02_VolumenDeNegocio."</td>");
                                          echo ("<td>".$oDepartartamento->T02_FechaBajaDepartamento."</td>");
                                        echo ("</tr>");
                                    }

                                    echo ("</tbody>");
                                    /* Ahora usamos la función 'rowCount()' que nos devuelve el número de filas afectadas por la consulta y 
                                     * almacenamos el valor en la variable '$numeroDeRegistros'
                                     */
                                    $numeroDeRegistrosConsultaPreparada = $resultadoConsultaPreparada->rowCount();
                                    // Y mostramos el número de registros
                                    echo ("<tfoot ><tr style='background-color: #666; color:white;'><td colspan='5'>Número de registros en la tabla Departamento: " . $numeroDeRegistrosConsultaPreparada . '</td></tr></tfoot>');
                                    echo ("</table>");
                                    echo ("</div>");
                                } else {
                                    echo "Hubo un error al insertar los datos en la tabla Departamento.";
                                }
                            } catch (PDOException $miExcepcionPDO) {
                                $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
                                $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

                                echo "<span style='color: red;'>Error: </span>" . $mensajeExcepcion . "<br>"; //Mostramos el mensaje de la excepción
                                echo "<span style='color: red;'>Código del error: </span>" . $errorExcepcion; //Mostramos el código de la excepción
                            } finally {
                                unset($miDB); // Para cerrar la conexión
                            }
                        } else {
                            ?>
                            <!-- Codigo del formulario -->
                            <form name="insercionValoresTablaDepartamento" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <fieldset>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="rounded-top" colspan="3"><legend>Creación de Departamento</legend></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!-- CodDepartamento Obligatorio -->
                                                <td class="d-flex justify-content-start">
                                                    <label for="CodDepartamento">Codigo de Departamento:</label>
                                                </td>
                                                <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                                    comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                                    que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                                    <input class="obligatorio d-flex justify-content-start" type="text" placeholder="AAD" name="CodDepartamento" value="<?php echo (isset($_REQUEST['CodDepartamento']) ? $_REQUEST['CodDepartamento'] : ''); ?>">
                                                </td>
                                                <td class="error">
                                                    <?php
                                                    if (!empty($aErrores['CodDepartamento'])) {
                                                        echo $aErrores['CodDepartamento'];
                                                    }
                                                    ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- DescDepartamento Obligatorio -->
                                                <td class="d-flex justify-content-start">
                                                    <label for="DescDepartamento">Descripción de Departamento:</label>
                                                </td>
                                                <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                                    comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                                    que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                                    <input class="obligatorio d-flex justify-content-start" type="text" name="DescDepartamento" placeholder="Departamento de Ventas" value="<?php echo (isset($_REQUEST['DescDepartamento']) ? $_REQUEST['DescDepartamento'] : ''); ?>">
                                                </td>
                                                <td class="error">
                                                    <?php
                                                    if (!empty($aErrores['DescDepartamento'])) {
                                                        echo $aErrores['DescDepartamento'];
                                                    }
                                                    ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- FechaCreacionDepartamento Opcional -->
                                                <td class="d-flex justify-content-start">
                                                    <label for="FechaCreacionDepartamento">Fecha de Creación:</label>
                                                </td>
                                                <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                                    comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                                    que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                                    <input disabled class="d-flex justify-content-start bloqueado" type="text" name="FechaCreacionDepartamento"  value="<?php echo ($fechaYHoraActualCreacionFormateada); ?>">
                                                </td>
                                                <td class="error">
                                                    <?php
                                                    if (!empty($aErrores['FechaCreacionDepartamento'])) {
                                                        echo $aErrores['FechaCreacionDepartamento'];
                                                    }
                                                    ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- VolumenNegocio Obligatorio -->
                                                <td class="d-flex justify-content-start">
                                                    <label for="VolumenDeNegocio">Volumen de Negocio:</label>
                                                </td>
                                                <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                                    comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                                    que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                                    <input class="obligatorio d-flex justify-content-start" type="text" name="VolumenDeNegocio" placeholder="1234.5" value="<?php echo (isset($_REQUEST['VolumenDeNegocio']) ? $_REQUEST['VolumenDeNegocio'] : ''); ?>">
                                                </td>
                                                <td class="error">
                                                    <?php
                                                    if (!empty($aErrores['VolumenDeNegocio'])) {
                                                        echo $aErrores['VolumenDeNegocio'];
                                                    }
                                                    ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- FechaBaja Opcional -->
                                                <td class="d-flex justify-content-start">
                                                    <label for="FechaBaja">Fecha de Baja:</label>
                                                </td>
                                                <td>                                                                                                <!-- El value contiene una operador ternario en el que por medio de un metodo 'isset()'
                                                                                                                                                    comprobamos que exista la variable y no sea 'null'. En el caso verdadero devovleremos el contenido del campo
                                                                                                                                                    que contiene '$_REQUEST' , en caso falso sobrescribira el campo a '' .-->
                                                    <input disabled class="d-flex justify-content-start bloqueado" type="text" name="FechaBaja" placeholder="YYYY/mm/dd HH:ii:ss" value="<?php echo (isset($_REQUEST['FechaBaja']) ? $_REQUEST['FechaBaja'] : ''); ?>">
                                                </td>
                                                <td class="error">
                                                    <?php
                                                    if (!empty($aErrores['FechaBaja'])) {
                                                        echo $aErrores['FechaBaja'];
                                                    }
                                                    ?> <!-- Aquí comprobamos que el campo del array '$aErrores' no esta vacío, si es así, mostramos el error. -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" name="enviar">Crear</button>
                                </fieldset>
                            </form>
                            <?php
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