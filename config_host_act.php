<?php 
include 'includes/core.php';
$type= $_GET['t'];
if(isset($_GET['id'])){
	$id=$_GET['id'];
}

if ($type=='1') {
	$service = makeSafe($_POST['txtService']);
	$inbox_table=makeSafe($_POST['txtInboxTable']);
	$inbox_content =makeSafe($_POST['txtInboxContent']);
	$inbox_sender =makeSafe($_POST['txtInboxSender']);
	$inbox_date =makeSafe($_POST['txtInboxDate']);
	$inbox_flag =makeSafe($_POST['txtInboxFlag']);
	$outbox_table =makeSafe($_POST['txtOutboxTable']);
	$outbox_content =makeSafe($_POST['txtOutboxContent']);
	$outbox_recipient =makeSafe($_POST['txtOutboxRecipient']);
	$outbox_date =makeSafe($_POST['txtOutboxDate']);
	$outbox_flag =makeSafe($_POST['txtOutboxFlag']);
	try {
		$query = "INSERT INTO tb_service(service, inbox_table, inbox_content, inbox_sender, inbox_date, inbox_flag, outbox_table, outbox_content, outbox_recipient, outbox_date, outbox_flag) VALUES ('$service', '$inbox_table', '$inbox_content', '$inbox_sender', '$inbox_date', '$inbox_flag', '$outbox_table', '$outbox_content', '$outbox_recipient', '$outbox_date', '$outbox_flag')";
		$result = mysql_query($query);
		if ($result) {
			$query_inb="
			CREATE TABLE `".$inbox_table."` (
				`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				`".$inbox_content."` VARCHAR(500) NULL DEFAULT NULL,
				`".$inbox_sender."` VARCHAR(255) NULL DEFAULT NULL,
				`".$inbox_date."` VARCHAR(255) NULL DEFAULT NULL,
				`".$inbox_flag."` VARCHAR(255) NULL DEFAULT NULL,
				PRIMARY KEY (`id`)
			)
			COLLATE='latin1_swedish_ci'
			ENGINE=InnoDB;
			";
			$result_inb = mysql_query($query_inb);

			$query_out="
			CREATE TABLE `".$outbox_table."` (
				`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				`".$outbox_content."` VARCHAR(500) NULL DEFAULT NULL,
				`".$outbox_recipient."` VARCHAR(255) NULL DEFAULT NULL,
				`".$outbox_date."` VARCHAR(255) NULL DEFAULT NULL,
				`".$outbox_flag."` VARCHAR(255) NULL DEFAULT NULL,
				PRIMARY KEY (`id`)
			)
			COLLATE='latin1_swedish_ci'
			ENGINE=InnoDB;
			";
			$result_out = mysql_query($query_out);
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