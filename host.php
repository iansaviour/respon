<?php  
  include 'includes/core.php';
  include 'includes/top.php';

  if(isset($_GET['id']) && isset($_GET['t'])){
    $id = $_GET['id'];
    $t = $_GET['t'];
    if($t == '1'){
      //view detail
      $query = "SELECT cd.*,op.* FROM tb_config_host_det cd INNER JOIN tb_operasi op ON op.id_operasi=cd.id_operasi WHERE cd.id_app='".$id."'";
    }elseif($t == '2'){
      //edit
      $query = "SELECT * FROM tb_host WHERE id=$id";
      $result = mysqli_query($id_mysql,$query);
      $data = mysqli_fetch_array($result);
    }elseif($t == '3'){
      //delete
    }
  }elseif(isset($_GET['t'])){
    //after select db
    $server_host = $_POST['txtHostAdd'];
    $username_host = $_POST['txtHostUsr'];
    $password_host = $_POST['txtHostPass'];
    $id_mysql_host = mysqli_connect($server_host, $username_host, $password_host);
    if (! $id_mysql_host) {
      $pesan_error = "Tidak dapat terhubung dengan host";
    }else{
      $query_seldb = "SHOW DATABASES";
      $result_seldb = mysqli_query($id_mysql_host,$query_seldb);
    }
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Konfigurasi Host
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Konfigurasi Host</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row" id="panel-list">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Konfigurasi Host</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp; Add</button>
              <button type="button" id="btn-refresh" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i>&nbsp; Refresh</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="example" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Nama Host</th>
                    <th>Host Address</th>
                    <th>Host Username</th>
                    <th>Host Password</th>
                    <th>Host Database</th>
                    <th>Lokal Host</th>
                    <th>Karakter Pemisah</th>
                    <th>Option</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->

    <!-- warning modal -->
    <div class="modal-warn" id="panel-modal-warn" >
      <div class="modal modal-warning">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModalWarn"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Warning</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure want to delete this host ?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline" id="ContModalWarn">Continue</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    </div><!-- /.example-modal -->

    <div class="row" id="panel-form" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
      <form class="form-horizontal" id="formControl1" method="POST" action="host.php?t=4">
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>Host Server</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Host Address</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-table" name="txtHostAdd" placeholder="Host Address">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-content" class="col-sm-2 control-label">Host Username</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-content" name="txtHostUsr" placeholder="Host Username">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Host Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="input-inbox-sender" name="txtHostPass" placeholder="Host Password">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnConnect" type="submit" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-refresh"></i> Connect</span></button>
            </div><!-- /.box-footer -->
          </div><!-- /.box-body -->
        </div>
      </form>
      </div>
    </div><!-- /.row -->

    <!-- edit 1-->
    <div class="row" id="panel-edit" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
      <form class="form-horizontal" id="formControl1" method="POST" action="host.php?t=4">
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>Host Server</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Host Address</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-table" name="txtHostAdd" placeholder="Host Address">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-content" class="col-sm-2 control-label">Host Username</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-content" name="txtHostUsr" placeholder="Host Username">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Host Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="input-inbox-sender" name="txtHostPass" placeholder="Host Password">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnConnect" type="submit" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-refresh"></i> Connect</span></button>
            </div><!-- /.box-footer -->
          </div><!-- /.box-body -->
        </div>
      </form>
      </div>
    </div><!-- /.row edit 1-->

  <!-- form 2-->
    <div class="row" id="panel-edit-next" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
      <form class="form-horizontal" id="formControl">
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>Host Server</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Host Address</label>
                <div class="col-sm-10">
                  <input type="textbox" readonly class="form-control" id="input-inbox-table" name="txtHostAdd" placeholder="Host Address" value="<?php echo $server_host; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-content" class="col-sm-2 control-label">Host Username</label>
                <div class="col-sm-10">
                  <input type="textbox" readonly class="form-control" id="input-inbox-content" name="txtHostUsr" placeholder="Host Username" value="<?php echo $username_host; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Host Password</label>
                <div class="col-sm-10">
                  <input type="password" readonly class="form-control" id="input-inbox-sender" name="txtHostPass" value="<?php echo $password_host; ?>">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnCancelConnect" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-refresh"></i> Cancel</span></button>
            </div><!-- /.box-footer -->
          </div><!-- /.box-body -->
        </div>
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>Database</h3><hr>
              <div class="form-group">
                <label for="input-host" class="col-sm-2 control-label">Database</label>
                <div class="col-sm-10">
                  <div class="form-group">
                    <select class="form-control" id="SelDb" name="SelDb">
                      <?php
                        if ($id_mysql_host) {

                          while ($data = mysqli_fetch_array($result_seldb,MYSQLI_ASSOC)) {
                            echo "<option value='" . $data['Database'] . "'>" . $data['Database'] . "</option>";
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>Detail</h3><hr>
              <div class="form-group">
                <label for="input-host" class="col-sm-2 control-label">Nama Host</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-host" name="txtHostNama" placeholder="Nama Host" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="input-host" class="col-sm-2 control-label">Nomor Telepon Host</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-host" name="txtHostTelp" placeholder="+628..." value="">
                </div>
              </div>
              <div class="form-group">
                <label for="input-host" class="col-sm-2 control-label">Email Host</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-host" name="txtHostEmail" placeholder="example@example.com" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="input-host" class="col-sm-2 control-label">Host Lokal</label>
                <div class="col-sm-10">
                  <select class="form-control" id="SelHostLokal" name="SelHostLokal">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-host" class="col-sm-2 control-label">Karakter Pemisah</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-host" name="txtHostKarakter" placeholder="#" value="">
                </div>
              </div>
              <div class="box-footer">
                <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
              </div><!-- /.box-footer -->
            </div>
          </div>
        </div>
      </form>
      </div>
    </div><!-- /.row edit 2-->

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">

$(document).ready(function() {
  <?php
    if(isset($_GET['id']) && isset($_GET['t'])){
      $t = $_GET['t'];
      ?>
        $("#closeModalWarn").click(function(event) {
          window.location="host.php";
        });

        $("#ContModalWarn").click(function(event) {
          var l = Ladda.create( document.querySelector( '#ContModalWarn' ) );
          l.start();
          $.ajax({
            url: "host_act.php?t=4&id=<?php echo $_GET['id']; ?>"
          })
          .done(function(data) {
            console.log(data);
            l.stop();
            if(data=="1"){
              window.location="host.php";
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

      <?php
      if($t == '1'){
        //view detail
        ?>
          $("#panel-list").hide();
          $("#panel-edit").hide();
          $("#panel-edit-next").hide();
          $("#panel-list-detail").fadeIn('slow');
          $('#dt_detail').DataTable( {
              "processing": true,
              "serverSide": true,
              "ajax": "host_act.php?t=3&id=<?php echo $_GET['id']; ?>",
              "order": [[ 0, "desc" ]],
              "columnDefs": [
                  {
                      "targets": [ 0 ],
                      "visible": false
                  },
                  {
                      "targets": [ 1 ],
                      "visible": false
                  }
              ]
          } );
        <?php
      }elseif($t=='2'){
        ?>
          $(".modal-warn .modal").hide();
          $("#panel-list").hide();
          $("#panel-list-detail").hide();
          $("#panel-edit-next").hide();
          $("#panel-edit").fadeIn('slow');
        <?php
      }elseif($t=='3'){
        ?>
          $("#panel-list").hide();
          $(".modal-warn .modal").fadeIn('slow');
        <?php
      }
      
    }elseif(isset($_GET['t'])){
      $t = $_GET['t'];
      if($t=='4'){
        ?>
          $("#panel-list").hide();
          $("#panel-list-detail").hide();
          $("#panel-edit").hide();
          $("#panel-edit-next").fadeIn('slow');
        <?php
      }
    }else{
      ?>
       $('#example').DataTable( {
              "processing": true,
              "serverSide": true,
              "ajax": "host_act.php?t=2",
              "order": [[ 0, "desc" ]],
              "columnDefs": [
                  {
                      "targets": [ 0 ],
                      "visible": false
                  },
                  {
                      "targets": [ 4 ],
                      "visible": false
                  }
              ]
          } );
      <?php
    }
  ?>
  
  $("#btn-refresh").click(function(event) {
    window.location="host.php";
  });

  $("#btn-add").click(function(event) {
    $("#panel-list").hide()
    $("#panel-form").fadeIn('slow');
  });

  $("#btnCancelConnect").click(function(event) {
    $("#panel-list").hide()
    $("#panel-edit-next").hide();
    $("#panel-form").fadeIn('slow');
  });

  $("#btnSave").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSave' ) );
    l.start();
    $.ajax({
      url: 'host_act.php?t=1',
      type: 'POST',
      data: $("#formControl").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="host.php";
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

});
</script>
<style>
  .modal-warn .modal {
    position: relative;
    top: auto;
    bottom: auto;
    right: auto;
    left: auto;
    z-index: 1;
    display: none;
  }
  .modal-warn .modal {
    background: transparent !important;
  }
</style>