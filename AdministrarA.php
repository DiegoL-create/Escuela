<?php
session_start();
require_once "Alumno.php";

if(!isset($_SESSION["Usuario"])){
    header("Location: LoginE.php");
    exit();
}

$alumno = new Alumno();

$modoEditar = false;
$datosAlumno = null;


if(isset($_GET["eliminar"])){

    if($alumno->eliminar($_GET["eliminar"])){

        echo "<script>
        alert('Alumno eliminado correctamente');
        window.location='AdministrarA.php';
        </script>";

        exit();
    }

}


if(isset($_GET["editar"])){

    $modoEditar = true;

    $datosAlumno = $alumno->obtener($_GET["editar"]);

}


if(isset($_POST["actualizar"])){

    $alumno->setNombre($_POST["nombre"]);
    $alumno->setNumeroControl($_POST["numeroControl"]);
    $alumno->setSemestre($_POST["semestre"]);
    $alumno->setCarrera($_POST["carrera"]);

    $resultado = $alumno->actualizar($_POST["idAlumno"]);

    if($resultado===true){

        echo "<script>
        alert('Alumno actualizado correctamente');
        window.location='AdministrarA.php';
        </script>";

        exit();

    }elseif($resultado=="duplicado"){

        echo "<script>
        alert('Ya existe ese Número de Control');
        </script>";

    }else{

        echo "<script>
        alert('No fue posible actualizar');
        </script>";

    }

}


if(isset($_POST["registrar"])){

    $alumno->setNombre($_POST["nombre"]);
    $alumno->setNumeroControl($_POST["numeroControl"]);
    $alumno->setSemestre($_POST["semestre"]);
    $alumno->setCarrera($_POST["carrera"]);

    $resultado = $alumno->registrar();

    if($resultado===true){

        echo "<script>
        alert('Alumno registrado correctamente');
        window.location='AdministrarA.php';
        </script>";

        exit();

    }elseif($resultado=="duplicado"){

        echo "<script>
        alert('Ese Número de Control ya existe');
        </script>";

    }else{

        echo "<script>
        alert('Error al registrar alumno');
        </script>";

    }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Administración de Alumnos</title>

<style>

body{

    font-family:Arial;
    background:#f5f5f5;
    margin:40px;

}

h2{

    text-align:center;

}

form{

    width:420px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px gray;

}

input{

    width:100%;
    padding:10px;
    margin-bottom:10px;

}

button{

    width:100%;
    padding:10px;
    color:white;
    border:none;
    cursor:pointer;
    border-radius:5px;

}

table{

    width:95%;
    margin:30px auto;
    border-collapse:collapse;
    background:white;

}

table,th,td{

    border:1px solid gray;

}

th{

    background:#0d6efd;
    color:white;

}

th,td{

    padding:10px;
    text-align:center;

}

</style>

</head>

<body>

<div style="text-align:right; margin-bottom:20px;">

<a href="LogoutE.php">

<button
type="button"
style="background:#dc3545;width:180px;">

Cerrar Sesión

</button>

</a>

</div>

<h2>

<?php

if($modoEditar)
    echo "Editar Alumno";
else
    echo "Registro de Alumnos";

?>

</h2>

<form method="POST">

<input
type="hidden"
name="idAlumno"
value="<?php echo ($modoEditar)?$datosAlumno["IdAlumno"]:""; ?>">

<label>Nombre</label>

<input
type="text"
name="nombre"
required
value="<?php echo ($modoEditar)?$datosAlumno["NombreA"]:""; ?>">

<label>Número de Control</label>

<input
type="text"
name="numeroControl"
required
value="<?php echo ($modoEditar)?$datosAlumno["NumeroControl"]:""; ?>">

<label>Semestre</label>

<input
type="number"
name="semestre"
min="1"
max="12"
required
value="<?php echo ($modoEditar)?$datosAlumno["Semestre"]:""; ?>">

<label>Carrera</label>

<input
type="text"
name="carrera"
required
value="<?php echo ($modoEditar)?$datosAlumno["Carrera"]:""; ?>">
<?php

if($modoEditar){

    echo '<button
            type="submit"
            name="actualizar"
            style="background:#198754;">
            Actualizar Alumno
          </button>';

    echo '<br><br>';

    echo '<a href="AdministrarA.php">
            <button
            type="button"
            style="background:#6c757d;">
            Cancelar Edición
            </button>
          </a>';

}else{

    echo '<button
            type="submit"
            name="registrar"
            style="background:#0d6efd;">
            Registrar Alumno
          </button>';

}

?>

</form>

<h2>Listado de Alumnos</h2>

<table>

<tr>

    <th>Nombre</th>
    <th>No. Control</th>
    <th>Semestre</th>
    <th>Carrera</th>
    <th>Acciones</th>

</tr>

<?php

$lista = $alumno->listar();

foreach($lista as $dato){

    echo "<tr>";

    echo "<td>".$dato["NombreA"]."</td>";

    echo "<td>".$dato["NumeroControl"]."</td>";

    echo "<td>".$dato["Semestre"]."</td>";

    echo "<td>".$dato["Carrera"]."</td>";

    echo "<td>";

    echo "<a href='AdministrarA.php?editar=".$dato["IdAlumno"]."'>

            <button
            type='button'
            style='
            background:#ffc107;
            color:black;
            width:90px;
            margin-bottom:5px;'>

            Editar

            </button>

          </a>";

    echo "<br>";

    echo "<a
            href='AdministrarA.php?eliminar=".$dato["IdAlumno"]."'

            onclick=\"return confirm('¿Está seguro de eliminar este alumno?');\">

            <button
            type='button'
            style='
            background:#dc3545;
            width:90px;'>

            Eliminar

            </button>

          </a>";

    echo "</td>";

    echo "</tr>";

}

?>

</table>

</body>

</html>