<?php 
include 'includes/core.php';
$type= $_GET['t'];
if(isset($_GET['id'])){
	$id=$_GET['id'];
}

if ($type=='1') {
	$username = isset($_POST['txtUsername']) ? makeSafe($_POST['txtUsername']) : '';
	$password = isset($_POST['txtPassword']) ? makeSafe($_POST['txtPassword']) : '';
	$field_identifier = isset($_POST['fieldId']) ? makeSafe($_POST['fieldId']) : '';
	$value_identifier = isset($_POST['valId']) ? makeSafe($_POST['valId']) : '';
	$id_user_role = isset($_POST['role']) ? makeSafe($_POST['role']) : '';

	try {
		$query = "INSERT INTO tb_m_user(username,password,id_user_role,identifier_login,value_identifier) VALUES ('$username',MD5('$password'),'$id_user_role','$field_identifier','$value_identifier')";
		$result = mysqli_query($id_mysql,$query);
		if (!$result) {
			echo"Error executing query.";
		}else{
			echo "1";
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='2') {
	$id_user = isset($_POST['idUser']) ? makeSafe($_POST['idUser']) : '';
	$username = isset($_POST['txtUsername']) ? makeSafe($_POST['txtUsername']) : '';
	$password = isset($_POST['txtPassword']) ? makeSafe($_POST['txtPassword']) : '';
	$field_identifier = isset($_POST['fieldId']) ? makeSafe($_POST['fieldId']) : '';
	$value_identifier = isset($_POST['valId']) ? makeSafe($_POST['valId']) : '';
	$id_user_role = isset($_POST['role']) ? makeSafe($_POST['role']) : '';

	try {
		$query = "UPDATE tb_m_user SET username='$username',password=MD5('$password'),id_user_role='$id_user_role',identifier_login='$field_identifier',value_identifier='$value_identifier' WHERE id_user='$id_user'";
		$result = mysqli_query($id_mysql,$query);
		if (!$result) {
			echo"Error executing query.";
		}else{
			echo "1";
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='view') {
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
	$table = '(SELECT usr.*,role.user_role FROM tb_m_user usr INNER JOIN tb_m_user_role role ON role.id_user_role=usr.id_user_role) temp';
	 
	// Table's primary key
	$primaryKey = 'id_user';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_user', 'dt' => 0 ),
	    array( 'db' => 'user_role',   'dt' => 1 ),
	    array( 'db' => 'username',   'dt' => 2 ),
	    array( 'db' => 'identifier_login',   'dt' => 3 ),
	    array( 'db' => 'value_identifier',   'dt' => 4 ),
	    array( 
	    	'db'        => 'id_user',
	        'dt'        => 5,
	        'formatter' => function( $d, $row ) {
	            return "<a href='user.php?id=$d&p=1'>"."<i class='fa fa-pencil'></i>"."</a>&nbsp<a href='user.php?del=1&id=$d'>"."<i class='fa fa-trash' onclick=\"return confirm('Are you sure you want to delete this user?')\"></i>"."</a>";
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