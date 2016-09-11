<?php 
include 'includes/core.php';

$type= $_GET['t'];
if ($type=='1') {
	$consumer_key = make_safe($_POST['txtConsumerKey']);
	$consumer_secret = make_safe($_POST['txtConsumerSecret']);
	$oauth_token = make_safe($_POST['txtOauthToken']);
	$oauth_token_secret = make_safe($_POST['txtOauthTokenSecret']);
	$interval = make_safe($_POST['txtReloadInterval'])*1000;

	try {
		$query = "UPDATE tb_option_twitter SET consumer_key='$consumer_key', consumer_secret='$consumer_secret', oauth_token='$oauth_token', oauth_token_secret='$oauth_token_secret', reload_interval='$interval' ";
		$result = mysql_query($query);
		if ($result) {
			echo"Configuration was updated successfully.";
		}else{
			echo"Error executing query.";
		}	
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='2') {
	try {
		$query = "SELECT reload_interval FROM tb_option_twitter";
		$result = mysql_query($query);
		$data = mysql_fetch_array($result);
		echo $data['reload_interval'];	
	} catch (Exception $e) {
		echo"0";
	}
}elseif ($type=="3") {
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
	$table = 'tb_inbox_twitter';
	 
	// Table's primary key
	$primaryKey = 'id_inbox';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_inbox', 'dt' => 0 ),
	    array( 'db' => 'inbox_user',  'dt' => 1 ),
	    array( 'db' => 'inbox_user_screen',   'dt' => 2 ),
	    array(
	        'db'        => 'inbox_date',
	        'dt'        => 3,
	        'formatter' => function( $d, $row ) {
	            return date( 'd M y', strtotime($d));
	        }
	    ),
	    array( 'db' => 'inbox',   'dt' => 4 )
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
}elseif ($type=="4") {
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
	$table = 'tb_sent_twitter';
	 
	// Table's primary key
	$primaryKey = 'id_outbox';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_outbox', 'dt' => 0 ),
	    array( 'db' => 'outbox_user_screen',   'dt' => 1 ),
	    array(
	        'db'        => 'outbox_date',
	        'dt'        => 2,
	        'formatter' => function( $d, $row ) {
	            return date( 'd M y', strtotime($d));
	        }
	    ),
	    array( 'db' => 'outbox',   'dt' => 3 ),
	    array(
	        'db'        => 'is_sent',
	        'dt'        => 4,
	        'formatter' => function( $d, $row ) {
	            if ($d==1) {
	            	return 'Pending';
	            } else {
	            	# code...
	            	return 'Sent';
	            }
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