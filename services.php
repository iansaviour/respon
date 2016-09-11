<?php  
  include 'includes/core.php';
  checkAccess();
  include 'includes/top.php';
  $id=0;
  if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query = "SELECT * FROM tb_service WHERE id_service=$id";
    $result = mysqli_query($id_mysql,$query);
    $data = mysqli_fetch_array($result);
    $service = $data['service'];
    //$pemisah_kolom = str_ireplace("<br />", "\r\n", nl2br($data['pemisah_kolom']));
    //$pemisah_baris = str_ireplace("<br />", "\r\n", nl2br($data['pemisah_baris']));
    if(substr_count(nl2br($data['pemisah_kolom']), "<br />") > 0){
      $pemisah_kolom = "\r\n" . $data['pemisah_kolom'];
    }else{
      $pemisah_kolom = $data['pemisah_kolom'];
    }
    if(substr_count(nl2br($data['pemisah_baris']), "<br />") > 0){
      $pemisah_baris = "\r\n" . $data['pemisah_baris'];
    }else{
      $pemisah_baris = $data['pemisah_baris'];
    }
    //
    $inbox_table=$data['inbox_table'];
    $inbox_content =$data['inbox_content'];
    $inbox_date =$data['inbox_date'];
    $inbox_flag =$data['inbox_flag'];
    $inbox_user =$data['inbox_sender'];
    $inbox_server =$data['inbox_server'];
    //
    $outbox_table =$data['outbox_table'];
    $outbox_content =$data['outbox_content'];
    $outbox_date =$data['outbox_date'];
    $outbox_flag =$data['outbox_flag'];
    $outbox_user =$data['outbox_recipient'];
    $outbox_server =$data['outbox_server'];
    //
  }else{
    $id=0;
    $service ="";
    $pemisah_kolom = "";
    $pemisah_baris = "";
    //
    $inbox_table="";
    $inbox_content ="";
    $inbox_date ="";
    $inbox_flag ="";
    $inbox_user="";
    $inbox_server ="";
    //
    $outbox_table ="";
    $outbox_content ="";
    $outbox_date ="";
    $outbox_flag ="";
    $outbox_user = "";
    $outbox_server = "";
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Services
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Services</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row" id="panel-list">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Services List</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp; Add</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="example" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Service</th>
                    <th>Inbox Table</th>
                    <th>Inbox Content</th>
                    <th>Inbox Date</th>
                    <th>Inbox Flag</th>
                    <th>Inbox Sender</th>
                    <th>Inbox Server</th>
                    <th>Outbox Table</th>
                    <th>Outbox Content</th>
                    <th>Outbox Date</th>
                    <th>Outbox Flag</th>
                    <th>Outbox Recipient</th>
                    <th>Outbox Server</th>
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
                  <input type="hidden" name="txtId" value="<?php echo $id; ?>">
                  <input type="textbox" class="form-control" id="input-service" name="txtService" placeholder="Service Name" value="<?php echo $service; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Pemisah Kolom</label>
                <div class="col-sm-10">
                  <textarea class="form-control"  name="txtPemisahKolom"><?php echo $pemisah_kolom; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Pemisah Baris</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="txtPemisahBaris"><?php echo $pemisah_baris; ?></textarea>
                </div>
              </div>

              <h3>Inbox Table</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Inbox Table Name</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-table" name="txtInboxTable" placeholder="Table Name" value="<?php echo $inbox_table; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-content" class="col-sm-2 control-label">Field Message</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-content" name="txtInboxContent" placeholder="Content FieldName" value="<?php echo $inbox_content; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Field Sender</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-sender" name="txtInboxSender" placeholder="User FieldName" value="<?php echo $inbox_user; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-date" class="col-sm-2 control-label">Field Date</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-date" name="txtInboxDate" placeholder="Date FieldName" value="<?php echo $inbox_date; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-flag" class="col-sm-2 control-label">Field Flag</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-flag" name="txtInboxFlag" placeholder="Flag FieldName" value="<?php echo $inbox_flag; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-server" class="col-sm-2 control-label">Field Server</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-server" name="txtInboxServer" placeholder="Server FieldName" value="<?php echo $inbox_server; ?>">
                </div>
              </div>
              <h3>Outbox Table</h3><hr>
              <div class="form-group">
                <label for="input-outbox-table" class="col-sm-2 control-label">Outbox Table Name</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-table" name="txtOutboxTable" placeholder="Table Name" value="<?php echo $outbox_table; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-content" class="col-sm-2 control-label">Field Message</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-content" name="txtOutboxContent" placeholder="Content FieldName" value="<?php echo $outbox_content; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-recipient" class="col-sm-2 control-label">Field Recipient</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-recipient" name="txtOutboxRecipient" placeholder="User FieldName" value="<?php echo $outbox_user; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-date" class="col-sm-2 control-label">Field Date</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-date" name="txtOutboxDate" placeholder="Date FieldName" value="<?php echo $outbox_date; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-flag" class="col-sm-2 control-label">Field Flag</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-flag" name="txtOutboxFlag" placeholder="Flag FieldName" value="<?php echo $outbox_flag; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-outbox-server" class="col-sm-2 control-label">Field Server</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-outbox-server" name="txtOutboxServer" placeholder="Server FieldName" value="<?php echo $outbox_server; ?>">
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
      "ajax": "services_act.php?t=2",
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
        url: 'services_act.php?t=1',
        type: 'POST',
        data: $("#formControl").serialize()
      })
      .done(function(data) {
        console.log(data);
        l.stop();
        if(data=="1"){
          window.location="services.php";
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

});
</script>