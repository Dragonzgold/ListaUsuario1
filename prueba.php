<?php
if(isset($_POST['txtNombre']) && isset($_POST['numEdad']) && isset($_POST['txtApellido'])) {
    $txtNombre = $_POST['txtNombre'];
    $numEdad = $_POST['numEdad'];
    $txtApellido = $_POST['txtApellido'];
    $estadoCivil = isset($_POST['txtEstadoCivil']) ? $_POST['txtEstadoCivil'] : "";
    $selSexo = isset($_POST['selSexo']) ? $_POST['selSexo'] : "";
    $selSueldo = isset($_POST['selSueldo']) ? $_POST['selSueldo'] : "";

    $optionEstadoCivil = "";
    $optionSexo = "";
    $optionSueldo = "";

    // Sentencia switch para la selección del estado civil
    switch($estadoCivil){
        case 1:
            $optionEstadoCivil = "Soltero(a)";
            break;
        case 2:
            $optionEstadoCivil = "Casado(a)";
            break;
        case 3:
            $optionEstadoCivil = "Viudo(a)";
            break;
    }

    // Sentencia switch para la selección de sexo
    switch($selSexo){
        case 1:
            $optionSexo = "Masculino";
            break;
        case 2:
            $optionSexo = "Femenino";
            break;
        case 3:
            $optionSexo = "Binario";
            break;
    }

    // Sentencia switch para la selección del sueldo
    switch($selSueldo){
        case 1:
            $optionSueldo = "menos de 1000$";
            break;
        case 2:
            $optionSueldo = "entre 1000 y 2500$";
            break;
        case 3:
            $optionSueldo = "más de 2500$";
            break;
    }

    // Función para agregar un registro a la base de datos
    function agregarRegistro($nombre, $edad, $apellido, $estadoCivil, $sexo, $sueldo) {
        $registro = $nombre . ',' . $edad . ',' . $apellido . ',' . $estadoCivil . ',' . $sexo . ',' . $sueldo . PHP_EOL;
        file_put_contents('basedatos.txt', $registro, FILE_APPEND);
    }

    // Ejemplo de uso
    agregarRegistro($txtNombre, $numEdad, $txtApellido, $optionEstadoCivil, $optionSexo, $optionSueldo);
}

// Función para obtener todos los registros de la base de datos
function obtenerRegistros() {
    $registros = file('basedatos.txt', FILE_IGNORE_NEW_LINES);
    $datos = array();

    foreach ($registros as $registro) {
        $campos = explode(',', $registro);
        $nombre = $campos[0];
        $edad = $campos[1];
        $apellido = $campos[2];
        $optionEstadoCivil = $campos[3];
        $optionSexo = $campos[4];
        $optionSueldo = $campos[5];
        $datos[] = array('nombre' => $nombre, 'edad' => $edad, 'apellido'=> $apellido, 'optionEstadoCivil'=>$optionEstadoCivil, 'optionSexo'=>$optionSexo, 'optionSueldo'=>$optionSueldo);
    }
    return $datos;
}

$registros = obtenerRegistros();

//Contador de mujeres que haya en la lista

function contMujer(){
    $registros = obtenerRegistros();
    $contadorF = 0;

    foreach ($registros as $registro){
        if($registro['optionSexo']=='Femenino'){
            $contadorF++;
        }
    }
    return $contadorF;
}

$numeroMujer = contMujer();


//contador de hombres casados que ganan mas de 2500$

function contHombresCasados(){
    $registros = obtenerRegistros();
    $contadorM = 0;

    foreach ($registros as $registro){
        if($registro['optionSexo']=='Masculino' && $registro['optionEstadoCivil']=='Casado(a)' && $registro['optionSueldo']=="más de 2500$"){
            $contadorM++;
        }
    }
    return $contadorM;
}

$numeroHombres = contHombresCasados();

//Contador de mujeres viudas que ganan mas de 1000$

function contMujeresViudas(){
    $registros = obtenerRegistros();
    $contadorMV = 0;

    foreach ($registros as $registro){
        if($registro['optionSexo']=='Femenino' && $registro['optionEstadoCivil']=='Viudo(a)' && $registro['optionSueldo']=="más de 2500$"){
            $contadorMV++;
        }

        if($registro['optionSueldo']=='entre 1000 y 2500$'){
            $contadorMV++;
        }
    }
    return $contadorMV;
}

