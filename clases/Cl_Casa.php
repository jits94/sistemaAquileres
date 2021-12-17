<?php

include("conexion.php");

$tipo = $_GET["op"];

if($tipo=="RegistrarCasa"){

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $medidas = $_POST["medidas"];
    $nroCasa = $_POST["nrocasa"];
    $fecha = $_POST['fecha'];
    $precio = $_POST['precio'];
    $estadoCasa = "disponible";
    $status = "Activo";


    if($nombre == "" || $descripcion == "" || $medidas == "" || $nroCasa == "" || $precio == "" || $fecha == ""){
        echo '3';
    }

        $insertar = "INSERT INTO casa VALUES(null,'$nombre','$descripcion','$medidas','$nroCasa',$precio,'$fecha','$estadoCasa','$status')";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
}




if($tipo=="editarCasa"){

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $medidas = $_POST["medidas"];
    $nroCasa = $_POST["nrocasa"];
    $id = $_POST['id'];
    $precio = $_POST['precio'];

    if($nombre == "" || $descripcion == "" || $medidas == "" || $nroCasa == "" || $precio == ""){
        echo '3';
    }
    else{
        $insertar = "UPDATE casa SET nombre = '$nombre', descripcion= '$descripcion',medidas='$medidas',nroCasa='$nroCasa',precio=$precio where id= $id";

        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    }
       
}

if($tipo=="EliminarCasa"){

    $id = $_POST['id'];
    $status = "Inactivo";

        $insertar = "UPDATE casa SET status_fl = '$status' where id= $id";
        $resultado2 = mysqli_query($conectar, $insertar);   

        if ($resultado2) {
            echo '1';
        } 
        else {
            echo '2';
        }
    
       
}

if($tipo=="VerInquilino"){

    $idCasa = $_POST['idCasa'];

        $consulta = "SELECT idPersona FROM alquilar where idCasa = $idCasa and status = 'Ocupado'";
        $resultado = mysqli_query($conectar, $consulta);
        $row = $resultado->fetch_assoc();
        $idPersona = $row['idPersona'];   


        $insertar = "SELECT nombre,apellidos,carnet,telefono,miembrosFamilia from persona where id= $idPersona";
        $resultado2 = mysqli_query($conectar, $insertar);
       
        if ($resultado2) {           
            while ($listado = mysqli_fetch_array($resultado2)) {
                $Arreglo[] = $listado;
            }
            $lista = $Arreglo;
            echo json_encode($lista);
        }
        else {
            echo 'no';
        }
    
       
}



if($tipo=="subirFoto"){

    $idDepartamento = $_POST['id'];
    $subirImagen = $_POST['f'];
//    $direccionFoto = "../fotosDpto/".$subirImagen."";

    if(is_array($_FILES) && count($_FILES) > 0){

        if(move_uploaded_file($_FILES["f"]["tmp_name"],"../fotosDpto/".$_FILES["f"]["name"])){
          return echo '1';
        }
        else{
           return echo '2';
        }
    }
    else{
        return echo '2';
    }
    

     
}



