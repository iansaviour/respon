<?php  
include 'includes/core.php';
checkSvc();
if(!isset($_GET['t'])){
include 'includes/top.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard 
      <small>Home</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Operation List</h3>
          </div>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Keyword</th>
                  <th>Nama Operasi</th>
                  <th>Login Required</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="op-body">
                <?php  
                  $str = file_get_contents('op.json');
                  $data = json_decode($str, true); 
                  $i = 0;
                  foreach ($data as $datax) {
                    if($datax['penanda_login']=="1"){
                      $login_required = "Yes";
                    }else{
                      $login_required = "No";
                    }
                    echo"<tr>";
                      echo"<td>$datax[keyword]</td>";
                      echo"<td>$datax[nama_operasi]</td>";
                      echo"<td>$login_required</td>";
                      echo"<td><a class='op-act' data-loc='$datax[id_app_det]' data-login='$datax[penanda_login]' style=\"cursor:pointer;\">Choose</a></td>";
                    echo"</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php  
  include 'includes/bottom.php';
?>

<script type="text/javascript">
  $(document).ready(function() {
    $("#activate").click(function(event) {
      $.ajax({
        url: 'index.php?t=set_svc',
        type: 'GET',
        data: {id: $("#select-svc").val(), svc : $("#select-svc option:selected").text()},
      })
      .done(function(data) {
        console.log("success");
        $("#cur-svc").html(data);
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    });

    $("#example1").DataTable();

     $("#op-body").on('click', '.op-act',function(e) {
        var login_req = $(this).data('login');
        var loc = $(this).data('loc');
        if(login_req=="1"){
          $.ajax({
            url: 'index.php?t=cek'
          })
          .done(function(data) {
            console.log(data);
            if(data=="0"){
              window.location="login_op.php?r="+loc;
            }else{
              window.location=""+loc+".php";
            }
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          
        }else{
          window.location=""+loc+".php";
        }
    });

  });
</script>

<?php  
}elseif($_GET['t']=="set_svc"){
  $_SESSION['id_svc'] = $_GET['id'];
  $_SESSION['svc'] = $_GET['svc'];
  echo $_SESSION['svc'];
}elseif($_GET['t']=="cek"){
  if (isset($_SESSION['is_login'])) {
    if($_SESSION['is_login']=="1"){
      echo"1";
    }else{
      echo"0";  
    }
  }else{
    echo"0";
  }
}
?>