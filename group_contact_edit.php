<?php  
  include 'includes/core.php';
  include 'includes/top.php';
  //
  $id_contact_group = "";
  if(isset($_GET['selCG'])){
    $id_contact_group = $_GET['selCG'];
    $queryx = "SELECT * FROM tb_contact_group WHERE id_contact_group='".$id_contact_group."'";
    $resultx = mysqli_query($id_mysql,$queryx);
    $datax = mysqli_fetch_array($resultx);

    $contact_group = $datax['contact_group'];
    $id_service =  $datax['id_service'];
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Group Contact
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Group Contact</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- table contact -->
    <div class="row" id="panel-form-contact" >
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>Group Contact</h3><hr>
              <form class="form-horizontal" id="GroupcontactForm">
                <div class="box-body">
                  <div class="form-group">
                    <label for="input-service" class="col-sm-2 control-label">Group Contact Name</label>
                    <div class="col-sm-10">
                      <input type="textbox" class="form-control" id="input-contact-name" name="txtGroupContactName" placeholder="Contact Name" value="<?php echo $contact_group; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="input-contact-table" class="col-sm-2 control-label">Service</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="selService">
                        <?php
                          $query_host = "SELECT * FROM tb_service";
                          $result_host = mysqli_query($id_mysql,$query_host);
                          while($row_host = $result_host->fetch_assoc()) {
                            ?>
                              <option value="<?php echo $row_host['id_service']; ?>" <?php if($row_host['id_service']==$id_service){echo "SELECTED";} ?>><?php echo $row_host['service']; ?></option>
                            <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Edit</span></button>
                  <button style="margin-left:5px;" id="btnBack" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-arrow-left"></i> Back</span></button>
                </div><!-- /.box-footer -->
              </form>
          </div><!-- /.box-body -->
        </div>
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
  $penanda = "''";
  if(isset($_GET['selCG'])){
    $id_contact_group = $_GET['selCG'];
    $penanda = "'?selCG=".$id_contact_group."'" ;
    ?>
    $("#btnSave").click(function(event) {
      var l = Ladda.create( document.querySelector( '#btnSave' ) );
      l.start();
      $.ajax({
        url: 'group_contact_edit_act.php?t=1&selCG=<?php echo $id_contact_group; ?>',
        type: 'POST',
        data: $("#GroupcontactForm").serialize()
      })
      .done(function(data) {
        console.log(data);
        l.stop();
        if(data=="1"){
          window.location="group_contact.php?selCG=<?php echo $id_contact_group; ?>";
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
    $("#btnBack").click(function(event) {
      window.location="group_contact.php?selCG=<?php echo $id_contact_group; ?>";
    });
    <?php
  }

?>
});
</script>