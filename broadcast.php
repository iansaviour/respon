<?php  
  include 'includes/core.php';
  include 'includes/top.php';
  //
  $id_contact_group = "";
  $contact_group = "";
  $service = "";
  $id_service = "";

  if(isset($_GET['selCG'])){
    $id_contact_group = $_GET['selCG'];
    $query = "SELECT c.*,s.service FROM tb_contact_group c INNER JOIN tb_service s ON s.id_service=c.id_service WHERE c.id_contact_group='".$id_contact_group."'";
    $result = mysqli_query($id_mysql,$query);
    $data = mysqli_fetch_array($result);

    $service = $data['service'];
    $contact_group = $data['contact_group'];
    $id_service =  $data['id_service'];
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Broadcast
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Broadcast</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <form class="form-horizontal" id="formView" method="GET">
      <div class="row" id="panel-form-contact" >
        <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <form class="form-horizontal" id="formView" method="GET">
          <div class="box box-primary">
            <div class="box-body">
              <div class="box-body">
                <div class="box-body">
                  <div class="form-group">
                    <label for="input-contact-table" class="col-sm-2 control-label">Group Contact</label>
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
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <button style="margin-left:5px;" id="btnView" type="submit" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-external-link"></i> Select</span></button>
                </div><!-- /.box-footer -->
            </div><!-- /.box-body -->
          </div>
        </div>
      </div><!-- /.row -->
      </div>
      </form>
    <!-- end table  -->
    <div class="row" id="panel-form" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
          <form class="form-horizontal" id="formControl">
            <div class="box-body">
              <h3>Service</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Service</label>
                <div class="col-sm-10">
                  <input type="hidden" class="form-control" id="input-id-service" name="txtService" placeholder="Server, contoh @ym_server" value="<?php echo $id_service; ?>">
                  <input type="textbox" readonly="true" class="form-control" id="input-service" name="txtServiceName" placeholder="Server, contoh @ym_server" value="<?php echo $service; ?>">
                </div>
              </div>
              <div class="form-group">
                  <label for="input-recipient" class="col-sm-2 control-label">Server</label>
                  <div class="col-sm-10">
                    <input type="textbox" class="form-control" id="input-server" name="txtServer" placeholder="Server, contoh @ym_server" value="">
                  </div>
              </div>

              <h3>Message</h3><hr>
              <div class="form-group">
                <label for="input-recipient" class="col-sm-2 control-label">Broadcast To</label>
                <div class="col-sm-10">
                  <input type="hidden" class="form-control" id="input-id-recipient" name="txtGroupContact" placeholder="Penerima pesan, pisahkan dengan ; " value="<?php echo $id_contact_group; ?>">
                  <input type="textbox" readonly="true" class="form-control" id="input-recipient" name="txtRecipient" placeholder="Penerima pesan, pisahkan dengan ; " value="<?php echo $contact_group; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-message" class="col-sm-2 control-label">Message</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="input-message" name="txtMessage" placeholder="Pesan" rows="4"></textarea>
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
<?php
  $penanda = "''";
  if(isset($_GET['selCG'])){
    $id_contact_group = $_GET['selCG'];
    $penanda = "?selCG=".$id_contact_group ;
    ?>
    $("#panel-form").fadeIn('slow');
    $("#btnSave").click(function(event) {
      var l = Ladda.create( document.querySelector( '#btnSave' ) );
      l.start();
      $.ajax({
        url: 'broadcast_act.php?t=1',
        type: 'POST',
        data: $("#formControl").serialize()
      })
      .done(function(data) {
        console.log(data);
        l.stop();
        if(data=="1"){
          window.location="broadcast.php?p=1";
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
  }
?>
  

});
</script>