<?php 
include 'includes/core.php';
$type= $_GET['t'];
if ($type=='1') {
	$id = makeSafe($_POST['txtId']);
	$app_name = makeSafe($_POST['txtAppName']);
	if ($id=="0") {
		try {
			$query = "INSERT INTO tb_config_host(app_name) VALUES ('$app_name')";
			$result = mysqli_query($id_mysql,$query);
			$id_new = mysqli_insert_id($id_mysql);
			if ($result) {
				try {
					mkdir("output/".$id_new, 0777, true);
					recurse_copy("bootstrap", "output/".$id_new."/bootstrap");
					recurse_copy("build", "output/".$id_new."/build");
					recurse_copy("dist", "output/".$id_new."/dist");
					recurse_copy("includes", "output/".$id_new."/includes");
					recurse_copy("plugins", "output/".$id_new."/plugins");
					copy("dashboard.php", "output/".$id_new."/index.php");
					copy("login_op.php", "output/".$id_new."/login_op.php");
					copy("logout.php", "output/".$id_new."/logout.php");
					svcToJson("output/".$id_new."/");
					createOPJson("output/".$id_new."/", $id_new);
					echo $id_new;
				} catch (Exception $e) {
					 $query_del = "DELETE FROM tb_config_host WHERE id_app='$id_new' ";
				     $result_del = mysqli_query($id_mysql, $query_del);
				     echo 'Error : ',  $e->getMessage(), "<br>";
				}
			}else{
				echo"Error executing query.";
			}	
		} catch (Exception $e) {
			echo 'Error : ',  $e->getMessage(), "<br>";
		}	
	}else{
		try {
			$query = "UPDATE tb_config_host SET app_name='$app_name' WHERE id_app='$id' ";
			$result=mysqli_query($id_mysql, $query);
			if ($result) {
				svcToJson("output/".$id."/");
				createOPJson("output/".$id."/", $id);
				echo $id;
			}else{
				echo"Error executing query.";
			}	
		} catch (Exception $e) {
			echo 'Error : ',  $e->getMessage(), "<br>";
		}
	}
}elseif ($type=='2') {
	/*
	 * DataTables example server-side processing script.
	 *
	 * Please note that this script is intentionally extremely simply to show how
	 * server-side processing can be implemented, and probably shouldn't be used as
	 * the basis for a large complex system. It is suitable for simple use cases as
	 * for learning.
	 *
	 * See http://datatables.net/usage/server-side for full details on the server-
	 * side processing requirements of DataTables.
	 *
	 * @license MIT - http://datatables.net/license_mit
	 */
	 
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	 
	// DB table to use
	$table = 'tb_config_host';
	 
	// Table's primary key
	$primaryKey = 'id_app';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'app_name',   'dt' => 0 ),
	    array(
	        'db'        => 'id_app',
	        'dt'        => 1,
	        'formatter' => function( $d, $row ) {
	            return "<a href='confighost.php?id=$d' title='Edit'><i class='fa fa-edit'></i> <a href='confighost_act.php?t=3&id=$d' onclick=\"return confirm('Are you sure you want to delete this services?')\" title=\"Delete\"><i class='fa fa-trash'></i></a>";
	        }
	    ),
	);
	 
	// SQL server connection information
	//connectMyDB($server_dev, $username_dev, $password_dev, $name_dev);
	$sql_details = array(
	    'user' => $username_dev,
	    'pass' => $password_dev,
	    'db'   => $name_dev,
	    'host' => $server_dev
	);
	 
	 
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	 
	require( 'ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
	);
}elseif ($type=='3') {
	$id=$_GET['id'];
	/*remove*/
	if (delete_directory("output/".$id)) {
		$query_del = "DELETE FROM tb_config_host WHERE id_app=$id";
		$result_del = mysqli_query($id_mysql,$query_del);
		if($result_del){
			header("Location:confighost.php");
		}else{
			echo"Delete error. <a href='confighost.php'>Back to home</a>";
		}
	}else{
		echo"Delete error. <a href='confighost.php'>Back to home</a>";
	}
	
}elseif ($type=='4') {
	/*
	 * DataTables example server-side processing script.
	 *
	 * Please note that this script is intentionally extremely simply to show how
	 * server-side processing can be implemented, and probably shouldn't be used as
	 * the basis for a large complex system. It is suitable for simple use cases as
	 * for learning.
	 *
	 * See http://datatables.net/usage/server-side for full details on the server-
	 * side processing requirements of DataTables.
	 *
	 * @license MIT - http://datatables.net/license_mit
	 */
	 
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	 
	// DB table to use
	$id=$_GET['o'];
	$table = " (SELECT o.id_operasi, o.keyword, o.nama_operasi, IF(ISNULL(cfg_det.id_app_det),'0', cfg_det.id_app_det) AS `id_app_det`,
	IF(o.penanda_login='1', 'Yes', 'No') AS `login_required`
	FROM tb_operasi o 
	LEFT JOIN tb_config_host_det cfg_det ON cfg_det.id_operasi = o.id_operasi AND cfg_det.id_app='$id' 
	ORDER BY o.nama_operasi ASC) temp";
	 
	// Table's primary key
	$primaryKey = 'id_app_det';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_operasi',   'dt' => 0 ),
	    array( 'db' => 'keyword',   'dt' => 1 ),
	    array( 'db' => 'login_required',   'dt' => 3 ),
	    array( 'db' => 'nama_operasi',   'dt' => 2 ),
	    array(
	        'db'        => 'id_app_det',
	        'dt'        => 4,
	        'formatter' => function( $d, $row ) {
	            if ($d!="0") {
	            	return"<input class='check-id' data-det='$d' data-id='$row[0]' type='checkbox' checked='checked'>";
	            }else{
	            	return"<input class='check-id' data-det='$d' data-id='$row[0]' type='checkbox'>";
	            }
	        }
	    ),
	);
	 
	// SQL server connection information
	//connectMyDB($server_dev, $username_dev, $password_dev, $name_dev);
	$sql_details = array(
	    'user' => $username_dev,
	    'pass' => $password_dev,
	    'db'   => $name_dev,
	    'host' => $server_dev
	);
	 
	 
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	 
	require( 'ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
	);
}elseif ($type=="5") {
	/*action for config det*/
	$checked = $_GET['c'];
	$id_app = $_GET['app'];
	$id_operasi = $_GET['o'];
	
	if ($checked=="true") {
		/*get opt*/
		$query_option = "SELECT * FROM tb_option";
		$result_option = mysqli_query($id_mysql, $query_option);
		$data_option = mysqli_fetch_array($result_option);
		$char_pemisah = $data_option['char_pemisah'];

		/*get nama operasi*/
		$query_op = "SELECT a.nama_operasi,a.penanda_login, a.keyword FROM tb_operasi a WHERE a.id_operasi='$id_operasi'";
		$result_op = mysqli_query($id_mysql, $query_op);
		$data_op = mysqli_fetch_array($result_op);

		/*insert*/
		$query="INSERT tb_config_host_det(id_app,id_operasi) VALUES('$id_app', '$id_operasi') ";
		try {
			$result = mysqli_query($id_mysql,$query);
			$pagename = mysqli_insert_id($id_mysql);
			$newFileName = 'output/'.$id_app.'/'.$pagename.".php";
			$newFileContent = '<?php  include "includes/core.php"; ?>';
			if($data_op['penanda_login']=="1"){
				$newFileContent = $newFileContent.'<?php checkOPLogin(); ?>'; 
			}
			$newFileContent=$newFileContent.'<?php  
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
			            <h3 class="box-title">'.$data_op['nama_operasi'].'</h3>
			          </div><!-- /.box-header -->
			          <div class="box-body">
			          <form class="form-horizontal" id="formControl">
			            <div class="box-body">
			              <div class="form-group">
			                <label for="input-via" class="col-sm-2 control-label">Service</label>
			                <div class="col-sm-10">
			                  <input type="hidden" name="keyword" value="'.$data_op['keyword'].'">
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
			              </div>';
			              
			              $query_par = "SELECT a.nama_parameter FROM tb_operasi_parameter a WHERE a.id_operasi='$id_operasi' ORDER BY a.id_operasi_parameter ASC";
			              $result_par = mysqli_query($id_mysql, $query_par);
			              $i_par=0;
			              while ($data_par=mysqli_fetch_array($result_par)) {
			              	$newFileContent=$newFileContent.'
			              	<div class="form-group">
				                <label for="input'.$i_par.'" class="col-sm-2 control-label">'.$data_par['nama_parameter'].'</label>
				                <div class="col-sm-10">
				                  <input type="textbox" class="form-control" id="input'.$i_par.'" name="box[]">
				                </div>
				            </div>
			              	';
			              	$i_par=$i_par+1;
			              }

			              
			             
			            $newFileContent=$newFileContent.'</div><!-- /.box-body -->
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
			    url: "'.$pagename.'.php?t=ibx&id="+id+"&svc="+$("#input-via").val(),
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
			      url: "'.$pagename.'.php?t=save",
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
			        $outbox.="'.$char_pemisah.'";
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
				    $query_ins = $query_ins."VALUES(\'$outbox\',\'".date("Y-m-d")."\', \'1\') ";
				    $result_ins = mysqli_query($id_mysql, $query_ins);
			      	if ($result_ins) {
			          $output= mysqli_insert_id($id_mysql);
			          $query_upd = "UPDATE $datax[outbox_table] SET $datax[outbox_content]=\'HOST'.$char_pemisah.'$output'.$char_pemisah.'$keyword'.$char_pemisah.'$outbox\' WHERE id=\'$output\'";
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
			        $query = "SELECT * FROM $datax[inbox_table] a WHERE $datax["inbox_content"] LIKE \'$id'.$char_pemisah.'%\'";
			        $result = mysqli_query($id_mysql, $query);
			        $jum = mysqli_num_rows($result);
			        if($jum==0){
			          $output="";
			        }else{
			          $data2  = mysqli_fetch_array($result);
			          $output_arr = explode("'.$char_pemisah.'", $data2[$datax["inbox_content"]]); 
			          $output = $output_arr[1];
			        }   
			      }
			    }
			    echo $output;
			  }
			?>
			';
			if(file_put_contents($newFileName,$newFileContent)!=false){
			   echo "1";
			}else{
			    echo "Cannot create file (".basename($newFileName).")";
			}
		} catch (Exception $e) {
			echo 'Error : ',  $e->getMessage(), "<br>";
			$query="DELETE FROM tb_config_host_det WHERE id_app='$id_app' AND id_operasi='$id_operasi' ";
			try {
				$result = mysqli_query($id_mysql,$query);
			} catch (Exception $e) {
			}
		}
	}else{
		/*delete*/
		$query_app_det = "SELECT id_app_det FROM tb_config_host_det WHERE id_app='$id_app' AND id_operasi='$id_operasi' ";
		$result_app_det = mysqli_query($id_mysql, $query_app_det);
		$data_app_det = mysqli_fetch_array($result_app_det);
		$id_app_det = $data_app_det['id_app_det'];

		$query="DELETE FROM tb_config_host_det WHERE id_app_det='$id_app_det' ";
		try {
			$pagename = $id_app_det;
			$newFileName = 'output/'.$id_app.'/'.$pagename.".php";
			unlink($newFileName);
			$result = mysqli_query($id_mysql,$query);
			echo"1";
		} catch (Exception $e) {
			echo 'Error : ',  $e->getMessage(), "<br>";
		}
	}
}


?>