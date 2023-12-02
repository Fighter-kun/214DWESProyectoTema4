<!DOCTYPE html>
<!--
        Descripción: CodigoEjercicio8XML
        Autor: Carlos García Cachón
        Fecha de creación/modificación: 16/11/2023
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Carlos García Cachón">
        <meta name="description" content="CodigoEjercicio8XML">
        <meta name="keywords" content="CodigoEjercicio, 8XML">
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
            <h1>8. Página web que toma datos de la tabla T02_Departamento y guarda en un fichero departamento.json. El fichero exportado se encuentra en el directorio .../tmp/ del servidor:</h1>
        </header>
        <main>
            <div class="container mt-3">
                <div class="row d-flex justify-content-start">
                    <div class="col">
                        <?php
                        /**
                         * @author Alvaro Cordero Miñambres 
                         * Adaptado por @author Carlos García Cachón
                         * @version 1.2
                         * @since 02/12/2023
                         * 
                         * @Annotation Exportando archivos en formato .xml
                         */


                        /**Funciones para tener un mayor control sobre nuestros errores
                         *
                         * La función ini_set('display_errors', 1); es una instrucción de configuración en PHP que se utiliza para activar la visualización de 
                            errores en tiempo de ejecución en el navegador web.
                         * Mostrará los errores directamente en la página web si ocurren durante la ejecución del script PHP.
                         */
                        ini_set('display_errors', 1);

                        /**Se utiliza para activar la visualización de errores que ocurren durante 
                         * el inicio del script, es decir, durante la fase de arranque (startup) del proceso PHP. */
                        ini_set('display_startup_errors', 1);

                        /**
                         * Establece el nivel de error que se informará durante la ejecución de un script PHP. 
                         * En este caso, E_ALL es una constante que representa todos los tipos de errores posibles en PHP.
                         */
                        error_reporting(E_ALL);

                        // Incluyo la configuración de conexión a la BD
                        require_once '../config/confDBPDO.php';

                        // Declaro una variable de entrada para mostrar o no la tabla con los valores de la BD
                        $entradaOK = true;

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

                            /**
                             * Declaracion de la consulta SQL 
                             * En este caso hacemos un select de la tabla Departamanetos
                             */
                            $sql1 = 'SELECT * FROM T02_Departamento';

                            //Preparamos la consulta que previamente vamos a ejecutar
                            $resultadoConsulta = $miDB->prepare($sql1);

                            //Ejecutamos la consulta
                            $resultadoConsulta->execute();

                            /**+
                             * Mostramos el numero de registros que hemos seleccionado
                             * el metodo rowCount() devuelve el numero de filas que tiene la consulta
                             */
                            $numRegistros = $resultadoConsulta->rowCount();

                            //Mediante echo mostranmos la variable que almacena el numero de registros
                            echo ('Numero de registros: ' . $numRegistros);

                            /**
                             * Instanciamos el nuevo documento usando el objeto DOMDocument
                             * Le asignamos dos parametros -> Version, Codificacion XML
                             */
                            $archivoXML = new DOMDocument("1.0", "utf-8");

                            //Le decimos que queremos formatear el codigo poniendo a true la propiedad formatOutput
                            $archivoXML->formatOutput = true;

                            /**Creo el nodo raiz departamentos del de dependeran los demas
                             * createElement() -> Crea un nuevo nodo elemento
                             * En este caso le pasamos como parametro el nombre del elemento
                             * */
                            $nDepartamentos = $archivoXML->createElement('Departamentos');

                            /**Introduzco el nodo raiz en el archivo
                             * appenChild() -> Añade un nuevo hijo al final de los hijos
                             */
                            $root = $archivoXML->appendChild($nDepartamentos);

                            //Guardo el primer registro como un objeto
                            $oResultado = $resultadoConsulta->fetchObject();

                            /**
                             *Recorro los registros que devuelve la consulta y obtengo por cada valor su resultado
                             */
                            while ($oResultado) {
                                //Guardamos los valores en un array asociativo
                                //Creo el nodo departamento para cada uno de ellos
                                $nDepartamento = $root->appendChild($archivoXML->createElement('Departamento'));

                                //Creo el elemento con el nombre CodDepartamento y despues el valor obtenido de la consulta
                                $nDepartamento->appendChild($archivoXML->createElement('CodDepartamento', $oResultado->T02_CodDepartamento));
                                
                                //Creo el elemento con el nombre DescDepartamento y despues el valor obtenido de la consulta
                                $nDepartamento->appendChild($archivoXML->createElement('DescDepartamento', $oResultado->T02_DescDepartamento));

                                //Creo el elemento con el nombre FechaCreacion Departamento y despues el valor obtenido de la consulta
                                $nDepartamento->appendChild($archivoXML->createElement('FechaCreacionDepartamento', $oResultado->T02_FechaCreacionDepartamento));

                                //Creo el elemento con el nombre VolumenNegocio y despues el valor obtenido de la consulta          
                                $nDepartamento->appendChild($archivoXML->createElement('VolumenDeNegocio', $oResultado->T02_VolumenDeNegocio));

                                /**
                                 * A la fechaBaja no le soy valor porque por defecto es null.
                                 */
                                $nDepartamento->appendChild($archivoXML->createElement('FechaBajaDepartamento'));

                                //Guardo el registro actual y avanzo el puntero al siguiente registro que obtengo de la consulta
                                $oResultado = $resultadoConsulta->fetchObject();
                            }

                            /**
                             * Guardamos el archivo en la ruta indicada
                             * save() -> Copia el árbol XML interno a un archivo
                             */

                            // Verifica si el directorio existe, si no, créalo
                            if (!file_exists("../tmp/")) {
                                mkdir("../tmp/", 0777, true);
                            }

                            // Intenta escribir en el archivo
                            if ($archivoXML->save('../tmp/departamentos.xml') !== false) {
                                echo "<br><span style='color: green'>Exportado correctamente</span>";
                            } else {
                                echo "<br><span style='color: red'>Error al exportar el archivo</span>";
                            }

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