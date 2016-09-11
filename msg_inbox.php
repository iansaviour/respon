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
      Messaging
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Inbox</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- table  -->
    <div class="row" id="panel-form-inbox" >
      <div class="col-lg-12 col-xs-12">
      <form class="form-horizontal" id="formView" method="GET">
        <div class="box box-primary">
          <div class="box-body">
            <div class="box-body">
              <h3>Inbox</h3><hr>
              <div class="form-group">
                <label for="input-inbox-table" class="col-sm-2 control-label">Service</label>
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
    <!-- table inbox -->
    <div class="row" id="panel-inbox" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Inbox</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-refresh-inbox" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i>&nbsp; Refresh</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="inbox" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Id Service</th>
                    <th>Sender</th>
                    <th>Server</th>
                    <th>Date</th>
                    <th>Flag</th>
                    <th>Message</th>
                    <th>Option</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end table inbox -->
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
    $('#inbox').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "msg_inbox_act.php?t=inbox&id_service=<?php echo $id_service; ?>",
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
    });
    $("#panel-inbox").fadeIn('slow');
    <?php
  }
?>
  $("#btn-refresh-inbox").click(function(event) {
    window.location="msg_inbox.php" + <?php echo $penanda ?>;
  });
});
</script>