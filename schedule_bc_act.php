<?php 
include 'includes/core.php';
$type= $_GET['t'];
if ($type=='1') {
	$id = makeSafe($_POST['txtId']);
	$name = makeSafe($_POST['txtName']);
	$id_contact_group = makeSafe($_POST['selCG']);
	$server = makeSafe($_POST['txtServer']);
	$message = makeSafe($_POST['txtMessage']);
	//
	$time_var = makeSafe($_POST['txtTimeVar']);
	$tipe_time = makeSafe($_POST['selTypeTime']);
	$is_now = makeSafe($_POST['selTypeStart']);
	$start_date = makeSafe($_POST['TxtDate']);
	$start_time = makeSafe($_POST['TxtTime']);
	//string
	if($tipe_time == "1"){
		$stipe = "SECOND";
	}elseif($tipe_time == "2"){
		$stipe = "MINUTE";
	}elseif($tipe_time == "3"){
		$stipe = "HOUR";
	}elseif($tipe_time == "4"){
		$stipe = "DAY";
	}elseif($tipe_time == "5"){
		$stipe = "WEEK";
	}elseif($tipe_time == "6"){
		$stipe = "MONTH";
	}
	if($is_now == "1"){
		$snow = "NOW()";
	}else{
		$snow = "'" . $start_date . " " . $start_time . "'";
	}
	//
	if($id==0){
		try {
			$query = "INSERT INTO tb_bc_sch(name,id_contact_group,server,message,time_var,tipe_time,is_now,start_date,start_time) VALUES('" . $name  . "','" . $id_contact_group . "','" . $server . "','" . $message . "','" . $time_var . "','" . $tipe_time . "','" . $is_now . "','" . $start_date . "','" . $start_time . "')";
			$result = mysqli_query($id_mysql,$query);
			$id = mysqli_insert_id($id_mysql);
			if ($result) {
				//add event broadcast
				$query_event = "
								CREATE EVENT bc_" . $id . "

								ON SCHEDULE
									 EVERY " . $time_var . " " . $stipe . "
									 STARTS " . $snow . "
								DO
									BEGIN
									    CALL broadcast('" . $id . "');
									END";
				$result_event = mysqli_query($id_mysql,$query_event);
				$query_event = "SET GLOBAL event_scheduler = ON";
				$result_event = mysqli_query($id_mysql,$query_event);

				svcToJson("");
				echo"1";
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
	$table = "(SELECT sch.id_bc_sch,name,cg.contact_group,sch.server FROM tb_bc_sch sch INNER JOIN tb_contact_group cg ON cg.id_contact_group=sch.id_contact_group) temp";
	 
	// Table's primary key
	$primaryKey = 'id_bc_sch';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_bc_sch',   'dt' => 0 ),
	    array( 'db' => 'name',   'dt' => 1 ),
	    array( 'db' => 'contact_group',   'dt' => 2 ),
	    array( 'db' => 'server',   'dt' => 3 ),
	    array(
	        'db'        => 'id_bc_sch',
	        'dt'        => 4,
	        'formatter' => function( $d, $row ) {
	            return "<a href='schedule_bc_act.php?t=3&id=$d' onclick=\"return confirm('Are you sure you want to delete this services?')\" title=\"Delete\">Delete</a>";
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
	$query = "SELECT * FROM tb_service WHERE id_service=$id";
	$result = mysqli_query($id_mysql,$query);
	$data = mysqli_fetch_array($result);

	try {
		/*remove event*/
		$query_event = 'DROP EVENT bc_' . $id;
		$result_event = mysqli_query($id_mysql,$query_event);

		/*remove svc*/
		$query_del = "DELETE FROM tb_bc_sch WHERE id_bc_sch=$id";
		$result_del = mysqli_query($id_mysql,$query_del);
		if($result_del){
			header("Location:schedule_bc.php");
		}else{
			echo"Delete error. <a href='schedule_bc.php'>Back to home</a>";
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}
}
?>