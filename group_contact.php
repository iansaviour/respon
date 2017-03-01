<?php  
  include 'includes/core.php';
  include 'includes/top.php';
  //
  $id_contact_group = "";
  if(isset($_GET['selCG'])){
    $id_contact_group = $_GET['selCG'];
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
    <!-- table  -->
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
                      <input type="textbox" class="form-control" id="input-contact-name" name="txtGroupContactName" placeholder="Contact Name" value="">
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
                              <option value="<?php echo $row_host['id_service']; ?>"><?php echo $row_host['service']; ?></option>
                            <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Add group contact</span></button>
                </div><!-- /.box-footer -->
              </form>
          </div><!-- /.box-body -->
        </div>
      </div>
      </div>
    </div><!-- /.row -->
    <form class="form-horizontal" id="formView" method="GET">
      <div class="row" id="panel-form-contact" >
        <div class="col-lg-12 col-xs-12">
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
                  <button style="margin-left:5px;display:none;" id="btnDelete" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-trash"></i> Delete</span></button>
                  <button style="margin-left:5px;display:none;" id="btnEdit" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-pencil"></i> Edit</span></button>
                  <button style="margin-left:5px;" id="btnView" type="submit" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-search"></i> View</span></button>
                </div><!-- /.box-footer -->
            </div><!-- /.box-body -->
          </div>
        </div>
      </div><!-- /.row -->
      </div>
      </form>
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
              <div class="box-header">
                <button style="margin-left:5px;" id="btnAddContact" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-user"></i> Add contact to group</span></button>
              </div><!-- /.box-footer -->
            </form>
            <hr>
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="contact" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Id Group</th>
                    <th>Id Contact</th>
                    <th>Id Service</th>
                    <th>Name</th>
                    <th>Contact ID</th>
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
  if(isset($_GET['selCG'])){
    $id_contact_group = $_GET['selCG'];
    $penanda = "'?selCG=".$id_contact_group."'" ;
    ?>
    $('#contact').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "group_contact_act.php?t=contact&selCG=<?php echo $id_contact_group; ?>",
        "order": [[ 1, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false
            },
            {
                "targets": [ 2 ],
                "visible": false
            },
            {
                "targets": [ 3 ],
                "visible": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            }
        ]
    });
    $("#panel-contact").fadeIn('slow');
    $("#btnEdit").fadeIn('slow');
    $("#btnDelete").fadeIn('slow');
    <?php
  }
?>
  $("#btnSave").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSave' ) );
    l.start();
    $.ajax({
      url: 'group_contact_act.php?t=1',
      type: 'POST',
      data: $("#GroupcontactForm").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="group_contact.php";
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
  $("#btnAddContact").click(function(event) {
    window.location="group_contact_add.php?selCG=<?php echo $id_contact_group; ?>";
  });
  $("#btnEdit").click(function(event) {
    window.location="group_contact_edit.php?selCG=<?php echo $id_contact_group; ?>";
  });
  $("#btnDelete").click(function(event) {
    var r = confirm('Are you sure you want to remove this contact group?');
    if (r == true ){
      window.location="group_contact_act.php?t=3&selCG=<?php echo $id_contact_group; ?>";
    }
  });

});
</script>