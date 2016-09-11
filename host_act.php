<?php 
include 'includes/core.php';
$type= $_GET['t'];
if(isset($_GET['id'])){
	$id=$_GET['id'];
}

if ($type=='1') {
	$hostAdd = makeSafe($_POST['txtHostAdd']);
	$hostUsr = makeSafe($_POST['txtHostUsr']);
	$hostPass = makeSafe($_POST['txtHostPass']);
	$hostDb = makeSafe($_POST['SelDb']);

	$hostNama = makeSafe($_POST['txtHostNama']);
	$hostTelp = makeSafe($_POST['txtHostTelp']);
	$hostEmail = makeSafe($_POST['txtHostEmail']);
	$hostLokal = makeSafe($_POST['SelHostLokal']);
	$hostPmsh = makeSafe($_POST['txtHostKarakter']);

	try {
		$query = "INSERT INTO tb_host(host,username,password,db,no_hp,email,nama_host,is_local,karakter_pemisah) VALUES ('$hostAdd', '$hostUsr', '$hostPass', '$hostDb', '$hostTelp', '$hostEmail', '$hostNama', '$hostLokal', '$hostPmsh')";
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
	$table = 'tb_host';
	 
	// Table's primary key
	$primaryKey = 'id_host';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_host', 'dt' => 0 ),
	    array( 'db' => 'nama_host',   'dt' => 1 ),
	    array( 'db' => 'host',   'dt' => 2 ),
	    array( 'db' => 'username',   'dt' => 3 ),
	    array( 'db' => 'password',   'dt' => 4 ),
	    array( 'db' => 'db',   'dt' => 5 ),
	    array( 
	    	'db' => 'is_local',   
	    	'dt' => 6,
	    	'formatter' => function( $d, $row ) {
	            if($d == "1"){
	            	return "Yes";
	            }else{
	            	return "No";
	            }
	        }
	    ),
	    array( 'db' => 'karakter_pemisah',   'dt' => 7 ),
	    array( 
	    	'db'        => 'id_host',
	        'dt'        => 8,
	        'formatter' => function( $d, $row ) {
	            return "<a href='host.php?t=3&id=$d'>"."<i class='fa fa-trash'></i>"."</a>";
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
	            return "<a href='host.php?t=3&id=$d'>"."<i class='fa fa-trash'></i>"."</a>";
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
}elseif ($type=='4') {
	try {
		$query = "DELETE FROM tb_host WHERE id_host='" . $id . "'";
		$result = mysqli_query($id_mysql,$query);
		if (!$result) {
			echo"Error executing query.";
		}else{
			echo "1";
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}


?>