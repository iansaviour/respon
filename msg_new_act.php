<?php 
include 'includes/core.php';
$type= $_GET['t'];
if(isset($_GET['id'])){
	$id=$_GET['id'];
}

if ($type=='1') {
	$service = makeSafe($_POST['selService']);
	$server = makeSafe($_POST['txtServer']);
	$recipient = makeSafe($_POST['txtRecipient']);
	$message = makeSafe($_POST['txtMessage']);
	//
	$recipient_array = explode(";",$recipient);
	//
	$queryx = "SELECT * FROM tb_service WHERE id_service='" . $service . "'";
	$resultx = mysqli_query($id_mysql,$queryx);
	$rowx = mysqli_fetch_array($resultx);
	//
	$outbox_table = $rowx['outbox_table'];
    $outbox_isi = $rowx['outbox_content'];
    $outbox_date = $rowx['outbox_date'];
    $outbox_flag = $rowx['outbox_flag'];
    $outbox_recipient = $rowx['outbox_recipient'];
    $outbox_server = $rowx['outbox_server'];
    //
	$query = "";
	//
	if(count($recipient_array)>1){
		$query = "INSERT INTO " .$outbox_table. "(" .$outbox_isi. "," .$outbox_date. "," .$outbox_recipient. "," .$outbox_server. ") VALUES";
		for ($i=0; $i<count($recipient_array); $i++) {
			if($i!=0){
				$query = $query . ",";
			}
			$query = $query . "('".$message."',NOW(),'".$recipient_array[$i]."','".$server."')";
		}
	}else{
		$query = "INSERT INTO " .$outbox_table. "(" .$outbox_isi. "," .$outbox_date. "," .$outbox_recipient. "," .$outbox_server. ") VALUES ('".$message."',NOW(),'".$recipient_array[0]."','".$server."')";
	}

	try {
		$result = mysqli_query($id_mysql,$query);
		if ($result) {
			echo "1";
		}else{
			echo"Error executing query.";
		}	
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
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
	    array( 'db' => 'id_app', 'dt' => 0 ),
	    array( 'db' => 'app_name',   'dt' => 1 ),
	    array( 
	    	'db'        => 'id_app',
	        'dt'        => 2,
	        'formatter' => function( $d, $row ) {
	            return "<a href='config_host.php?t=1&id=$d'>"."<i class='fa fa-sitemap'></i>"."</a>&nbsp<a href='keyword.php?t=2&id=$d'>"."<i class='fa fa-pencil'></i>"."</a>&nbsp<a href='keyword.php?t=3&id=$d'>"."<i class='fa fa-trash'></i>"."</a>";
	        }
	    )
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
	$table = " ( SELECT cd.id_app_det,cd.id_app,op.id_operasi,op.nama_operasi FROM tb_config_host_det cd INNER JOIN tb_operasi op ON op.id_operasi=cd.id_operasi WHERE cd.id_app=". $id ." ) temp";
	 
	// Table's primary key
	$primaryKey = 'id_app_det';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_app_det', 'dt' => 0 ),
	    array( 'db' => 'id_app',   'dt' => 1 ),
	    array( 'db' => 'nama_operasi',   'dt' => 2 ),
	    array( 
	    	'db'        => 'id_app_det',
	        'dt'        => 3,
	        'formatter' => function( $d, $row ) {
	            return "<a href='config_host.php?t=1&id=$d'>"."<i class='fa fa-sitemap'></i>"."</a>&nbsp<a href='keyword.php?t=2&id=$d'>"."<i class='fa fa-pencil'></i>"."</a>&nbsp<a href='keyword.php?t=3&id=$d'>"."<i class='fa fa-trash'></i>"."</a>";
	        }
	    )
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
}


?>