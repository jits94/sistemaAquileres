<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}



$sql = "SELECT * FROM casa where status_fl != 'Inactivo'";

$resultado = mysqli_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Condominios</title>
  <link rel="icon" type="image/jpg" href="../img/logo.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- DataTables -->
   <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
   <!-- SweetAlert2 -->
   <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php  
        require "Navegador.php";
    ?>

    <?php  
        require "Menus.php";
    ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Lista de Departamentos</h1>
          </div><!-- /.col
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div> /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
 
<div class="card">
              <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-Casa"><i class="fas fa-plus-circle"></i> Agregar nuevo departamento
                  <button type="button" class="btn btn-primary" onclick="abrirmodalsubirfoto()"><i class="fas fa-images"></i> Subir Foto
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th width=100px>Nombre</th>
                    <th width=150px>Descripción</th>
                    <th>Medidas</th>
                    <th>Nro</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Disponibilidad</th>
                    <th>Accion</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $cont = 0; 
                      while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                          <td><?php echo $row['id']; ?></td>
                          <td><?php echo $row['nombre']; ?></td>
                          <td><?php echo $row['descripcion']; ?></td>
                          <td><?php echo $row['medidas']; ?></td>
                          <td><?php echo $row['nroCasa']; ?></td>
                          <td><?php echo $row['precio']; ?></td>
                          <td><?php echo $row['fecha']; ?></td> 
                          <?php 
                          if($row['estadocasa'] == "Alquilado"){
                            ?>
                            <td class='text text-danger'><?php echo $row['estadocasa']; ?></td>
                            <td>
                              <button type='button' class='btn btn-info btn-sm checkbox-toggle' onclick="VerInquilino('<?php echo $row['id']; ?>')"><i title="Ver Inquilino" class="fas fa-user"></i></button>  
                              <button type='button' class='btn btn-success btn-sm checkbox-toggle'  onclick="editarCasaModal('<?php echo $row['id']; ?>','<?php echo $row['nombre']; ?>','<?php echo $row['descripcion']; ?>','<?php echo $row['medidas']; ?>','<?php echo $row['nroCasa']; ?>','<?php echo $row['precio']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                              <button type='button' class='btn btn-danger btn-sm checkbox-toggle' onclick="ConfirmarEliminarCasa('<?php echo $row['id']; ?>')"><i title="Eliminar" class="fas fa-trash"></i></button>
                              <button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="verFoto()"><i title="Ver Foto" class="fas fa-images"></i></button>
                            </td>
                          <?php 
                          }
                          else{
                            ?>
                             <td><?php echo $row['estadocasa']; ?></td>
                            <td>
                              <button type='button' class='btn btn-success btn-sm checkbox-toggle'  onclick="editarCasaModal('<?php echo $row['id']; ?>','<?php echo $row['nombre']; ?>','<?php echo $row['descripcion']; ?>','<?php echo $row['medidas']; ?>','<?php echo $row['nroCasa']; ?>','<?php echo $row['precio']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                              <button type='button' class='btn btn-danger btn-sm checkbox-toggle' onclick="ConfirmarEliminarCasa('<?php echo $row['id']; ?>')"><i title="Eliminar" class="fas fa-trash"></i></button>
                              <button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="verFoto()"><i title="Ver Foto" class="fas fa-images"></i></button>
                            </td>
                            <?php
                          }
                          ?>                     
                         
                        </tr>
                    <?php } ?>                 
                  </tfooter>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        
   
   
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <?php $año = date('Y'); ?>
                        <div><h6><strong>Copyright &copy; Software Bolivia <?php echo $año ?></strong> 
                          Todos los derechos reservados.</h6>
                        </div>
                        <div class="float-right d-none d-sm-inline-block">
                          <h6><b>Version</b> 1.0</h6> 
                        </div>
                    </div>
                </div>
            </footer> 
   

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
</div>
<!-- ./wrapper -->





