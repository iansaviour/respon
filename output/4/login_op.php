<?php  include "includes/core.php"; ?>
<?php  
  if(!isset($_GET["t"])){
  include "includes/top.php";
  if (isset($_GET['r'])) {
    $r = $_GET['r'].".php";
  }else{
    $r = "index.php";
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Login Operasi
      <small>Form Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Login Operasi</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row" id="panel-form">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Login Form</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" id="formControl">
            <div class="box-body">
              <div class="form-group">
                <label for="input-via" class="col-sm-2 control-label">Service</label>
                <div class="col-sm-10">
                  <select class="form-control" id="select-svc" name="comboSvc">
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input0" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="username" name="username">
                </div>
              </div>
              <div class="form-group">
                <label for="input1" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="password" name="password">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-success pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-send"></i> Login</span></button>
              <div class="pull-right" style="padding-top:8px;" id="output"></div>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php  
  include "includes/bottom.php";
?>
<script type="text/javascript">
var intv;
var id = 0;
function getInbox(){
  clearInterval(intv);
  var jqXHR = $.ajaxq('MyQueue', {
    url: 'login_op.php?t=ibx&id='+id+'&svc='+$("#select-svc").val(),
    beforeSend: function() {
       
    },
    error: function() {
      console.log("error");
    },
    complete: function() {
      console.log("complete");
    },
    success: function(data) {
      console.log("success");
      if(data==""){
        intv = setInterval(function() {getInbox();}, 3000);
      }else{
        var l = Ladda.create( document.querySelector("#btnSave") );
        l.stop();
        console.log(data);
        if(data=="true"){
          window.location="<?php echo $r; ?>";
        }else{
          alert("Incorrect username/password.");
        }
      }
    }
  });
}


$(document).ready(function() {
   $.getJSON( "apps.json", function( data ) {
    $.each( data, function( key, val ) {
      $("#select-svc").append("<option value='"+val.id_service+"'>"+val.service+"</option>");
    });
  });

  $("#btnSave").click(function(event) {
    var l = Ladda.create( document.querySelector("#btnSave") );
    l.start();
    $.ajax({
      url: "login_op.php?t=save",
      type: "POST",
      data: $("#formControl").serialize()
    })
    .done(function(data) {
      if(data.indexOf("Error")>-1){
        $("#output").html(data);
      }else{
        id=data;
        getInbox();
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });
});
</script>
<?php  
  }elseif ($_GET["t"]=="save") {
    $id_service = $_POST['comboSvc'];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $output = "";

    $str = file_get_contents('apps.json');
    $data = json_decode($str, true); 
    $i = 0;
    foreach ($data as $datax) {
      if($datax['id_service']==$id_service){
        $query = "INSERT INTO $datax[outbox_table]($datax[outbox_content],$datax[outbox_date],$datax[outbox_flag]) VALUES('$username#$password','".date("Y-m-d")."','1') ";
        $result = mysqli_query($id_mysql,$query);
        if ($result) {
          $output= mysqli_insert_id($id_mysql);
        }else{
          $output="Error Login";
        }
      }
    }
    echo $output;
  }elseif ($_GET["t"]=="ibx"){
    $id_service = $_GET['svc'];
    $id=$_GET['id'];

    $str = file_get_contents('apps.json');
    $data = json_decode($str, true); 
    $i = 0;
    $output = "";
    foreach ($data as $datax) {
      if($datax['id_service']==$id_service){
        $query = "SELECT * FROM $datax[inbox_table] a WHERE a.id_outbox=$id ";
        $result = mysqli_query($id_mysql, $query);
        $jum = mysqli_num_rows($result);
        if($jum==0){
          $output="";
        }else{
          $data2  = mysqli_fetch_array($result);
          $output = $data2[$datax['inbox_content']];
          if($output=="true"){
            $_SESSION['is_login']="1";
          }else{
            $_SESSION['is_login']="2";
          }
        }   
      }
    }
    echo $output;
  }
?>