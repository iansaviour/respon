<?php  
  include 'includes/core.php';
  include 'includes/top.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      QUEUE EXAMPLE
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Queue</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-12 col-xs-12">
        
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Configuration</h3>
          </div><!-- /.box-header -->
          
          <div id="test">
            <?php  
              /*$query_def = "SELECT count_msg FROM tb_option_twitter";
              $result_def = mysql_query($query_def);
              $data_def = mysql_fetch_array($result_def);
              echo"<p>Default Connection : $data_def[count_msg]</p>";
              mysql_close();

              connectMyDB("localhost", "root", "bangcat48", "db_twitter");
              $query = "SELECT count_msg FROM tb_opt";
              $result = mysql_query($query);
              $data = mysql_fetch_array($result);
              echo"<p>Custom Connection : $data[count_msg]</p>";
              mysql_close();

              connectMyDB($server_dev, $username_dev, $password_dev, $name_dev);
              $query_def = "SELECT reload_interval FROM tb_option_twitter";
              $result_def = mysql_query($query_def);
              $data_def = mysql_fetch_array($result_def);
              echo"<p>Default Connection : $data_def[reload_interval]</p>";*/
              $query_eksekusi = "SELECT tb_eksekusi_respon.id_eksekusi,tb_inbox_twitter.inbox_user_screen,tb_operasi.id_jenis_operasi,tb_eksekusi_respon.query_value,tb_host.host,tb_host.username,tb_host.password,tb_eksekusi_respon.output_sms,tb_eksekusi_respon.output_field,tb_inbox_twitter.inbox,tb_host.db,IFNULL(tb_eksekusi_respon.id_operasi,0) as id_operasi,tb_eksekusi_respon.is_broadcast,tb_eksekusi_respon.broadcast_grup ";
              $query_eksekusi .= "FROM tb_eksekusi_respon ";
              $query_eksekusi .= "INNER JOIN tb_inbox_twitter ON tb_eksekusi_respon.id_inbox = tb_inbox_twitter.id_inbox ";
              $query_eksekusi .= "INNER JOIN tb_operasi ON tb_eksekusi_respon.id_operasi = tb_operasi.id_operasi ";
              $query_eksekusi .= "INNER JOIN tb_host ON tb_operasi.id_host = tb_host.id_host ";
              $query_eksekusi .= "WHERE op_status='0' ";
              $result_eksekusi = mysql_query($query_eksekusi);
              $n_eksekusi = mysql_num_rows($result_eksekusi);
              if ($n_eksekusi>0) {
                $data = array(); // make a new array to hold all your data
                $index = 0;
                while ($datax=mysql_fetch_array($result_eksekusi)) {
                  $data[$index]['id_eksekusi'] = $datax['id_eksekusi'];
                  $index++;
                }
                echo $data[6]['id_eksekusi'];
              }
            ?>
          </div>

        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">
  var i = 1;
  var intv;
  var intv_s= 0;
  
  function callAPI(){
    //clear
    //clearInterval(intv);

    //get
    //console.log("NakhlaSoft");
     $.ajax({
      url: 'queue_act.php',
      async :false
    })
    .done(function(data) {
      $("#test").append(data);
      //console.log(data);
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    
    //intv = setInterval(function() {callAPI()}, intv_s);
  }


  $(document).ready(function() {
    //console.log("NakhlaSoft");
    setInterval(function() {callAPI()}, 1);
  });
</script>