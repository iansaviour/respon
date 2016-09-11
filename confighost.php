<?php  
  include 'includes/core.php';
  checkAccess();
  include 'includes/top.php';
  $id=0;
  if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query = "SELECT * FROM tb_config_host cfg WHERE cfg.id_app=".$id." ";
    $result = mysqli_query($id_mysql, $query);
    $data = mysqli_fetch_array($result);
    $app_name = $data['app_name'];
  }else{
    $id=0;
    $app_name = "";
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Configuration Host
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Configuration Host</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row" id="panel-list">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">List Application</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp; Add</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="example" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Application</th>
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
        <div class="alert alert-success" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Edit successfully</span>
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
                <label for="input-app-name" class="col-sm-2 control-label">Application</label>
                <div class="col-sm-10">
                  <input type="hidden" name="txtId" value="<?php echo $id; ?>">
                  <input type="textbox" class="form-control" id="input-app-name" name="txtAppName" placeholder="Application Name" value="<?php echo $app_name; ?>">
                 <!--  <input type="checkbox" checked="checked"> -->
                </div>
              </div>

              <?php if($id!="0"){ ?>
              <div class="form-group">
                <label for="input-path" class="col-sm-2 control-label">Folder Path</label>
                <div class="col-sm-10">
                  <input type="textbox" class="form-control" readonly="readonly" id="input-path" name="txtAppPath" value="<?php echo "output/".$id."/"; ?>">
                 <!--  <input type="checkbox" checked="checked"> -->
                </div>
              </div>
              <?php } ?>
              
              <div id="panel-key">
                <h3>Keyword List</h3><hr>
                <div id="loading-process" style="display:none;">Please wait...</div>
                <div id="table-detail">
                  <table class="table table-striped" id="example2" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Id Operasi</th>
                        <th>Keyword</th>
                        <th>Nama Operasi</th>
                        <th>Login Required</th>
                        <th>Select</th>
                      </tr>
                    </thead>
                  </table>
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

    $("#input-inbox-table").attr("disabled", "disabled"); 
    $("#input-outbox-table").attr("disabled", "disabled"); 
  }else{
    $("#panel-key").hide();
  }

  $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "confighost_act.php?t=2",
      "order": [[ 1, "desc" ]]
  } );

  $('#example2').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "confighost_act.php?t=4&o="+id+" ",
      "order": [[ 4, "desc" ]],
      "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
  } );

  $("#btn-add").click(function(event) {
    $("#panel-list").hide()
    $("#panel-form").fadeIn('slow');
  });

  $("#btnSave").click(function(event) {
      var l = Ladda.create( document.querySelector( '#btnSave' ) );
      l.start();
      $.ajax({
        url: 'confighost_act.php?t=1',
        type: 'POST',
        data: $("#formControl").serialize()
      })
      .done(function(data) {
        l.stop();
        $("#alertInfo").html(data);
        if(data.indexOf("Error")>-1){
          //$("#alertInfo").show();
        }else{
          window.location="confighost.php?id="+data+"";
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    });

     $("#example2").on('click', '.check-id',function(e) {
        var op =$(this).data('id');
        var det = $(this).data('det');
        var cond ="";
        if ($(this).prop('checked')==true){ 
          cond="true";
        }else{
          cond="false";
        }
        var jqXHR = $.ajaxq('MyQueue', {
            url: 'confighost_act.php?t=5&c='+cond+'&app='+id+'&o='+op+'&d='+det+'',
            beforeSend: function() {
              $("#table-detail").hide();
              $("#loading-process").fadeIn("slow");
            },
            error: function() {
              console.log("error");
            },
            complete: function() {
              console.log("complete");
            },
            success: function(data) {
              console.log("success");
              if(data=='1'){
                $("#loading-process").hide();
                $("#table-detail").show();
              }else{
                $("#loading-process").html("Error : "+data);
              }
            }
          });
    });

});
</script>