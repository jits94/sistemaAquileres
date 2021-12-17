<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}



$sql = "SELECT * FROM local";

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
            <h1 class="m-0">Listado de Locales para eventos</h1>
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-Casa"><i class="fas fa-plus-circle"></i> Agregar nuevo local
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Disponibilidad</th>
                    <th>status</th>
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
                          <td><?php echo $row['estado']; ?></td> 
                          <td><?php echo $row['status']; ?></td> 
                            <?php 
                            if($row['status'] == "Deshabilitado"){
                                $titulo = "Habilitar";
                                $color= "btn btn-primary btn-sm checkbox-toggle";
                            }
                            else{
                                $titulo = "Deshabilitar";
                                $color= "btn btn-danger btn-sm checkbox-toggle";
                            }
                            
                            ?>                     
                          <td><button type='button' class='btn btn-success btn-sm checkbox-toggle'  onclick="editarLocalModal('<?php echo $row['id']; ?>','<?php echo $row['nombre']; ?>','<?php echo $row['descripcion']; ?>','<?php echo $row['status']; ?>')"> Editar</button>
                          <button type='button' class="<?php echo $color;?>"  onclick="ConfirmarEliminarLocal('<?php echo $row['id']; ?>','<?php echo $row['status']; ?>')"><?php echo $titulo;?></button>
                          </td>
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



    <!-- Modal Registrar local --> 
    <div class="modal fade" id="modal-Casa">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-glass-cheers"></i>  Registrar Local</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Nombre Local</b></label>
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
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="registrarLocal()">Crear Local</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




       <!-- Modal editar local --> 
    <div class="modal fade" id="modalEditarlocal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i>  Editar Local</h4>
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
                  
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarCasa()">Actualizar Local</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->



  <script>

        //Llama al modal editar casa y le manda los campos de la fila
        function editarLocalModal(id,nombre,descripcion) {
        
            $('#id1').val(id);  
            $('#nombre1').val(nombre);
            $('#descripcion1').val(descripcion);

            $('#modalEditarlocal').modal('show');
        }

             //Llama al modal editar casa y le manda los campos de la fila
        function ConfirmarEliminarLocal(id,estado) {
        
        if(estado == "Deshabilitado"){
            Swal.fire({
            title: 'Confirmación..!',
            text: "¿Seguro que desea Habilitar el local?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Habilitar!'
            }).then((result) => {
                    if (result.isConfirmed) {
                        ElimnarLocal(id,'Habilitado');                      
                    }
            })
        }
        else{
            Swal.fire({
            title: 'Confirmación..!',
            text: "¿Seguro que desea deshabilitar el local?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Deshabilitar!'
            }).then((result) => {
                    if (result.isConfirmed) {
                        ElimnarLocal(id,'Deshabilitado');                      
                    }
            })
        }
        
        }

        function ElimnarLocal(id1,estado) {
           
           $.ajax({
           url: '../clases/Cl_Local.php?op=EliminarLocal',
           type: 'POST',
           data: {
               id: id1,
               estado: estado           
               }, 
               success: function(vs) {
                   if (vs == 2) {
                       MostrarAlerta("Error..!", "ha ocurrido un error", "error");
                       return false;
                   }else{
                       Swal.fire(
                       'Eliminado!',
                       'Local ha sido '+estado+' correctamente.',
                       'success'
                       )
                       window.location.href = "local.php";
                     //  $('#example1').load('local.php #example1')
                   }                  
               }
           })         
       }



       function editarCasa(){
            
            var id = $("#id1").val();
            var nombre = $("#nombre1").val();
            var descripcion = $("#descripcion1").val();

            $.ajax({                
                 url:'../clases/Cl_Local.php?op=editarLocal',
                 type:'POST',
                 data:{
                    id:id,
                    nombre: nombre,
                    descripcion: descripcion            
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Local actualizado correctamente!','success')
                        //$('#example1').load('local.php #example1')
                        $('#modalEditarlocal').modal('toggle');
                        window.location.href = "local.php";
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



          function registrarLocal(){
            
              var nombre = $("#nombre").val();
              var descripcion = $("#descripcion").val();

              $.ajax({                
                   url:'../clases/Cl_Local.php?op=RegistrarLocal',
                   type:'POST',
                   data:{
                      nombre: nombre,
                      descripcion: descripcion            
                   },
                   error: function(resp){
                     alert(resp);
                   },
                   success: function(resp){
                        if(resp == 1){
                          Swal.fire('Exito..!','Local resgistrado correctamente!','success')
                         // $('#example1').load('local.php #example1')
                          $('#modal-local').modal('toggle');
                          window.location.href = "local.php";
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




<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
