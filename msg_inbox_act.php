<?php 
include 'includes/core.php';
$type= $_GET['t'];
$id_service = '';
if(isset($_GET['id_service'])){
	$id_service = $_GET['id_service'];
}
if($type=='inbox') {
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
	$queryx = "SELECT * FROM tb_service WHERE id_service='" . $id_service . "' LIMIT 1";
	$resultx = mysqli_query($id_mysql,$queryx);
	$row = $resultx->fetch_array();
	$table = "(SELECT id,'" . $id_service . "' AS id_service,". $row['inbox_sender'] ." as sender,". $row['inbox_server'] ." as server,". $row['inbox_date'] ." as date,". $row['inbox_flag'] ." as flag,". $row['inbox_content'] ." as isi FROM ". $row['inbox_table'] .") temp";

	// Table's primary key
	$primaryKey = 'id';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id', 'dt' => 0 ),
	    array( 'db' => 'id_service', 'dt' => 1 ),
	    array( 'db' => 'sender',   'dt' => 2 ),
	    array( 'db' => 'server',   'dt' => 3 ),
	    array( 'db' => 'date',   'dt' => 4 ),
	    array( 'db' => 'flag',   
	    	   'dt' => 5,
	    	   'formatter' => function( $d, $row ) {
		            if($d == "1"){
		            	return "Belum diproses";
		            }else{
		            	return "Sudah diproses";
		            }
		        }
	    	),
	    array( 'db' => 'isi',   'dt' => 6 ),
	    array( 
	    	'db'        => 'id',
	        'dt'        => 7,
	        'formatter' => function( $d, $row ) {
	        	//
	        	return "<a href='msg_new.php?reply=1&id=$d&id_service=".$row[1]."'>"."<i class='fa fa-mail-reply'></i>"."</a>&nbsp<a href='msg_inbox_act.php?id=$d&t=2&id_service=".$row[1]."'>"."<i class='fa fa-trash' onclick=\"return confirm('Are you sure you want to delete this message?')\"></i>"."</a>";
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
}elseif ($type=='2') {//delete
	$id_service=$_GET['id_service'];
	$id=$_GET['id'];

	$query = "SELECT * FROM tb_service WHERE id_service=$id_service";
	$result = mysqli_query($id_mysql,$query);
	$data = mysqli_fetch_array($result);

	try {
		/*remove svc*/
		$query_del = "DELETE FROM ". $data["inbox_table"] ." WHERE id=$id";
		$result_del = mysqli_query($id_mysql,$query_del);
		if($result_del){
			header("Location:msg_inbox.php?selService=" . $id_service);
		}else{
			echo "Delete error. <a href='msg_inbox.php?selService=" . $id_service."'>Back to home</a>";
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}
}
?>