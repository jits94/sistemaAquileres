<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="alquilerCasa"){

    $idCasa = $_POST["idCasa"];
    $idPersona = $_POST["idPersona"];
    $descuento = $_POST["descuento"];
    $fecha = $_POST['fecha'];
    $total = $_POST['total'];
    $estadoPago = "Puntual";
    $multas = 0;
    $status = "Ocupado";


    if($idCasa == "" || $idPersona == "" || $descuento == "" || $total == "" || $fecha == ""){
        echo '3';
    }

        $insertarAqluiler = "INSERT INTO alquilar VALUES(null,'$idCasa','$idPersona',$descuento,'$fecha',$total,'$status')";
        $resultado2 = mysqli_query($conectar, $insertarAqluiler);   


        $consultar = "SELECT id FROM alquilar order by id desc limit 1";
        $resultado1 = mysqli_query($conectar,$consultar);
        $row = $resultado1->fetch_assoc();
        $idAlquilar = $row['id'];

        $insertarPago = "INSERT INTO cobroAlquiler VALUES(null,$idAlquilar,$total,'$fecha','$estadoPago','$multas')";
        $resultado3 = mysqli_query($conectar, $insertarPago);   

        $actualizar = "UPDATE casa SET estadocasa = 'Alquilado' where id = $idCasa";
        $resultado4 = mysqli_query($conectar,$actualizar);


        if ($resultado4) {
            echo '1';
        } 
        else {
            echo '2';
        }
}

if($tipo=="LiberarDepartamento"){

    $id = $_POST['id'];
    $idCasa = $_POST['idCasa'];

   
        $insertar = "UPDATE alquilar SET status = 'Libre' where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        $insertar1 = "UPDATE casa SET estadocasa = 'disponible' where id= $idCasa";
        $resultado2 = mysqli_query($conectar, $insertar1);   

        if ($resultado2) {
            echo '1';
        } else {
            echo '2';
        }
     
}

if($tipo=="editarAlquiler"){

    $id = $_POST['id'];
    $descuento = $_POST["descuento"];
    $fecha = $_POST['fecha'];
    $total = $_POST['total'];

    if($descuento == "" || $total == "" || $fecha == ""){
        echo '3';
    }
   
        $insertar = "UPDATE alquilar SET descuento = $descuento, fecha= '$fecha', total=$total where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } else {
            echo '2';
        }
     
}

if($tipo=="EliminarAlquiler"){

    $id = $_POST['id'];
   

        $insertar = "DELETE FROM alquilar where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}

if($tipo=="DatosCasa"){

    $id = $_POST['id'];

        $insertar = "SELECT precio from casa where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);
        $row1 = $resultado2->fetch_assoc();
        $precio = $row1['precio'];   
       
        if ($precio != "" || $precio != null) {           
            echo $precio;
        }
        else {
            echo 'no';
        }
    
       
}




