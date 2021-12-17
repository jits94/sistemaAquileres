<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarPago"){

    $estadoPago = $_POST["estadoPago"];
    $idAlquiler = $_POST["idAlquiler"];
    $fecha = $_POST['fecha'];
    $total = $_POST['total'];
    $multas = 0;
    $proximoPago = $_POST['proximoPago'];
    $idCobro = $_POST["idCobro"];


    if($estadoPago == "" || $idAlquiler == "" || $total == "" || $fecha == ""){
        echo '3';
    }

    if($idCobro == "" || $idCobro == null){
        $consultar = "SELECT c.id as idCobro FROM cobroAlquiler as c left join alquilar as a on a.id = c.idalquilar left join persona as p on p.id = a.idPersona where a.id = $idAlquiler  order by c.proximoPago desc limit 1";
        $resultado1 = mysqli_query($conectar, $consultar);
        $row1 = $resultado1->fetch_assoc();
        $idCobro = $row1['idCobro'];   
    }
    
        $Actualizar = "UPDATE cobroAlquiler SET estado = 'Pagado' where id= $idCobro";
        $resultado2 = mysqli_query($conectar, $Actualizar);   

        $insertarAqluiler = "INSERT INTO cobroAlquiler VALUES(null,$idAlquiler,$total,'$fecha','$estadoPago',$multas,'$proximoPago','Pendiente')";
        $resultado2 = mysqli_query($conectar, $insertarAqluiler);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}

if($tipo=="EditarPago"){

    $id = $_POST['id'];
    $fecha = $_POST['fecha'];
    $total = $_POST['total'];
    $proximoPago = $_POST['proximoPago'];

    if($total == "" || $fecha == ""){
        echo '3';
    }
   
        $insertar = "UPDATE cobroAlquiler SET fecha = '$fecha', total=$total, proximoPago= '$proximoPago' where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } else {
            echo '2';
        }
     
}

if($tipo=="EliminarPago"){

    $id = $_POST['id'];
   

        $insertar = "DELETE FROM cobroAlquiler where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}

if($tipo=="DatosPago"){

    $id = $_POST['id'];

        $insertar = "SELECT * from alquilar where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);
        $row1 = $resultado2->fetch_assoc();
        $precio = $row1['total'];   
       
        if ($precio != "" || $precio != null) {           
            echo $precio;
        }
        else {
            echo 'no';
        }
    
       
}




