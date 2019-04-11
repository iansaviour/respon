<?php  
  include 'includes/core.php';
  include 'includes/top.php';

  $selHost = '';
  $selTb = '';
  //
  $InDesc = '';
  $selIdKontak = '';
  $selPesan = '';
  $selTanggal = '';
  $selWaktu = '';
  //
  if(isset($_GET['id']) && isset($_GET['p'])){
    $queryx = "SELECT * FROM tb_sch_msg WHERE id_sch_msg='".$_GET['id']."'";
    $resultx = mysqli_query($id_mysql,$queryx);
    $datax = mysqli_fetch_array($resultx);

    $selHost = $datax['id_host'];
    $selTb = $datax['table_name'];
    //
    $InDesc = $datax['sch_msg_name'];
    $selIdKontak = $datax['fl_id_contact'];
    $selPesan = $datax['fl_msg'];
    $selTanggal = $datax['fl_date'];
    $selWaktu = $datax['fl_hour'];
  }else{
    $selHost = isset($_POST['selHost']) ? $_POST['selHost'] : '';
    $selTb = isset($_POST['selTb']) ? $_POST['selTb'] : '';
    //
    $InDesc = isset($_POST['sch_msg_name']) ? $_POST['sch_msg_name'] : '';
    $selIdKontak = isset($_POST['fl_id_contact']) ? $_POST['fl_id_contact'] : '';
    $selPesan = isset($_POST['fl_msg']) ? $_POST['fl_msg'] : '';
    $selTanggal = isset($_POST['fl_date']) ? $_POST['fl_date'] : '';
    $selWaktu = isset($_POST['fl_hour']) ? $_POST['fl_hour'] : '';
  }
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Scheduled Message
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Scheduled Message</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row" id="panel-list">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">List Scheduled Message</h3>
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
                    <th>Id Host</th>
                    <th>Host</th>
                    <th>Description</th>
                    <th>Table</th>
                    <th>Option</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->

    <!-- step 1 -->
    <div class="row" id="panel-form-1" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
          <h3 class="box-title">Scheduled Message</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="AddStep1" id="formControl" method="POST" action="sch_msg.php?p=1">
            <div class="box-body">
              <h3>Detail</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Host</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selHost">
                    <?php
                      $query_host = "SELECT * FROM tb_host";
                      $result_host = mysqli_query($id_mysql,$query_host);
                      while($row_host = $result_host->fetch_assoc()) {
                        ?>
                          <option value="<?php echo $row_host['id_host']; ?>"><?php echo $row_host['nama_host']; ?></option>
                        <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnSave" type="submit" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-arrow-right"></i> Next</span></button>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step 1 -->
    <!-- step insert -->
    <div class="row" id="panel-form-insert-1" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Scheduled Message</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Insert1" id="Insert1" method="POST" action="sch_msg.php?p=1a">
            <div class="box-body">
              <h3>Detail</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Host</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selHostDis" disabled>
                    <?php
                      $query_host = "SELECT * FROM tb_host";
                      $result_host = mysqli_query($id_mysql,$query_host);
                      while($row_host = $result_host->fetch_assoc()) {
                        if($row_host['id_host'] == $_POST['selHost']){
                          ?>
                            <option SELECTED value="<?php echo $row_host['id_host']; ?>"><?php echo $row_host['nama_host']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row_host['id_host']; ?>"><?php echo $row_host['nama_host']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selHost" value="<?php echo $_POST['selHost']; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Tabel</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selTb">
                    <?php
                      if(isset($_POST['selHost'])){
                        //
                        $query_h = "SELECT * FROM tb_host WHERE id_host=" . $_POST['selHost'];
                        $result_h = mysqli_query($id_mysql,$query_h);
                        $data_h = mysqli_fetch_array($result_h);
                        //
                        $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                        $query_tb = "SHOW TABLES";
                        $result_tb = mysqli_query($id_mysql_tb,$query_tb);
                        while($row = $result_tb->fetch_array()) {
                          ?>
                            <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnSave" type="submit" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-arrow-right"></i> Next</span></button>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step insert -->
    <!-- step insert 2 -->
    <div class="row" id="panel-form-insert-2" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Scheduled Message</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Insert2" id="Insert2" >
            <input type="hidden" name="idOperasi" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="box-body">
              <h3>Detail</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Host</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selHostDis" disabled>
                    <?php
                      $query_host = "SELECT * FROM tb_host";
                      $result_host = mysqli_query($id_mysql,$query_host);
                      while($row_host = $result_host->fetch_assoc()) {
                        if($row_host['id_host'] == $selHost){
                          ?>
                            <option SELECTED value="<?php echo $row_host['id_host']; ?>"><?php echo $row_host['nama_host']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row_host['id_host']; ?>"><?php echo $row_host['nama_host']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selHost" value="<?php echo $selHost; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Tabel</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selTbDis" disabled>
                    <?php
                      if($selHost!=''){
                        $query_h = "SELECT * FROM tb_host WHERE id_host='" . $selHost."'";
                          $result_h = mysqli_query($id_mysql,$query_h);
                          $data_h = mysqli_fetch_array($result_h);
                          //
                          $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                          $query_tb = "SHOW TABLES";
                          $result_tb = mysqli_query($id_mysql_tb,$query_tb);
                          while($row = $result_tb->fetch_array()) {
                            if($row[0] == $selTb){
                              ?>
                                <option SELECTED value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                              <?php
                            }else{
                              ?>
                                <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                              <?php
                            }
                          }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selTb" value="<?php echo $selTb; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="InDesc" placeholder="Deskripsi singkat" value="<?php echo $InDesc; ?>">
                </div>
              </div>
              <div class="form-group" >
                <label for="input-service" class="col-sm-2 control-label" >Field Id Kontak</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selIdKontak">
                    <?php
                      if($selTb!=''){
                        $query = "DESC " . $selTb ;
                        $result = mysqli_query($id_mysql_tb,$query);
                        while($row = $result->fetch_array()) {
                          ?>
                            <option <?php if($selIdKontak==$selTb .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                          <?php
                        }
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group" >
                <label for="input-service" class="col-sm-2 control-label" >Field Pesan</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selPesan">
                    <?php
                      if($selTb!=''){
                        $query = "DESC " . $selTb ;
                        $result = mysqli_query($id_mysql_tb,$query);
                        while($row = $result->fetch_array()) {
                          ?>
                            <option <?php if($selPesan==$selTb .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                          <?php
                        }
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group" >
                <label for="input-service" class="col-sm-2 control-label" >Field Tanggal</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selTanggal">
                    <?php
                      if($selTb!=''){
                        $query = "DESC " . $selTb ;
                        $result = mysqli_query($id_mysql_tb,$query);
                        while($row = $result->fetch_array()) {
                          ?>
                            <option <?php if($selTanggal==$selTb .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                          <?php
                        }
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group" >
                <label for="input-service" class="col-sm-2 control-label" >Field Waktu</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selWaktu">
                    <?php
                      if($selTb!=''){
                        $query = "DESC " . $selTb ;
                        $result = mysqli_query($id_mysql_tb,$query);
                        while($row = $result->fetch_array()) {
                          ?>
                            <option <?php if($selWaktu==$selTb .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                          <?php
                        }
                      }
                      ?>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <?php
              if(isset($_GET['id'])){//edit
                  ?>
                    <button style="margin-left:5px;" id="btnEditIns" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-edit"></i> Save Edit</span></button>
                  <?php
                }else{//new
                  ?>
                    <button style="margin-left:5px;" id="btnSaveIns" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                  <?php
                }
              ?>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step insert 2 -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">
$(document).ready(function() {
  //view main
  $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "sch_msg_act.php?t=view",
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
    //delete
    if(isset($_GET['del']) && isset($_GET['id'])){
      $query_del = "DELETE FROM tb_sch_msg WHERE id_sch_msg='" . $_GET['id'] . "'";
      $result = mysqli_query($id_mysql,$query_del);
      ?>
        window.location="sch_msg.php";
      <?php
    }
    //navigation
    if(isset($_GET['p'])){
      ?>
      <?php
      if($_GET['p'] == '1'){ //insert 1
        ?>
          $("#panel-list").hide();
          $("#panel-form-insert-1").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1a'){ //insert 2
        ?>
          $("#panel-list").hide();
          $("#panel-form-insert-2").fadeIn('slow');
        <?php
      }
    }
  ?>
  //main form button
  $("#btn-add").click(function(event) {
    $("#panel-list").hide()
    $("#panel-form-1").fadeIn('slow');
  });

  $("#btn-refresh").click(function(event) {
    window.location="sch_msg.php";
  });

  $("#btnSaveIns").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSaveIns' ) );
    l.start();
    $.ajax({
      url: 'sch_msg_act.php?t=1',
      type: 'POST',
      data: $("#Insert2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="sch_msg.php";
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

  $("#btnEditIns").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnEditIns' ) );
    l.start();
    $.ajax({
      url: 'sch_msg_act.php?t=1edit',
      type: 'POST',
      data: $("#Insert2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="sch_msg.php";
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