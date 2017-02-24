<?php 
include 'includes/core.php';
$type= $_GET['t'];
$id_contact_group = '';
if(isset($_GET['selCG'])){
	$id_contact_group = $_GET['selCG'];
}
if($type=='1'){
	$contact_name = makeSafe($_POST['txtGroupContactName']);
	$id_service = makeSafe($_POST['selService']);

	$query = "INSERT INTO tb_contact_group(id_service,contact_group) VALUES('".$id_service."','".$contact_name."')";
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
	$table = "(SELECT cont.id_contact,cont.contact_name,cont.contact_id,IF(ISNULL(gd.id_contact_group),2,1) AS member,gd.id_contact_group_det,'" . $id_contact_group . "' as id_contact_group 		FROM tb_contact cont
				LEFT JOIN tb_contact_group_det gd ON gd.id_contact=cont.id_contact AND gd.id_contact_group='".$id_contact_group."'
				WHERE id_service=(SELECT id_service FROM tb_contact_group WHERE id_contact_group='".$id_contact_group."') AND ISNULL(gd.id_contact_group)) temp";

	// Table's primary key
	$primaryKey = 'id_contact';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
		array( 'db' => 'id_contact', 'dt' => 0 ),
		array( 'db' => 'contact_name', 'dt' => 1),
	    array( 'db' => 'contact_id', 'dt' => 2 ),
	    array( 'db' => 'member', 'dt' => 3 ),
	    array( 'db' => 'id_contact_group_det', 'dt' => 4 ),
	    array( 
	    	'db'        => 'id_contact_group',
	        'dt'        => 5,
	        'formatter' => function( $d, $row ) {
	        	//
	        	return "<a href='group_contact_add_act.php?t=2&id_contact=".$row[0]."&selCG=$d'>"."<i id='Plus". $row[0] ."' class='fa fa-plus'></i>"."</a>";
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
	$id=$_GET['id_contact'];
	$id_grup=$_GET['selCG'];

	try {
		/*remove svc*/
		$query_del = "DELETE FROM tb_contact_group_det WHERE id_contact_group='".$id_grup."' AND id_contact='".$id."'; INSERT INTO tb_contact_group_det(id_contact_group,id_contact) VALUES('".$id_grup."','".$id."');";
		$result_del = mysqli_multi_query($id_mysql,$query_del);
		if($result_del){
			header("Location:group_contact_add.php?selCG=" . $id_contact_group);
		}else{
			echo "Insert erraor. <a href='group_contact_add.php?selCG=" . $id_contact_group."'>Back to home</a>";
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}
}
?>