$numeroMujeresViudas = contMujeresViudas();

//La suma de la edad de todos los hombres

function calcularEdadHombres(){
    $registros = obtenerRegistros();
    $edadHombre = 0;

    foreach ($registros as $registro){

        if($registro['optionSexo']=='Masculino'){

            $edadHombre += $registro['edad'];

        }
    }
    return $edadHombre;
}

$edadHombreTest = calcularEdadHombres();

//contador de hombres en la lista

function promedioHombres(){
    $registros = obtenerRegistros();
    $contHombreP = 0;

    foreach ($registros as $registro){
        if($registro['optionSexo']=='Masculino'){

            $contHombreP++;
        }
    }
    return $contHombreP;
}

$contadorhombreTest = promedioHombres();

//Promediar la edad de los hombres

$promedioHombreListado = $edadHombreTest/$contadorhombreTest;


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>prueba</title>

    <link rel="stylesheet" href="assets/css/index.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>


    <div class="tablaEdit">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col" class="centerText">Nombre</th>
                    <th scope="col" class="centerText">Apellido</th>
                    <th scope="col" class="centerText">Edad</th>
                    <th scope="col" class="centerText">Compromiso</th>
                    <th scope="col" class="centerText">Sexo</th>
                    <th scope="col" class="centerText">Sueldo</th>
                </tr>
            </thead>
            <tbody>
                <td class="centerText"> <?php
                if($txtNombre = (!empty($_POST['txtNombre']))){
                    foreach ($registros as $registro) {
                        echo $registro['nombre']. '<br>'; 
                    }
                }
                ?> </td>
                <td class="centerText"> <?php
                if($txtApellido = (!empty($_POST['txtApellido']))){
                    foreach ($registros as $registro) {
                        echo $registro['apellido']. '<br>'; 
                    }
                }
                ?></td>
                <td class="centerText"><?php
                if($numEdad = (!empty($_POST['numEdad']))){
                    foreach ($registros as $registro) {
                        echo $registro['edad']. '<br>'; 
                    }
                }
                ?></td>
                <td class="centerText"><?php
                    foreach ($registros as $registro) {
                        echo $registro['optionEstadoCivil']. '<br>'; 
                    }
                ?></td>
                <td class="centerText">
                <?php
                    foreach ($registros as $registro) {
                        echo $registro['optionSexo']. '<br>'; 
                    }
                ?>
                </td>
                <td class="centerText">
                <?php
                    foreach ($registros as $registro) {
                        echo $registro['optionSueldo']. '<br>'; 
                    }
                ?>
                </td>
            </tbody>
        </table>
    </div>

    <h1 class="titulo">
        Insertar datos en la lista
    </h1>

    <form action="prueba.php" method="post">

        <label for="nombre">Nombre</label>
        <input type="text" name="txtNombre" id="nombre" required>
        <label for="edad">Edad</label>
        <input type="number" name="numEdad" id="edad" required>
        <label for="apellido">Apellido</label>
        <input type="text" name="txtApellido" id="apellido" required>
        <label for="estadoCivil">Estado Civil</label>

        <select name="txtEstadoCivil" id="estadoCivil">
            <option value="1">soltero(a)</option>
            <option value="2">casado(a)</option>
            <option value="3">viudo(a)</option>
        </select>

        <label for="selSexo">Sexo</label>

        <select name="selSexo" id="selSexo">
            <option value="1">Masculino</option>
            <option value="2">Femenino</option>
            <option value="3">Binario</option>
        </select>

        <label for="selSueldo">Sueldo</label>

        <select name="selSueldo" id="selSueldo">
            <option value="1">Menos 1000$</option>
            <option value="2">entre 1000 y 2500$</option>
            <option value="3">mas de 2500$</option>
        </select>

        <input type="submit" value="enviarValores">

    </form>
    <br><br>
    <h2>Datos</h2>
    <p>
        Total de mujeres en la lista: <?php  echo $numeroMujer ?>
        <br>
    </p>
    <p>
        total de hombres casados que ganan mas de 2500: <?php  echo $numeroHombres ?>
        <br>
    </p>
    <p>
        total de mujeres viudas: <?php  echo $numeroMujeresViudas ?>
        <br>
    </p>
    <p>
        Edad promedio de los hombres: <?php  echo round($promedioHombreListado, 2) ?>
    </p>
</body>
</html>