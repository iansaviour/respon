<?php 
include 'includes/core.php';
$type= $_GET['t'];
if ($type=='1') {//insert Insert
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	//
	$sch_msg_name = isset($_POST['InDesc']) ? makeSafe($_POST['InDesc']) : '';
	//
	$table_name = isset($_POST['selTb']) ? makeSafe($_POST['selTb']) : '';
	$selIdKontak = isset($_POST['selIdKontak']) ? makeSafe($_POST['selIdKontak']) : '';
	$selPesan = isset($_POST['selPesan']) ? makeSafe($_POST['selPesan']) : '';
	$selTanggal = isset($_POST['selTanggal']) ? makeSafe($_POST['selTanggal']) : '';
	$selWaktu = isset($_POST['selWaktu']) ? makeSafe($_POST['selWaktu']) : '';
	//
	try {
		$query = "INSERT INTO tb_sch_msg(id_host,sch_msg_name,table_name,fl_id_contact,fl_msg,fl_date,fl_hour) VALUES ('$id_host','$sch_msg_name','$table_name','$selIdKontak','$selPesan','$selTanggal','$selWaktu')";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			echo "1";
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='1edit') {//edit Insert
	$id_sch_msg = isset($_POST['idOperasi']) ? makeSafe($_POST['idOperasi']) : '';
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	//
	$sch_msg_name = isset($_POST['InDesc']) ? makeSafe($_POST['InDesc']) : '';
	//
	$table_name = isset($_POST['selTb']) ? makeSafe($_POST['selTb']) : '';
	$selIdKontak = isset($_POST['selIdKontak']) ? makeSafe($_POST['selIdKontak']) : '';
	$selPesan = isset($_POST['selPesan']) ? makeSafe($_POST['selPesan']) : '';
	$selTanggal = isset($_POST['selTanggal']) ? makeSafe($_POST['selTanggal']) : '';
	$selWaktu = isset($_POST['selWaktu']) ? makeSafe($_POST['selWaktu']) : '';
	//
	try {
		$query = "UPDATE tb_sch_msg SET id_host='$id_host',sch_msg_name='$sch_msg_name',table_name='$table_name',fl_id_contact='$selIdKontak',fl_msg='$selPesan',fl_date='$selTanggal',fl_hour='$selWaktu' WHERE id_sch_msg='$id_sch_msg'";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			echo '1';
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
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
	$table = " ( SELECT schm.id_sch_msg,schm.id_host,hst.nama_host,schm.sch_msg_name,schm.table_name FROM tb_sch_msg schm
INNER JOIN tb_host hst ON hst.id_host=schm.id_host) temp";
	 
	// Table's primary key
	$primaryKey = 'id_sch_msg';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_sch_msg', 'dt' => 0 ),
	    array( 'db' => 'id_host',   'dt' => 1 ),
	    array( 'db' => 'nama_host',   'dt' => 2 ),
	    array( 'db' => 'sch_msg_name',   'dt' => 3 ),
	    array( 'db' => 'table_name',   'dt' => 4 ),
	    array( 
	    	'db'        => 'id_sch_msg',
	        'dt'        => 5,
	        'formatter' => function( $d, $row ) {
	        	//
	        	$p = '1a';
	        	return "<a href='sch_msg.php?id=$d&p=$p'>"."<i class='fa fa-pencil'></i>"."</a>&nbsp<a href='sch_msg.php?del=1&id=$d'>"."<i class='fa fa-trash' onclick=\"return confirm('Are you sure you want to delete this scheduled message?')\"></i>"."</a>";
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