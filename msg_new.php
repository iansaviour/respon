<?php  
  include 'includes/core.php';
  checkAccess();
  include 'includes/top.php';
  
  $id_service = "";
  $server = "";
  
  $recipient = "";
  $msg = "";

  if(isset($_GET["reply"])){//from inbox
    $id_service = $_GET["id_service"];
    $id = $_GET["id"];
    //
    $query = "SELECT * FROM tb_service WHERE id_service=$id_service";
    $result = mysqli_query($id_mysql,$query);
    $row = mysqli_fetch_array($result);
    //
    $queryx = "SELECT id,". $row['inbox_sender'] ." as sender,". $row['inbox_server'] ." as server,". $row['inbox_date'] ." as date,". $row['inbox_flag'] ." as flag,". $row['inbox_content'] ." as isi FROM ". $row['inbox_table'] ." WHERE id=$id";
    $resultx = mysqli_query($id_mysql,$queryx);
    $datax = mysqli_fetch_array($resultx);

    $server = $datax["server"];
    $recipient = $datax["sender"];
  }elseif(isset($_GET["forward"])){//from outbox
    $id_service = $_GET["id_service"];
    $id = $_GET["id"];
    //
    $query = "SELECT * FROM tb_service WHERE id_service=$id_service";
    $result = mysqli_query($id_mysql,$query);
    $row = mysqli_fetch_array($result);
    //
    $queryx = "SELECT id,". $row['outbox_recipient'] ." as recipient,". $row['outbox_server'] ." as server,". $row['outbox_date'] ." as date,". $row['outbox_flag'] ." as flag,". $row['outbox_content'] ." as isi FROM ". $row['outbox_table'] ." WHERE id=$id";
    $resultx = mysqli_query($id_mysql,$queryx);
    $datax = mysqli_fetch_array($resultx);

    $msg = $datax["isi"];
    $server = $datax["server"];
  }elseif(isset($_GET["contact"])){//from outbox
    $id = $_GET["id"];
    //
    $query = "SELECT contact_id,id_service FROM tb_contact WHERE id_contact=$id";
    $result = mysqli_query($id_mysql,$query);
    $row = mysqli_fetch_array($result);
    //
    $recipient = $row['contact_id'];
    $id_service = $row['id_service'];
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Messaging
      <small>New Message</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">New Message</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row" id="panel-form">
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
              <h3>Service</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Select Service</label>
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
                  <label for="input-recipient" class="col-sm-2 control-label">Server</label>
                  <div class="col-sm-10">
                    <input type="textbox" class="form-control" id="input-server" name="txtServer" placeholder="Server, contoh @ym_server" value="<?php echo $server; ?>">
                  </div>
              </div>

              <h3>Message</h3><hr>
              <div class="form-group">
                <label for="input-recipient" class="col-sm-2 control-label">Recipient</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="input-recipients" name="txtRecipient" placeholder="Penerima pesan, pisahkan dengan ; " value="<?php echo $recipient; ?>">
                    <span class="input-group-btn">
                      <button class="btn btn-info btn-flat" id="btnKontak" type="button">Kontak</button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group" id="divKontak" style="display:none;">
                <label for="input-recipient" class="col-sm-2 control-label">Kontak</label>
                <div class="col-sm-10">
                  <table class="table table-striped" id="contact" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                    <thead>
                      <tr>
                        <th>Id Contact</th>
                        <th>Contact Name</th>
                        <th>Contact ID</th>
                        <th>Option</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="form-group">
                <label for="input-message" class="col-sm-2 control-label">Message</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="input-message" name="txtMessage" placeholder="Pesan" rows="4"><?php echo $msg; ?></textarea>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-send"></i> Send</span></button>
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
    if(isset($_GET["p"])){
      ?>
      $("#alertInfoBody").html("Pesan dikirim.");
      $("#alertInfo").fadeIn("slow");
      setTimeout(function() {$("#alertInfo").fadeOut("slow");}, 3000);
      <?php
    }
  ?>
  $('#contact').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "msg_new_act.php?t=contact",
      "order": [[ 0, "desc" ]],
      "columnDefs": [
          {
              "targets": [ 0 ],
              "visible": false
          }
      ]
  });
  $("#btnKontak").click(function(event) {
      if($("#divKontak").css('display') == "none"){
        $("#divKontak").fadeIn("slow");
        $("#btnKontak").text("Tutup Kontak");
      }else{
        $("#divKontak").fadeOut("slow");
        $("#btnKontak").text("Kontak");
      }
      
  });
  $("#btnSave").click(function(event) {
      var l = Ladda.create( document.querySelector( '#btnSave' ) );
      l.start();
      $.ajax({
        url: 'msg_new_act.php?t=1',
        type: 'POST',
        data: $("#formControl").serialize()
      })
      .done(function(data) {
        console.log(data);
        l.stop();
        if(data=="1"){
          window.location="msg_new.php?p=1";
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
function tes(id){
  var text = document.getElementById('input-recipients');
  text.value = (text.value + id + ';');
}
</script>