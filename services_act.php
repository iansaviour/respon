<?php 
include 'includes/core.php';
$type= $_GET['t'];
if ($type=='1') {
	$id = makeSafe($_POST['txtId']);
	$service = makeSafe($_POST['txtService']);
	$pemisah_kolom = $_POST['txtPemisahKolom'];
	$pemisah_baris = $_POST['txtPemisahBaris'];
	$max_char = $_POST['txtMaxChar'];
	//
	$inbox_table=makeSafe($_POST['txtInboxTable']);
	$inbox_table_serv=makeSafe($_POST['txtInboxTableServ']);
	$inbox_content =makeSafe($_POST['txtInboxContent']);
	$inbox_user =makeSafe($_POST['txtInboxSender']);
	$inbox_date =makeSafe($_POST['txtInboxDate']);
	$inbox_flag =makeSafe($_POST['txtInboxFlag']);
	$inbox_server =makeSafe($_POST['txtInboxServer']);
	//
	$outbox_table =makeSafe($_POST['txtOutboxTable']);
	$outbox_content =makeSafe($_POST['txtOutboxContent']);
	$outbox_user =makeSafe($_POST['txtOutboxRecipient']);
	$outbox_date =makeSafe($_POST['txtOutboxDate']);
	$outbox_flag =makeSafe($_POST['txtOutboxFlag']);
	$outbox_server =makeSafe($_POST['txtOutboxServer']);
	//
	if($id==0){
		try {
			$query = "INSERT INTO tb_service(service, pemisah_kolom, pemisah_baris, inbox_table, inbox_table_serv, inbox_content, inbox_date, inbox_flag, inbox_sender,inbox_server, outbox_table, outbox_content, outbox_date, outbox_flag, outbox_recipient, outbox_server,max_char) VALUES ('$service','$pemisah_kolom','$pemisah_baris', '$inbox_table','$inbox_table_serv', '$inbox_content', '$inbox_date', '$inbox_flag','$inbox_user','$inbox_server', '$outbox_table', '$outbox_content', '$outbox_date', '$outbox_flag', '$outbox_user', '$outbox_server','$max_char')";
			$result = mysqli_query($id_mysql,$query);
			if ($result) {
				$query_inb="
				CREATE TABLE `".$inbox_table."` (
					`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
					`id_outbox` BIGINT UNSIGNED NOT NULL,
					`".$inbox_content."` TEXT NULL DEFAULT NULL,
					`".$inbox_date."` VARCHAR(255) NULL DEFAULT NULL,
					`".$inbox_flag."` TINYINT(3) NULL DEFAULT 1,
					`".$inbox_user."` VARCHAR(255) NULL DEFAULT NULL,
					`".$inbox_server."` VARCHAR(255) NULL DEFAULT NULL,
					PRIMARY KEY (`id`)
				)
				COLLATE='latin1_swedish_ci'
				ENGINE=InnoDB;
				";
				$result_inb = mysqli_query($id_mysql,$query_inb);

				$query_inb_serv="
				CREATE TABLE `".$inbox_table_serv."` (
					`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
					`id_outbox` BIGINT UNSIGNED NOT NULL,
					`".$inbox_content."` TEXT NULL DEFAULT NULL,
					`".$inbox_date."` VARCHAR(255) NULL DEFAULT NULL,
					`".$inbox_flag."` TINYINT(3) NULL DEFAULT 1,
					`".$inbox_user."` VARCHAR(255) NULL DEFAULT NULL,
					`".$inbox_server."` VARCHAR(255) NULL DEFAULT NULL,
					PRIMARY KEY (`id`)
				)
				COLLATE='latin1_swedish_ci'
				ENGINE=InnoDB;
				";
				$result_inb_serv = mysqli_query($id_mysql,$query_inb_serv);
				//add trigger
				$query_trig = 'CREATE TRIGGER `'.$service.'_multipart` AFTER INSERT ON `'.$inbox_table_serv.'`
							  FOR EACH ROW BEGIN
							    SET @msg = new.'.$inbox_content.';
								select IF(@msg LIKE "[%]%",1,2) into @set;
								if @set = 1 then
									SET @end_pos = INSTR(@msg, "]");
									SET @kode_unik = RIGHT(LEFT(@msg, @end_pos-1),@end_pos-2);
									
									SET @end_pos = INSTR(@kode_unik, "_");
									SET @timest = LEFT(@kode_unik, @end_pos-1);
									
									SET @curstr = REPLACE(@kode_unik,CONCAT(@timest,"_"),"");
									
									SET @end_pos = INSTR(@curstr,"_");
									SET @jml_pesan = trim(leading "0" from LEFT(@curstr,@end_pos-1));
									
									SET @pencari = CONCAT(@timest,"_",LEFT(@curstr,@end_pos-1),"_");
									
									SET @curstr = REPLACE(@kode_unik,@pencari,"");
									SET @urut_pesan = TRIM(LEADING "0" FROM @curstr);
									
									SELECT COUNT(*) into @jml_ada FROM '.$inbox_table_serv.' WHERE '.$inbox_content.' LIKE concat("[",@pencari,"%");
									
									if @jml_ada >= @jml_pesan then
										SELECT GROUP_CONCAT(SUBSTRING('.$inbox_content.', INSTR('.$inbox_content.', "]") + 1) SEPARATOR "") into @msg_final FROM '.$inbox_table_serv.' where '.$inbox_content.' LIKE CONCAT("[",@pencari,"%") ORDER BY '.$inbox_content.' ASC;
										INSERT INTO xin('.$inbox_content.','.$inbox_date.','.$inbox_user.','.$inbox_server.') VALUES(@msg_final,new.'.$inbox_date.',new.'.$inbox_user.',new.'.$inbox_server.');
									end if;
								else
									INSERT INTO xin('.$inbox_content.','.$inbox_date.','.$inbox_user.','.$inbox_server.') VALUES(new.'.$inbox_content.',new.'.$inbox_date.',new.'.$inbox_user.',new.'.$inbox_server.');
								end if;
							  END;';
				$result_trig = mysqli_query($id_mysql,$query_trig);

				$query_out="
				CREATE TABLE `".$outbox_table."` (
					`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
					`".$outbox_content."` TEXT NULL DEFAULT NULL,
					`".$outbox_date."` VARCHAR(255) NULL DEFAULT NULL,
					`".$outbox_flag."` TINYINT(3) NULL DEFAULT 1,
					`".$outbox_user."` VARCHAR(255) NULL DEFAULT NULL,
					`".$outbox_server."` VARCHAR(255) NULL DEFAULT NULL,
					PRIMARY KEY (`id`)
				)
				COLLATE='latin1_swedish_ci'
				ENGINE=InnoDB;
				";
				$result_out = mysqli_query($id_mysql,$query_out);
				svcToJson("");
				echo"1";
			}else{
				echo"Error executing query.";
			}	
		} catch (Exception $e) {
			echo 'Error : ',  $e->getMessage(), "<br>";
		}	
	}else{
		try {
			$query_old = "SELECT * FROM tb_service WHERE id_service='$id' ";
			$result_old = mysqli_query($id_mysql, $query_old);
			$data_old = mysqli_fetch_array($result_old);

			$query_upd = "UPDATE tb_service SET 
			service = '$service',
			pemisah_kolom = '$pemisah_kolom',
			pemisah_baris = '$pemisah_baris',
			inbox_table = '$inbox_table',
			inbox_table_serv = '$inbox_table_serv',
			inbox_content = '$inbox_content',
			inbox_date = '$inbox_date',
			inbox_flag = '$inbox_flag',
			inbox_sender = '$inbox_user',
			inbox_server = '$inbox_server',
			outbox_table = '$outbox_table',
			outbox_content = '$outbox_content',
			outbox_date = '$outbox_date',
			outbox_flag = '$outbox_flag',
			outbox_recipient = '$outbox_user',
			outbox_server = '$outbox_server',
			max_char = '$max_char'
			WHERE id_service='$id' ";
			$result = mysqli_query($id_mysql,$query_upd);

			/*ALTER*/
			$query_inb = "RENAME TABLE `$data_old[inbox_table]` TO `$inbox_table` ";
			$result_inb = mysqli_query($id_mysql,$query_inb);
			$query_inb_serv = "RENAME TABLE `$data_old[inbox_table_serv]` TO `$inbox_table_serv` ";
			$result_inb_serv = mysqli_query($id_mysql,$query_inb_serv);
			$query_out = "RENAME TABLE `$data_old[outbox_table]` TO `$outbox_table` ";
			$result_out = mysqli_query($id_mysql,$query_out);
			
			$query_alter_inb = "ALTER TABLE `$inbox_table` CHANGE COLUMN `$data_old[inbox_content]` `$inbox_content` TEXT NULL DEFAULT NULL AFTER `id`,
			CHANGE COLUMN `$data_old[inbox_date]` `$inbox_date` VARCHAR(255) NULL DEFAULT NULL AFTER `$inbox_content`,
			CHANGE COLUMN `$data_old[inbox_flag]` `$inbox_flag` TINYINT(3) NULL DEFAULT 1 AFTER `$inbox_date`,
			CHANGE COLUMN `$data_old[inbox_sender]` `$inbox_user` VARCHAR(255) NULL DEFAULT NULL AFTER `$inbox_flag`,
			CHANGE COLUMN `$data_old[inbox_server]` `$inbox_server` VARCHAR(255) NULL DEFAULT NULL AFTER `$inbox_user`
			";
			$result_alter_inb = mysqli_query($id_mysql,$query_alter_inb);

			$query_alter_inb_serv = "ALTER TABLE `$inbox_table_serv` CHANGE COLUMN `$data_old[inbox_content]` `$inbox_content` TEXT NULL DEFAULT NULL AFTER `id`,
			CHANGE COLUMN `$data_old[inbox_date]` `$inbox_date` VARCHAR(255) NULL DEFAULT NULL AFTER `$inbox_content`,
			CHANGE COLUMN `$data_old[inbox_flag]` `$inbox_flag` TINYINT(3) NULL DEFAULT 1 AFTER `$inbox_date`,
			CHANGE COLUMN `$data_old[inbox_sender]` `$inbox_user` VARCHAR(255) NULL DEFAULT NULL AFTER `$inbox_flag`,
			CHANGE COLUMN `$data_old[inbox_server]` `$inbox_server` VARCHAR(255) NULL DEFAULT NULL AFTER `$inbox_user`
			";
			$result_alter_inb_serv = mysqli_query($id_mysql,$query_alter_inb_serv);

			//add trigger
			$query_trig = 'DROP TRIGGER `'.$data_old['service'].'_multipart`';
			$result_trig = mysqli_query($id_mysql,$query_trig);
			$query_trig = 'CREATE TRIGGER `'.$service.'_multipart` AFTER INSERT ON `'.$inbox_table_serv.'`
						  FOR EACH ROW BEGIN
						    SET @msg = new.'.$inbox_content.';
							select IF(@msg LIKE "[%]%",1,2) into @set;
							if @set = 1 then
								SET @end_pos = INSTR(@msg, "]");
								SET @kode_unik = RIGHT(LEFT(@msg, @end_pos-1),@end_pos-2);
								
								SET @end_pos = INSTR(@kode_unik, "_");
								SET @timest = LEFT(@kode_unik, @end_pos-1);
								
								SET @curstr = REPLACE(@kode_unik,CONCAT(@timest,"_"),"");
								
								SET @end_pos = INSTR(@curstr,"_");
								SET @jml_pesan = trim(leading "0" from LEFT(@curstr,@end_pos-1));
								
								SET @pencari = CONCAT(@timest,"_",LEFT(@curstr,@end_pos-1),"_");
								
								SET @curstr = REPLACE(@kode_unik,@pencari,"");
								SET @urut_pesan = TRIM(LEADING "0" FROM @curstr);
								
								SELECT COUNT(*) into @jml_ada FROM '.$inbox_table_serv.' WHERE '.$inbox_content.' LIKE concat("[",@pencari,"%");
								
								if @jml_ada >= @jml_pesan then
									SELECT GROUP_CONCAT(SUBSTRING('.$inbox_content.', INSTR('.$inbox_content.', "]") + 1) SEPARATOR "") into @msg_final FROM '.$inbox_table_serv.' where '.$inbox_content.' LIKE CONCAT("[",@pencari,"%") ORDER BY '.$inbox_content.' ASC;
									INSERT INTO xin('.$inbox_content.','.$inbox_date.','.$inbox_user.','.$inbox_server.') VALUES(@msg_final,new.'.$inbox_date.',new.'.$inbox_user.',new.'.$inbox_server.');
								end if;
							else
								INSERT INTO xin('.$inbox_content.','.$inbox_date.','.$inbox_user.','.$inbox_server.') VALUES(new.'.$inbox_content.',new.'.$inbox_date.',new.'.$inbox_user.',new.'.$inbox_server.');
							end if;
						  END;';
			$result_trig = mysqli_query($id_mysql,$query_trig);

			$query_alter_out = "ALTER TABLE `$outbox_table` CHANGE COLUMN 
			`$data_old[outbox_content]` `$outbox_content` TEXT NULL DEFAULT NULL  AFTER `id`,
			`$data_old[outbox_date]` `$outbox_date` VARCHAR(255) NULL DEFAULT NULL AFTER `$inbox_content`,
			`$data_old[outbox_flag]` `$outbox_flag` TINYINT(3) NULL DEFAULT 1 AFTER `$inbox_date`,
			`$data_old[outbox_recipient]` `$outbox_user` VARCHAR(255) NULL DEFAULT NULL AFTER `$inbox_flag`,
			`$data_old[outbox_server]` `$outbox_server` VARCHAR(255) NULL DEFAULT NULL AFTER `$outbox_user`
			";
			$result_alter_out = mysqli_query($id_mysql,$query_alter_out);
			svcToJson("");
			echo"1";
		} catch (Exception $e) {
			echo 'Error : ',  $e->getMessage(), "<br>";
		}
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
	$table = 'tb_service';
	 
	// Table's primary key
	$primaryKey = 'id_service';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'service',   'dt' => 0 ),
	    array( 'db' => 'inbox_table_serv',   'dt' => 1 ),
	    array( 'db' => 'inbox_table',   'dt' => 2 ),
	    array( 'db' => 'inbox_content',   'dt' => 3 ),
	    array( 'db' => 'inbox_date',   'dt' => 4 ),
	    array( 'db' => 'inbox_flag',   'dt' => 5 ),
	    array( 'db' => 'inbox_sender',   'dt' => 6 ),
	    array( 'db' => 'inbox_server',   'dt' => 7 ),
	    array( 'db' => 'outbox_table',   'dt' => 8 ),
	    array( 'db' => 'outbox_content',   'dt' => 9 ),
	    array( 'db' => 'outbox_date',   'dt' => 10 ),
	    array( 'db' => 'outbox_flag',   'dt' => 11 ),
	    array( 'db' => 'outbox_recipient',   'dt' => 12 ),
	    array( 'db' => 'outbox_server',   'dt' => 13 ),
	    array( 'db' => 'max_char',   'dt' => 14 ),
	    array(
	        'db'        => 'id_service',
	        'dt'        => 15,
	        'formatter' => function( $d, $row ) {
	            return "<a href='services.php?id=$d' title='Edit'>Edit</a><br><a href='services_act.php?t=3&id=$d' onclick=\"return confirm('Are you sure you want to delete this services?')\" title=\"Delete\">Delete</a>";
	        }
	    ),
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
	$id=$_GET['id'];
	$query = "SELECT * FROM tb_service WHERE id_service=$id";
	$result = mysqli_query($id_mysql,$query);
	$data = mysqli_fetch_array($result);

	try {
		/*remove table*/
		$query_drop = "DROP TABLE `".$data['inbox_table']."`;";
		$result_drop = mysqli_query($id_mysql,$query_drop);
		$query_drop2 = "DROP TABLE `".$data['outbox_table']."`;";
		$result_drop2 = mysqli_query($id_mysql,$query_drop2);
		$query_trig = 'DROP TRIGGER `'.$data['service'].'_multipart`';
		$result_trig = mysqli_query($id_mysql,$query_trig);
		$query_drop3 = "DROP TABLE `".$data['inbox_table_serv']."`;";
		$result_drop3 = mysqli_query($id_mysql,$query_drop3);

		/*remove svc*/
		$query_del = "DELETE FROM tb_service WHERE id_service=$id";
		$result_del = mysqli_query($id_mysql,$query_del);
		if($result_del){
			header("Location:services.php");
		}else{
			echo"Delete error. <a href='services.php'>Back to home</a>";
		}
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}
}


?>