<?php 
include 'includes/core.php';
$type= $_GET['t'];
$id_service = '';
if(isset($_GET['id_service'])){
	$id_service = $_GET['id_service'];
}
if($type=='1'){
	$contact_name = makeSafe($_POST['txtContactName']);
	$contact_id = makeSafe($_POST['txtContactID']);

	$query = "INSERT INTO tb_contact(id_service,contact_name,contact_id) VALUES('".$id_service."','".$contact_name."','".$contact_id."')";
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
}
elseif($type=='contact') {
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
	$table = "(SELECT '' as x,id_contact,contact_name,contact_id,id_service FROM tb_contact WHERE id_service='" . $id_service . "') temp";

	// Table's primary key
	$primaryKey = 'id_contact';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'x', 'dt' => 0 ),
	    array( 'db' => 'id_contact', 'dt' => 1 ),
	    array( 'db' => 'contact_name', 'dt' => 2 ),
	    array( 'db' => 'contact_id',   'dt' => 3 ),
	    array( 'db' => 'id_service',   'dt' => 4 ),
	    array( 
	    	'db'        => 'id_contact',
	        'dt'        => 5,
	        'formatter' => function( $d, $row ) {
	        	//
	        	return "<a href='msg_new.php?contact=1&id=".$row[1]."'>"."<i class='fa fa-envelope'></i>"."</a>&nbsp<a href='contact_act.php?id=$d&t=2&id_service=".$row[4]."&id_contact=".$row[1]."'>"."<i class='fa fa-trash' onclick=\"return confirm('Are you sure you want to delete this contact?')\"></i>"."</a>";
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
	$id_contact=$_GET['id_contact'];

	try {
		/*remove svc*/
		$query_del = "DELETE FROM tb_contact WHERE id_contact=$id_contact";
		$result_del = mysqli_query($id_mysql,$query_del);
		if($result_del){
			header("Location:contact.php?selService=" . $id_service);
		}else{
			echo "Delete error. <a href='contact.php?selService=" . $id_service."'>Back to home</a>";
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}
}
?>