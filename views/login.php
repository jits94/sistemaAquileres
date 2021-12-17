<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio de Sesión</title>
  <link rel="icon" type="image/jpg" href="../img/logo.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
   <!-- SweetAlert2 -->
   <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>
<body class="hold-transition login-page" style="background: url(../img/login.jpg);
    background-attachment: fixed;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    ">
<div class="login-box">
  <div class="login-logo">
   <b>Sistema para Condominios</b>
  </div>
  <!-- /.login-logo -->

  
  <div class="card" >
    <div class="card-body">
      <p class="login-box-msg">Debe autenticarse para iniciar sesión</p>
      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="usuario"  id="usuario" placeholder="usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="contra"  id="contra" placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
          <div class="row">
          <div class="col-8">
          <p class="mb-1">
            <a href="recuperar-contraseña.php">Olvide mi constraseña</a>
          </p>
          </div>
          <!-- /.col -->
          <div class="col-12" style="padding-top:20px">
            <button type="button" class="btn btn-primary btn-block" onclick="autenticacion()">Iniciar sesión</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <div class="row" style="position: relative; padding: 20px 0;">
        <h5 class="col-xs-12 text-center" style="position: absolute; margin-top: 0px; padding-left: 80px;">
          by <img src="../img/LogoSoft.png" class="img-responsive" style="width: 140px; display: inline-block">
        </h5>
      </div>
      <!--<div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>-->
      <!-- /.social-auth-links -->

    
     <!-- <p class="mb-0">
        <a href="registrarse.php" class="text-center">Registrar nuevo miembro</a>
      </p>
    </div>-->
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->








<script>

    function autenticacion(){
      var usuario = $("#usuario").val();
      var password = $("#contra").val();
               if(usuario == "" || password == ""){
                   return swal.fire("Datos incompletos","Debe ingresar el usuario y la contraseña","warning");
               }
                
               $.ajax({                
                   url:'../clases/Cl_inicioSesion.php',
                   type:'POST',
                   data:{
                       user: usuario,
                       pass: password                    
                   },
                   success: function(resp){
                        if(resp == 1){
                            window.location.href = "../index.php";
                        }
                        else{
                            if(resp == 2){
                                swal.fire('Ops..!','Usuario y/o contraseña incorrectos','Error');
                            }
                            else{
                              if(resp == 3){
                                swal.fire('Error..!','Usuario ingresado no existe','Error');
                              }
                            }
                        }
                   }
              });                   
    }


</script>





<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
