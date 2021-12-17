<?php

include("conexion.php");

$idDepartamento = $_POST['id'];
$subirImagen = $_POST['f'];
//    $direccionFoto = "../fotosDpto/".$subirImagen."";

if(is_array($_FILES) && count($_FILES) > 0){

    if(move_uploaded_file($_FILES["f"]["tmp_name"],"fotosDpto/".$_FILES["f"]["name"])){
      return echo '1';
    }
    else{
       return echo '2';
    }
}
else{
    return echo '2';
}


