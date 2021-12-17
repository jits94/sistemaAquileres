<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}



$sql = "SELECT * FROM persona where estado = 'Activo'";

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
            <h1 class="m-0">Listado de personas del condominio</h1>
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-Persona"><i class="fas fa-plus-circle"></i> Agregar nueva persona
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Carnet</th>
                    <th>Telefono</th>
                    <th>Fecha</th>
                    <th>Total Personas</th>
                    <th>Accion</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $cont = 0;
                      while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                        <td><?php echo $row['id']; ?></td>
                          <td><?php echo $row['nombre']; ?></td>
                          <td><?php echo $row['apellidos']; ?></td>
                          <td><?php echo $row['carnet']; ?></td>
                          <td><?php echo $row['telefono']; ?></td>
                          <td><?php echo $row['fechaNacimiento']; ?></td>
                          <td><?php echo $row['miembrosFamilia']; ?></td>                    
                          <td><button type='button' class='btn btn-success btn-sm checkbox-toggle'  onclick="editarPersonaModal('<?php echo $row['id']; ?>','<?php echo $row['nombre']; ?>','<?php echo $row['apellidos']; ?>','<?php echo $row['carnet']; ?>','<?php echo $row['telefono']; ?>','<?php echo $row['miembrosFamilia']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                          <button type='button' class='btn btn-danger btn-sm checkbox-toggle' onclick="ConfirmarEliminarPersona('<?php echo $row['id']; ?>')"><i title="Eliminar" class="fas fa-trash"></i></button>
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



    <!-- Modal Registrar Casa --> 
    <div class="modal fade" id="modal-Persona">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-user-tie"></i>  Registrar Datos de la Persona</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Nombre</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="nombre" placeholder="Ingresar nombre">
                  </div>                 
                </div>  
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Apellidos</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                    </div>
                    <input type="text" class="form-control" id="apellidos" placeholder="Ingresar apellidos">
                  </div>                
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Carnet</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" class="form-control" id="carnet" placeholder="Ingresar carnet">
                  </div>                 
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Telefono</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" class="form-control" id="telefono" placeholder="Ingresar telefono">
                  </div>                 
                </div>   
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Miembros de la Familia</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-users"></i></span>
                    </div>
                    <input type="text" class="form-control" id="miembrosFamilia" placeholder="Ingresar cantidad">
                  </div>                 
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Fecha Registro</b></label>
                  <input type="date" class="form-control" id="fecha">
                </div>                  
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="registrarPersona()">Registrar Persona</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




       <!-- Modal editar persona --> 
    <div class="modal fade" id="modalEditarPersona">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-user-tie"></i>  Editar datos de la Persona</h4>
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
                  <label for="inputName" class="form-label"><b>Nombre</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="nombre1" placeholder="Ingresar nombre">
                  </div>                 
                </div>  
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Apellidos</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                    </div>
                    <input type="text" class="form-control" id="apellidos1" placeholder="Ingresar apellidos">
                  </div>                
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Carnet</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" class="form-control" id="carnet1" placeholder="Ingresar carnet">
                  </div>                 
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Telefono</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" class="form-control" id="telefono1" placeholder="Ingresar telefono">
                  </div>                 
                </div>   
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Miembros de la Familia</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-users"></i></span>
                    </div>
                    <input type="text" class="form-control" id="miembrosFamilia1" placeholder="Ingresar cantidad">
                  </div>                 
                </div>  
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarPersona()">Actualizar Persona</button>
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
        function editarPersonaModal(id,nombre,apellidos,carnet,telefono,miembrosFamilia) {
        
            $('#id1').val(id);  
            $('#nombre1').val(nombre);
            $('#apellidos1').val(apellidos);
            $('#carnet1').val(carnet);
            $('#telefono1').val(telefono);
            $('#miembrosFamilia1').val(miembrosFamilia); 

            $('#modalEditarPersona').modal('show');
        }

             //Llama al modal editar casa y le manda los campos de la fila
        function ConfirmarEliminarPersona(id) {
        
          Swal.fire({
            title: 'Esta Seguro?',
            text: "Una vez eliminada la persona ya no se podra recuperar sus datos!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                    if (result.isConfirmed) {
                        ElimnarPersona(id);                      
                    }
            })
        }

        function ElimnarPersona(id1) {
           
           var id = id1;
           
           $.ajax({
           url: '../clases/Cl_Persona.php?op=EliminarPersona',
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
                       'Persona eliminada correctamente.',
                       'success'
                       )
                      // $('#example1').load('casas.php #example1')
                      window.location.href = "persona.php";
                   }                  
               }
           })         
       }



       function editarPersona(){
            
            var id = $("#id1").val();
            var nombre = $("#nombre1").val();
            var apellidos = $("#apellidos1").val();
            var carnet = $("#carnet1").val();
            var telefono = $("#telefono1").val();
            var miembrosFamilia1 = $("#miembrosFamilia1").val();

            $.ajax({                
                 url:'../clases/Cl_Persona.php?op=editarPersona',
                 type:'POST',
                 data:{
                    id: id,
                    nombre: nombre,
                    apellidos: apellidos,
                    carnet: carnet,
                    telefono: telefono,
                    miembrosFamilia: miembrosFamilia1        
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Persona actualizada correctamente!','success')
                        $('#modalEditarPersona').modal('toggle');
                        window.location.href = "persona.php";
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



          function registrarPersona(){
            
              var nombre = $("#nombre").val();
              var apellidos = $("#apellidos").val();
              var carnet = $("#carnet").val();
              var telefono = $("#telefono").val();
              var fecha = $("#fecha").val();
              var miembrosFamilia = $("#miembrosFamilia").val();

              $.ajax({                
                   url:'../clases/Cl_Persona.php?op=RegistrarPersona',
                   type:'POST',
                   data:{
                      nombre: nombre,
                      apellidos: apellidos,
                      carnet: carnet,
                      telefono: telefono,
                      fecha: fecha,
                      miembrosFamilia:miembrosFamilia              
                   },
                   error: function(resp){
                     alert(resp);
                   },
                   success: function(resp){
                        if(resp == 1){
                          Swal.fire('Exito..!','Persona resgistrada correctamente!','success')
                         // $('#example1').load('casas.php #example1')
                          $('#modal-Persona').modal('toggle');
                          window.location.href = "persona.php";
                        }
                        else{
                            if(resp == 2){
                              Swal.fire(
                                'Error!',
                                'Ha ocurrido un error al guardar la información a la base de datos!',
                                'error'
                              )
                            }
                            else{
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
