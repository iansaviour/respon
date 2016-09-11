<?php  
  include 'includes/core.php';
  include 'includes/top.php';

  $selJenis = '';
  $selHost = '';
  $selTb = '';
  $selFunc = '';
  //
  $NmKeyw = '';
  $Keyw = '';
  $selPub = '1';
  $selLogin = '1';
  $selSQL = '1';
  //
  $NmOutput = '';
  //
  $TableSearch = array();
  if(isset($_GET['id']) && isset($_GET['p'])){
    $queryx = "SELECT * FROM tb_operasi WHERE id_operasi='".$_GET['id']."'";
    $resultx = mysqli_query($id_mysql,$queryx);
    $datax = mysqli_fetch_array($resultx);

    $selJenis = $datax['id_jenis_operasi'];
    $selHost =  $datax['id_host'];
    $selSQL =  $datax['id_jenis_sql'];

    $NmKeyw = $datax['nama_operasi'];
    $Keyw = $datax['keyword'];
    $selPub = $datax['is_publik'];
    $selLogin = $datax['penanda_login'];
    if($selJenis == '0'){//prosedural
      $queryx = "SELECT nama_prosedural,nama_hasil FROM tb_operasi_prosedural WHERE id_operasi='".$_GET['id']."' LIMIT 1";
      $resultx = mysqli_query($id_mysql,$queryx);
      $datax = mysqli_fetch_array($resultx);

      $selFunc = $datax['nama_prosedural'];
      $NmOutput = $datax['nama_hasil'];
    }elseif($selJenis == '4'){//search
      $queryx = "SELECT nama_tabel FROM tb_operasi_tabel WHERE id_operasi='".$_GET['id']."'";
      $resultx = mysqli_query($id_mysql,$queryx);
      $TableSearch = array();
      while($row = $resultx->fetch_array()) {
        array_push($TableSearch,$row[0]);
      }
    }else{
      $queryx = "SELECT nama_tabel FROM tb_operasi_tabel WHERE id_operasi='".$_GET['id']."' LIMIT 1";
      $resultx = mysqli_query($id_mysql,$queryx);
      $datax = mysqli_fetch_array($resultx);

      $selTb = $datax['nama_tabel'];
    }
    
  }else{
    $selJenis = isset($_POST['selJenis']) ? $_POST['selJenis'] : '';
    $selHost = isset($_POST['selHost']) ? $_POST['selHost'] : '';
    $selTb = isset($_POST['selTb']) ? $_POST['selTb'] : '';
    $selFunc = isset($_POST['selFunc']) ? $_POST['selFunc'] : '';
    $selSQL = isset($_POST['selSQL']) ? $_POST['selSQL'] : '';
    //
    if(isset($_POST['TableSearch'])){
       $TableSearch =  $_POST['TableSearch'];
    }else{
      $TableSearch = array();
    }
   
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
            <h3 class="box-title">Keyword List</h3>
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
                    <th>Host</th>
                    <th>Nama Keyword</th>
                    <th>Keyword</th>
                    <th>Jenis Operasi</th>
                    <th>Keyword Publik</th>
                    <th>Penanda Login</th>
                    <th>Id Jenis Operasi</th>
                    <th>Id Jenis SQL</th>
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
          <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="AddStep1" id="formControl" method="POST" action="keyword.php?p=1">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenis">
                    <option value="0">Procedural</option>
                    <option value="1">Insert</option>
                    <option value="2">Update</option>
                    <option value="3">Delete</option>
                    <option value="4">Select</option>
                  </select>
                </div>
              </div>
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
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Insert1" id="Insert1" method="POST" action="keyword.php?p=1a">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $_POST['selJenis']){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $_POST['selJenis']; ?>">
                </div>
              </div>
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
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Insert2" id="Insert2" >
            <input type="hidden" name="idOperasi" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $selJenis){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                <label for="input-service" class="col-sm-2 control-label">Nama Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="NmKeyw" placeholder="Nama Keyword" value="<?php echo $NmKeyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="Keyw" placeholder="Keyword" value="<?php echo $Keyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword Publik</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selPub">
                    <option <?php if($selPub=='1'){echo "SELECTED";} ?> value="1">Publik</option>
                    <option <?php if($selPub=='0'){echo "SELECTED";} ?> value="0">Private</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Membutuhkan Login</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selLogin">
                    <option <?php if($selLogin=='1'){echo "SELECTED";} ?> value="1">Ya</option>
                    <option <?php if($selLogin=='2'){echo "SELECTED";} ?> value="2">Tidak</option>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-body">
              <h3>Parameter</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="DynInsertRow" name="DynInsertRow">
                <table class="table table-bordered" id="DynInsert">
                  <tr>
                    <th>Parameter</th>
                    <th>Nama Parameter</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_parameter WHERE id_operasi='" . $_GET['id'] . "'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldIns[]">
                            <?php
                            if($selTb!=''){
                              $query = "DESC " . $selTb ;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  <option <?php if($row_det['parameter']==$selTb.'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="PrmIns[]">
                        </td>
                        <td><button id="AddRowInsert" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldIns[]">
                            <?php
                            if($selTb!=''){
                              $query = "DESC " . $selTb ;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  <option <?php if($row_det['parameter']==$selTb.'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="PrmIns[]">
                        </td>
                        <td><button id='DelRowInsert' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="FieldIns[]">
                        <?php
                        if($selTb!=''){
                          $query = "DESC " . $selTb ;
                          $result = mysqli_query($id_mysql_tb,$query);
                          while($row = $result->fetch_array()) {
                            ?>
                              <option value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input class="form-control" type="textbox" value="" name="PrmIns[]">
                    </td>
                    <td><button id="AddRowInsert" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div>
            <div class="box-footer">
              <?php
              if(isset($_GET['dup'])){//duplicate
                ?>
                  <button style="margin-left:5px;" id="btnDupIns" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-copy"></i> Duplicate</span></button>
                <?php
              }else{
                if(isset($_GET['id'])){//edit
                  ?>
                    <button style="margin-left:5px;" id="btnEditIns" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-edit"></i> Save Edit</span></button>
                  <?php
                }else{//new
                  ?>
                    <button style="margin-left:5px;" id="btnSaveIns" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                  <?php
                }
              }
              ?>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step insert 2 -->
    <!-- step update -->
    <div class="row" id="panel-form-update-1" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Update1" id="Update1" method="POST" action="keyword.php?p=1a">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $_POST['selJenis']){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $_POST['selJenis']; ?>">
                </div>
              </div>
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
    <!-- end step update -->
    <!-- step update 2 -->
    <div class="row" id="panel-form-update-2" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Update2" id="Update2" >
            <input type="hidden" name="idOperasi" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $selJenis){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                <label for="input-service" class="col-sm-2 control-label">Nama Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="NmKeyw" placeholder="Nama Keyword" value="<?php echo $NmKeyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="Keyw" placeholder="Keyword" value="<?php echo $Keyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword Publik</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selPub">
                    <option <?php if($selPub=='1'){echo "SELECTED";} ?> value="1">Publik</option>
                    <option <?php if($selPub=='0'){echo "SELECTED";} ?> value="0">Private</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Membutuhkan Login</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selLogin">
                    <option <?php if($selLogin=='1'){echo "SELECTED";} ?> value="1">Ya</option>
                    <option <?php if($selLogin=='2'){echo "SELECTED";} ?> value="2">Tidak</option>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-body"><!-- parameter kunci -->
              <h3>Parameter Kunci</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="2DynUpdateRow" name="2DynUpdateRow">
                <table class="table table-bordered" id="2DynUpdate">
                  <tr>
                    <th>Parameter</th>
                    <th>Nama Parameter</th>
                    <th>Type</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_parameter WHERE id_operasi='" . $_GET['id'] . "' AND is_kunci='1'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="2FieldUpd[]">
                            <?php
                            if($selTb!=''){
                              $query = "DESC " . $selTb ;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  <option <?php if($row_det['parameter']==$selTb.'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="2PrmUpd[]">
                        </td>
                        <td>
                          <select class="form-control" name="2TypeUpd[]">
                            <option <?php if($row_det['type']=="="){echo "SELECTED";} ?> value='='>=</option>
                            <option <?php if($row_det['type']=="<"){echo "SELECTED";} ?> value='<'>&lt;</option>
                            <option <?php if($row_det['type']=="<="){echo "SELECTED";} ?> value='<='>&lt;=</option>
                            <option <?php if($row_det['type']==">"){echo "SELECTED";} ?> value='>'>&gt;</option>
                            <option <?php if($row_det['type']==">="){echo "SELECTED";} ?> value='>='>&gt;=</option>
                            <option <?php if($row_det['type']=="LIKE"){echo "SELECTED";} ?> value='LIKE'>LIKE</option>
                          </select>
                        </td>
                        <td><button id="2AddRowUpdate" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="2FieldUpd[]">
                            <?php
                            if($selTb!=''){
                              $query = "DESC " . $selTb ;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  <option <?php if($row_det['parameter']==$selTb.'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="2PrmUpd[]">
                        </td>
                        <td>
                          <select class="form-control" name="2TypeUpd[]">
                            <option <?php if($row_det['type']=="="){echo "SELECTED";} ?> value='='>=</option>
                            <option <?php if($row_det['type']=="<"){echo "SELECTED";} ?> value='<'>&lt;</option>
                            <option <?php if($row_det['type']=="<="){echo "SELECTED";} ?> value='<='>&lt;=</option>
                            <option <?php if($row_det['type']==">"){echo "SELECTED";} ?> value='>'>&gt;</option>
                            <option <?php if($row_det['type']==">="){echo "SELECTED";} ?> value='>='>&gt;=</option>
                            <option <?php if($row_det['type']=="LIKE"){echo "SELECTED";} ?> value='LIKE'>LIKE</option>
                          </select>
                        </td>
                        <td><button id='2DelRowUpdate' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="2FieldUpd[]">
                        <?php
                        if($selTb!=''){
                          $query = "DESC " . $selTb ;
                          $result = mysqli_query($id_mysql_tb,$query);
                          while($row = $result->fetch_array()) {
                            ?>
                              <option value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input class="form-control" type="textbox" value="" name="2PrmUpd[]">
                    </td>
                    <td>
                      <select class="form-control" name="2TypeUpd[]">
                        <option value='='>=</option>
                        <option value='<'>&lt;</option>
                        <option value='<='>&lt;=</option>
                        <option value='>'>&gt;</option>
                        <option value='>='>&gt;=</option>
                        <option value='LIKE'>LIKE</option>
                      </select>
                    </td>
                    <td><button id="2AddRowUpdate" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div><!-- parameter kunci -->
            <div class="box-body"><!-- parameter value -->
              <h3>Parameter Value</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="DynUpdateRow" name="DynUpdateRow">
                <table class="table table-bordered" id="DynUpdate">
                  <tr>
                    <th>Parameter</th>
                    <th>Nama Parameter</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_parameter WHERE id_operasi='" . $_GET['id'] . "' AND is_kunci='0'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldUpd[]">
                            <?php
                            if($selTb!=''){
                              $query = "DESC " . $selTb ;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  <option <?php if($row_det['parameter']==$selTb.'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="PrmUpd[]">
                        </td>
                        <td><button id="AddRowUpdate" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldUpd[]">
                            <?php
                            if($selTb!=''){
                              $query = "DESC " . $selTb ;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  <option <?php if($row_det['parameter']==$selTb.'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="PrmUpd[]">
                        </td>
                        <td><button id='DelRowUpdate' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="FieldUpd[]">
                        <?php
                        if($selTb!=''){
                          $query = "DESC " . $selTb ;
                          $result = mysqli_query($id_mysql_tb,$query);
                          while($row = $result->fetch_array()) {
                            ?>
                              <option value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input class="form-control" type="textbox" value="" name="PrmUpd[]">
                    </td>
                    <td><button id="AddRowUpdate" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div>
            <div class="box-footer">
              <?php
              if(isset($_GET['dup'])){//duplicate
                ?>
                  <button style="margin-left:5px;" id="btnDupUpd" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-copy"></i> Duplicate</span></button>
                <?php
              }else{
                if(isset($_GET['id'])){//edit
                  ?>
                    <button style="margin-left:5px;" id="btnEditUpd" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-edit"></i> Save Edit</span></button>
                  <?php
                }else{//new
                  ?>
                    <button style="margin-left:5px;" id="btnSaveUpd" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                  <?php
                }
              }
              ?>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step update 2 -->
    <!-- step delete -->
    <div class="row" id="panel-form-delete-1" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Delete1" id="Delete1" method="POST" action="keyword.php?p=1a">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $_POST['selJenis']){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $_POST['selJenis']; ?>">
                </div>
              </div>
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
    <!-- end step delete -->
    <!-- step delete 2 -->
    <div class="row" id="panel-form-delete-2" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Delete2" id="Delete2" >
            <input type="hidden" name="idOperasi" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $selJenis){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                <label for="input-service" class="col-sm-2 control-label">Nama Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="NmKeyw" placeholder="Nama Keyword" value="<?php echo $NmKeyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="Keyw" placeholder="Keyword" value="<?php echo $Keyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword Publik</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selPub">
                    <option <?php if($selPub=='1'){echo "SELECTED";} ?> value="1">Publik</option>
                    <option <?php if($selPub=='0'){echo "SELECTED";} ?> value="0">Private</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Membutuhkan Login</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selLogin">
                    <option <?php if($selLogin=='1'){echo "SELECTED";} ?> value="1">Ya</option>
                    <option <?php if($selLogin=='2'){echo "SELECTED";} ?> value="2">Tidak</option>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-body"><!-- parameter kunci -->
              <h3>Parameter Kunci</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="2DynDeleteRow" name="2DynDeleteRow">
                <table class="table table-bordered" id="2DynDelete">
                  <tr>
                    <th>Parameter</th>
                    <th>Nama Parameter</th>
                    <th>Type</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_parameter WHERE id_operasi='" . $_GET['id'] . "' AND is_kunci='1'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="2FieldDel[]">
                            <?php
                            if($selTb!=''){
                              $query = "DESC " . $selTb ;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  <option <?php if($row_det['parameter']==$selTb.'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="2PrmDel[]">
                        </td>
                        <td>
                          <select class="form-control" name="2TypeDel[]">
                            <option <?php if($row_det['type']=="="){echo "SELECTED";} ?> value='='>=</option>
                            <option <?php if($row_det['type']=="<"){echo "SELECTED";} ?> value='<'>&lt;</option>
                            <option <?php if($row_det['type']=="<="){echo "SELECTED";} ?> value='<='>&lt;=</option>
                            <option <?php if($row_det['type']==">"){echo "SELECTED";} ?> value='>'>&gt;</option>
                            <option <?php if($row_det['type']==">="){echo "SELECTED";} ?> value='>='>&gt;=</option>
                            <option <?php if($row_det['type']=="LIKE"){echo "SELECTED";} ?> value='LIKE'>LIKE</option>
                          </select>
                        </td>
                        <td><button id="2AddRowDelete" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="2FieldDel[]">
                            <?php
                            if($selTb!=''){
                              $query = "DESC " . $selTb ;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  <option <?php if($row_det['parameter']==$selTb.'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="2PrmDel[]">
                        </td>
                        <td>
                          <select class="form-control" name="2TypeDel[]">
                            <option <?php if($row_det['type']=="="){echo "SELECTED";} ?> value='='>=</option>
                            <option <?php if($row_det['type']=="<"){echo "SELECTED";} ?> value='<'>&lt;</option>
                            <option <?php if($row_det['type']=="<="){echo "SELECTED";} ?> value='<='>&lt;=</option>
                            <option <?php if($row_det['type']==">"){echo "SELECTED";} ?> value='>'>&gt;</option>
                            <option <?php if($row_det['type']==">="){echo "SELECTED";} ?> value='>='>&gt;=</option>
                            <option <?php if($row_det['type']=="LIKE"){echo "SELECTED";} ?> value='LIKE'>LIKE</option>
                          </select>
                        </td>
                        <td><button id='2DelRowDelete' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="2FieldDel[]">
                        <?php
                        if($selTb!=''){
                          $query = "DESC " . $selTb ;
                          $result = mysqli_query($id_mysql_tb,$query);
                          while($row = $result->fetch_array()) {
                            ?>
                              <option value="<?php echo $selTb .'.'.$row[0]; ?>"><?php echo $selTb .'.'.$row[0]; ?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input class="form-control" type="textbox" value="" name="2PrmDel[]">
                    </td>
                    <td>
                      <select class="form-control" name="2TypeDel[]">
                        <option value='='>=</option>
                        <option value='<'>&lt;</option>
                        <option value='<='>&lt;=</option>
                        <option value='>'>&gt;</option>
                        <option value='>='>&gt;=</option>
                        <option value='LIKE'>LIKE</option>
                      </select>
                    </td>
                    <td><button id="2AddRowDelete" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div><!-- parameter kunci -->
            <div class="box-footer">
              <?php
              if(isset($_GET['dup'])){//duplicate
                ?>
                  <button style="margin-left:5px;" id="btnDupDel" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-copy"></i> Duplicate</span></button>
                <?php
              }else{
                if(isset($_GET['id'])){//edit
                  ?>
                    <button style="margin-left:5px;" id="btnEditDel" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-edit"></i> Save Edit</span></button>
                  <?php
                }else{//new
                  ?>
                    <button style="margin-left:5px;" id="btnSaveDel" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                  <?php
                }
              }
              ?>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step delete 2 -->
    <!-- step procedural -->
    <div class="row" id="panel-form-pros-1" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Proc1" id="Proc1" method="POST" action="keyword.php?p=1b">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <option <?php if($selJenis == '0'){echo "SELECTED";} ?> value="0">Procedural</option>
                    <option <?php if($selJenis == '1'){echo "SELECTED";} ?> value="1">Insert</option>
                    <option <?php if($selJenis == '2'){echo "SELECTED";} ?> value="2">Update</option>
                    <option <?php if($selJenis == '3'){echo "SELECTED";} ?> value="3">Delete</option>
                    <option <?php if($selJenis == '4'){echo "SELECTED";} ?> value="4">Select</option>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                <label for="input-service" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selSQL">
                    <option value='2'>Function</option>
                    <option value='3'>Procedure</option>
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
    <!-- end step procedure -->
    <!-- step function 1 -->
    <div class="row" id="panel-form-function-1" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Func1" id="Func1" method="POST" action="keyword.php?p=1a">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <option <?php if($selJenis == '0'){echo "SELECTED";} ?> value="0">Procedural</option>
                    <option <?php if($selJenis == '1'){echo "SELECTED";} ?> value="1">Insert</option>
                    <option <?php if($selJenis == '2'){echo "SELECTED";} ?> value="2">Update</option>
                    <option <?php if($selJenis == '3'){echo "SELECTED";} ?> value="3">Delete</option>
                    <option <?php if($selJenis == '4'){echo "SELECTED";} ?> value="4">Select</option>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                  <input type="hidden" name="selHost" value="<?php echo $selHost; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selSQLDis" Disabled>
                    <option <?php if($selSQL == '2'){echo "SELECTED";} ?> value='2'>Function</option>
                    <option <?php if($selSQL == '3'){echo "SELECTED";} ?> value='3'>Procedure</option>
                  </select>
                  <input type="hidden" name="selSQL" value="<?php echo $selSQL; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Function</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selFunc">
                    <?php
                      if(isset($_POST['selHost'])){
                        //
                        $query_h = "SELECT * FROM tb_host WHERE id_host=" . $_POST['selHost'];
                        $result_h = mysqli_query($id_mysql,$query_h);
                        $data_h = mysqli_fetch_array($result_h);
                        //
                        $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                        $query_tb = "SELECT SPECIFIC_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = '".$data_h['db']."' AND ROUTINE_TYPE = 'FUNCTION'";
                        $result_tb = mysqli_query($id_mysql_tb,$query_tb);
                        while($row = $result_tb->fetch_assoc()) {
                          ?>
                            <option value="<?php echo $row['SPECIFIC_NAME']; ?>"><?php echo $row['SPECIFIC_NAME']; ?></option>
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
    <!-- end step function 1 -->
    <!-- step Function 2 -->
    <div class="row" id="panel-form-function-2" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Function2" id="Function2" >
            <input type="hidden" name="idOperasi" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $selJenis){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                <label for="input-service" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selSQLDis" Disabled>
                    <option <?php if($selSQL == '2'){echo "SELECTED";} ?> value='2'>Function</option>
                    <option <?php if($selSQL == '3'){echo "SELECTED";} ?> value='3'>Procedure</option>
                  </select>
                  <input type="hidden" name="selSQL" value="<?php echo $selSQL; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Function</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selFuncDis" Disabled>
                    <?php
                      if($selHost !=''){
                        //
                        $query_h = "SELECT * FROM tb_host WHERE id_host=" . $selHost;
                        $result_h = mysqli_query($id_mysql,$query_h);
                        $data_h = mysqli_fetch_array($result_h);
                        //
                        $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                        $query_tb = "SELECT SPECIFIC_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = '".$data_h['db']."' AND ROUTINE_TYPE = 'FUNCTION'";
                        $result_tb = mysqli_query($id_mysql_tb,$query_tb);
                        while($row = $result_tb->fetch_assoc()) {
                          if($row['SPECIFIC_NAME'] == $selFunc){
                            ?>
                              <option SELECTED value="<?php echo $row['SPECIFIC_NAME']; ?>"><?php echo $row['SPECIFIC_NAME']; ?></option>
                            <?php
                          }else{
                            ?>
                              <option value="<?php echo $row['SPECIFIC_NAME']; ?>"><?php echo $row['SPECIFIC_NAME']; ?></option>
                            <?php
                          }
                          
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selFunc" value="<?php echo $selFunc; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Nama Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="NmKeyw" placeholder="Nama Keyword" value="<?php echo $NmKeyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="Keyw" placeholder="Keyword" value="<?php echo $Keyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword Publik</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selPub">
                    <option <?php if($selPub=='1'){echo "SELECTED";} ?> value="1">Publik</option>
                    <option <?php if($selPub=='0'){echo "SELECTED";} ?> value="0">Private</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Membutuhkan Login</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selLogin">
                    <option <?php if($selLogin=='1'){echo "SELECTED";} ?> value="1">Ya</option>
                    <option <?php if($selLogin=='2'){echo "SELECTED";} ?> value="2">Tidak</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Display Output Function</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="NmOutput" placeholder="Display Output Function" value="<?php echo $NmOutput; ?>">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-body">
              <h3>Parameter</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="DynFunctionRow" name="DynFunctionRow">
                <table class="table table-bordered" id="DynFunction">
                  <tr>
                    <th>Parameter</th>
                    <th>Nama Parameter</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_parameter WHERE id_operasi='" . $_GET['id'] . "'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldFunc[]">
                            <?php
                            if($selFunc!=''){
                              $query = "SELECT CAST(param_list AS CHAR(1000) CHARACTER SET utf8) AS parameter FROM mysql.proc WHERE db = '".$data_h['db']."' AND NAME = '".$selFunc ."'";
                              $result = mysqli_query($id_mysql_tb,$query);
                              $data = mysqli_fetch_array($result);
                              //explode
                              $param = explode(",", $data['parameter']);
                              //loop
                              foreach ($param as $row) {
                                ?>
                                  <option <?php if($row_det['parameter']==explode(' ',trim($row))[0]){echo "SELECTED";} ?> value="<?php echo explode(' ',trim($row))[0]; ?>"><?php echo explode(' ',trim($row))[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="PrmFunc[]">
                        </td>
                        <td><button id="AddRowFunction" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldFunc[]">
                            <?php
                            if($selFunc!=''){
                              $query = "SELECT CAST(param_list AS CHAR(1000) CHARACTER SET utf8) AS parameter FROM mysql.proc WHERE db = '".$data_h['db']."' AND NAME = '".$selFunc ."'";
                              $result = mysqli_query($id_mysql_tb,$query);
                              $data = mysqli_fetch_array($result);
                              //explode
                              $param = explode(",", $data['parameter']);
                              //loop
                              foreach ($param as $row) {
                                ?>
                                  <option <?php if($row_det['parameter']==explode(' ',trim($row))[0]){echo "SELECTED";} ?> value="<?php echo explode(' ',trim($row))[0]; ?>"><?php echo explode(' ',trim($row))[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="PrmFunc[]">
                        </td>
                        <td><button id='DelRowFunction' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="FieldFunc[]">
                        <?php
                        if($selFunc!=''){
                          $query = "SELECT CAST(param_list AS CHAR(1000) CHARACTER SET utf8) AS parameter FROM mysql.proc WHERE db = '".$data_h['db']."' AND NAME = '".$selFunc ."'";
                          $result = mysqli_query($id_mysql_tb,$query);
                          $data = mysqli_fetch_array($result);
                          //explode
                          $param = explode(",", $data['parameter']);
                          //loop
                          foreach ($param as $row) {
                            ?>
                              <option value="<?php echo explode(' ',trim($row))[0]; ?>"><?php echo explode(' ',trim($row))[0]; ?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input class="form-control" type="textbox" value="" name="PrmFunc[]">
                    </td>
                    <td><button id="AddRowFunction" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div>
            <div class="box-footer">
              <?php
              if(isset($_GET['dup'])){//duplicate
                ?>
                  <button style="margin-left:5px;" id="btnDupFunc" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-copy"></i> Duplicate</span></button>
                <?php
              }else{
                if(isset($_GET['id'])){//edit
                  ?>
                    <button style="margin-left:5px;" id="btnEditFunc" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-edit"></i> Save Edit</span></button>
                  <?php
                }else{//new
                  ?>
                    <button style="margin-left:5px;" id="btnSaveFunc" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                  <?php
                }
              }
              ?>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step Function 2 -->
    <!-- step Procedure 1 -->
    <div class="row" id="panel-form-procedure-1" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Proc1" id="Proc1" method="POST" action="keyword.php?p=1a">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <option <?php if($selJenis == '0'){echo "SELECTED";} ?> value="0">Procedural</option>
                    <option <?php if($selJenis == '1'){echo "SELECTED";} ?> value="1">Insert</option>
                    <option <?php if($selJenis == '2'){echo "SELECTED";} ?> value="2">Update</option>
                    <option <?php if($selJenis == '3'){echo "SELECTED";} ?> value="3">Delete</option>
                    <option <?php if($selJenis == '4'){echo "SELECTED";} ?> value="4">Select</option>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                  <input type="hidden" name="selHost" value="<?php echo $selHost; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selSQLDis" Disabled>
                    <option <?php if($selSQL == '2'){echo "SELECTED";} ?> value='2'>Function</option>
                    <option <?php if($selSQL == '3'){echo "SELECTED";} ?> value='3'>Procedure</option>
                  </select>
                  <input type="hidden" name="selSQL" value="<?php echo $selSQL; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Procedure</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selFunc">
                    <?php
                      if(isset($_POST['selHost'])){
                        //
                        $query_h = "SELECT * FROM tb_host WHERE id_host=" . $_POST['selHost'];
                        $result_h = mysqli_query($id_mysql,$query_h);
                        $data_h = mysqli_fetch_array($result_h);
                        //
                        $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                        $query_tb = "SELECT SPECIFIC_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = '".$data_h['db']."' AND ROUTINE_TYPE = 'PROCEDURE'";
                        $result_tb = mysqli_query($id_mysql_tb,$query_tb);
                        while($row = $result_tb->fetch_assoc()) {
                          ?>
                            <option value="<?php echo $row['SPECIFIC_NAME']; ?>"><?php echo $row['SPECIFIC_NAME']; ?></option>
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
    <!-- end step procedure 1 -->
    <!-- step Procedure 2 -->
    <div class="row" id="panel-form-procedure-2" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Procedure2" id="Procedure2" >
            <input type="hidden" name="idOperasi" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $selJenis){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                <label for="input-service" class="col-sm-2 control-label">Type</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selSQLDis" Disabled>
                    <option <?php if($selSQL == '2'){echo "SELECTED";} ?> value='2'>Function</option>
                    <option <?php if($selSQL == '3'){echo "SELECTED";} ?> value='3'>Procedure</option>
                  </select>
                  <input type="hidden" name="selSQL" value="<?php echo $selSQL; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Procedure</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selFuncDis" Disabled>
                    <?php
                      if($selHost !=''){
                        //
                        $query_h = "SELECT * FROM tb_host WHERE id_host=" . $selHost;
                        $result_h = mysqli_query($id_mysql,$query_h);
                        $data_h = mysqli_fetch_array($result_h);
                        //
                        $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                        $query_tb = "SELECT SPECIFIC_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = '".$data_h['db']."' AND ROUTINE_TYPE = 'PROCEDURE'";
                        $result_tb = mysqli_query($id_mysql_tb,$query_tb);
                        while($row = $result_tb->fetch_assoc()) {
                          if($row['SPECIFIC_NAME'] == $selFunc){
                            ?>
                              <option SELECTED value="<?php echo $row['SPECIFIC_NAME']; ?>"><?php echo $row['SPECIFIC_NAME']; ?></option>
                            <?php
                          }else{
                            ?>
                              <option value="<?php echo $row['SPECIFIC_NAME']; ?>"><?php echo $row['SPECIFIC_NAME']; ?></option>
                            <?php
                          }
                          
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selFunc" value="<?php echo $selFunc; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Nama Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="NmKeyw" placeholder="Nama Keyword" value="<?php echo $NmKeyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="Keyw" placeholder="Keyword" value="<?php echo $Keyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword Publik</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selPub">
                    <option <?php if($selPub=='1'){echo "SELECTED";} ?> value="1">Publik</option>
                    <option <?php if($selPub=='0'){echo "SELECTED";} ?> value="0">Private</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Membutuhkan Login</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selLogin">
                    <option <?php if($selLogin=='1'){echo "SELECTED";} ?> value="1">Ya</option>
                    <option <?php if($selLogin=='2'){echo "SELECTED";} ?> value="2">Tidak</option>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-body">
              <h3>Parameter</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="DynProcedureRow" name="DynProcedureRow">
                <table class="table table-bordered" id="DynProcedure">
                  <tr>
                    <th>Parameter</th>
                    <th>Nama Parameter</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_parameter WHERE id_operasi='" . $_GET['id'] . "'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldProcc[]">
                            <?php
                            if($selFunc!=''){
                              $query = "SELECT CAST(param_list AS CHAR(1000) CHARACTER SET utf8) AS parameter FROM mysql.proc WHERE db = '".$data_h['db']."' AND NAME = '".$selFunc ."'";
                              $result = mysqli_query($id_mysql_tb,$query);
                              $data = mysqli_fetch_array($result);
                              //explode
                              $param = explode(",", $data['parameter']);
                              //loop
                              foreach ($param as $row) {
                                ?>
                                  <option <?php if($row_det['parameter']==explode(' ',trim($row))[0]){echo "SELECTED";} ?> value="<?php echo explode(' ',trim($row))[0]; ?>"><?php echo explode(' ',trim($row))[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="PrmProc[]">
                        </td>
                        <td><button id="AddRowProcedure" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldProc[]">
                            <?php
                            if($selFunc!=''){
                              $query = "SELECT CAST(param_list AS CHAR(1000) CHARACTER SET utf8) AS parameter FROM mysql.proc WHERE db = '".$data_h['db']."' AND NAME = '".$selFunc ."'";
                              $result = mysqli_query($id_mysql_tb,$query);
                              $data = mysqli_fetch_array($result);
                              //explode
                              $param = explode(",", $data['parameter']);
                              //loop
                              foreach ($param as $row) {
                                ?>
                                  <option <?php if($row_det['parameter']==explode(' ',trim($row))[0]){echo "SELECTED";} ?> value="<?php echo explode(' ',trim($row))[0]; ?>"><?php echo explode(' ',trim($row))[0]; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="PrmProc[]">
                        </td>
                        <td><button id='DelRowProcedure' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="FieldProc[]">
                        <?php
                        if($selFunc!=''){
                          $query = "SELECT CAST(param_list AS CHAR(1000) CHARACTER SET utf8) AS parameter FROM mysql.proc WHERE db = '".$data_h['db']."' AND NAME = '".$selFunc ."'";
                          $result = mysqli_query($id_mysql_tb,$query);
                          $data = mysqli_fetch_array($result);
                          //explode
                          $param = explode(",", $data['parameter']);
                          //loop
                          foreach ($param as $row) {
                            ?>
                              <option value="<?php echo explode(' ',trim($row))[0]; ?>"><?php echo explode(' ',trim($row))[0]; ?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input class="form-control" type="textbox" value="" name="PrmProc[]">
                    </td>
                    <td><button id="AddRowProcedure" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div>
            <div class="box-footer">
              <?php
              if(isset($_GET['dup'])){//duplicate
                ?>
                  <button style="margin-left:5px;" id="btnDupProc" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-copy"></i> Duplicate</span></button>
                <?php
              }else{
                if(isset($_GET['id'])){//edit
                  ?>
                    <button style="margin-left:5px;" id="btnEditProc" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-edit"></i> Save Edit</span></button>
                  <?php
                }else{//new
                  ?>
                    <button style="margin-left:5px;" id="btnSaveProc" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                  <?php
                }
              }
              ?>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step Procedure 2 -->
    <!-- step search -->
    <div class="row" id="panel-form-search-1" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Search1" id="Search1" method="POST" action="keyword.php?p=1a">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $selJenis){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
              </div>
              <div class="box-body">
              <h3>Tabel</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="DynTableSearchRow" name="DynTableSearchRow">
                <table class="table table-bordered" id="DynTableSearch">
                  <tr>
                    <th>Nama Tabel</th>
                    <th style="width: 40px">#</th>
                  </tr>
                  <tr>
                    <td>
                      <select class="form-control" name="TableSearch[]">
                        <?php
                        if($selHost!=''){
                          $query_h = "SELECT * FROM tb_host WHERE id_host=" . $selHost;
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
                    </td>
                    <td><button id="AddRowTableSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
                </table>
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
    <!-- end step search -->
    <!-- step Search 2 -->
    <div class="row" id="panel-form-search-2" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Keyword</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <form class="form-horizontal" name="Search2" id="Search2" >
            <input type="hidden" name="idOperasi" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="box-body">
              <h3>Detail Keyword</h3><hr>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Jenis Keyword</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selJenisDis" DISABLED>
                    <?php
                      $query_jns_op = "SELECT * FROM tb_jenis_operasi";
                      $result_jns_op = mysqli_query($id_mysql,$query_jns_op);
                      while($row = $result_jns_op->fetch_assoc()) {
                        if($row['id_jenis_operasi'] == $selJenis){
                          ?>
                            <option SELECTED value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }else{
                          ?>
                            <option value="<?php echo $row['id_jenis_operasi']; ?>"><?php echo $row['jenis_operasi']; ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="selJenis" value="<?php echo $selJenis; ?>">
                </div>
              </div>
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
                <label for="input-service" class="col-sm-2 control-label">Nama Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="NmKeyw" placeholder="Nama Keyword" value="<?php echo $NmKeyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" name="Keyw" placeholder="Keyword" value="<?php echo $Keyw; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Keyword Publik</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selPub">
                    <option <?php if($selPub=='1'){echo "SELECTED";} ?> value="1">Publik</option>
                    <option <?php if($selPub=='0'){echo "SELECTED";} ?> value="0">Private</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="input-service" class="col-sm-2 control-label">Membutuhkan Login</label>
                <div class="col-sm-10">
                  <select class="form-control" name="selLogin">
                    <option <?php if($selLogin=='1'){echo "SELECTED";} ?> value="1">Ya</option>
                    <option <?php if($selLogin=='2'){echo "SELECTED";} ?> value="2">Tidak</option>
                  </select>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-body">
              <h3>Tabel</h3><hr>
              <div class="form-group">
                <table class="table table-bordered">
                  <?php
                    if(isset($_GET['id'])){//edit
                      for ($i=0; $i<count($TableSearch); $i++) {
                        ?>
                        <tr>
                          <td>
                            <input class="form-control" type="textbox" value="<?php echo $TableSearch[$i]; ?>" name="TableSearchDis" disabled>
                            <input class="form-control" type="hidden" value="<?php echo $TableSearch[$i]; ?>" name="TableSearch[]">
                          </td>
                        </tr>
                        <?php
                      }
                    }else{//new
                      for ($i=0; $i<count($TableSearch); $i++) {
                        ?>
                        <tr>
                          <td>
                            <input class="form-control" type="textbox" value="<?php echo $TableSearch[$i]; ?>" name="TableSearchDis" disabled>
                            <input class="form-control" type="hidden" value="<?php echo $TableSearch[$i]; ?>" name="TableSearch[]">
                          </td>
                        </tr>
                        <?php
                      }
                    }
                  ?>
                </table>
              </div>
            </div><!-- /.box-body -->
            <div class="box-body"><!-- parameter kunci -->
              <h3>Parameter Kunci</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="2DynSearchRow" name="2DynSearchRow">
                <table class="table table-bordered" id="2DynSearch">
                  <tr>
                    <th>Parameter</th>
                    <th>Nama Parameter</th>
                    <th>Type</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_parameter WHERE id_operasi='" . $_GET['id'] . "' AND is_kunci='1'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="2FieldSearch[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($row_det['parameter']==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="2PrmSearch[]">
                        </td>
                        <td>
                          <select class="form-control" name="2TypeSearch[]">
                            <option <?php if($row_det['type']=="="){echo "SELECTED";} ?> value='='>=</option>
                            <option <?php if($row_det['type']=="<"){echo "SELECTED";} ?> value='<'>&lt;</option>
                            <option <?php if($row_det['type']=="<="){echo "SELECTED";} ?> value='<='>&lt;=</option>
                            <option <?php if($row_det['type']==">"){echo "SELECTED";} ?> value='>'>&gt;</option>
                            <option <?php if($row_det['type']==">="){echo "SELECTED";} ?> value='>='>&gt;=</option>
                            <option <?php if($row_det['type']=="LIKE"){echo "SELECTED";} ?> value='LIKE'>LIKE</option>
                          </select>
                        </td>
                        <td><button id="2AddRowSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="2FieldSearch[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($row_det['parameter']==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_parameter']; ?>" name="2PrmSearch[]">
                        </td>
                        <td>
                          <select class="form-control" name="2TypeSearch[]">
                            <option <?php if($row_det['type']=="="){echo "SELECTED";} ?> value='='>=</option>
                            <option <?php if($row_det['type']=="<"){echo "SELECTED";} ?> value='<'>&lt;</option>
                            <option <?php if($row_det['type']=="<="){echo "SELECTED";} ?> value='<='>&lt;=</option>
                            <option <?php if($row_det['type']==">"){echo "SELECTED";} ?> value='>'>&gt;</option>
                            <option <?php if($row_det['type']==">="){echo "SELECTED";} ?> value='>='>&gt;=</option>
                            <option <?php if($row_det['type']=="LIKE"){echo "SELECTED";} ?> value='LIKE'>LIKE</option>
                          </select>
                        </td>
                        <td><button id='2DelRowSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="2FieldSearch[]">
                        <?php
                        if(count($TableSearch)>0){
                          for ($i=0; $i<count($TableSearch); $i++) {
                            $query = "DESC " . $TableSearch[$i] ;
                            $result = mysqli_query($id_mysql_tb,$query);
                            while($row = $result->fetch_array()) {
                              ?>
                                <option value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                              <?php
                            }
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input class="form-control" type="textbox" value="" name="2PrmSearch[]">
                    </td>
                    <td>
                      <select class="form-control" name="2TypeSearch[]">
                        <option value='='>=</option>
                        <option value='<'>&lt;</option>
                        <option value='<='>&lt;=</option>
                        <option value='>'>&gt;</option>
                        <option value='>='>&gt;=</option>
                        <option value='LIKE'>LIKE</option>
                      </select>
                    </td>
                    <td><button id="2AddRowSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div><!-- parameter kunci -->
            <div class="box-body"><!-- parameter order by -->
              <h3>Parameter Order</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="OrderSearchRow" name="OrderSearchRow">
                <table class="table table-bordered" id="OrderSearch">
                  <tr>
                    <th>Order By</th>
                    <th>Ascending / Descending</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_order_by WHERE id_operasi='" . $_GET['id'] . "'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="OrderSearch[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($row_det['order_by']==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <select class="form-control" name="OrderTypeSearch[]">
                            <option <?php if($row_det['type']=="1"){echo "SELECTED";} ?> value='1'>Ascending</option>
                            <option <?php if($row_det['type']=="2"){echo "SELECTED";} ?> value='2'>Descending</option>
                          </select>
                        </td>
                        <td><button id="AddRowOrderSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="OrderSearch[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($row_det['order_by']==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <select class="form-control" name="OrderTypeSearch[]">
                            <option <?php if($row_det['type']=="1"){echo "SELECTED";} ?> value='1'>Ascending</option>
                            <option <?php if($row_det['type']=="2"){echo "SELECTED";} ?> value='2'>Descending</option>
                          </select>
                        </td>
                        <td><button id='AddRowOrderSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="OrderSearch[]">
                        <?php
                        if(count($TableSearch)>0){
                          for ($i=0; $i<count($TableSearch); $i++) {
                            $query = "DESC " . $TableSearch[$i] ;
                            $result = mysqli_query($id_mysql_tb,$query);
                            while($row = $result->fetch_array()) {
                              ?>
                                <option value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                              <?php
                            }
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <select class="form-control" name="OrderTypeSearch[]">
                        <option value='1'>Ascending</option>
                        <option value='2'>Descending</option>
                      </select>
                    </td>
                    <td><button id="AddRowOrderSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div><!-- parameter order by -->
            <div class="box-body"><!-- parameter output -->
              <h3>Parameter Output</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="DynSearchRow" name="DynSearchRow">
                <table class="table table-bordered" id="DynSearch">
                  <tr>
                    <th>Parameter</th>
                    <th>Nama Parameter</th>
                    <th>Tipe Output</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_output WHERE id_operasi='" . $_GET['id'] . "'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldSearch[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($row_det['output']==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_output']; ?>" name="PrmSearch[]">
                        </td>
                        <td>
                          <select class="form-control" name="TypOutputSearch[]">
                            <option <?php if($row_det['jenis_output'] == "1"){echo "SELECTED";} ?> value="1">String</option>
                            <option <?php if($row_det['jenis_output'] == "2"){echo "SELECTED";} ?> value="2">Number</option>
                            <option <?php if($row_det['jenis_output'] == "3"){echo "SELECTED";} ?> value="3">Currency</option>
                          </select>
                        </td>
                        <td><button id="AddRowSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="FieldSearch[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($row_det['output']==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" type="textbox" value="<?php echo $row_det['nama_output']; ?>" name="PrmSearch[]">
                        </td>
                        <td>
                          <select class="form-control" name="TypOutputSearch[]">
                            <option <?php if($row_det['jenis_output'] == "1"){echo "SELECTED";} ?> value="1">String</option>
                            <option <?php if($row_det['jenis_output'] == "2"){echo "SELECTED";} ?> value="2">Number</option>
                            <option <?php if($row_det['jenis_output'] == "3"){echo "SELECTED";} ?> value="3">Currency</option>
                          </select>
                        </td>
                        <td><button id='DelRowSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="FieldSearch[]">
                        <?php
                        if(count($TableSearch)>0){
                          for ($i=0; $i<count($TableSearch); $i++) {
                            $query = "DESC " . $TableSearch[$i] ;
                            $result = mysqli_query($id_mysql_tb,$query);
                            while($row = $result->fetch_array()) {
                              ?>
                                <option value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                              <?php
                            }
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <input class="form-control" type="textbox" value="" name="PrmSearch[]">
                    </td>
                    <td>
                      <select class="form-control" name="TypOutputSearch[]">
                        <option value="1">String</option>
                        <option value="2">Number</option>
                        <option value="3">Currency</option>
                      </select>
                    </td>
                    <td><button id="AddRowSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div><!-- end parameter output -->
            <?php
              if(count($TableSearch)>1){
            ?>
            <div class="box-body"><!-- parameter join -->
              <h3>Join Parameter</h3><hr>
              <div class="form-group">
                <input type="hidden" value="2" id="3DynSearchRow" name="3DynSearchRow">
                <table class="table table-bordered" id="3DynSearch">
                  <tr>
                    <th>Join Field 1</th>
                    <th>Join Field 2</th>
                    <th style="width: 40px">#</th>
                  </tr>
              <?php
                if(isset($_GET['id'])){//edit
                  $query_det = "SELECT * FROM tb_operasi_join WHERE id_operasi='" . $_GET['id'] . "'";
                  $result_det = mysqli_query($id_mysql,$query_det);
                  $i = 1;
                  while($row_det = $result_det->fetch_assoc()) {
                    $join = explode("=", $row_det['field_join']);
                    $join1 = $join[0];
                    $join2= $join[1];
                    if($i=='1'){//first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="Join1Search[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($join1==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <select class="form-control" name="Join2Search[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($join2==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td><button id="AddRowSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                      </tr>
                      <?php
                    }else{//other than first row
                      ?>
                      <tr>
                        <td>
                          <select class="form-control" name="Join1Search[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($join1==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <select class="form-control" name="Join2Search[]">
                            <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    <option <?php if($join2==$TableSearch[$i] .'.'.$row[0]){echo "SELECTED";} ?> value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td><button id='DelRowSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>
                      </tr>
                      <?php
                    }
                    $i++;
                  }
                }else{//new
                  ?>
                  <tr>
                    <td>
                      <select class="form-control" name="Join1Search[]">
                        <?php
                        if(count($TableSearch)>0){
                          for ($i=0; $i<count($TableSearch); $i++) {
                            $query = "DESC " . $TableSearch[$i] ;
                            $result = mysqli_query($id_mysql_tb,$query);
                            while($row = $result->fetch_array()) {
                              ?>
                                <option value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                              <?php
                            }
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td>
                      <select class="form-control" name="Join2Search[]">
                        <?php
                        if(count($TableSearch)>0){
                          for ($i=0; $i<count($TableSearch); $i++) {
                            $query = "DESC " . $TableSearch[$i] ;
                            $result = mysqli_query($id_mysql_tb,$query);
                            while($row = $result->fetch_array()) {
                              ?>
                                <option value="<?php echo $TableSearch[$i] .'.'.$row[0]; ?>"><?php echo $TableSearch[$i] .'.'.$row[0]; ?></option>
                              <?php
                            }
                          }
                        }
                        ?>
                      </select>
                    </td>
                    <td><button id="3AddRowSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="black" data-size="s" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-plus"></i></span> Add Row</button></td>
                  </tr>
              <?php
                }
              ?>
                </table>
              </div>
            </div>
            <?php
              }
            ?>
            <div class="box-footer">
              <?php
              if(isset($_GET['dup'])){//duplicate
                ?>
                  <button style="margin-left:5px;" id="btnDupSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-copy"></i> Duplicate</span></button>
                <?php
              }else{
                if(isset($_GET['id'])){//edit
                  ?>
                    <button style="margin-left:5px;" id="btnEditSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-edit"></i> Save Edit</span></button>
                  <?php
                }else{//new
                  ?>
                    <button style="margin-left:5px;" id="btnSaveSearch" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                  <?php
                }
              }
              ?>
            </div><!-- /.box-footer -->
          </form>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end step Search 2 -->
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
      "ajax": "keyword_act.php?t=view",
      "order": [[ 0, "desc" ]],
      "columnDefs": [
          {
              "targets": [ 0 ],
              "visible": false
          },
          {
              "targets": [ 7 ],
              "visible": false
          },
          {
              "targets": [ 8 ],
              "visible": false
          }
      ]
  } );
  <?php
    //delete
    if(isset($_GET['del']) && isset($_GET['id'])){
      $query_del = "DELETE FROM tb_operasi WHERE id_operasi='" . $_GET['id'] . "'";
      $result = mysqli_query($id_mysql,$query_del);
      ?>
        window.location="keyword.php";
      <?php
    }
    //navigation
    if(isset($_GET['p']) && $selJenis != ''){
      ?>
      <?php
      if($_GET['p'] == '1' && $selJenis == '1'){ //insert 1
        ?>
          $("#panel-list").hide();
          $("#panel-form-insert-1").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1a' && $selJenis == '1'){ //insert 2
        ?>
          $("#panel-list").hide();
          $("#panel-form-insert-2").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1' && $selJenis == '2'){ //update 1
        ?>
          $("#panel-list").hide();
          $("#panel-form-update-1").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1a' && $selJenis == '2'){ //update 2
        ?>
          $("#panel-list").hide();
          $("#panel-form-update-2").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1' && $selJenis == '3'){ //delete 1
        ?>
          $("#panel-list").hide();
          $("#panel-form-delete-1").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1a' && $selJenis == '3'){ //delete 2
        ?>
          $("#panel-list").hide();
          $("#panel-form-delete-2").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1' && $selJenis == '0'){ //proc 1
        ?>
          $("#panel-list").hide();
          $("#panel-form-pros-1").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1b' && $selJenis == '0' && $selSQL == '2'){ //proc function 1
        ?>
          $("#panel-list").hide();
          $("#panel-form-function-1").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1a' && $selJenis == '0' && $selSQL == '2'){ //proc function 2
        ?>
          $("#panel-list").hide();
          $("#panel-form-function-2").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1b' && $selJenis == '0' && $selSQL == '3'){ //proc procedure 1
        ?>
          $("#panel-list").hide();
          $("#panel-form-procedure-1").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1a' && $selJenis == '0' && $selSQL == '3'){ //proc procedure 2
        ?>
          $("#panel-list").hide();
          $("#panel-form-procedure-2").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1' && $selJenis == '4'){ //search 1
        ?>
          $("#panel-list").hide();
          $("#panel-form-search-1").fadeIn('slow');
        <?php
      }elseif($_GET['p'] == '1a' && $selJenis == '4'){ //search 2
        ?>
          $("#panel-list").hide();
          $("#panel-form-search-2").fadeIn('slow');
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
    window.location="keyword.php";
  });
  //insert form button
  $("#AddRowInsert").click(function(event) {
    $('#DynInsert').append("<tr id='trInsDyn" + $("#DynInsertRow").val() + "'><td><select class='form-control' name='FieldIns[]'>"+
                           
                          <?php
                            if($selTb!=''){
                              //
                              $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                              $query = 'DESC ' . $selTb;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  "<option value='" + <?php echo '"'.$selTb.".".$row[0].'"'; ?> + "'>" + <?php echo '"'.$selTb.".".$row[0].'"'; ?> + "</option>"+
                                <?php
                              }
                            }
                          ?>
                            "</select></td><td><input class='form-control' type='textbox' value='' name='PrmIns[]'></td><td>" + 
                            "<button id='DelRowInsert' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button>" +
                            "</td></tr>");
    $('#DynInsertRow').val(parseInt($("#DynInsertRow").val()) + 1);
  });

  $(document).on('click', '#DelRowInsert', function(e) {
    $(this).closest("tr").remove();
  });

  $("#btnSaveIns").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSaveIns' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=1',
      type: 'POST',
      data: $("#Insert2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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
      url: 'keyword_act.php?t=1edit',
      type: 'POST',
      data: $("#Insert2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnDupIns").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnDupIns' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=1',
      type: 'POST',
      data: $("#Insert2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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
  //update form button
  //value
  $("#AddRowUpdate").click(function(event) {
    $('#DynUpdate').append("<tr id='trUpdDyn" + $("#DynUpdateRow").val() + "'><td><select class='form-control' name='FieldUpd[]'>"+
                           
                          <?php
                            if($selTb!=''){
                              //
                              $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                              $query = 'DESC ' . $selTb;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  "<option value='" + <?php echo '"'.$selTb.".".$row[0].'"'; ?> + "'>" + <?php echo '"'.$selTb.".".$row[0].'"'; ?> + "</option>"+
                                <?php
                              }
                            }
                          ?>
                            "</select></td><td><input class='form-control' type='textbox' value='' name='PrmUpd[]'></td><td>" + 
                            "<button id='DelRowUpdate' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button>" +
                            "</td></tr>");
    $('#DynUpdateRow').val(parseInt($("#DynUpdateRow").val()) + 1);
  });

  $(document).on('click', '#DelRowUpdate', function(e) {
    $(this).closest("tr").remove();
  });
//kunci
$("#2AddRowUpdate").click(function(event) {
    $('#2DynUpdate').append("<tr id='2trUpdDyn" + $("#2DynUpdateRow").val() + "'><td><select class='form-control' name='2FieldUpd[]'>"+
                           
                          <?php
                            if($selTb!=''){
                              //
                              $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                              $query = 'DESC ' . $selTb;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  "<option value='" + <?php echo '"'.$selTb.".".$row[0].'"'; ?> + "'>" + <?php echo '"'.$selTb.".".$row[0].'"'; ?> + "</option>"+
                                <?php
                              }
                            }
                          ?>
                            "</select></td><td><input class='form-control' type='textbox' value='' name='2PrmUpd[]'></td>" + 
                            "<td><select class='form-control' name='2TypeUpd[]'><option value='='>=</option><option value='<'>&lt;</option><option value='<='>&lt;=</option><option value='>'>&gt;</option><option value='>='>&gt;=</option><option value='LIKE'>LIKE</option></select></td>" +
                            "<td><button id='2DelRowUpdate' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>" +
                            "</tr>");
    $('#2DynUpdateRow').val(parseInt($("#2DynUpdateRow").val()) + 1);
  });

  $(document).on('click', '#2DelRowUpdate', function(e) {
    $(this).closest("tr").remove();
  });

  $("#btnSaveUpd").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSaveUpd' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=2',
      type: 'POST',
      data: $("#Update2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnEditUpd").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnEditUpd' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=2edit',
      type: 'POST',
      data: $("#Update2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnDupUpd").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnDupUpd' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=2',
      type: 'POST',
      data: $("#Update2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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
  //delete form button
  //kunci
  $("#2AddRowDelete").click(function(event) {
    $('#2DynDelete').append("<tr id='2trDelDyn" + $("#2DynDeleteRow").val() + "'><td><select class='form-control' name='2FieldDel[]'>"+
                           
                          <?php
                            if($selTb!=''){
                              //
                              $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                              $query = 'DESC ' . $selTb;
                              $result = mysqli_query($id_mysql_tb,$query);
                              while($row = $result->fetch_array()) {
                                ?>
                                  "<option value='" + <?php echo '"'.$selTb.".".$row[0].'"'; ?> + "'>" + <?php echo '"'.$selTb.".".$row[0].'"'; ?> + "</option>"+
                                <?php
                              }
                            }
                          ?>
                            "</select></td><td><input class='form-control' type='textbox' value='' name='2PrmDel[]'></td>" + 
                            "<td><select class='form-control' name='2TypeDel[]'><option value='='>=</option><option value='<'>&lt;</option><option value='<='>&lt;=</option><option value='>'>&gt;</option><option value='>='>&gt;=</option><option value='LIKE'>LIKE</option></select></td>" +
                            "<td><button id='2DelRowDelete' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>" +
                            "</tr>");
    $('#2DynDeleteRow').val(parseInt($("#2DynDeleteRow").val()) + 1);
  });

  $(document).on('click', '#2DelRowDelete', function(e) {
    $(this).closest("tr").remove();
  });

  $("#btnSaveDel").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSaveDel' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=3',
      type: 'POST',
      data: $("#Delete2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnEditDel").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnEditDel' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=3edit',
      type: 'POST',
      data: $("#Delete2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnDupDel").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnDupDel' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=3',
      type: 'POST',
      data: $("#Delete2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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
  //Function form button
  $("#AddRowFunction").click(function(event) {
    $('#DynFunction').append("<tr id='trFuncDyn" + $("#DynFunctionRow").val() + "'><td><select class='form-control' name='FieldFunc[]'>"+
                          <?php
                            if($selFunc!=''){
                              //
                              $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                              $query = "SELECT CAST(param_list AS CHAR(1000) CHARACTER SET utf8) AS parameter FROM mysql.proc WHERE db = '".$data_h['db']."' AND NAME = '".$selFunc ."'";
                              $result = mysqli_query($id_mysql_tb,$query);
                              $data = mysqli_fetch_array($result);
                              //explode
                              $param2 = explode(",", $data['parameter']);
                              //loop
                              foreach ($param2 as $row) {
                                ?>
                                  "<option value='" + <?php echo "'". explode(' ',trim($row))[0] . "'"; ?> + "'>" + <?php echo "'". explode(' ',trim($row))[0] . "'"; ?> + "</option>" +
                                <?php
                              }
                            }
                          ?>
                            "</select></td><td><input class='form-control' type='textbox' value='' name='PrmFunc[]'></td><td>" + 
                            "<button id='DelRowFunction' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button>" +
                            "</td></tr>");
    $('#DynFunctionRow').val(parseInt($("#DynFunctionRow").val()) + 1);
  });

  $(document).on('click', '#DelRowFunction', function(e) {
    $(this).closest("tr").remove();
  });

  $("#btnSaveFunc").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSaveFunc' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=4',
      type: 'POST',
      data: $("#Function2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnEditFunc").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnEditFunc' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=4edit',
      type: 'POST',
      data: $("#Function2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnDupFunc").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnDupFunc' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=4',
      type: 'POST',
      data: $("#Function2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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
  //procedure button
  $("#AddRowProcedure").click(function(event) {
    $('#DynProcedure').append("<tr id='trProcDyn" + $("#DynProcedureRow").val() + "'><td><select class='form-control' name='FieldProc[]'>"+
                          <?php
                            if($selFunc!=''){
                              //
                              $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                              $query = "SELECT CAST(param_list AS CHAR(1000) CHARACTER SET utf8) AS parameter FROM mysql.proc WHERE db = '".$data_h['db']."' AND NAME = '".$selFunc ."'";
                              $result = mysqli_query($id_mysql_tb,$query);
                              $data = mysqli_fetch_array($result);
                              //explode
                              $param2 = explode(",", $data['parameter']);
                              //loop
                              foreach ($param2 as $row) {
                                ?>
                                  "<option value='" + <?php echo "'". explode(' ',trim($row))[0] . "'"; ?> + "'>" + <?php echo "'". explode(' ',trim($row))[0] . "'"; ?> + "</option>" +
                                <?php
                              }
                            }
                          ?>
                            "</select></td><td><input class='form-control' type='textbox' value='' name='PrmProc[]'></td><td>" + 
                            "<button id='DelRowProcedure' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button>" +
                            "</td></tr>");
    $('#DynProcedureRow').val(parseInt($("#DynProcedureRow").val()) + 1);
  });

  $(document).on('click', '#DelRowProcedure', function(e) {
    $(this).closest("tr").remove();
  });

  $("#btnSaveProc").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSaveProc' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=5',
      type: 'POST',
      data: $("#Procedure2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnEditProc").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnEditProc' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=5edit',
      type: 'POST',
      data: $("#Procedure2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnDupProc").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnDupProc' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=5',
      type: 'POST',
      data: $("#Procedure2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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
  //search form button
  $("#AddRowTableSearch").click(function(event) {
    $('#DynTableSearch').append("<tr id='trTableDyn" + $("#DynTableSearchRow").val() + "'><td><select class='form-control' name='TableSearch[]'>"+
                          <?php
                            if($selHost!=''){
                              //
                              $query_h = "SELECT * FROM tb_host WHERE id_host=" . $selHost;
                              $result_h = mysqli_query($id_mysql,$query_h);
                              $data_h = mysqli_fetch_array($result_h);
                              //
                              $id_mysql_tb = mysqli_connect($data_h['host'], $data_h['username'], $data_h['password'], $data_h['db']);
                              $query_tb = "SHOW TABLES";
                              $result_tb = mysqli_query($id_mysql_tb,$query_tb);
                              while($row = $result_tb->fetch_array()) {
                                ?>
                                  "<option value='" + <?php echo "'". $row[0] . "'"; ?> + "'>" + <?php echo "'". $row[0] . "'"; ?> + "</option>" +
                                <?php
                              }
                            }
                          ?>
                            "</select></td><td>" + 
                            "<button id='DelRowTableSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button>" +
                            "</td></tr>");
    $('#DynTableSearchRow').val(parseInt($("#DynTableSearcheRow").val()) + 1);
  });
  $(document).on('click', '#DelRowTableSearch', function(e) {
    $(this).closest("tr").remove();
  });
  //
  //value
  $("#AddRowSearch").click(function(event) {
    $('#DynSearch').append("<tr id='trSearchDyn" + $("#DynSearchRow").val() + "'><td><select class='form-control' name='FieldSearch[]'>"+
                           
                          <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    "<option value='" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "'>" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "</option>"+
                                  <?php
                                }
                              }
                            }
                          ?>
                            "</select></td><td><input class='form-control' type='textbox' value='' name='PrmSearch[]'></td><td>" + 
                            "<select class='form-control' name='TypOutputSearch[]''><option value='1'>String</option><option value='2'>Number</option><option value='3'>Currency</option></select></td><td>" +
                            "<button id='DelRowSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button>" +
                            "</td></tr>");
    $('#DynSearchRow').val(parseInt($("#DynSearchRow").val()) + 1);
  });

  $(document).on('click', '#DelRowSearch', function(e) {
    $(this).closest("tr").remove();
  });
//kunci
$("#2AddRowSearch").click(function(event) {
    $('#2DynSearch').append("<tr id='2trSearchDyn" + $("#2DynSearchRow").val() + "'><td><select class='form-control' name='2FieldSearch[]'>"+
                           
                          <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    "<option value='" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "'>" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "</option>"+
                                  <?php
                                }
                              }
                            }
                          ?>
                            "</select></td><td><input class='form-control' type='textbox' value='' name='2PrmSearch[]'></td>" + 
                            "<td><select class='form-control' name='2TypeSearch[]'><option value='='>=</option><option value='<'>&lt;</option><option value='<='>&lt;=</option><option value='>'>&gt;</option><option value='>='>&gt;=</option><option value='LIKE'>LIKE</option></select></td>" +
                            "<td><button id='2DelRowSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>" +
                            "</tr>");
    $('#2DynSearchRow').val(parseInt($("#2DynSearchRow").val()) + 1);
  });

  $(document).on('click', '#2DelRowSearch', function(e) {
    $(this).closest("tr").remove();
  });
  //order by
$("#AddRowOrderSearch").click(function(event) {
    $('#OrderSearch').append("<tr id='OrderSearch" + $("#OrderSearchRow").val() + "'><td><select class='form-control' name='OrderSearch[]'>"+
                           
                          <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    "<option value='" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "'>" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "</option>"+
                                  <?php
                                }
                              }
                            }
                          ?>
                            "</select></td>" + 
                            "<td><select class='form-control' name='OrderTypeSearch[]'><option value='1'>Ascending</option><option value='2'>Descending</option></select></td>" +
                            "<td><button id='DelRowOrderSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>" +
                            "</tr>");
    $('#OrderSearchRow').val(parseInt($("#OrderSearchRow").val()) + 1);
  });

  $(document).on('click', '#DelRowOrderSearch', function(e) {
    $(this).closest("tr").remove();
  });
//join
$("#3AddRowSearch").click(function(event) {
    $('#3DynSearch').append("<tr id='3trSearchDyn" + $("#2DynSearchRow").val() + "'><td><select class='form-control' name='Join1Search[]'>"+
                           
                          <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    "<option value='" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "'>" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "</option>"+
                                  <?php
                                }
                              }
                            }
                          ?>
                            "</select></td><td><select class='form-control' name='Join2Search[]'>"+
                          <?php
                            if(count($TableSearch)>0){
                              for ($i=0; $i<count($TableSearch); $i++) {
                                $query = "DESC " . $TableSearch[$i] ;
                                $result = mysqli_query($id_mysql_tb,$query);
                                while($row = $result->fetch_array()) {
                                  ?>
                                    "<option value='" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "'>" + <?php echo '"'. $TableSearch[$i].".".$row[0].'"'; ?> + "</option>"+
                                  <?php
                                }
                              }
                            }
                          ?>
                            "</select></td>" + 
                            "<td><button id='3DelRowSearch' type='button' class='btn btn-info pull-right ladda-button' data-color='red' data-size='xs' data-style='zoom-out'><span class='ladda-label'><i class='fa fa-minus'></i></span> Delete Row</button></td>" +
                            "</tr>");
    $('#3DynSearchRow').val(parseInt($("#3DynSearchRow").val()) + 1);
  });

  $(document).on('click', '#3DelRowSearch', function(e) {
    $(this).closest("tr").remove();
  });
  $("#btnSaveSearch").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnSaveSearch' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=6',
      type: 'POST',
      data: $("#Search2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnEditSearch").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnEditSearch' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=6edit',
      type: 'POST',
      data: $("#Search2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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

  $("#btnDupSearch").click(function(event) {
    var l = Ladda.create( document.querySelector( '#btnDupSearch' ) );
    l.start();
    $.ajax({
      url: 'keyword_act.php?t=6',
      type: 'POST',
      data: $("#Search2").serialize()
    })
    .done(function(data) {
      console.log(data);
      l.stop();
      if(data=="1"){
        window.location="keyword.php";
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