<!--        MODAL         -->



    <!-- Modal Registrar Casa --> 
    <div class="modal fade" id="modal-Casa">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-home"></i>  Registrar Casa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Nombre Casa</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                    </div>
                    <input type="text" class="form-control" name="nombre" id ="nombre" placeholder="Ingresar nombre">
                  </div>                 
                </div>  
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Descripción</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                    </div>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresar descripcion de la casa">
                  </div>                
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Medida de Casa</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-text-height"></i></span>
                    </div>
                    <input type="text" class="form-control" name="medidas" id="medidas" placeholder="Ingresar medida de casa">
                  </div>                 
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Nro de Casa</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
                    </div>
                    <input type="text" class="form-control" name="nrocasa" id="nrocasa" placeholder="Ingresar numero de casa">
                  </div>                 
                </div>   
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>precio</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                    </div>
                    <input type="text" class="form-control" name="precio" id="precio" placeholder="Ingresar el precio">
                  </div>                 
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Fecha Registro</b></label>
                  <input type="date" class="form-control" name="fecha" id="fecha">
                </div>                  
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="registrarCasa()">Crear Casa</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




       <!-- Modal editar Casa --> 
    <div class="modal fade" id="modalEditarCasa">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i>  Editar Casa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
                <div class="col-md-6">
                  <input type="HIDDEN" class="form-control" id="id1">
                </div>
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Nombre Casa</b></label>
                  <input type="text" class="form-control" id ="nombre1" placeholder="Ingresar nombre">
                </div>  
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Descripción</b></label>
                  <input type="text" class="form-control" id="descripcion1" placeholder="Ingresar descripcion de la casa">
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Medida de Casa</b></label>
                  <input type="text" class="form-control"  id="medidas1" placeholder="Ingresar medida de casa">
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Nro de Casa</b></label>
                  <input type="text" class="form-control"  id="nrocasa1" placeholder="Ingresar numero de casa">
                </div>   
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>precio</b></label>
                  <input type="text" class="form-control"    id="precio1" placeholder="Ingresar el precio">
                </div>                  
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarCasa()">Actualizar Casa</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->


          <!-- Modal ver iniquilno --> 
    <div class="modal fade" id="modalVerInquilino">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-user"></i>  Datos Inquilino</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Nombre</b></label>
                  <input type="text" class="form-control" id ="nombrePersona" disabled>
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Apellidos</b></label>
                  <input type="text" class="form-control" id="apellidos" disabled>
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Carnet</b></label>
                  <input type="text" class="form-control"  id="carnet" disabled>
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Telefono</b></label>
                  <input type="text" class="form-control"  id="telefono" disabled>
                </div>   
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Total Personas</b></label>
                  <input type="text" class="form-control" id="totalPersonas" disabled>
                </div>                  
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal fade-->

     
    
          <!-- Modal agregar fotos departamentos --> 
    <div class="modal fade" id="modal-AgregarFoto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-images"></i> Subir Foto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
              <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputCasa" class="form-label"><b>Departamento</b></label> 
                        <select class="form-select" id="idDepartamento" style="width: 100%;" > 
                            <option selected="selected" disabled>Seleccionar...</option>
                            <?php
                                $consulta = "SELECT * FROM casa;";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                            ?>
                            <?php foreach ($ejecutar as $ocpiones) : ?>
                                <option value="<?php echo $ocpiones['id'] ?>"><?php echo $ocpiones['nombre'] ?> - <?php echo $ocpiones['descripcion'] ?> - <?php echo $ocpiones['nroCasa'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div> 
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Buscar Foto</b></label>
                  <input type="file" class="form-control-file" id="direccionFoto" accept="image/x-png,image/jpeg">
                </div>                  
              </form>
            </div>
            <div class="modal-footer col-md-12">
            <button type="button" class="btn btn-primary" onclick="subirFotos()">subir foto</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal fade-->  




    <!-- Modal ver fotos --> 
    <div class="modal fade" id="modalVerfotos">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="2" aria-label="Slide 3"></button>
                  <button type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="3" aria-label="Slide 4"></button>
                  <button type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="4" aria-label="Slide 5"></button>
                  <button type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="5" aria-label="Slide 6"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="../fotosDpto/b-1-Sala.jpeg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../fotosDpto/b-1-comedor.jpeg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../fotosDpto/b-1-cuarto1.jpeg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../fotosDpto/b-1-cuarto2.jpeg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../fotosDpto/b-1-baño.jpeg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../fotosDpto/b-1-cocina.jpeg" class="d-block w-100" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Siguiente</span>
                </button>
              </div>
               <!-- /.carouselExampleControlsNoTouching -->
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal fade-->

  <script>



        function subirFotos(){
         
         var idDepartamento = $("#idDepartamento");
         var direccionFoto = $("#direccionFoto");
         if(idDepartamento == ""){
           return swal.fire('Faltan Datos..!','Debe seleccionar el departamento','warning');
         }

         if(direccionFoto == ""){
           return swal.fire('Faltan Datos..!','Debe seleccionar la foto','warning');
         }

         var formData = new FormData();
         var foto= $("#direccionFoto")[0].files[0];
         formData.append('id',idDepartamento);
         formData.append('f',foto);

         $.ajax({
           type: 'POST',
           url:'../clases/Cl_SubirFoto.php',
           data: formData,
           contentType:false,
           processData:false,
           success: function(resp){
             if(resp == 1){
                swal.fire('Exito..!','Foto subida correctamente','success');
             }else{
              swal.fire('Ops..!','Error al subir la foto','error');
             }
           }
         })
        }


        function verFoto(){
          $('#modalVerfotos').modal('show');
        }

        function abrirmodalsubirfoto(){
          $('#modal-AgregarFoto').modal('show');
        }


        //obtiene la datos del inquilino desde la BD y lo pasa al modal
        function VerInquilino(idCasa) {
              
          $.ajax({
           url: '../clases/Cl_Casa.php?op=VerInquilino',
           type: 'POST',
           data: {
                idCasa: idCasa            
               }, 
               success: function(vs) {
                   if (vs == 2) {
                       MostrarAlerta("Error..!", "Error al recuperar los datos del inquilino", "error");                     
                   }else{
                    var nombre = [];
                    var apellidos = [];
                    var carnet = [];
                    var telefono = [];
                    var totalPersonas = [];
                    var data= JSON.parse(vs);
                    for(var i=0;i< data.length;i++){
                      nombre.push(data[i][0]);
                      apellidos.push(data[i][1]);
                      carnet.push(data[i][2]);
                      telefono.push(data[i][3]); 
                      totalPersonas.push(data[i][4]);
                    }
                    $('#nombrePersona').val(nombre);
                    $('#apellidos').val(apellidos);
                    $('#carnet').val(carnet);
                    $('#telefono').val(telefono);
                    $('#totalPersonas').val(totalPersonas); 

                    $('#modalVerInquilino').modal('show');
                   }                  
               }
           })         

          }



        //Llama al modal editar casa y le manda los campos de la fila
        function editarCasaModal(id,nombre,descripcion,medidas,nrocasa,precio) {
        
            $('#id1').val(id);  
            $('#nombre1').val(nombre);
            $('#descripcion1').val(descripcion);
            $('#medidas1').val(medidas);
            $('#nrocasa1').val(nrocasa);
            $('#precio1').val(precio); 

            $('#modalEditarCasa').modal('show');
        }

             //Llama al modal editar casa y le manda los campos de la fila
        function ConfirmarEliminarCasa(id) {
        
          Swal.fire({
            title: 'Esta Seguro?',
            text: "Una vez eliminado ya no se podra recuperar!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                    if (result.isConfirmed) {
                        ElimnarCasa(id);                      
                    }
            })
        }

        function ElimnarCasa(id1) {
           
           var id = id1;

           $.ajax({
           url: '../clases/Cl_Casa.php?op=EliminarCasa',
           type: 'POST',
           data: {
               id: id            
               }, 
               success: function(vs) {
                   if (vs == 2) {
                       MostrarAlerta("Error..!", "ha ocurrido un error", "error");                     
                   }else{
                       Swal.fire(
                       'Eliminado!',
                       'Casa eliminada correctamente.',
                       'success'
                       )
                      // $('#example1').load('casas.php #example1')
                      window.location.href = "casas.php";
                   }                  
               }
           })         
       }



       function editarCasa(){
            
            var id = $("#id1").val();
            var nombre = $("#nombre1").val();
            var descripcion = $("#descripcion1").val();
            var medidas = $("#medidas1").val();
            var nrocasa = $("#nrocasa1").val();
            var precio = $("#precio1").val();

            $.ajax({                
                 url:'../clases/Cl_Casa.php?op=editarCasa',
                 type:'POST',
                 data:{
                    id:id,
                    nombre: nombre,
                    descripcion: descripcion,
                    medidas: medidas,
                    nrocasa: nrocasa,
                    precio:precio              
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Casa actualizada correctamente!','success')
                      //  $('#example1').load('casas.php #example1')
                        $('#modalEditarCasa').modal('toggle');
                        window.location.href = "casas.php";
                      }
                      else{
                          if(resp == 2){
                            Swal.fire(
                              'Error!',
                              'Ha ocurrido un error al guardar la información a la base de datos!',
                              'error'
                            ) 
                          }else{
                                if(resp == 3){
                                  Swal.fire(
                                    'Campos Vacios!',
                                    'Debe completar todos los campos!',
                                    'warning'
                                  )
                                }
                          }                      
                      }
                 }
            });             
         
        }



          function registrarCasa(){
            
              var nombre = $("#nombre").val();
              var descripcion = $("#descripcion").val();
              var medidas = $("#medidas").val();
              var nrocasa = $("#nrocasa").val();
              var fecha = $("#fecha").val();
              var precio = $("#precio").val();

              $.ajax({                
                   url:'../clases/Cl_Casa.php?op=RegistrarCasa',
                   type:'POST',
                   data:{
                      nombre: nombre,
                      descripcion: descripcion,
                      medidas: medidas,
                      nrocasa: nrocasa,
                      fecha: fecha,
                      precio:precio              
                   },
                   error: function(resp){
                     alert(resp);
                   },
                   success: function(resp){
                        if(resp == 1){
                          Swal.fire('Exito..!','Casa resgistrada correctamente!','success')
                         // $('#example1').load('casas.php #example1')
                          $('#modal-Casa').modal('toggle');
                          window.location.href = "casas.php";
                        }
                        else{
                            if(resp == 2){
                              Swal.fire(
                                'Error!',
                                'Ha ocurrido un error al guardar la información a la base de datos!',
                                'error'
                              )
                            }
                           
                        }
                   }
              });             
           
          }
      </script>



<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>-->
<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf"],
      "language": lenguaje_español
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  })

  var lenguaje_español = 
    {
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ningún dato disponible en esta tabla", 
    "info":  "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",   
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {       
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "aria": {
        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }
   

  
  
</script>
</body>
</html>
