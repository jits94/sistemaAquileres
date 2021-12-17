<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarLocal"){

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $status = "Habilitado";
    $estado = "Disponible";


    if($nombre == "" || $descripcion == ""){
        echo '3';
    }

        $insertar = "INSERT INTO local VALUES(null,'$nombre','$descripcion','$status','$estado')";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}

if($tipo=="editarLocal"){

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $id = $_POST['id'];

    if($nombre == "" || $descripcion == ""){
        echo '3';
    }
    else{
        $insertar = "UPDATE local SET nombre = '$nombre', descripcion= '$descripcion' where id= $id";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    }
       
}

if($tipo=="EliminarLocal"){

    $id = $_POST['id'];
    $status = $_POST['estado'];

        $insertar = "UPDATE local SET status = '$status' where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}




