<?php  
  include 'includes/core.php';
  checkAccess();
  include 'includes/top.php';
  $id=0;
  if(isset($_GET['id'])){
    $id=$_GET['id'];

    $query = "SELECT * FROM tb_bc_sch WHERE id_bc_sch=$id";
    $result = mysqli_query($id_mysql,$query);
    $data = mysqli_fetch_array($result);
    //
    $name = $data['name'];
    $id_contact_group=$data['id_contact_group'];
    $server=$data['server'];
    $message=$data['message'];
    //
    $start_date=$data['start_date'];
    $start_time=$data['start_time'];
    //
    $is_now = $data['is_now'];
    //
    $tipe_time = $data['tipe_time'];
    $time_var = $data['time_var'];
  }else{
    $id=0;
    //
    $name = "";
    $id_contact_group = "";
    $server = "";
    $message = "";
    //
    $start_date = "";
    $start_time = "";
    //
    $is_now = "2";
    //
    $tipe_time = "1";
    $time_var = "1";
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Scheduler
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Broadcast Schedule</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row" id="panel-list">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Schedule List</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp; Add</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="example" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama Schedule</th>
                    <th>Grup Kontak</th>
                    <th>Server</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->

    <div class="row" id="panel-form" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>

        <div class="box box-primary">
          <div class="box-body">
          <form class="form-horizontal" id="formControl">
            <div class="box-body">
              <h3>General</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Scheduler</label>
                <div class="col-sm-10">
                  <input type="hidden" name="txtId" value="<?php echo $id; ?>">
                  <input type="textbox" class="form-control" id="input-service" name="txtName" placeholder="Schedule Name" value="<?php echo $name; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Grup Kontak</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selCG">
                    <?php
                      $query_gc = "SELECT * FROM tb_contact_group";
                      $result_gc = mysqli_query($id_mysql,$query_gc);
                      while($row_gc = $result_gc->fetch_assoc()) {
                        ?>
                          <option <?php if($id_contact_group == $row_gc['id_contact_group']){echo "SELECTED";} ?> value="<?php echo $row_gc['id_contact_group']; ?>"><?php echo $row_gc['contact_group']; ?></option>
                        <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Server</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-server" name="txtServer" placeholder="Server" value="<?php echo $server; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Message</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="input-message" name="txtMessage" placeholder="Pesan" rows="4"><?php echo $message; ?></textarea>
                </div>
              </div>
              <h3>Schedule</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Setiap</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-timevar" name="txtTimeVar" placeholder="Variable Waktu" value="<?php echo $time_var; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                  <select class="form-control" name="selTypeTime">
                    <option <?php if($tipe_time == 1){echo "SELECTED";} ?> value="1">Detik</option>
                    <option <?php if($tipe_time == 2){echo "SELECTED";} ?> value="2">Menit</option>
                    <option <?php if($tipe_time == 3){echo "SELECTED";} ?> value="3">Jam</option>
                    <option <?php if($tipe_time == 4){echo "SELECTED";} ?> value="4">Hari</option>
                    <option <?php if($tipe_time == 5){echo "SELECTED";} ?> value="5">Minggu</option>
                    <option <?php if($tipe_time == 6){echo "SELECTED";} ?> value="6">Bulan</option>
                  </select>
                </div>
              </div>
              <h3>Start Schedule</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Mulai schedule</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selTypeStart">
                    <option <?php if($is_now == 1){echo "SELECTED";} ?> value="1">Seketika</option>
                    <option <?php if($is_now == 2){echo "SELECTED";} ?> value="2">Sesuai Jadwal</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-10">
                  <div class="input-group bootstrap-timepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control datepicker" name="TxtDate">
                  </div><!-- /.input group -->
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jam</label>
                <div class="col-sm-10">
                  <div class="input-group bootstrap-timepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control timepicker" name="TxtTime">
                  </div><!-- /.input group -->
                </div>
              </div>
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save Changes</span></button>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">
var id= <?php echo $id;  ?>;
$(document).ready(function() {
  if(id!=0){
    $("#panel-list").hide()
    $("#panel-form").show();

    //$("#input-inbox-table").attr("disabled", "disabled"); 
    //$("#input-outbox-table").attr("disabled", "disabled"); 
  }

  $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "schedule_bc_act.php?t=2",
      "order": [[ 0, "desc" ]]
  } );

  $("#btn-add").click(function(event) {
    $("#panel-list").hide()
    $("#panel-form").fadeIn('slow');
  });

  $("#btnSave").click(function(event) {
      var l = Ladda.create( document.querySelector( '#btnSave' ) );
      l.start();
      $.ajax({
        url: 'schedule_bc_act.php?t=1',
        type: 'POST',
        data: $("#formControl").serialize()
      })
      .done(function(data) {
        console.log(data);
        l.stop();
        if(data=="1"){
          window.location="schedule_bc.php";
        }else{
          $("#alertInfoBody").html(data);
          $("#alertInfo").fadeIn("slow");
          setTimeout(function() {$("#alertInfo").fadeOut("slow");}, 3000);
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    });

    $("#example").on('click', '.edit-svc',function(e) {
        //id_edit = $(this).data('id');
        //alert(id_edit);
    });
    $("[data-mask]").inputmask();
    //Timepicker
    $(".timepicker").timepicker({
        showInputs: false,
        showMeridian: false,
        showSeconds:true
    });
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      showInputs: false
    });
});
</script>