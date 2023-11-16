<!DOCTYPE html>
<!--
	Descripción: CodigoEjercicio2PDO
	Autor: Carlos García Cachón
	Fecha de creación/modificación: 13/11/2023
-->
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Carlos García Cachón">
  <meta name="description" content="CodigoEjercicio2PDO">
  <meta name="keywords" content="CodigoEjercicio, 2PDO">
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
                    <h2>CONTENIDO POR MEDIO DE PDO:</h2>
                    <h3>CON CONSULTA PREPARADA</h3>
                    <?php
                    /**
                     * @author Carlos García Cachón
                     * @version 1.1 
                     * @since 13/11/2023
                     */
                    // Utilizamos el bloque 'try'
                    try {
                        require_once '../config/confDB.php';
                        // Establecemos la conexión por medio de PDO
                        $miDB = new PDO(DSN,USERNAME,PASSWORD);
                        echo ("CONEXIÓN EXITOSA POR PDO<br><br>"); // Mensaje si la conexión es exitosa
                        
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
                        
                        echo ("<h3>CONSULTA NORMAL</h3>");
                        // ESTA PARTE SERIA PARA MOSTRAR LA TABLA PERO EN UN CONSULTA NORMAL
                        // Ejecutamos la consulta SQL
                        $resultadoConsulta = $miDB->query("SELECT * FROM T02_Departamento");
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
                        while ($oDepartartamento = $resultadoConsulta->fetchObject()) {
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
                        $numeroDeRegistros = $resultadoConsulta->rowCount();
                        // Y mostramos el número de registros
                        echo ("<tfoot ><tr style='background-color: #666; color:white;'><td colspan='5'>Número de registros en la tabla Departamento: ".$numeroDeRegistros.'</td></tr></tfoot>');
                        echo ("</table>");
                        echo ("</div>");
                        
                    } catch (PDOException $pdoEx) { // Si falla el 'try' , mostramos el mensaje seguido del error correspondiente
                        echo ("<div class='fs-4 text'>ERROR DE CONEXIÓN</div> ".$pdoEx->getMessage());
                    } 
                    unset($miDB); //Para cerrar la conexión
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