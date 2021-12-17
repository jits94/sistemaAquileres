<?php
session_start();
require("clases/conexion.php");

if (!isset($_SESSION['id'])) {
    header("Location: views/login.php");
} else {
    $usuario = $_SESSION['usuario'];

}

$mes = date('m');
$año = date('Y');
$sql = "SELECT c.id as idCobro,a.id as idalquilar,concat(p.nombre,' ',p.apellidos) as persona,c.total,c.proximoPago FROM cobroAlquiler as c left join alquilar as a on a.id = c.idalquilar left join persona as p on p.id = a.idPersona where month(c.proximoPago) = $mes and year(c.proximoPago) = $año and c.estado = 'Pendiente'";

$resultado = mysqli_query($conectar, $sql);
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Condominios</title>
  <link rel="icon" type="image/jpg" href="img/logo.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/logo.png" alt="Software Bolivia" height="60" width="60">
  </div>

 <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" >
            <?php echo $usuario; ?> <i class="fas fa-user fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
                <div class="dropdown-divider"></div>
                <a href="views/datosUsuario.php" class="dropdown-item">
                    <i class="fas fa-tools"></i> Configuracion
                </a>
                <div class="dropdown-divider"></div>
                <a href="views/logout.php" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="img/logo.png" alt="Software Bolivia" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Software Bolivia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Jorge Moron</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
            </li>
            <li class="nav-item">
            <a href="views/casas.php" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Departamentos               
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="local.php" class="nav-link">
              <i class="nav-icon fas fa-glass-cheers"></i>
              <p>
                Local Eventos
              </p>
            </a>
          </li>-->
          <li class="nav-item">
            <a href="views/persona.php" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Persona               
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="views/alquilarCasa.php" class="nav-link">
              <i class="nav-icon fas fa-store-alt"></i>
              <p>
              Alquilar Departamento
              </p>
            </a>
          </li>         
          <!--
          <li class="nav-item">
            <a href="../pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-store-alt"></i>
              <p>
                Alquilar
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="alquilarCasa.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alquilar Departamento</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/advanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alquilar Local</p>
                </a>
              </li>
            </ul>
          </li>    -->   
           
            <!--<li class="nav-item">
            <a href="views/empleado.php" class="nav-link">
              <i class="nav-icon fas fa-address-card"></i>
              <p>
                Empleado               
              </p>
            </a>
          </li>-->
          <li class="nav-item">
            <a href="views/cobrosAlquiler.php" class="nav-link">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                Registrar Cobro               
              </p>
            </a>
          </li>
         <!-- <li class="nav-item">
            <a href="views/registrarVisitas.php" class="nav-link">
              <i class="nav-icon fas fa-car"></i>
              <p>
                Registrar Visita               
              </p>
            </a>
          </li>-->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Panel de Control</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php
                  $consulta = "SELECT COUNT(estadocasa) as alquilados FROM casa where estadocasa = 'Alquilado'";
                  $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                  $row = $ejecutar->fetch_assoc();
                  $cantidad = $row['alquilados'];
                ?>
                  <h3><?php echo $cantidad;  ?></h3>

                <p><h5>Dptos. Alquilados</h5></p>
              </div>
              <div class="icon">
                <i class="ion ion-home"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php
                  $consulta = "SELECT COUNT(estadocasa) as alquilados FROM casa where estadocasa = 'disponible'";
                  $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                  $row = $ejecutar->fetch_assoc();
                  $cantidad1 = $row['alquilados'];
                ?>
                  <h3><?php echo $cantidad1;  ?></h3>


                <p><h5>Dptos. sin Alquilar</h5></p>
              </div>
              <div class="icon">
                <i class="ion ion-home"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php
                  $consulta = "SELECT sum(p.miembrosFamilia)as total FROM alquilar as a left join persona as p on p.id = a.idPersona where a.status = 'Ocupado'";
                  $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                  $row = $ejecutar->fetch_assoc();
                  $cantidad1 = $row['total'];
                ?>
                  <h3><?php echo $cantidad1;  ?></h3>

                <p><h5>Total Personas</h5></p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>          
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php
                  $consulta = "SELECT sum(total) as total FROM alquilar where status = 'Ocupado' ";
                  $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                  $row = $ejecutar->fetch_assoc();
                  $cantidad1 = $row['total'];
                  $english_format_number = number_format($cantidad1);
                ?>
                  <h3><?php echo $english_format_number;  ?></h3>

                <p><h5>Ingreso Mensual</h5></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
          <!--  <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Total ingresos por mes</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">Año 2021</span>
                  </p>
                
                </div>
                 /.d-flex 

                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Este Año
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Año Anterior
                  </span>
                </div>
              </div>
            </div>-->   
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Proximo pago alquiler</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table id="ejemplo" class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Inquilino(a)</th>
                    <th>Monto</th>
                    <th>Fecha del Pago</th>
                    <th>Cobrar</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $cont = 0; 
                        while ($row = $resultado->fetch_assoc()) { ?>
                          <tr>
                            <td><?php echo $row['persona']; ?></td>
                            <td><?php echo $row['total']; ?></td>
                            <td><?php echo $row['proximoPago']; ?></td>
                            <td>
                              <button type='button' class='btn btn-success btn-sm checkbox-toggle' onclick="AbrirModalCobrar('<?php echo $row['idCobro']; ?>','<?php echo $row['idalquilar']; ?>','<?php echo $row['persona']; ?>','<?php echo $row['total']; ?>')"><i title="Cobrar" class="fas fa-cash-register"></i></button>
                            </td>                                 
                          </tr>
                      <?php } ?>      
                  </tbody>
                </table>
              </div>
            </div>
          </section>
          <!-- /.Left col -->   
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->




  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</div>



<script>
    function AbrirModalCobrar(idCobro,idAlquilar,inquilino,total){

            $('#idCobro').val(idCobro);
            $('#idAlquilar').val(idAlquilar);
            $('#total').val(total);
            $('#inquilino').val(inquilino);

            $('#modal-RegistrarPago').modal('show');
    }


    function RegistrarPago(){

            var idCobro = $('#idCobro').val();
            var estadoPago = $("#estadoPago").val();
            var idAlquiler = $("#idAlquilar").val();
            var fecha = $("#fecha").val();
            var total = $("#total").val();
            var proximoPago =  $("#proximoPago").val();

            $.ajax({                
                 url:'clases/Cl_cobrosAlquiler.php?op=RegistrarPago',
                 type:'POST',
                 data:{
                    estadoPago: estadoPago,
                    idAlquiler: idAlquiler,
                    fecha: fecha,  
                    total: total,
                    proximoPago: proximoPago,
                    idCobro: idCobro
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Pago resgistrado correctamente!','success')
                        $('#ejemplo').load('index.php #ejemplo')
                        $('#modal-RegistrarPago').modal('toggle');
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



 <!-- Modal Registrar Pago --> 
 <div class="modal fade" id="modal-RegistrarPago">
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
                    <div class="col-md-6">
                            <label for="inputName" class="form-label"><b>Nombre Inquilino</b></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="inquilino">
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
                        <label for="inputName" class="form-label"><b>Fecha Pago</b></label>
                        <input type="date" class="form-control" id="fecha">
                    </div>  
                    <div class="col-md-6">
                        <label for="inputName" class="form-label"><b>Fecha Proximo Pago</b></label>
                        <input type="date" class="form-control" id="proximoPago">
                    </div>  
                    <div class="col-md-6">
                      <input type="HIDDEN" class="form-control" id="idAlquilar">
                    </div>   
                    <div class="col-md-6">
                      <input type="HIDDEN" class="form-control" id="idCobro">
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





<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
