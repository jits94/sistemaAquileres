<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}



$sql = "SELECT a.id,c.id as idCasa,c.nombre,c.descripcion,concat(p.nombre,' ',p.apellidos) as persona,p.telefono,c.precio,c.nroCasa,a.descuento,a.fecha,a.total,a.status FROM alquilar as a left join casa as c on c.id = a.idCasa left join persona as p on p.id = a.idPersona";

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
            <h1 class="m-0">Listado de alquileres de Locales</h1>
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-Alquiler"><i class="fas fa-plus-circle"></i> Agregar nuevo alquiler
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th>Departamento</th>
                    <th>Inquilino</th>
                    <th>Telefono</th>
                    <th>Ingresó</th>
                    <th>Precio</th>
                    <th>Desc.</th>                  
                    <th>Total</th>
                    <th>Status</th>
                    <th>Accion</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $cont = 0; 
                      while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                          <td><?php echo $row['id']; ?></td>
                          <td><?php echo $row['nombre']; ?></td>
                          <td><?php echo $row['persona']; ?></td>
                          <td><?php echo $row['telefono']; ?></td>
                          <td><?php echo $row['fecha']; ?></td>
                          <td><?php echo $row['precio']; ?></td>
                          <td><?php echo $row['descuento']; ?></td>
                          <td><?php echo $row['total']; ?></td>  
                           
                          <?php 
                            if($row['status'] == "Ocupado"){
                              ?>
                              <td  class='text text-danger'><?php echo $row['status']; ?></td>   
                              <td><button type='button' class='btn btn-info btn-sm checkbox-toggle'  onclick="editarAlquilerModal('<?php echo $row['id']; ?>','<?php echo $row['fecha']; ?>','<?php echo $row['total']; ?>','<?php echo $row['precio']; ?>','<?php echo $row['descuento']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                              <button type='button' class='btn btn-success btn-sm checkbox-toggle'  onclick="ConfirmarLiberarAlquilerCasa('<?php echo $row['id']; ?>','<?php echo $row['idCasa']; ?>')"><i title="Liberar Departamento" class="fas fa-door-open"></i></button>
                              <button type='button' class='btn btn-danger btn-sm checkbox-toggle' onclick="ConfirmarEliminarAlquilerCasa('<?php echo $row['id']; ?>')"><i title="Eliminar" class="fas fa-trash"></i></button>
                              </td>
                              <?php
                            }
                            else{
                              ?>
                              <td><?php echo $row['status']; ?></td>   
                              <td><button type='button' class='btn btn-info btn-sm checkbox-toggle'  onclick="editarAlquilerModal('<?php echo $row['id']; ?>','<?php echo $row['fecha']; ?>','<?php echo $row['total']; ?>','<?php echo $row['precio']; ?>','<?php echo $row['descuento']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                              <button type='button' class='btn btn-danger btn-sm checkbox-toggle' onclick="ConfirmarEliminarAlquilerCasa('<?php echo $row['id']; ?>')"><i title="Eliminar" class="fas fa-trash"></i></button>
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
    <div class="modal fade" id="modal-Alquiler">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-home"></i>  Registrar Nuevo Alquiler</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formAlquilarCasa" class="row g-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputCasa" class="form-label"><b>Departamento</b></label> 
                        <select class="form-control select2" id="idCasa" style="width: 100%;" onchange="traerDatosCasa($(this).val())" > 
                            <option selected="selected" disabled>Seleccionar...</option>
                            <?php
                                $consulta = "SELECT * FROM casa where estadocasa = 'disponible' and status_fl = 'Activo' order by nroCasa asc;";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                            ?>
                            <?php foreach ($ejecutar as $ocpiones) : ?>
                                <option value="<?php echo $ocpiones['id'] ?>"><?php echo $ocpiones['nombre'] ?> - <?php echo $ocpiones['descripcion'] ?> - <?php echo $ocpiones['nroCasa'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputCategoria" class="form-label"><b>Persona</b></label>
                        <select class="form-control select2" id="idPersona" style="width: 100%;">
                            <option selected="selected" disabled>Seleccionar...</option>
                            <?php
                                $consulta1 = "SELECT * FROM persona where estado = 'Activo' order by apellidos asc;";
                                $ejecutar1 = mysqli_query($conectar, $consulta1) or die(mysqli_error($conectar));
                            ?>
                            <?php foreach ($ejecutar1 as $ocpiones1) : ?>
                                <option value="<?php echo $ocpiones1['id'] ?>"><?php echo $ocpiones1['apellidos'] ?> - <?php echo $ocpiones1['nombre'] ?> </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>    
                <div class="col-md-6">
                        <label for="inputName" class="form-label"><b>Precio</b></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input type="text" class="form-control" id="precio" placeholder="Ingresar precio" disabled>
                        </div>                 
                    </div>             
                    <div class="col-md-6">
                        <label for="inputName" class="form-label"><b>Descuento</b></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-text-height"></i></span>
                            </div>
                            <input type="text" class="form-control" id="descuento" placeholder="Ingresar descuento">
                        </div>                 
                    </div>  
                    <div class="col-md-6">
                        <label for="inputName" class="form-label"><b>Total</b></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                            </div>
                            <input type="text" class="form-control" id="total">
                        </div>                 
                    </div>   
                    <div class="col-md-6">
                    <label for="inputName" class="form-label"><b>Fecha Alquiler</b></label>
                    <input type="date" class="form-control" id="fecha">
                    </div>                  
                </form>
              </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="AlquilarCasa()">Crear nuevo alquiler</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




       <!-- Modal editar alquiler --> 
    <div class="modal fade" id="modalEditarAlquiler">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i>  Editar datos del alquiler</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Fecha de Ingreso</b></label>
                  <input type="date" class="form-control" id ="fecha1">
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Precio Alquiler</b></label>
                  <input type="text" class="form-control" id="precio1" disabled>
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Descuento</b></label>
                  <input type="text" class="form-control"  id="descuento1" placeholder="Ingresar descuento">
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Total</b></label>
                  <input type="text" class="form-control"  id="total1" placeholder="Ingresar total">
                </div>
                <div class="col-md-6">
                  <input type="HIDDEN" class="form-control" id="id1">
                </div>                  
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarAlquiler()">Actualizar Alquiler</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->



  <script>

        //traer los datos de la casa para el selected del modal registrar nuevo alquiler
        function traerDatosCasa(idCasa){
         
            $.ajax({
           url: '../clases/Cl_alquilerCasa.php?op=DatosCasa',
           type: 'POST',
           data: {
               id: idCasa            
               }, 
               error: function(resp){
                     alert(resp);
                   },
               success: function(vs) {
                   if (vs == 'no') {
                       swal.fire('Error..!', 'error al obtener el precio de la casa', 'error');                     
                   }else{
                    $('#precio').val(vs);
                   }
               }
           })         

        }


        //Llama al modal editar casa y le manda los campos de la fila
        function ConfirmarLiberarAlquilerCasa(id,idCasa) {
        
          Swal.fire({
            title: 'Esta Seguro?',
            text: "Una vez liberado, el departamento quedara disponible para alquilar!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Liberar!'
            }).then((result) => {
                    if (result.isConfirmed) {
                        LiberarCasa(id,idCasa);                      
                    }
            })
        }

        function LiberarCasa(id1,idCasa) {
           
           var id = id1;
           var idCasa = idCasa;

           $.ajax({
           url: '../clases/Cl_alquilerCasa.php?op=LiberarDepartamento',
           type: 'POST',
           data: {
               id: id,
               idCasa: idCasa           
               }, 
               success: function(vs) {
                   if (vs == 2) {
                       MostrarAlerta("Error..!", "ha ocurrido un error", "error");                     
                   }else{
                       Swal.fire(
                       'Liberado!',
                       'Departamento liberado correctamente.',
                       'success'
                       )
                      // $('#example1').load('casas.php #example1')
                      window.location.href = "alquilarCasa.php";
                   }                  
               }
           })         
       }
             //Llama al modal editar casa y le manda los campos de la fila
        function ConfirmarEliminarAlquilerCasa(id) {
        
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
                      ElimnarAlquiler(id);                      
                    }
            })
        }

        function ElimnarAlquiler(id1) {
           
           var id = id1;

           $.ajax({
           url: '../clases/Cl_alquilerCasa.php?op=EliminarAlquiler',
           type: 'POST',
           data: {
               id: id            
               }, 
               success: function(vs) {
                   if (vs == 2) {
                    Swal.fire("Error..!", "ha ocurrido un error al elminar", "error");                     
                   }else{
                       Swal.fire(
                       'Eliminado!',
                       'Alquiler eliminado correctamente.',
                       'success'
                       )
                      // $('#example1').load('casas.php #example1')
                      window.location.href = "alquilarCasa.php";
                   }                  
               }
           })         
       }


       function editarAlquilerModal(id,fecha,total,precio,descuento) {
        
        $('#id1').val(id);  
        $('#fecha1').val(fecha);
        $('#total1').val(total);
        $('#precio1').val(precio);
        $('#descuento1').val(descuento);

        $('#modalEditarAlquiler').modal('show');
    }



       function editarAlquiler(){
            
            var id = $("#id1").val();
            var fecha = $("#fecha1").val();
            var descuento = $("#descuento1").val();
            var total = $("#total1").val();

            $.ajax({                
                 url:'../clases/Cl_alquilerCasa.php?op=editarAlquiler',
                 type:'POST',
                 data:{
                    id:id,
                    fecha: fecha,
                    descuento: descuento,
                    total: total            
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Alquiler actualizado correctamente!','success')
                      //  $('#example1').load('casas.php #example1')
                        $('#modalEditarAlquiler').modal('toggle');
                        window.location.href = "alquilarCasa.php";
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



          function AlquilarCasa(){
            
              var idCasa = $("#idCasa").val();
              var idPersona = $("#idPersona").val();
              var descuento = $("#descuento").val();
              var fecha = $("#fecha").val();
              var total = $("#total").val();

              $.ajax({                
                   url:'../clases/Cl_alquilerCasa.php?op=alquilerCasa',
                   type:'POST',
                   data:{
                      idCasa: idCasa,
                      idPersona: idPersona,
                      descuento: descuento,
                      fecha: fecha,  
                      total: total
                   },
                   error: function(resp){
                     alert(resp);
                   },
                   success: function(resp){
                        if(resp == 1){
                          Swal.fire('Exito..!','Nuevo alquiler resgistrado correctamente!','success')
                          $('#modal-Alquiler').modal('toggle');
                          window.location.href = "alquilarCasa.php";
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
