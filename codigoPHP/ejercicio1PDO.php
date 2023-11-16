<!DOCTYPE html>
<!--
	Descripción: CodigoEjercicio1PDO
	Autor: Carlos García Cachón
	Fecha de creación/modificación: 02/11/2023
-->
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Carlos García Cachón">
  <meta name="description" content="CodigoEjercicio1PDO">
  <meta name="keywords" content="CodigoEjercicio, 1PDO">
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
                    <h2>CONEXION POR MEDIO DE PDO:</h2>
                    <?php
                    /**
                     * @author Carlos García Cachón
                     * @version 1.1 
                     * @since 03/11/2023
                     */
                    require_once '../config/confDB.php';
                    // La variable $attributes almacena los artibutos que se pueden mostrar de una base de datos
                    // No se incluyen "PERSISTENT", "PREFETCH" y "TIMEOUT" 
                    $attributesPDO = ["AUTOCOMMIT", 
                        "ERRMODE", 
                        "CASE", 
                        "CLIENT_VERSION", 
                        "CONNECTION_STATUS",
                        "ORACLE_NULLS", 
                        "SERVER_INFO", 
                        "SERVER_VERSION"];
                    // Utilizamos el bloque 'try'
                    try {
                        // Establecemos la conexión por medio de PDO
                        $miDB = new PDO(DSN,USERNAME,PASSWORD);
                        echo ("<div class='fs-4 text'>CONEXIÓN EXITOSA POR PDO</div><br>"); // Mensaje si la conexión es exitosa
                        echo ("<div class='fs-4 text'>ATRIBUTOS PDO:</div><br>");
                        foreach ($attributesPDO as $valor) {
                            echo('PDO::<u>ATTR_'.$valor.'</u> => <b>'.$miDB->getAttribute(constant("PDO::ATTR_$valor"))."</b><br>");
                        }
                    } catch (PDOException $pdoEx) { // Si falla el 'try' , msotramos el mensaje seguido del error correspondiente
                        echo ("<div class='fs-4 text'>ERROR DE CONEXIÓN</div> ".$pdoEx->getMessage());
                    } 
                    unset($miDB); //Para cerrar la conexión
                    ?>
                    <br><br>
                    <h2>CONEXION POR MEDIO DE PDO (FALLIDA):</h2>
                    <?php
                    /* Si quisieramos hacer que salte el 'PDOException' , deberemos de poner algún dato erroneo al crear el objeto.
                     * Para ello duplicamos el bloque de código anterior, pero añadiendo un dato erroneo, en este caso podremos mal
                     * el '$host' .
                     */ 
                    // Utilizamos el bloque 'try'
                    try {
                        // Establecemos la conexión por medio de PDO
                        $miDB = new PDO(DSN,USERNAME,'paso1'); // Aqui ponemos mal la contraseña para buscar el mensaje de error
                        echo ("<div class='fs-4 text'>CONEXIÓN EXITOSA POR PDO</div><br>"); // Mensaje si la conexión es exitosa
                        foreach ($attributesPDO as $valor) {
                            echo('PDO::<u>ATTR_'.$valor.'</u> => <b>'.$miDB->getAttribute(constant("PDO::ATTR_$valor"))."</b><br>");
                        }
                    } catch (PDOException $pdoEx) { // Si falla el 'try' , msotramos el mensaje seguido del error correspondiente
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