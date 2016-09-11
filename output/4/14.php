<?php  include "includes/core.php"; ?><?php checkOPLogin(); ?><?php  
			  if(!isset($_GET["t"])){
			  include "includes/top.php";
			?>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
			  <!-- Content Header (Page header) -->
			  <section class="content-header">
			    <h1>
			      Operasi
			      <small>Form Panel</small>
			    </h1>
			    <ol class="breadcrumb">
			      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			      <li class="active">Operasi</li>
			    </ol>
			  </section>

			  <!-- Main content -->
			  <section class="content">
			    <div class="row" id="panel-form">
			      <div class="col-lg-12 col-xs-12">
			        <div class="box box-primary">
			          <div class="box-header with-border">
			            <h3 class="box-title">Mencari NIP Login</h3>
			          </div><!-- /.box-header -->
			          <div class="box-body">
			          <form class="form-horizontal" id="formControl">
			            <div class="box-body">
			              <div class="form-group">
			                <label for="input-via" class="col-sm-2 control-label">Service</label>
			                <div class="col-sm-10">
			                  <input type="hidden" name="keyword" value="NIPLOGIN">
			                  <select class="form-control" id="input-via" name="comboSvc">
			                  <?php  
			                  $str = file_get_contents("apps.json");
			                  $data = json_decode($str, true); 
			                  $i = 0;
			                  foreach ($data as $datax) {
			                    echo"<option value=\"$datax[id_service]\">$datax[service]</option>";
			                  }
			                  ?>
			                  </select>
			                </div>
			              </div>
			              	<div class="form-group">
				                <label for="input0" class="col-sm-2 control-label">NAMA</label>
				                <div class="col-sm-10">
				                  <input type="textbox" class="form-control" id="input0" name="box[]">
				                </div>
				            </div>
			              	</div><!-- /.box-body -->
			            <div class="box-footer">
			              <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-success pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-send"></i> Send</span></button>
			            </div><!-- /.box-footer -->
			          </form>
			          </div><!-- /.box-body -->
			        </div>
			      </div>
			    </div><!-- /.row -->

			    <div class="row">
			      <div class="col-md-12">
			        <div class="box box-success">
			          <div class="box-header with-border">
			            <h3 class="box-title">Result</h3>
			          </div>
			          <div class="box-body" id="output">
			            
			          </div><!-- /.box-body -->
			        </div>
			      </div>
			    </div>
			  </section><!-- /.content -->
			</div><!-- /.content-wrapper -->


			<?php  
			  include "includes/bottom.php";
			?>
			<script type="text/javascript">
			var intv;
			var id = 0;
			function getInbox(){
			  clearInterval(intv);
			  var jqXHR = $.ajaxq("MyQueue", {
			    url: "14.php?t=ibx&id="+id+"&svc="+$("#input-via").val(),
			    beforeSend: function() {
			       
			    },
			    error: function() {
			      console.log("error");
			    },
			    complete: function() {
			      console.log("complete");
			    },
			    success: function(data) {
			      var dt=$.trim(data);
			      console.log("success");
			      if(dt==""){
			        intv = setInterval(function() {getInbox();}, 3000);
			      }else{
			        var l = Ladda.create( document.querySelector("#btnSave") );
			        l.stop();
			        $("#output").html(dt);
			      }
			    }
			  });
			}
			$(document).ready(function() {
			  $("#btnSave").click(function(event) {
			  	$("#output").html("");
			    var l = Ladda.create( document.querySelector("#btnSave") );
			    l.start();
			    $.ajax({
			      url: "14.php?t=save",
			      type: "POST",
			      data: $("#formControl").serialize()
			    })
			    .done(function(data) {
			      console.log(data);
			      var dt=$.trim(data);
			      if(dt.indexOf("Error")>-1){
			        $("#output").html(data);
			      }else{
			        id=dt;
			        getInbox();
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
			<?php  
			  }elseif ($_GET["t"]=="save") {
			    $via = $_POST["comboSvc"];
			    $test = $_POST["box"];
			    $keyword = $_POST["keyword"];
			    $outbox ="";
			    for ($i=0; $i<count($test) ; $i++) { 
			      if($i>0){
			        $outbox.="#";
			      }
			      $outbox = $outbox.$test[$i];
			    }

			    $output = "";
				$str = file_get_contents("apps.json");
			    $data = json_decode($str, true); 
			    $i = 0;
			    foreach ($data as $datax) {
			      if($datax["id_service"]==$via){
			        $query_ins = "INSERT INTO  $datax[outbox_table]($datax[outbox_content], $datax[outbox_date], $datax[outbox_flag])";
				    $query_ins = $query_ins."VALUES('$outbox','".date("Y-m-d")."', '1') ";
				    $result_ins = mysqli_query($id_mysql, $query_ins);
			      	if ($result_ins) {
			          $output= mysqli_insert_id($id_mysql);
			          $query_upd = "UPDATE $datax[outbox_table] SET $datax[outbox_content]='HOST#$output#$keyword#$outbox' WHERE id='$output'";
			          $result_upd = mysqli_query($id_mysql, $query_upd);
			        }else{
			          $output="Error";
			        }
			      }
			    }
			    echo $output;
			  }elseif ($_GET["t"]=="ibx"){
			    $id_service = $_GET["svc"];
			    $id=$_GET["id"];

			    $str = file_get_contents("apps.json");
			    $data = json_decode($str, true); 
			    $i = 0;
			    $output = "";
			    foreach ($data as $datax) {
			      if($datax["id_service"]==$id_service){
			        $query = "SELECT * FROM $datax[inbox_table] a WHERE $datax["inbox_content"] LIKE '$id#%'";
			        $result = mysqli_query($id_mysql, $query);
			        $jum = mysqli_num_rows($result);
			        if($jum==0){
			          $output="";
			        }else{
			          $data2  = mysqli_fetch_array($result);
			          $output_arr = explode("#", $data2[$datax["inbox_content"]]); 
			          $output = $output_arr[1];
			        }   
			      }
			    }
			    echo $output;
			  }
			?>
			