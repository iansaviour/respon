<?php 
include 'includes/core.php';
$type= $_GET['t'];
$id_service = '';
if(isset($_GET['id_service'])){
	$id_service = $_GET['id_service'];
}
if ($type=='1') {
	$phpexe = isset($_POST['txtphpexe']) ? makeSafe($_POST['txtphpexe']) : '';
	$respon = isset($_POST['txtresponloc']) ? makeSafe($_POST['txtresponloc']) : '';
	$rentang_min = isset($_POST['rentang_min']) ? makeSafe($_POST['rentang_min']) : '';
	//
	$char_pemisah = isset($_POST['char_pemisah']) ? makeSafe($_POST['char_pemisah']) : '';
	$balas_spam = isset($_POST['balas_spam']) ? makeSafe($_POST['balas_spam']) : '';
	$pesan_spam = isset($_POST['pesan_spam']) ? makeSafe($_POST['pesan_spam']) : '';
	$pesan_gagal = isset($_POST['pesan_gagal']) ? makeSafe($_POST['pesan_gagal']) : '';
	$pesan_sukses = isset($_POST['pesan_sukses']) ? makeSafe($_POST['pesan_sukses']) : '';
	$pesan_private = isset($_POST['pesan_private']) ? makeSafe($_POST['pesan_private']) : '';
	try {
		$query = "UPDATE tb_option SET respon_loc='$respon',phpexe_loc='$phpexe',rentang_min='$rentang_min',char_pemisah='$char_pemisah',balas_spam='$balas_spam',pesan_spam='$pesan_spam',pesan_gagal='$pesan_gagal',pesan_sukses='$pesan_sukses',pesan_private='$pesan_private'";
		$result = mysqli_query($id_mysql,$query);
		if (!$result) {
			echo"Error executing query.";
		}else{
			/*
			//exec
			exec('schtasks /delete /tn Respon /f');
			exec('SchTasks /Create /SC MINUTE /MO 5 /TN Respon /TR "C:\xampp_new\php\php.exe -f C:\xampp_new\htdocs\respon\respon.php"',$output);
			//
			if(count($output) > 0){
				echo $output[0];
			}else{
				echo "Start Failed";
			}
			*/
			exec('schtasks /delete /tn Respon /f');
			//modify respon.vbs
			$myfile = fopen("respon.vbs", "w") or die("Unable to open file!");
			$txt = 'CreateObject("Wscript.Shell").Run "'.$respon.'respon.bat", 0, True';
			fwrite($myfile, $txt);
			fclose($myfile);
			//modify respon.bat
			$myfile = fopen("respon.bat", "w") or die("Unable to open file!");
			$txt = $phpexe . " -f " . $respon . "respon.php";
			fwrite($myfile, $txt);
			fclose($myfile);
			//modify respon.xml
			$myfile = fopen("respon.xml", "w") or die("Unable to open file!");
			$txt = "<?xml version=\"1.0\" encoding=\"UTF-16\"?>" . PHP_EOL;
			$txt .= "<Task version=\"1.2\" xmlns=\"http://schemas.microsoft.com/windows/2004/02/mit/task\">" . PHP_EOL;
			  $txt .= "<RegistrationInfo>" . PHP_EOL;
			    $txt .= "<Date>2016-07-29T08:46:58</Date>" . PHP_EOL;
			    $txt .= "<Author>septian</Author>" . PHP_EOL;
			  $txt .= "</RegistrationInfo>" . PHP_EOL;
			  $txt .= "<Triggers>" . PHP_EOL;
			    $txt .= "<TimeTrigger>" . PHP_EOL;
			      $txt .= "<Repetition>" . PHP_EOL;
			        $txt .= "<Interval>PT1M</Interval>" . PHP_EOL;
			        $txt .= "<StopAtDurationEnd>false</StopAtDurationEnd>" . PHP_EOL;
			      $txt .= "</Repetition>" . PHP_EOL;
			      $txt .= "<StartBoundary>2016-01-01T00:00:00</StartBoundary>" . PHP_EOL;
			      $txt .= "<Enabled>true</Enabled>" . PHP_EOL;
			    $txt .= "</TimeTrigger>" . PHP_EOL;
			  $txt .= "</Triggers>" . PHP_EOL;
			  $txt .= "<Settings>" . PHP_EOL;
			    $txt .= "<MultipleInstancesPolicy>IgnoreNew</MultipleInstancesPolicy>" . PHP_EOL;
			    $txt .= "<DisallowStartIfOnBatteries>false</DisallowStartIfOnBatteries>" . PHP_EOL;
			    $txt .= "<StopIfGoingOnBatteries>false</StopIfGoingOnBatteries>" . PHP_EOL;
			    $txt .= "<AllowHardTerminate>true</AllowHardTerminate>" . PHP_EOL;
			    $txt .= "<StartWhenAvailable>false</StartWhenAvailable>" . PHP_EOL;
			    $txt .= "<RunOnlyIfNetworkAvailable>false</RunOnlyIfNetworkAvailable>" . PHP_EOL;
			    $txt .= "<IdleSettings>" . PHP_EOL;
			      $txt .= "<StopOnIdleEnd>false</StopOnIdleEnd>" . PHP_EOL;
			      $txt .= "<RestartOnIdle>false</RestartOnIdle>" . PHP_EOL;
			    $txt .= "</IdleSettings>" . PHP_EOL;
			    $txt .= "<AllowStartOnDemand>true</AllowStartOnDemand>" . PHP_EOL;
			    $txt .= "<Enabled>true</Enabled>" . PHP_EOL;
			    $txt .= "<Hidden>false</Hidden>" . PHP_EOL;
			    $txt .= "<RunOnlyIfIdle>false</RunOnlyIfIdle>" . PHP_EOL;
			    $txt .= "<WakeToRun>false</WakeToRun>" . PHP_EOL;
			    $txt .= "<ExecutionTimeLimit>PT0S</ExecutionTimeLimit>" . PHP_EOL;
			    $txt .= "<Priority>7</Priority>" . PHP_EOL;
			  $txt .= "</Settings>" . PHP_EOL;
			  $txt .= "<Actions Context='Author'>" . PHP_EOL;
			    $txt .= "<Exec>" . PHP_EOL;
			      $txt .= "<Command>wscript.exe</Command>" . PHP_EOL;
			      $txt .= "<Arguments>".$respon."respon.vbs</Arguments>" . PHP_EOL;
			    $txt .= "</Exec>" . PHP_EOL;
			  $txt .= "</Actions>" . PHP_EOL;
			$txt .= "</Task>";
			fwrite($myfile, $txt);
			fclose($myfile);
			//
			//exec('SchTasks /Create /SC MINUTE /MO '.$rentang_min.' /TN Respon /TR "wscript.exe '.$respon.'respon.vbs"',$output);
			exec('SchTasks /Create /XML '. $respon .'respon.xml /tn Respon',$output);
			if(count($output) > 0){
				echo $output[0];
			}else{
				echo "Start Failed";
			}
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='2') {
	try {
			exec('schtasks /delete /tn Respon /f',$output);
			echo "1";
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif($type=='inbox') {
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
	$table = "(SELECT id,". $row['inbox_sender'] ." as sender,". $row['inbox_date'] ." as date,". $row['inbox_flag'] ." as flag,". $row['inbox_content'] ." as isi FROM ". $row['inbox_table'] .") temp";

	// Table's primary key
	$primaryKey = 'id';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id', 'dt' => 0 ),
	    array( 'db' => 'sender',   'dt' => 1 ),
	    array( 'db' => 'date',   'dt' => 2 ),
	    array( 'db' => 'flag',   
	    	   'dt' => 3,
	    	   'formatter' => function( $d, $row ) {
		            if($d == "1"){
		            	return "Belum diproses";
		            }else{
		            	return "Sudah diproses";
		            }
		        }
	    	),
	    array( 'db' => 'isi',   'dt' => 4 )
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
}elseif($type=='outbox') {
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
	$table = "(SELECT id,". $row['outbox_recipient'] ." as sender,". $row['outbox_date'] ." as date,". $row['outbox_flag'] ." as flag,". $row['outbox_content'] ." as isi FROM ". $row['outbox_table'] .") temp";

	// Table's primary key
	$primaryKey = 'id';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id', 'dt' => 0 ),
	    array( 'db' => 'sender',   'dt' => 1 ),
	    array( 'db' => 'date',   'dt' => 2 ),
	    array( 'db' => 'flag',   
	    	   'dt' => 3,
	    	   'formatter' => function( $d, $row ) {
		            if($d == "1"){
		            	return "Belum diproses";
		            }else{
		            	return "Sudah diproses";
		            }
		        }
	    	),
	    array( 'db' => 'isi',   'dt' => 4 )
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
}elseif($type=='respon') {
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
	$table = "tb_log_respon";

	// Table's primary key
	$primaryKey = 'id_log';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_log', 'dt' => 0 ),
	    array( 'db' => 'log',   'dt' => 1 ),
	    array( 'db' => 'datetime',   'dt' => 2 )
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