<?php
	include 'includes/koneksi.php';
	include 'includes/function.php';

	function add_log($data,$id_mysql){ //log respon
		$query="INSERT INTO tb_log_respon(log,datetime) VALUES('".$data."',NOW())";
		//echo $query . "<br>";
		$result = mysqli_query($id_mysql,$query);
	}
	function balas_normal($id_mysql,$sender_var,$server_var,$pesan_var,$nm_tbl_outb,$nm_fl_msg,$nm_fl_date,$nm_fl_recipient,$nm_fl_server,$max_char_var){
		
		if(strlen($pesan_var)>$max_char_var){
			//bagi
			//$kode_unik = "[" . time() . "_" . "xxx" . "_" . "xxx" . "]";
			$timestamp_var = time();
			$pjg_per_pesan = ($max_char_var-strlen("[" . $timestamp_var . "_" . "xxx" . "_" . "xxx" . "]"));
			$jml_pesan = ceil(strlen($pesan_var)/$pjg_per_pesan);
			//
			for ($i=1; $i<=$jml_pesan; $i++) {
				$kode_unik = "[" . $timestamp_var . "_" . str_pad($jml_pesan, 3, '0', STR_PAD_LEFT) . "_" . str_pad($i, 3, '0', STR_PAD_LEFT) . "]";
				$str = substr($pesan_var, (($i-1)*$pjg_per_pesan),$pjg_per_pesan);

				$pesan_varx = $kode_unik . $str;

				$query="INSERT INTO " .$nm_tbl_outb. "(" .$nm_fl_msg. "," .$nm_fl_date. "," .$nm_fl_recipient. "," .$nm_fl_server. ") VALUES('". $pesan_varx ."',NOW(),'".$sender_var."','".$server_var."')";
				$result = mysqli_query($id_mysql,$query);
			}

		}else{
			$query="INSERT INTO " .$nm_tbl_outb. "(" .$nm_fl_msg. "," .$nm_fl_date. "," .$nm_fl_recipient. "," .$nm_fl_server. ") VALUES('".$pesan_var."',NOW(),'".$sender_var."','".$server_var."')";
			$result = mysqli_query($id_mysql,$query);
		}
	}
	function balas_spam($id_mysql,$balas_spam_var,$sender_var,$server_var,$pesan_spam_var,$nm_tbl_outb,$nm_fl_msg,$nm_fl_date,$nm_fl_recipient,$nm_fl_server){
		if($balas_spam_var == '1'){
			$query="INSERT INTO " .$nm_tbl_outb. "(" .$nm_fl_msg. "," .$nm_fl_date. "," .$nm_fl_recipient. "," .$nm_fl_server. ") VALUES('".$pesan_spam_var."',NOW(),'".$sender_var."','".$server_var."')";
			//echo $query . "<br>";
			$result = mysqli_query($id_mysql,$query);
		}
	}
	function balas_gagal($id_mysql,$sender_var,$server_var,$pesan_gagal_var,$nm_tbl_outb,$nm_fl_msg,$nm_fl_date,$nm_fl_server,$nm_fl_recipient){
		$query="INSERT INTO " .$nm_tbl_outb. "(" .$nm_fl_msg. "," .$nm_fl_date. "," .$nm_fl_recipient. "," .$nm_fl_server. ") VALUES('".$pesan_gagal_var."',NOW(),'".$sender_var."','".$server_var."')";
		//echo $query . "<br>";
		$result = mysqli_query($id_mysql,$query);
	}
	function balas_sukses($id_mysql,$sender_var,$server_var,$pesan_sukses_var,$nm_tbl_outb,$nm_fl_msg,$nm_fl_date,$nm_fl_server,$nm_fl_recipient){
		$query="INSERT INTO " .$nm_tbl_outb. "(" .$nm_fl_msg. "," .$nm_fl_date. "," .$nm_fl_recipient. "," .$nm_fl_server. ") VALUES('".$pesan_sukses_var."',NOW(),'".$sender_var."','".$server_var."')";
		//echo $query . "<br>";
		$result = mysqli_query($id_mysql,$query);
	}
	//
	$char_pemisah = '';
	$pesan_spam = '';
    $pesan_gagal = '';
    $pesan_sukses = '';
    //$keyword_host = '';
    $balas_spam = '';
	//
	//$query="INSERT INTO tb_log_respon(log,datetime) VALUES('Response successfully executed',NOW())";
	//$result = mysqli_query($id_mysql,$query);
	//cari parameter option
	//$query= "SELECT char_pemisah,pesan_spam,pesan_gagal,pesan_sukses,keyword_host,balas_spam FROM tb_option LIMIT 1";
	$query= "SELECT char_pemisah,pesan_spam,pesan_gagal,pesan_sukses,balas_spam,pesan_private FROM tb_option LIMIT 1";
	$result = mysqli_query($id_mysql,$query);
	$data = mysqli_fetch_array($result);
    $char_pemisah = $data['char_pemisah'];
    $pesan_spam = $data['pesan_spam'];
    $pesan_gagal = $data['pesan_gagal'];
    $pesan_sukses = $data['pesan_sukses'];
    $pesan_private = $data['pesan_private'];
    //$keyword_host = $data['keyword_host'];
    $balas_spam = $data['balas_spam'];
    //loop setiap service
	$queryx = "SELECT * FROM tb_service";
	$resultx = mysqli_query($id_mysql,$queryx);
	//
	$cnt_msg = 0; //counter pesan diolah
	//
	$pesan_log = '';
	while($row = $resultx->fetch_assoc()) {
		//deklarasi
		$nama_service = $row['service'];
		$max_char = $row['max_char'];
		$pemisah_kolom = $row['pemisah_kolom'];
		$pemisah_baris = $row['pemisah_baris'];
		//
		$inbox_table= $row['inbox_table'];
	    $inbox_isi = $row['inbox_content'];
	    $inbox_date = $row['inbox_date'];
	    $inbox_flag = $row['inbox_flag'];
	    $inbox_sender = $row['inbox_sender'];
	    $inbox_server = $row['inbox_server'];
	    //
	    $outbox_table = $row['outbox_table'];
	    $outbox_isi = $row['outbox_content'];
	    $outbox_date = $row['outbox_date'];
	    $outbox_flag = $row['outbox_flag'];
	    $outbox_recipient = $row['outbox_recipient'];
	    $outbox_server = $row['outbox_server'];
	    //
		$cnt_msg_sub = 0; //counter pesan diolah per service
		//get inbox flag = 1
	    $query_inb = "SELECT * FROM ".$inbox_table." WHERE ".$inbox_flag."='1'";
		$result_inb = mysqli_query($id_mysql,$query_inb);
		//
		while($row_inb = $result_inb->fetch_array()) {
			//get message
			$id_message = $row_inb['id'];
			//set inbox flag = 2 , processed
	    	$query_flag = "UPDATE " . $inbox_table . " SET " . $inbox_flag . "='2' WHERE id='" . $id_message . "'";
	    	$result_flag = mysqli_query($id_mysql,$query_flag);
			//
			$message = $row_inb[$inbox_isi];
			$sender = $row_inb[$inbox_sender];
			$server_inb = $row_inb[$inbox_server];
			$msg_array = explode($char_pemisah,$message);
			$balasan_prefix = '';
			if(count($msg_array)>1){
				$keyword = '';
				$parameter = '';
				$host_id_outbox = '';
				$jenis_pesan = ''; //1=nothing,2=host

				/*
				if(strtoupper($msg_array[0])==$keyword_host){//host first
					$jenis_pesan = '2';
					$host_id_outbox = $msg_array[1];
					$keyword = $msg_array[2];
					//
					$balasan_prefix = $host_id_outbox . $char_pemisah;
					//
					$parameter = substr($message, strlen($keyword_host . $char_pemisah . $host_id_outbox . $char_pemisah . $keyword . $char_pemisah));
					$parameter_array = explode($char_pemisah,$parameter);
				}else{
				*/
					$jenis_pesan = '1';
					$keyword = $msg_array[0];
					$parameter = substr($message, strlen($keyword . $char_pemisah));
					$parameter_array = explode($char_pemisah,$parameter);
				//}
				//olah
				if(strlen($keyword) > 0){
					//search for keyword
					$query_kw = "SELECT host.*,op.* FROM tb_operasi op INNER JOIN tb_host host ON host.id_host=op.id_host WHERE keyword='" . $keyword . "' LIMIT 1";
					$result_kw = mysqli_query($id_mysql,$query_kw);
					$row_kw = $result_kw->fetch_array();
					if(count($row_kw)>0){//check keyword
						$id_operasi = $row_kw['id_operasi'];
						//
						$query_par = "SELECT * FROM tb_operasi_parameter WHERE id_operasi='".$id_operasi."'";
						$result_par = mysqli_query($id_mysql,$query_par);
						$row_par = $result_par->fetch_array();
						$row_par_count = mysqli_num_rows($result_par);

						if($row_par_count==count($parameter_array)){
							//
							$host_kw = $row_kw['host'];
							$username_kw = $row_kw['username'];
							$password_kw = $row_kw['password'];
							$db_kw = $row_kw['db'];
							//
							if($id_mysql_host = mysqli_connect($host_kw,$username_kw,$password_kw,$db_kw)){
								if($row_kw['id_jenis_operasi']==0){//Procedure function
									if($row_kw['id_jenis_sql']==2){//Function
										//cari function
										$query_func = "SELECT * FROM tb_operasi_prosedural WHERE id_operasi='".$id_operasi."' LIMIT 1";
										$result_func = mysqli_query($id_mysql,$query_func);
										$row_func = $result_func->fetch_array();
										$nama_function = $row_func['nama_prosedural'];
										$nama_hasil = $row_func['nama_hasil'];
										//parameter
										$exec_par = '';
										for ($i=0; $i<count($parameter_array); $i++) {
											if($i>0){
												$exec_par = $exec_par . ",'" . $parameter_array[$i] . "'";
											}else{
												$exec_par = $exec_par . "'" . $parameter_array[$i] . "'";
											}
										}
										
										//cek private or publik, boleh atau tidak
										$allowed_keyword = 1;
										if($row_kw['is_publik']==2){
											$query_pt = "SELECT * FROM tb_contact WHERE contact_id='" . $sender . "'";
											$result_pt = mysqli_query($id_mysql,$query_pt);
											$row_pt = $result_pt->fetch_array();
											$ptc = mysqli_num_rows($result_pt);
											if($ptc>0){
												$allowed_keyword = 1;
											}else{
												$allowed_keyword = 2;
											}
										}
										if($allowed_keyword == 1){
											$query_exec = "SELECT ".$nama_function."(".$exec_par.")";

											//eksekusi
											if($result_func = mysqli_query($id_mysql_host,$query_exec)){
												$row_func = $result_func->fetch_array();
												//output
												$pesan = $nama_hasil.$row_func[0];
												balas_normal($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server,$max_char);
											}else{
												balas_gagal($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_gagal,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
											}
										}else{
											//pesan private
											balas_normal($id_mysql,$sender,$server_inb,$pesan_private,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server,$max_char);
										}
									}else{//Procedure
										//cari procedure
										$query_func = "SELECT * FROM tb_operasi_prosedural WHERE id_operasi='".$id_operasi."' LIMIT 1";
										$result_func = mysqli_query($id_mysql,$query_func);
										$row_func = $result_func->fetch_array();
										$nama_procedure = $row_func['nama_prosedural'];
										//parameter
										$exec_par = '';
										for ($i=0; $i<count($parameter_array); $i++) {
											if($i>0){
												$exec_par = $exec_par . ",'" . $parameter_array[$i] . "'";
											}else{
												$exec_par = $exec_par . "'" . $parameter_array[$i] . "'";
											}
										}

										//cek private or publik, boleh atau tidak
										$allowed_keyword = 1;
										if($row_kw['is_publik']==2){
											$query_pt = "SELECT * FROM tb_contact WHERE contact_id='" . $sender . "'";
											$result_pt = mysqli_query($id_mysql,$query_pt);
											$row_pt = $result_pt->fetch_array();
											$ptc = mysqli_num_rows($result_pt);
											if($ptc>0){
												$allowed_keyword = 1;
											}else{
												$allowed_keyword = 2;
											}
										}
										if($allowed_keyword == 1){
											$query_exec = "CALL ".$nama_procedure."(".$exec_par.")";

											//eksekusi
											if($result_func = mysqli_query($id_mysql_host,$query_exec)){
												//output
												balas_sukses($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_sukses,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
											}else{
												balas_gagal($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_gagal,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
											}
										}else{
											//pesan private
											balas_normal($id_mysql,$sender,$server_inb,$pesan_private,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server,$max_char);
										}
									}
								}elseif($row_kw['id_jenis_operasi']==1){//insert
									//cari insert tabel
									$query_func = "SELECT nama_tabel FROM tb_operasi_tabel WHERE id_operasi='".$id_operasi."' LIMIT 1";
									$result_func = mysqli_query($id_mysql,$query_func);
									$row_func = $result_func->fetch_array();
									$nama_tabel = $row_func['nama_tabel'];
									//parameter
									//value insert
									$query_value = "SELECT parameter FROM tb_operasi_parameter WHERE id_operasi='".$id_operasi."' AND is_kunci!='1'";
									$result_value = mysqli_query($id_mysql,$query_value);
									$param_par = '';
									$value_par = '';
									$j=0;
									while($row_value = $result_value->fetch_array()) {
										if($j>0){
											$param_par = $param_par . "," . $row_value['parameter']; 
											$value_par = $value_par . "," . "'" . $parameter_array[$j] . "'";
										}else{
											$param_par = $param_par . $row_value['parameter'];
											$value_par = $value_par . "'" . $parameter_array[$j] . "'";
										}
										$j++;
									}
									//cek private or publik, boleh atau tidak
									$allowed_keyword = 1;
									if($row_kw['is_publik']==2){
										$query_pt = "SELECT * FROM tb_contact WHERE contact_id='" . $sender . "'";
										$result_pt = mysqli_query($id_mysql,$query_pt);
										$row_pt = $result_pt->fetch_array();
										$ptc = mysqli_num_rows($result_pt);
										if($ptc>0){
											$allowed_keyword = 1;
										}else{
											$allowed_keyword = 2;
										}
									}
									if($allowed_keyword == 1){
										//eksekusi
										$query_exec = "INSERT INTO ".$nama_tabel."(".$param_par.") VALUES(".$value_par.")";
										//
										if($result_func = mysqli_query($id_mysql_host,$query_exec)){
											//output
											balas_sukses($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_sukses,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
										}else{
											balas_gagal($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_gagal,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
										}
									}else{
										//pesan private
										balas_normal($id_mysql,$sender,$server_inb,$pesan_private,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server,$max_char);
									}
								}elseif($row_kw['id_jenis_operasi']==2){//update
									//cari update tabel
									$query_func = "SELECT nama_tabel FROM tb_operasi_tabel WHERE id_operasi='".$id_operasi."' LIMIT 1";
									$result_func = mysqli_query($id_mysql,$query_func);
									$row_func = $result_func->fetch_array();
									$nama_tabel = $row_func['nama_tabel'];
									//parameter
									$i=0;
									//value update
									$query_value = "SELECT parameter FROM tb_operasi_parameter WHERE id_operasi='".$id_operasi."' AND is_kunci!='1'";
									$result_value = mysqli_query($id_mysql,$query_value);
									$value_par = '';
									$j=0;
									while($row_value = $result_value->fetch_array()) {
										if($j>0){
											$value_par = $value_par . "," . $row_value['parameter'] . "='" . $parameter_array[$i] . "'";
										}else{
											$value_par = $value_par . $row_value['parameter'] . "='" . $parameter_array[$i] . "'";
										}
										$i++;
										$j++;
									}
									//kunci update
									$query_kunci = "SELECT parameter,type FROM tb_operasi_parameter WHERE id_operasi='".$id_operasi."' AND is_kunci='1'";
									$result_kunci = mysqli_query($id_mysql,$query_kunci);
									$kunci_par = '';
									$j=0;
									while($row_kunci = $result_kunci->fetch_array()) {
										if($j>0){
											$kunci_par = $kunci_par . " AND " . $row_kunci['parameter'] ." ". $row_kunci['type'] ." '". $parameter_array[$i]. "'";
										}else{
											$kunci_par = $kunci_par . $row_kunci['parameter'] ." ". $row_kunci['type'] ." '". $parameter_array[$i] . "'";
										}
										$i++;
										$j++;
									}
									//cek private or publik, boleh atau tidak
									$allowed_keyword = 1;
									if($row_kw['is_publik']==0){
										//cari penanda kontak
										$rk = $row_kw['reff_kontak'];
										$query_pk = "SELECT " . $rk . " FROM tb_contact WHERE contact_id='".$sender."' LIMIT 1";
										$result_pk = mysqli_query($id_mysql,$query_pk);
										$row_pk = $result_pk->fetch_array();
										$pk = $row_pk[0];
										//cari penanda tabel
										$rt = $row_kw['reff_kontak_tabel'];
										$query_pt = "SELECT " . $rt . " FROM ".$nama_tabel." WHERE ".$kunci_par." GROUP BY " . $rt;
										$result_pt = mysqli_query($id_mysql_host,$query_pt);
										$row_pt = $result_pt->fetch_array();
										$pt = $row_pt[0];
										$ptc = mysqli_num_rows($result_pt);
										//jika tidak sama = 2
										if($ptc>1){
											$allowed_keyword = 2;
										}elseif($pk==$pt){
											$allowed_keyword = 1;
										}else{
											$allowed_keyword = 2;
										}
									}elseif($row_kw['is_publik']==2){
										$query_pt = "SELECT * FROM tb_contact WHERE contact_id='" . $sender . "'";
										$result_pt = mysqli_query($id_mysql,$query_pt);
										$row_pt = $result_pt->fetch_array();
										$ptc = mysqli_num_rows($result_pt);
										if($ptc>0){
											$allowed_keyword = 1;
										}else{
											$allowed_keyword = 2;
										}
									}

									if($allowed_keyword==1){
										//eksekusi
										$query_exec = "UPDATE ".$nama_tabel." SET ".$value_par."  WHERE " . $kunci_par;
										//
										if($result_func = mysqli_query($id_mysql_host,$query_exec)){
											//output
											balas_sukses($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_sukses,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
										}else{
											balas_gagal($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_gagal,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
										}
									}else{
										//pesan private
										balas_normal($id_mysql,$sender,$server_inb,$pesan_private,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server,$max_char);
									}
								}elseif($row_kw['id_jenis_operasi']==3){//delete
									//cari delete tabel
									$query_func = "SELECT nama_tabel FROM tb_operasi_tabel WHERE id_operasi='".$id_operasi."' LIMIT 1";
									$result_func = mysqli_query($id_mysql,$query_func);
									$row_func = $result_func->fetch_array();
									$nama_tabel = $row_func['nama_tabel'];
									//parameter
									//kunci delete
									$query_kunci = "SELECT parameter,type FROM tb_operasi_parameter WHERE id_operasi='".$id_operasi."' AND is_kunci='1'";
									$result_kunci = mysqli_query($id_mysql,$query_kunci);
									$kunci_par = '';
									$j=0;
									while($row_kunci = $result_kunci->fetch_array()) {
										if($j>0){
											$kunci_par = $kunci_par . " AND " . $row_kunci['parameter'] ." ". $row_kunci['type'] ." '". $parameter_array[$j]. "'";
										}else{
											$kunci_par = $kunci_par . $row_kunci['parameter'] ." ". $row_kunci['type'] ." '". $parameter_array[$j] . "'";
										}
										$j++;
									}
									//cek private or publik, boleh atau tidak
									$allowed_keyword = 1;
									if($row_kw['is_publik']==2){
										$query_pt = "SELECT * FROM tb_contact WHERE contact_id='" . $sender . "'";
										$result_pt = mysqli_query($id_mysql,$query_pt);
										$row_pt = $result_pt->fetch_array();
										$ptc = mysqli_num_rows($result_pt);
										if($ptc>0){
											$allowed_keyword = 1;
										}else{
											$allowed_keyword = 2;
										}
									}
									if($allowed_keyword == 1){
										//eksekusi
										$query_exec = "DELETE FROM ".$nama_tabel." WHERE " . $kunci_par;
										//
										if($result_func = mysqli_query($id_mysql_host,$query_exec)){
											//output
											balas_sukses($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_sukses,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
										}else{
											balas_gagal($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_gagal,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
										}
									}else{
										//pesan private
										balas_normal($id_mysql,$sender,$server_inb,$pesan_private,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server,$max_char);
									}
								}elseif($row_kw['id_jenis_operasi']==4){//select
									//cari tabel
									$query_tbl = "SELECT nama_tabel FROM tb_operasi_tabel WHERE id_operasi='".$id_operasi."'";
									$result_tbl = mysqli_query($id_mysql,$query_tbl);

									$table_par = '';
									$i=0;
									while($row_tbl = $result_tbl->fetch_array()) {
										if($i>0){
											$table_par = $table_par . "," . $row_tbl['nama_tabel'];
										}else{
											$table_par = $table_par . $row_tbl['nama_tabel'];
										}
										$i++;
									}
									//join
									$query_join = "SELECT field_join FROM tb_operasi_join WHERE id_operasi='".$id_operasi."'";
									$result_join = mysqli_query($id_mysql,$query_join);
									$join_par = '';
									while($row_join = $result_join->fetch_array()) {
										$join_par = $join_par . " AND " . $row_join['field_join'];
									}
									//parameter
									$query_func = "SELECT parameter,type FROM tb_operasi_parameter WHERE id_operasi='".$id_operasi."' AND is_kunci='1'";
									$result_func = mysqli_query($id_mysql,$query_func);

									$where_par = '';
									$i=0;
									while($row_func = $result_func->fetch_array()) {
										if($row_func['type']=='LIKE'){
											$where_par = $where_par . " AND " . $row_func['parameter'] . " " . $row_func['type'] . " '%" . $parameter_array[$i] ."%'";
										}else{
											$where_par = $where_par . " AND " . $row_func['parameter'] . " " . $row_func['type'] . " '" . $parameter_array[$i] ."'";
										}
										$i++;
									}
									//output
									$query_output = "SELECT output,nama_output FROM tb_operasi_output WHERE id_operasi='".$id_operasi."'";
									$result_output = mysqli_query($id_mysql,$query_output);

									$output_par = '';
									$i=0;
									while($row_output = $result_output->fetch_array()) {
										if($i>0){
											$output_par = $output_par . "," . $row_output['output'];
										}else{
											$output_par = $output_par . $row_output['output'];
										}
										$i++;
									}
									//order 
									$query_order = "SELECT order_by,IF(`type`=1,'ASC','DESC') AS `type` FROM tb_operasi_order_by WHERE id_operasi='".$id_operasi."'";
									$result_order = mysqli_query($id_mysql,$query_order);
									$order_par = '';
									$i=0;
									while($row_order = $result_order->fetch_array()) {
										if($i>0){
											$order_par = $order_par . "," . $row_order['order_by'] . " " . $row_order['type'] . " ";
										}else{
											$order_par = $order_par . $row_order['order_by'] . " " . $row_order['type'] . " ";
										}
										$i++;
									}
									if($order_par != ""){
										$order_par = " ORDER BY " . $order_par;
									}

									//full query
									$full_query = "SELECT " . $output_par . " FROM " . $table_par . " WHERE 1=1 " . $join_par . $where_par . $order_par;
									//cek private or publik, boleh atau tidak
									$allowed_keyword = 1;
									if($row_kw['is_publik']==0){
										//cari penanda kontak
										$rk = $row_kw['reff_kontak'];
										$query_pk = "SELECT " . $rk . " FROM tb_contact WHERE contact_id='".$sender."' LIMIT 1";
										$result_pk = mysqli_query($id_mysql,$query_pk);
										$row_pk = $result_pk->fetch_array();
										$pk = $row_pk[0];
										//cari penanda tabel
										$rt = $row_kw['reff_kontak_tabel'];
										$query_pt = "SELECT " . $rt . " FROM " . $table_par . " WHERE 1=1 " . $join_par . $where_par . " GROUP BY ". $rt ." " . $order_par;
										$result_pt = mysqli_query($id_mysql_host,$query_pt);
										$row_pt = $result_pt->fetch_array();
										$pt = $row_pt[0];
										$ptc = mysqli_num_rows($result_pt);
										//jika tidak sama = 2
										if($ptc>1){
											$allowed_keyword = 2;
										}elseif($pk==$pt){
											$allowed_keyword = 1;
										}else{
											$allowed_keyword = 2;
										}
									}elseif($row_kw['is_publik']==2){
										$query_pt = "SELECT * FROM tb_contact WHERE contact_id='" . $sender . "'";
										$result_pt = mysqli_query($id_mysql,$query_pt);
										$row_pt = $result_pt->fetch_array();
										$ptc = mysqli_num_rows($result_pt);
										if($ptc>0){
											$allowed_keyword = 1;
										}else{
											$allowed_keyword = 2;
										}
									}

									if($allowed_keyword==1){
										//echo $full_query;
										//select hasilnya
										$query_result = $full_query;
										$result_result = mysqli_query($id_mysql_host,$query_result);
										$result_par="";
										$j=0;
										while($row_result = $result_result->fetch_array()) {
											if($j>0){
												$result_par = $result_par . $pemisah_baris;
											}
											//
											$i=0;
											$query_output = "SELECT output,nama_output,jenis_output FROM tb_operasi_output WHERE id_operasi='".$id_operasi."'";
											$result_output = mysqli_query($id_mysql,$query_output);
											while($row_output = $result_output->fetch_array()) {
												$result_string = "";
												//output is string,integer, or currency
												if($row_output['jenis_output'] == "2"){//number
													$result_string = number_format($row_result[$i], 2, ',', '.');
												}elseif($row_output['jenis_output'] == "3"){//currency
													$result_string = "Rp. " . number_format($row_result[$i], 2, ',', '.');
												}else{//string
													$result_string = $row_result[$i];
												}
												if($i>0){
													$result_par = $result_par . $pemisah_kolom . $row_output['nama_output'] . $result_string;
												}else{
													$result_par = $result_par . $row_output['nama_output'] . $result_string;
												}
												$i++;
											}
											$j++;
										}
										//
										if($j==0){
											$pesan="Data tidak ditemukan.";
										}else{
											$pesan=$result_par;
										}
										balas_normal($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server,$max_char);
									}else{
										//pesan private
										balas_normal($id_mysql,$sender,$server_inb,$pesan_private,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server,$max_char);
									}
								}
							}else{
								//gagal connect
								balas_gagal($id_mysql,$sender,$server_inb,$balasan_prefix.$pesan_gagal,$outbox_table,$outbox_isi,$outbox_date,$outbox_server,$outbox_recipient);
							}
						}else{
							//balas spam (parameter tidak sesuai jumlahnya)
							balas_spam($id_mysql,$balas_spam,$sender,$server_inb,$balasan_prefix.$pesan_spam,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server);
						}
					}else{
						//balas spam (keyword tidak ada)
						balas_spam($id_mysql,$balas_spam,$sender,$server_inb,$balasan_prefix.$pesan_spam,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server);
					}
				}else{
					//balas spam (keyword kosong atau parameter kosong)
					balas_spam($id_mysql,$balas_spam,$sender,$server_inb,$balasan_prefix.$pesan_spam,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server);
				}
			}else{
				//balas spam (random message tanpa karakter pemisah)
				balas_spam($id_mysql,$balas_spam,$sender,$server_inb,$balasan_prefix.$pesan_spam,$outbox_table,$outbox_isi,$outbox_date,$outbox_recipient,$outbox_server);
			}
	    	//set inbox flag = 3
	    	$query_flag = "UPDATE " . $inbox_table . " SET " . $inbox_flag . "='3' WHERE id='" . $id_message . "'";
	    	$result_flag = mysqli_query($id_mysql,$query_flag);
	    	//
	    	$cnt_msg_sub += 1;
		}
		//log
		$pesan_log = $pesan_log . " " . $nama_service . "=" . $cnt_msg_sub;
		$cnt_msg += $cnt_msg_sub;
	}

	add_log("Respon berhasil dieksekusi , ".$cnt_msg." pesan berhasil diproses. Detail :" . $pesan_log,$id_mysql);
?>