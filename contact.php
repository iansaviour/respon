<?php  
  include 'includes/core.php';
  include 'includes/top.php';
  //
  $id_service = "";
  if(isset($_GET['selService'])){
    $id_service = $_GET['selService'];
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Contact
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Contact</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- table  -->
    <div class="row" id="panel-form-contact" >
      <div class="col-lg-12 col-xs-12">
      <form class="form-horizontal" id="formView" method="GET">
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>Contact</h3><hr>
              <div class="form-group">
                <label for="input-contact-table" class="col-sm-2 control-label">Service</label>
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
    <!-- table contact -->
    <div class="row" id="panel-contact" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Contact</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <form class="form-horizontal" id="contactForm">
              <div class="box-body">
                <div class="form-group">
                  <label for="input-service" class="col-sm-2 control-label">Contact Name</label>
                  <div class="col-sm-10">
                    <input type="textbox" class="form-control" id="input-contact-name" name="txtContactName" placeholder="Contact Name" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="input-service" class="col-sm-2 control-label">Contact ID</label>
                  <div class="col-sm-10">
                    <input type="textbox" class="form-control" id="input-contact-id" name="txtContactID" placeholder="Contoh : example@yahoo.com or +62361999999" value="">
                  </div>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Add new contact</span></button>
              </div><!-- /.box-footer -->
            </form>
            <hr>
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="contact" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Contact ID</th>
                    <th>ID Service</th>
                    <th>Option</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end table contact -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">
$(document).ready(function() {
<?php
  $penanda = "''";
  if(isset($_GET['selService'])){
    $id_service = $_GET['selService'];
    $penanda = "'?selService=".$id_service."'" ;
    ?>
    $('#contact').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "contact_act.php?t=contact&id_service=<?php echo $id_service; ?>",
        "order": [[ 1, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            },
            {
              "orderable": false,
              "className": 'select-checkbox',
              "targets":   0,
              "visible": false
            }
        ],
        "select": {
            "style":    'os',
            "style": 'multiple',
            "selector": 'td:first-child'
        }
    });
    $("#panel-contact").fadeIn('slow');
    <?php
  }
?>
  var selectedIds = [];

  $(":checked").each(function() {
      selectedIds.push($(this).val());
  });
  
  $("#btnSave").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSave' ) );
    l.start();
    $.ajax({
      url: 'contact_act.php?t=1&id_service=<?php echo $id_service; ?>',
      type: 'POST',
      data: $("#contactForm").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="contact.php?&selService=<?php echo $id_service; ?>";
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