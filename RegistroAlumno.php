<?php
require_once "Alumno.php";

$alumno = new Alumno();

if(isset($_POST["registrar"])){

    $alumno->setNombre($_POST["nombre"]);
    $alumno->setNumeroControl($_POST["numeroControl"]);
    $alumno->setSemestre($_POST["semestre"]);
    $alumno->setCarrera($_POST["carrera"]);

    if($alumno->registrar()){

        echo "<script>
        alert('Registro realizado correctamente');
        window.location='LoginE.php';
        </script>";

    }else{

        echo "<script>
        alert('Error al registrar');
        </script>";

    }

}
?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<title>Registro de Alumnos</title>

<style>

body{
    font-family: Arial;
    background:#f5f5f5;
    margin:40px;
}

h2{
    text-align:center;
}

form{
    background:white;
    width:400px;
    margin:auto;
    padding:20px;
    border-radius:10px;
    box-shadow:0px 0px 10px gray;
}

input{
    width:100%;
    padding:8px;
    margin-bottom:10px;
}

button{
    width:100%;
    padding:10px;
    background:#0d6efd;
    color:white;
    border:none;
    cursor:pointer;
}

table{
    width:90%;
    margin:30px auto;
    border-collapse:collapse;
    background:white;
}

table,th,td{
    border:1px solid black;
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

<h2>Registro de Alumnos</h2>

<form method="POST">

<label>Nombre</label>
<input type="text" name="nombre" required>

<label>Número de Control</label>
<input type="text" name="numeroControl" required>

<label>Semestre</label>
<input type="number" name="semestre" min="1" max="12" required>

<label>Carrera</label>
<input type="text" name="carrera" required>

<button type="submit" name="registrar">
Registrar Alumno
</button>