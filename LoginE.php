<?php
session_start();

require_once 'BaseE.php';
require_once 'UsuarioE.php';

$error = '';

$database = new Base();
$db = $database->getConnection();

if(!$db){
    $error = "Error de conexión a la base de datos 'Escuela'.";
}

if($_SERVER["REQUEST_METHOD"]=="POST" && $db){

    $usuario = new Usuario($db);

    $usuario->setUsuario($_POST["Usuario"]);
    $usuario->setPassword($_POST["Password"]);

    if($usuario->login()){

        $_SESSION["Id"] = $usuario->getId();
        $_SESSION["Usuario"] = $usuario->getUsuario();

        header("Location: AdministrarA.php");
        exit();

    }else{

        $error = "Usuario o contraseña incorrectos.";

    }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Administrador</title>

<style>

body{

    font-family:Arial;
    background:#f2f2f2;

}

.container{

    width:350px;
    margin:100px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0px 0px 10px gray;

}

input{

    width:100%;
    padding:10px;
    margin-bottom:15px;

}

button{

    width:100%;
    padding:10px;
    background:#0d6efd;
    color:white;
    border:none;
    cursor:pointer;

}

.error{

    color:red;
    margin-bottom:15px;

}

</style>

</head>

<body>

<div class="container">

<h2>Iniciar Sesión</h2>

<?php
if($error!=""){
    echo "<div class='error'>$error</div>";
}
?>

<form method="POST">

<input
type="text"
name="Usuario"
placeholder="Usuario"
required>

<input
type="password"
name="Password"
placeholder="Contraseña"
required>

<button type="submit">

Ingresar

</button>

<hr>

<div style="text-align:center; margin-top:15px;">

<p>¿Eres alumno?</p>

<a href="RegistroAlumno.php">
    <button type="button">
        Soy Alumno
    </button>
</a>

</div>x

</form>

</div>

</body>

</html>