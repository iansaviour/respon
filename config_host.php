<?php  
  include 'includes/core.php';
  checkAccess();
  include 'includes/top.php';

  if(isset($_GET['id']) && isset($_GET['t'])){
    $id = $_GET['id'];
    $t = $_GET['t'];
    if($t == '1'){
      //view detail
      $query = "SELECT cd.*,op.* FROM tb_config_host_det cd INNER JOIN tb_operasi op ON op.id_operasi=cd.id_operasi WHERE cd.id_app='".$id."'";
    }elseif($t == '2'){
      //edit
    }elseif($t == '3'){
      //delete
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
              <button type="button" id="btn-delete" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i>&nbsp; Delete</button>
              <button type="button" id="btn-refresh" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i>&nbsp; Refresh</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="example" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Aplikasi</th>
                    <th>Option</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->

    <!-- view_detail -->
    <div class="row" id="panel-list-detail" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Detail Konfigurasi Host</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp; Add</button>
              <button type="button" id="btn-delete" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i>&nbsp; Delete</button>
              <button type="button" id="btn-refresh" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i>&nbsp; Refresh</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="dt_detail" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th>Id App Det</th>
                    <th>Id App</th>
                    <th>Nama Keyword</th>
                    <th>Option</th>
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
          <div class="box-header with-border">
            <h3 class="box-title">Configuration Service</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" id="formControl">
            <div class="box-body">
              <h3>General</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Service</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-service" name="txtService" placeholder="Service Name" value="<?php echo $i; ?>">
                </div>
              </div>

              <h3>Inbox Table</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Inbox Table Name</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-table" name="txtInboxTable" placeholder="Table Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-content" class="col-sm-2 control-label">Content</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-content" name="txtInboxContent" placeholder="Field Content Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Sender</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-sender" name="txtInboxSender" placeholder="Field Sender Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-date" class="col-sm-2 control-label">Date</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-date" name="txtInboxDate" placeholder="Field Date Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-flag" class="col-sm-2 control-label">Flag</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-flag" name="txtInboxFlag" placeholder="Field Flag Name">
                </div>
              </div>

              <h3>Outbox Table</h3><hr>
              <div class="form-group">
                <label for="input-outbox-table" class="col-sm-2 control-label">Outbox Table Name</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-table" name="txtOutboxTable" placeholder="Table Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-content" class="col-sm-2 control-label">Content</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-content" name="txtOutboxContent" placeholder="Field Content Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-recipient" class="col-sm-2 control-label">Recipient</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-recipient" name="txtOutboxRecipient" placeholder="Field Recipient Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-date" class="col-sm-2 control-label">Date</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-date" name="txtOutboxDate" placeholder="Field Date Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-flag" class="col-sm-2 control-label">Flag</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-flag" name="txtOutboxFlag" placeholder="Field Flag Name">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save Changes</span></button>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->

    <!-- edit -->
    <div class="row" id="panel-edit" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Edit Service</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" id="formControl">
            <div class="box-body">
              <h3>General</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Service</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-service" name="txtService" placeholder="Service Name" value="<?php echo $data['service']; ?>">
                </div>
              </div>

              <h3>Inbox Table</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Inbox Table Name</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-table" name="txtInboxTable" placeholder="Table Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-content" class="col-sm-2 control-label">Content</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-content" name="txtInboxContent" placeholder="Field Content Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Sender</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-sender" name="txtInboxSender" placeholder="Field Sender Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-date" class="col-sm-2 control-label">Date</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-date" name="txtInboxDate" placeholder="Field Date Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-flag" class="col-sm-2 control-label">Flag</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-flag" name="txtInboxFlag" placeholder="Field Flag Name">
                </div>
              </div>

              <h3>Outbox Table</h3><hr>
              <div class="form-group">
                <label for="input-outbox-table" class="col-sm-2 control-label">Outbox Table Name</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-table" name="txtOutboxTable" placeholder="Table Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-content" class="col-sm-2 control-label">Content</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-content" name="txtOutboxContent" placeholder="Field Content Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-recipient" class="col-sm-2 control-label">Recipient</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-recipient" name="txtOutboxRecipient" placeholder="Field Recipient Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-date" class="col-sm-2 control-label">Date</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-date" name="txtOutboxDate" placeholder="Field Date Name">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-flag" class="col-sm-2 control-label">Flag</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-flag" name="txtOutboxFlag" placeholder="Field Flag Name">
                </div>
              </div>
            </div><!-- /.box-body -->
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

$(document).ready(function() {
  <?php
    if(isset($_GET['id']) && isset($_GET['t'])){
      $t = $_GET['t'];
      if($t == '1'){
        //view detail
        ?>
          $("#panel-list").hide();
          $("#panel-edit").hide();
          $("#panel-list-detail").fadeIn('slow');
          $('#dt_detail').DataTable( {
              "processing": true,
              "serverSide": true,
              "ajax": "config_host_act.php?t=3&id=<?php echo $_GET['id']; ?>",
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

      }elseif($t=='3'){

      }
      
    }else{
      ?>
       $('#example').DataTable( {
              "processing": true,
              "serverSide": true,
              "ajax": "config_host_act.php?t=2",
              "order": [[ 0, "desc" ]],
              "columnDefs": [
                  {
                      "targets": [ 0 ],
                      "visible": false
                  }
              ]
          } );
      <?php
    }
  ?>
  
  $("#btn-add").click(function(event) {
    $("#panel-list").hide()
    $("#panel-form").fadeIn('slow');
  });

  $("#btnSave").click(function(event) {
      var l = Ladda.create( document.querySelector( '#btnSave' ) );
      l.start();
      $.ajax({
        url: 'config_host_act.php?t=1',
        type: 'POST',
        data: $("#formControl").serialize()
      })
      .done(function(data) {
        console.log(data);
        l.stop();
        if(data=="1"){
          window.location="config_host.php";
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