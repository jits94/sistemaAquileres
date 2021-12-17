<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}



$sql = "SELECT ca.id,concat(p.nombre, ' ',p.apellidos) as persona,c.nroCasa,ca.total,ca.fecha,ca.estadoPago,ca.proximoPago FROM cobroAlquiler as ca left join alquilar as a on a.id = ca.idalquilar left join persona as p on p.id = a.idPersona left join casa as c on c.id = a.idCasa";

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
            <h1 class="m-0">Lista de cobros</h1>
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-Alquiler"><i class="fas fa-plus-circle"></i> Registrar Pago
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th>Persona</th>
                    <th>Nro Dpto.</th>
                    <th>Total</th>
                    <th>Fecha Pago</th>                                   
                    <th>Estado Pago</th>
                    <th>Proximo Pago</th>      
                    <th>Accion</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $cont = 0; 
                      while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                          <td><?php echo $row['id']; ?></td>
                          <td><?php echo $row['persona']; ?></td>
                          <td><?php echo $row['nroCasa']; ?></td>
                          <td><?php echo $row['total']; ?></td>
                          <td><?php echo $row['fecha']; ?></td>                        
                          <td><?php echo $row['estadoPago']; ?></td>                         
                          <td><?php echo $row['proximoPago']; ?></td>
                          <td>
                            <button type='button' class='btn btn-success btn-sm checkbox-toggle'  onclick="ConfirmarEditarPago('<?php echo $row['id']; ?>','<?php echo $row['fecha']; ?>','<?php echo $row['total']; ?>','<?php echo $row['proximoPago']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                            <button type='button' class='btn btn-danger btn-sm checkbox-toggle' onclick="ConfirmarEliminarPago('<?php echo $row['id']; ?>')"><i title="Eliminar" class="fas fa-trash"></i></button>
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



    <!-- Modal Registrar Pago --> 
    <div class="modal fade" id="modal-Alquiler">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-money-bill-alt"></i>  Registrar Nuevo Pago</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formAlquilarCasa" class="row g-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputCategoria" class="form-label"><b>Nombre Inquilino</b></label>
                            <select class="form-control select2" id="idAlquiler" style="width: 100%;" onchange="traerDatosCuotaPago($(this).val())">
                                <option selected="selected" disabled>Seleccionar...</option>
                                <?php
                                    $consulta1 = "SELECT a.id,concat(p.nombre,' ',p.apellidos) as persona FROM alquilar as a left join persona as p on p.id = a.idPersona;";
                                    $ejecutar1 = mysqli_query($conectar, $consulta1) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar1 as $ocpiones1) : ?>
                                    <option value="<?php echo $ocpiones1['id'] ?>"><?php echo $ocpiones1['persona'] ?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputCategoria" class="form-label"><b>Estado Pago</b></label>
                            <select class="form-control select2" id="estadoPago" style="width: 100%;">
                                <option selected="selected" disabled>Seleccionar...</option>
                                <option>Puntual</option>
                                <option>Retrasado</option>
                            </select>
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
                        <label for="inputName" class="form-label"><b>Fecha Pago</b></label>
                        <input type="date" class="form-control" id="fecha">
                    </div>  
                    <div class="col-md-6">
                        <label for="inputName" class="form-label"><b>Fecha Proximo Pago</b></label>
                        <input type="date" class="form-control" id="proximoPago">
                    </div>                  
                </form>
              </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="RegistrarPago()"> Registrar Pago</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




       <!-- Modal editar pago --> 
    <div class="modal fade" id="modaleditarPago">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i>  Editar Pago</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
               
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Total Pagado</b></label>
                  <input type="text" class="form-control" id ="total1" placeholder="Ingresar pago">
                </div>  
                <div class="col-md-6">
                  <label for="inputName" class="form-label"><b>Fecha del Pago</b></label>
                  <input type="date" class="form-control" id="fecha1">
                </div>  
                <div class="col-md-6">
                        <label for="inputName" class="form-label"><b>Fecha Proximo Pago</b></label>
                        <input type="date" class="form-control" id="proximoPago1">
                    </div>  
                <div class="col-md-6">
                  <input type="HIDDEN" class="form-control" id="id1">
                </div>
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarPago()">Actualizar Pago</button>
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
   function traerDatosCuotaPago(idAlquiler){
         
         $.ajax({
        url: '../clases/Cl_cobrosAlquiler.php?op=DatosPago',
        type: 'POST',
        data: {
            id: idAlquiler            
            }, 
            error: function(resp){
                  alert(resp);
                },
            success: function(vs) {
                if (vs == 'no') {
                    swal.fire('Error..!', 'error al obtener la cuota mensual', 'error');                     
                }else{
                 $('#total').val(vs);
                }
            }
        })         

     }


        //Llama al modal editar casa y le manda los campos de la fila
        function ConfirmarEditarPago(id,fecha,total,proximoPago) {

            $('#id1').val(id);
            $('#total1').val(total);
            $('#fecha1').val(fecha);
            $('#proximoPago1').val(proximoPago);

            $('#modaleditarPago').modal('show');
        }

      
             //Llama al modal editar pago y le manda los campos de la fila
        function ConfirmarEliminarPago(id) {
        
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
                      ElimnarCobro(id);                      
                    }
            })
        }

        function ElimnarCobro(id1) {
           
           var id = id1;

           $.ajax({
           url: '../clases/Cl_cobrosAlquiler.php?op=EliminarPago',
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
                       'Pago eliminado correctamente.',
                       'success'
                       )
                      // $('#example1').load('casas.php #example1')
                      window.location.href = "cobrosAlquiler.php";
                   }                  
               }
           })         
       }



       function editarPago(){
            
            var id = $("#id1").val();
            var fecha = $("#fecha1").val();
            var total = $("#total1").val();
            var proximoPago = $("#proximoPago1").val();

            $.ajax({                
                 url:'../clases/Cl_cobrosAlquiler.php?op=EditarPago',
                 type:'POST',
                 data:{
                    id:id,
                    fecha: fecha,
                    total: total,
                    proximoPago: proximoPago                            
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Pago actualizado correctamente!','success')
                      //  $('#example1').load('casas.php #example1')
                        $('#modaleditarPago').modal('toggle');
                        window.location.href = "cobrosAlquiler.php";
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

          function RegistrarPago(){
            
              var estadoPago = $("#estadoPago").val();
              var idAlquiler = $("#idAlquiler").val();
              var fecha = $("#fecha").val();
              var total = $("#total").val();
              var proximoPago =  $("#proximoPago").val();

              $.ajax({                
                   url:'../clases/Cl_cobrosAlquiler.php?op=RegistrarPago',
                   type:'POST',
                   data:{
                      estadoPago: estadoPago,
                      idAlquiler: idAlquiler,
                      fecha: fecha,  
                      total: total,
                      proximoPago: proximoPago
                   },
                   error: function(resp){
                     alert(resp);
                   },
                   success: function(resp){
                        if(resp == 1){
                          Swal.fire('Exito..!','Pago resgistrado correctamente!','success')
                          $('#modal-Alquiler').modal('toggle');
                          window.location.href = "cobrosAlquiler.php";
                        }
                        else{
                            if(resp == 2){
                              Swal.fire(
                                'Error!',
                                'Ha ocurrido un error al guardar la información a la base de datos!',
                                'error'
                              )
                            }   else{
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
