<?php  
  include 'includes/core.php';
  include 'includes/top.php';

  $id='';
  $username='';
  $id_user_role='1';
  $field_identifier='';
  $value_identifier='';
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM tb_m_user WHERE id_user='" . $id . "' LIMIT 1";
    $result = mysqli_query($id_mysql,$query);
    $data = mysqli_fetch_array($result);
    $username = $data['username'];
    $id_user_role = $data['id_user_role'];
    $field_identifier = $data['identifier_login'];
    $value_identifier = $data['value_identifier'];;
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Konfigurasi User
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Konfigurasi User</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row" id="panel-list">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Konfigurasi User</h3>
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
                    <th>Role</th>
                    <th>Username</th>
                    <th>Identifier Login</th>
                    <th>Value Identifier</th>
                    <th>Option</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->

    <!-- new -->
    <div class="row" id="panel-form" style="display:none;">
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
              <h3>Detail User</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Role</label>
                <div class="col-sm-10">
                  <input type="hidden" class="form-control" id="input-inbox-table" name="idUser" value="<?php echo $id; ?>">
                  <select class="form-control" name="role">
                    <?php
                      $query = "SELECT * FROM tb_m_user_role";
                      $result = mysqli_query($id_mysql,$query);
                      while($row = $result->fetch_assoc()) {
                        ?>
                          <option <?php if($row['id_user_role']==$id_user_role){echo "SELECTED";} ?> value="<?php echo $row['id_user_role']; ?>"><?php echo $row['user_role']; ?></option>
                        <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-table" name="txtUsername" placeholder="Username" value="<?php echo $username; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="input-inbox-sender" name="txtPassword" placeholder="Password">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Field Identifier</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-sender" name="fieldId" placeholder="Field Identifier"  value="<?php echo $field_identifier; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-inbox-sender" class="col-sm-2 control-label">Value Identifier</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" id="input-inbox-sender" name="valId" placeholder="Value Identifier"  value="<?php echo $value_identifier; ?>">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <?php
              if($id==''){//new
                ?>
                  <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                <?php
              }else{//edit
                ?>
                  <button style="margin-left:5px;" id="btnEdit" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save Edit</span></button>
                <?php
              }
              ?>
            </div><!-- /.box-footer -->
          </div><!-- /.box-body -->
        </div>
      </form>
      </div>
    </div><!-- /.row -->
    <!-- end new -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">

$(document).ready(function() {
  //view
  $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "user_act.php?t=view",
      "order": [[ 0, "desc" ]],
      "columnDefs": [
        {
            "targets": [ 0 ],
            "visible": false
        }
      ]
  } );
  //navigation
  <?php
    //delete
    if(isset($_GET['del']) && isset($_GET['id'])){
      $query_del = "DELETE FROM tb_m_user WHERE id_user='" . $_GET['id'] . "'";
      $result = mysqli_query($id_mysql,$query_del);
      ?>
        window.location="user.php";
      <?php
    }elseif(isset($_GET['p'])){
      if($_GET['p'] == '1'){ //edit
        ?>
          $("#panel-list").hide();
          $("#panel-form").fadeIn('slow');
        <?php
      }
    }
  ?>
  $("#btn-refresh").click(function(event) {
    window.location="user.php";
  });

  $("#btn-add").click(function(event) {
    $("#panel-list").hide()
    $("#panel-form").fadeIn('slow');
  });

  $("#btnSave").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSave' ) );
    l.start();
    $.ajax({
      url: 'user_act.php?t=1',
      type: 'POST',
      data: $("#formControl").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="user.php";
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
  $("#btnEdit").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnEdit' ) );
    l.start();
    $.ajax({
      url: 'user_act.php?t=2',
      type: 'POST',
      data: $("#formControl").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="user.php";
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