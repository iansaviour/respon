<?php  
session_start();
include 'includes/koneksi.php';
include 'includes/function.php';
if(!isset($_GET['code'])){
  checkAccessLoginPage();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    <!-- ladda -->
    <link rel="stylesheet" href="plugins/ladda/ladda.min.css">
    <link rel="stylesheet" href="plugins/ladda/ladda-themeless.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>Autoresponder</b>Engine</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="../../index2.html" method="post" id="defaultForm">
          <div class="form-group has-feedback">
            <input id="login-username" type="email" name="username" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input id="login-password" type="password" name="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button id="btn-sign" type="button" class="btn btn-primary pull-right ladda-button" data-size="xs" data-style="zoom-out"><span class="ladda-label"> Sign In</span></button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- LADDA -->
    <script src="dist/js/spin.min.js"></script>
    <script src="dist/js/ladda.min.js"></script>
    <script>
      $(function () {
        $("#btn-sign").click(function(event) {
          if($("#login-username").val()=="" ||  $("#login-password").val()==""){
            alert("Username dan password harus terisi");
          }else{
            var l = Ladda.create(document.querySelector( '#btn-sign' ));
            l.start();
            $.ajax({
              url: 'login.php?code=process',
              type: 'POST',
              data: $("#defaultForm").serialize(),
            })
            .done(function(data) {
              if(data=="sukses"){
                l.stop();
                window.location="index.php";
              }else{
                l.stop();
                console.log(data);
                alert("Username dan password tidak ditemukan !");
              }
              //console.log(data);
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
                  
          }
        });
      });
    </script>
  </body>
</html>
<?php  
}elseif ($_GET['code']=="process") {
  $username = makeSafe($_POST['username']);
  $password = md5(makeSafe($_POST['password']));
  $query ="SELECT * FROM tb_m_user WHERE username='$username' AND password='$password' LIMIT 1";
  $result = mysqli_query($id_mysql,$query);
  if(mysqli_num_rows($result)>0){
    $data = mysqli_fetch_array($result);
    $_SESSION['id_user']=$data['id_user'];
    $_SESSION['is_login_respon']="1";
    $_SESSION['id_user_role']= $data['id_user_role'];
    $_SESSION['username']= $data['username'];
    echo "sukses";
  }else{
    echo"gagal";
  }
}
?>