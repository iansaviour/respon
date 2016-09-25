<?php  
  include 'includes/core.php';
  include 'includes/top.php';
  //balas spam dkk, pesan error
  $query = "SELECT * FROM tb_option";
  $result = mysqli_query($id_mysql,$query);
  $data = mysqli_fetch_array($result);

  exec('schtasks /query /tn Respon /fo list',$output);
  //
  $type = "";
  $id_service = "";
  if(isset($_GET['selService']) && isset($_GET['selView'])){
    $id_service = $_GET['selService'];
    $type = $_GET['selView'];
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard Respon
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Konfigurasi Respon Scheduler</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    
    <!-- table respon -->
    <div class="row" id="panel-respon">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Log Respon</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-refresh-respon" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i>&nbsp; Refresh</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="respon" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Log Respon</th>
                    <th>Datetime</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end table respon -->
    <!-- table  -->
    <div class="row" id="panel-form-inbox" >
      <div class="col-lg-12 col-xs-12">
      <form class="form-horizontal" id="formView" method="GET">
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>View Inbox/Outbox</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Service</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selService">
                    <?php
                      $query_host = "SELECT * FROM tb_service";
                      $result_host = mysqli_query($id_mysql,$query_host);
                      while($row_host = $result_host->fetch_assoc()) {
                        ?>
                          <option <?php if($id_service == $row_host['id_service']){echo "SELECTED";} ?> value="<?php echo $row_host['id_service']; ?>"><?php echo $row_host['service']; ?></option>
                        <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">View</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selView">
                    <option <?php if($type == "1"){echo "SELECTED";} ?> value="1">Inbox</option>
                    <option <?php if($type == "2"){echo "SELECTED";} ?> value="2">Outbox</option>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnView" type="submit" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-search"></i> View</span></button>
            </div><!-- /.box-footer -->
          </div><!-- /.box-body -->
        </div>
      </div>
    </form>
    </div><!-- /.row -->
    <!-- end table  -->
    <!-- table inbox -->
    <div class="row" id="panel-inbox" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Inbox</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-refresh-inbox" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i>&nbsp; Refresh</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="inbox" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Sender</th>
                    <th>Date</th>
                    <th>Flag</th>
                    <th>Message</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end table inbox -->
    <!-- table outbox -->
    <div class="row" id="panel-outbox" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Outbox</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-refresh-outbox" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i>&nbsp; Refresh</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="outbox" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Recipient</th>
                    <th>Date</th>
                    <th>Flag</th>
                    <th>Message</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end table outbox -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">
$(document).ready(function() {
  $('#respon').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "respon_config_act.php?t=respon",
      "order": [[ 0, "desc" ]],
      "columnDefs": [
          {
              "targets": [ 0 ],
              "visible": false
          }
      ]
  });
<?php
  $penanda = "''";
  if(isset($_GET['selService']) && isset($_GET['selView'])){
    $id_service = $_GET['selService'];
    $type = $_GET['selView'];
    $penanda = "'?selService=".$id_service."&selView=".$type."'" ;
    if($type == "1"){
      ?>
        $('#inbox').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax": "respon_config_act.php?t=inbox&id_service=<?php echo $id_service; ?>",
          "order": [[ 0, "desc" ]],
          "columnDefs": [
              {
                  "targets": [ 0 ],
                  "visible": false
              }
          ]
      });
      $("#panel-outbox").hide();
      $("#panel-inbox").fadeIn('slow');
      <?php
    }else{
      ?>
        $('#outbox').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax": "respon_config_act.php?t=outbox&id_service=<?php echo $id_service; ?>",
          "order": [[ 0, "desc" ]],
          "columnDefs": [
              {
                  "targets": [ 0 ],
                  "visible": false
              }
          ]
        });
        $("#panel-inbox").hide();
        $("#panel-outbox").fadeIn('slow');
      <?php
    }
  }
?>
  $("#btnEdit").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnEdit' ) );
    l.start();
    $.ajax({
      url: 'respon_config_act.php?t=1',
      type: 'POST',
      data: $("#formControl").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="respon_config.php" + <?php echo $penanda ?>;
      }else{
        window.location="respon_config.php" + <?php echo $penanda ?>;
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });
  $("#btnStop").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnStop' ) );
    l.start();
    $.ajax({
      url: 'respon_config_act.php?t=2',
      type: 'POST',
      data: $("#formControl").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="respon_config.php" + <?php echo $penanda ?>;
      }else{
        $("#alertInfoBody").html(data);
        $("#alertInfo").fadeIn("slow");
        setTimeout(function() {$("#alertInfo").fadeOut("slow");}, 10000);
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });

  $("#btn-refresh-inbox").click(function(event) {
    window.location="respon_config.php" + <?php echo $penanda ?>;
  });

  $("#btn-refresh-outbox").click(function(event) {
    window.location="respon_config.php" + <?php echo $penanda ?>;
  });

  $("#btn-refresh-respon").click(function(event) {
    window.location="respon_config.php" + <?php echo $penanda ?>;
  });
});
</script>