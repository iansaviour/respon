<?php 
	$id_mysql = mysqli_connect($server_dev, $username_dev, $password_dev, $name_dev);
	
	//Fungsi eksekusi query express ke database akademik
	function query($query) {
		global $db_host;
		global $db_username;
		global $db_password;
		global $db_name;
		
		$connect = mysql_connect($db_host,$db_username,$db_password);
		$use_db = mysql_select_db($db_name);
		if($connect) {
			if($use_db) {
				$data = mysql_query($query);
				if($data) return $data;
				else return false;
			}
			else return false;
		}
		else return false;
	}

	function delete_directory($dirname) {
	     if (is_dir($dirname))
	           $dir_handle = opendir($dirname);
		 if (!$dir_handle)
		      return false;
		 while($file = readdir($dir_handle)) {
		       if ($file != "." && $file != "..") {
		            if (!is_dir($dirname."/".$file))
		                 unlink($dirname."/".$file);
		            else
		                 delete_directory($dirname.'/'.$file);
		       }
		 }
		 closedir($dir_handle);
		 rmdir($dirname);
		 return true;
	}

	function recurse_copy($src,$dst) { 
	    $dir = opendir($src); 
	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	        } 
	    } 
	    closedir($dir); 
	} 

	function svcToJson($dst){
		global $id_mysql;
		$query = "SELECT * FROM tb_service svc JOIN tb_option ORDER BY svc.id_service ASC";
		$result = mysqli_query($id_mysql, $query);
		$posts=array();
		$res=array();
		while ($data = mysqli_fetch_array($result)) {
			$id_service = $data["id_service"];
			$service= $data["service"];
			$inbox_table= $data["inbox_table"];
			$inbox_content= $data["inbox_content"];
			$inbox_date= $data["inbox_date"];
			$inbox_flag= $data["inbox_flag"];
			$inbox_sender= $data["inbox_sender"];
			$outbox_table= $data["outbox_table"];
			$outbox_content= $data["outbox_content"];
			$outbox_date= $data["outbox_date"];
			$outbox_flag= $data["outbox_flag"];
			$outbox_recipient= $data["outbox_recipient"];
			$char_pemisah = $data["char_pemisah"];
			$posts[] = array(
						'id_service'=> $id_service, 
						'service'=> $service,
						'inbox_table' => $inbox_table,
						'inbox_content' => $inbox_content,
						'inbox_date' => $inbox_date,
						'inbox_flag' => $inbox_flag,
						'inbox_sender' => $inbox_sender,
						'outbox_table' => $outbox_table,
						'outbox_content' => $outbox_content,
						'outbox_date' => $outbox_date,
						'outbox_flag' => $outbox_flag,
						'outbox_recipient' => $outbox_recipient,
						'char_pemisah' => $char_pemisah
					 );
		}
		$fp = fopen($dst.'apps.json', 'w');
		fwrite($fp, json_encode($posts));
		fclose($fp);
	}

	function createOPJson($dst, $id_app){
		global $id_mysql;
		$query = "SELECT det.id_app_det,det.id_operasi, op.id_host, op.id_jenis_operasi, op.id_jenis_sql, 
		op.keyword, op.is_publik, op.nama_operasi, op.penanda_login
		FROM tb_config_host_det det 
		INNER JOIN tb_operasi op ON op.id_operasi = det.id_operasi
		WHERE det.id_app=$id_app";
		$result = mysqli_query($id_mysql, $query);
		$posts=array();
		$res=array();
		while ($data = mysqli_fetch_array($result)) {
			$id_app_det = $data["id_app_det"];
			$id_operasi = $data["id_operasi"];
			$id_host = $data["id_host"];
			$id_jenis_operasi = $data["id_jenis_operasi"];
			$id_jenis_sql = $data["id_jenis_sql"];
			$keyword = $data["keyword"];
			$is_publik = $data["is_publik"];
			$nama_operasi = $data["nama_operasi"];
			$penanda_login = $data["penanda_login"];
			$posts[] = array(
						'id_app_det' => $id_app_det,
						'id_operasi'=> $id_operasi, 
						'id_host'=> $id_host,
						'id_jenis_operasi' => $id_jenis_operasi,
						'id_jenis_sql' => $id_jenis_sql,
						'keyword' => $keyword,
						'is_publik' => $is_publik,
						'nama_operasi' => $nama_operasi,
						'penanda_login' => $penanda_login
					 );
		}
		$fp = fopen($dst.'op.json', 'w');
		fwrite($fp, json_encode($posts));
		fclose($fp);
	}

	function copy_directory($src,$dst) {
	    $dir = opendir($src);
	    @mkdir($dst);
	    while(false !== ( $file = readdir($dir)) ) {
	        if (( $file != '.' ) && ( $file != '..' )) {
	            if ( is_dir($src . '/' . $file) ) {
	                recurse_copy($src . '/' . $file,$dst . '/' . $file);
	            }
	            else {
	                copy($src . '/' . $file,$dst . '/' . $file);
	            }
	        }
	    }
	    closedir($dir);
	}
	
	function getCredentials(){
		$query = "SELECT consumer_key, consumer_secret, oauth_token, oauth_token_secret FROM tb_option_twitter ";
		$res = mysql_query($query);
		$data = mysql_fetch_array($res);
		return $data;
	}

	function limitReq($auth,$type){
		$params = array(
			'resources' => $type,
		);
		$response = $auth->get('application/rate_limit_status', $params);
		$head = $auth->getHeaders();
		return $head['x-rate-limit-remaining'];
	}

	function sender_default_id(){
		$query = "SELECT nama_modem FROM tb_modem WHERE is_default='1'";
		$result = mysql_query($query);
		$data = mysql_fetch_array($result);
		$sender_default = $data['nama_modem'];
		Return $sender_default;
	}

	function nomor_default(){
		$query = "SELECT nomor FROM tb_modem WHERE is_default='1'";
		$result = mysql_query($query);
		$data = mysql_fetch_array($result);
		$nomor = $data['nomor'];
		Return $nomor;
	}

	function cast_operasi($sender, $id_operasi, $message, $type){
		//type 1=sms,2=twitter
		$sender_ID = sender_default_id();
		$query_id = "SELECT char_pemisah FROM tb_option LIMIT 1";
		$result_id = mysql_query($query_id);
		$data_id = mysql_fetch_array($result_id);
		$pemisah_lokal = $data_id['char_pemisah'];
		$query = "SELECT * FROM tb_operasi_cast, tb_host WHERE tb_operasi_cast.id_host = tb_host.id_host AND tb_operasi_cast.id_operasi = '$id_operasi' ";

		if ($type=="1") {
			$result = mysql_query($query);
			while ($data = mysql_fetch_array($result)) {
				$no_hp = $data['no_hp'];
				if ($no_hp!=$sender || $no_hp!=nomor_default()) {
					$karakter_pemisah = $data['karakter_pemisah'];
					if ($karakter_pemisah="") {
						// ambil pemisah
						$query_id = "SELECT char_pemisah FROM tb_option LIMIT 1";
						$result_id = mysql_query($query_id);
						$data_id = mysql_fetch_array($result_id);
						$karakter_pemisah = $data['char_pemisah'];
					}
					$sms_out = str_replace($pemisah_lokal, $karakter_pemisah, $pemisah_lokal);
					//fungsi_send_sms(sms_out, no_hp, "2");
				}
			}
		} elseif($type="2") {
			$result = mysql_query($query);
			while ($data = mysql_fetch_array($result)) {
				$user_screen = $data['user_screen'];
				if ($user_screen!=$sender) {
					$karakter_pemisah = $data['karakter_pemisah'];
					if ($karakter_pemisah="") {
						// ambil pemisah
						$query_id = "SELECT char_pemisah FROM tb_option LIMIT 1";
						$result_id = mysql_query($query_id);
						$data_id = mysql_fetch_array($result_id);
						$karakter_pemisah = $data['char_pemisah'];
					}
					$sms_out = str_replace($pemisah_lokal, $karakter_pemisah, $pemisah_lokal);
					fungsi_send_twitter($sms_out, $user_screen);
				}
			}
		}
		
	}

	function fungsi_send_twitter($twit, $user_screen){
		$query="INSERT INTO tb_sent_twitter(`outbox_date`,`outbox`,`outbox_user_screen`,`is_sent`) VALUES(NOW(),'".addslashes($twit)."','".$user_screen."','1')";
		$result = mysql_query($query);
	}

	function fungsi_broadcast_twitter($sms_out, $user_screen, $grup_name){
		$query_cek ="SELECT kontak.nama_kontak,kontak.user_screen FROM tb_grup_kontak_member g_kontak_m ";
		$query_cek.="INNER JOIN tb_grup_kontak g_kontak ON g_kontak.id_grup_kontak=g_kontak_m.id_grup_kontak ";
		$query_cek.="INNER JOIN tb_kontak kontak ON g_kontak_m.id_kontak=kontak.id_kontak ";
		$query_cek.="WHERE g_kontak.grup_kontak='$grup_name' ";
		$result_cek = mysql_query($query_cek);
		$n = mysql_num_rows($result_cek);
		if ($n>0) {
			while ($data = mysql_fetch_array($result_cek)) {
				fungsi_send_twitter($sms_out, $data["user_screen"]);
			}
			//  'send broadcast success
			fungsi_send_twitter("Broadcast sukses.", $user_screen);
		} else {
			//send there is no grup member
            fungsi_send_twitter("Tidak ada yang terdaftar dalam grup.", $user_screen);
		}
		
	}

	function dataRespon($media_respon, $type_respon){
		$media_query = "";
		if ($media_respon=="1") { //twitter
			$media_query="INNER JOIN tb_inbox_twitter ON tb_eksekusi_respon.id_inbox = tb_inbox_twitter.id_inbox ";
		}

		$query_eksekusi="";
		if ($type_respon=="1") { //spam
			$query_eksekusi = "SELECT tb_eksekusi_respon.id_eksekusi,tb_inbox_twitter.inbox_user_screen,tb_eksekusi_respon.query_value,tb_eksekusi_respon.output_sms ";
			$query_eksekusi .= "FROM tb_eksekusi_respon ";
			$query_eksekusi .= $media_query;
			$query_eksekusi .= "WHERE output_sms='Error : SMS SPAM' ";
			$result_eksekusi = mysql_query($query_eksekusi);
			$n_eksekusi = mysql_num_rows($result_eksekusi);
			$data = array();
			$index = 0;
			while ($data_eksekusi = mysql_fetch_array($result_eksekusi)) {
				$data[$index]['id_eksekusi'] = $data_eksekusi["id_eksekusi"];
		        $data[$index]['pengirim'] = $data_eksekusi["inbox_user_screen"];
		        $data[$index]['output_sms'] = $data_eksekusi["output_sms"];
				$index++;
			}
		}elseif ($type_respon=="2") { //gagal
			$query_eksekusi = "SELECT tb_eksekusi_respon.id_eksekusi,tb_inbox_twitter.inbox_user_screen,tb_eksekusi_respon.query_value,tb_eksekusi_respon.output_sms ";
			$query_eksekusi .= "FROM tb_eksekusi_respon ";
			$query_eksekusi .= $media_query;
			$query_eksekusi .= "WHERE query_value='error' ";
			$result_eksekusi = mysql_query($query_eksekusi);
			$n_eksekusi = mysql_num_rows($result_eksekusi);
			$data = array();
			$index = 0;
			while ($data_eksekusi = mysql_fetch_array($result_eksekusi)) {
				$data[$index]['id_eksekusi'] = $data_eksekusi["id_eksekusi"];
		        $data[$index]['pengirim'] = $data_eksekusi["inbox_user_screen"];
		        $data[$index]['output_sms'] = $data_eksekusi["output_sms"];
				$index++;
			}
		}elseif ($type_respon=="3") { //reply data
			$query_eksekusi  = "SELECT tb_eksekusi_respon.id_eksekusi,tb_inbox_twitter.inbox_user_screen,tb_operasi.id_jenis_operasi,tb_eksekusi_respon.query_value,tb_host.host,tb_host.username,tb_host.password,tb_eksekusi_respon.output_sms,tb_eksekusi_respon.output_field,tb_eksekusi_respon.key_op,tb_host.db,tb_eksekusi_respon.id_operasi,tb_inbox_twitter.inbox,tb_eksekusi_respon.is_broadcast,tb_eksekusi_respon.broadcast_grup ";
			$query_eksekusi .= "FROM tb_eksekusi_respon ";
			$query_eksekusi .= $media_query;
			$query_eksekusi .= "INNER JOIN tb_operasi ON tb_eksekusi_respon.id_operasi = tb_operasi.id_operasi ";
			$query_eksekusi .= "INNER JOIN tb_host ON tb_operasi.id_host = tb_host.id_host ";
			$query_eksekusi .= "WHERE op_status='1' ";
			$result_eksekusi = mysql_query($query_eksekusi);
			$n_eksekusi = mysql_num_rows($result_eksekusi);
			$data = array();
			$index = 0;
			while ($data_eksekusi = mysql_fetch_array($result_eksekusi)) 
			{
				$data[$index]['id_eksekusi'] = $data_eksekusi["id_eksekusi"];
		        $data[$index]['pengirim'] = $data_eksekusi["inbox_user_screen"];

		        //operasi
		        $data[$index]['jenis_operasi'] = $data_eksekusi["id_jenis_operasi"];
		        $data[$index]['query_parsing'] = $data_eksekusi["query_value"];
		        $data[$index]['host'] = $data_eksekusi["host"];
		        $data[$index]['username'] = $data_eksekusi["username"];
		        $data[$index]['password'] = $data_eksekusi["password"];
		        $data[$index]['output_sms'] = $data_eksekusi["output_sms"];
		        $data[$index]['output_field'] = $data_eksekusi["output_field"];
		        $data[$index]['key_op'] = $data_eksekusi["key_op"];
		        $data[$index]['dbx'] = $data_eksekusi["db"];
		        $data[$index]['id_operasix'] = $data_eksekusi["id_operasi"];
		        $data[$index]['sms_in'] = $data_eksekusi["inbox"];
				$index++;
			}
		}elseif ($type_respon=="4") { //sukses
			$query_eksekusi = "SELECT tb_eksekusi_respon.id_eksekusi,tb_inbox_twitter.inbox_user_screen,tb_operasi.id_jenis_operasi,tb_eksekusi_respon.query_value,tb_host.host,tb_host.username,tb_host.password,tb_eksekusi_respon.output_sms,tb_eksekusi_respon.output_field,tb_inbox_twitter.inbox,tb_host.db,IFNULL(tb_eksekusi_respon.id_operasi,0) as id_operasi,tb_eksekusi_respon.is_broadcast,tb_eksekusi_respon.broadcast_grup ";
			$query_eksekusi .= "FROM tb_eksekusi_respon ";
			$query_eksekusi .= $media_query;
			$query_eksekusi .= "INNER JOIN tb_operasi ON tb_eksekusi_respon.id_operasi = tb_operasi.id_operasi ";
			$query_eksekusi .= "INNER JOIN tb_host ON tb_operasi.id_host = tb_host.id_host ";
			$query_eksekusi .= "WHERE op_status='0' ";
			$result_eksekusi = mysql_query($query_eksekusi);
			$n_eksekusi = mysql_num_rows($result_eksekusi);
			$data = array();
			$index = 0;
			while ($data_eksekusi = mysql_fetch_array($result_eksekusi)) {
				$data[$index]['id_eksekusi'] = $data_eksekusi["id_eksekusi"];
		        $data[$index]['pengirim'] = $data_eksekusi["inbox_user_screen"];

		        $data[$index]['jenis_operasi'] = $data_eksekusi["id_jenis_operasi"];
		        $data[$index]['query_parsing'] = $data_eksekusi["query_value"];
		        $data[$index]['host'] = $data_eksekusi["host"];
		        $data[$index]['username'] = $data_eksekusi["username"];
		        $data[$index]['password'] = $data_eksekusi["password"];
		        $data[$index]['output_sms'] = $data_eksekusi["output_sms"];
		        $data[$index]['output_field'] = $data_eksekusi["output_field"];
		        $data[$index]['sms_in'] = $data_eksekusi["inbox"];
		        $data[$index]['dbx'] = $data_eksekusi["db"];
		        $data[$index]['id_operasix'] = $data_eksekusi["id_operasi"];

		        $data[$index]['is_broadcastx'] = $data_eksekusi["is_broadcast"];
		        $data[$index]['broadcast_grupx'] = $data_eksekusi["broadcast_grup"];
				$index++;
			}
		}
		return $data;
	}
	
	//Fungsi untuk get nama file dari url
	function get_file($url) {
		$temp = explode('/', $url);

		return $temp[(count($temp) - 1)];
	}

	function checkAccess(){
		if(isset($_SESSION['is_login_respon'])){
			//return $_SESSION['id_role'];
		}else{
			header("Location: login.php");	
			die();
		}
	}

	function checkSvc(){
		if(isset($_SESSION['id_svc'])){
			$_SESSION['svc'] = $_SESSION['svc']; 
		}else{
			$_SESSION['svc']="-";
		}
	}

	function checkOPLogin(){
		if(isset($_SESSION['is_login'])!="1"){
			header("Location: login_op.php");	
			die();
		}
	}

	function checkAccessLoginPage(){
		if(isset($_SESSION['is_login_respon'])){
			header("Location: index.php");	
			die();
		}else{
			
		}
	}
	

	/*defend against cross-site scripting*/
	function strip_html_tags( $text ){
		$text = preg_replace(
		    array(
		      // Remove invisible content
		        '@<head[^>]*?>.*?</head>@siu',
		        '@<style[^>]*?>.*?</style>@siu',
		        '@<script[^>]*?.*?</script>@siu',
		        '@<object[^>]*?.*?</object>@siu',
		        '@<embed[^>]*?.*?</embed>@siu',
		        '@<applet[^>]*?.*?</applet>@siu',
		        '@<noframes[^>]*?.*?</noframes>@siu',
		        '@<noscript[^>]*?.*?</noscript>@siu',
		        '@<noembed[^>]*?.*?</noembed>@siu'
		    ),
		    array(
		        '', '', '', '', '', '', '', '', ''), $text );
		  
		return strip_tags( $text);
	}

	function makeSafe($variable){
		global $id_mysql;
		$variable = strip_html_tags($variable);
	    $variable = mysqli_real_escape_string($id_mysql,trim($variable));
	    //$variable = remove_white_spaces($variable);
	    return $variable;
	}
	

	//FUngsi url profile pegawai
	function profil_peg($id_pegawai) {
		return "SEMPRUL";
	}

	//Fungsi get row pertama dari tabel
	function get_value($tb_name,$col_name) {
		$query = "SELECT * FROM ".$tb_name." LIMIT 1";
		$data = query($query);
		
		$baris = mysql_fetch_array($data);
		
		if($col_name == "") {
			return $baris;
		}
		else {
			return $baris[$col_name];
		}
	}
	
	//Fungsi alamat avatar mahasiswa
	function show_ava($id_mhs) {
		return pictURL($id_mhs,2,2);
	}
	
	//Fungsi membalik tanggal
	function fix_date($val) {
		$date = explode('-',$val);
		$date = $date[2]." ".text_month($date[1])." ".$date[0];
		return $date;
	}

	// Fungsi memastikan keberhasilan query
	function confirm_query($result_set){
		if(!$result_set){
			die("Query database gagal: " . mysql_error());
		}
	}

	// Fungsi redirect
	function redirect($url = NULL){
		if($url != NULL){
			header("Location: {$url}");
			exit;
		}
	}

	
	//Fungsi selisih tanggal
	function date_difference($charSeparator, $endDate, $beginDate)
	{
		$date_parts1=explode($charSeparator, $beginDate);
		$date_parts2=explode($charSeparator, $endDate);
		
		$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
		$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
		
		return $end_date - $start_date;
	}
	
	//Fungsi konversi bulan
	function text_month($number_month)
	{
		if($number_month == 1) return "Januari";
		else if($number_month == 2) return "Februari";
		else if($number_month == 3) return "Maret";
		else if($number_month == 4) return "April";
		else if($number_month == 5) return "Mei";
		else if($number_month == 6) return "Juni";
		else if($number_month == 7) return "Juli";
		else if($number_month == 8) return "Agustus";
		else if($number_month == 9) return "September";
		else if($number_month == 10) return "Oktober";
		else if($number_month == 11) return "November";
		else return "Desember";
	}
	
	//Fungsi get jumlah record
	function get_jumlah($query) {
		$query_jml = $query;
		$data = query($query_jml);
		$jml = mysql_num_rows($data);
		
		return $jml;
	}
	
	//fungsi cari angkatan
	function cari_angkatan($id_mhs){
		$query = "SELECT tb_angkatan.angkatan FROM tb_angkatan,tb_mhs WHERE tb_mhs.id_angkatan=tb_angkatan.id_angkatan AND tb_mhs.id_mhs = '" . $id_mhs . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		
		return($angkatan);
	}
	
	//fungsi cari id_mhs dari nim
	function cari_id_mhs($nim){
		$query = "SELECT tb_mhs.id_mhs FROM tb_mhs WHERE tb_mhs.nim = '" . $nim . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		
		return($id_mhs);
	}
	
	//fungsi cari nim dari id_mhs
	function cari_detail_mhs($id_mhs,$pil){
		$hasil = "";
		//pil
		//1= nim
		//2= nama
		//3 = id_konsentrasi
		//4 = nama_konsentrasi
		$query = "SELECT tb_mhs.nim,tb_mhs.nama,id_konsentrasi FROM tb_mhs WHERE tb_mhs.id_mhs = '" . $id_mhs . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		$id_konsentrasix = $id_konsentrasi;
		if($pil == 1){
			$hasil = $nim;
		}elseif($pil == 2){
			$hasil = $nama;
		}
		elseif($pil == 3){
			$hasil =  $id_konsentrasix;
		}
		elseif($pil == 4){
			$query_konsentrasi = "SELECT nama as nama_konsentrasi FROM tb_konsentrasi WHERE id_konsentrasi='" . $id_konsentrasix . "'";
			$data_konsentrasi = query($query_konsentrasi);
			$baris_kon = mysql_fetch_array($data_konsentrasi);
			$hasil =  $baris_kon["nama_konsentrasi"];
		}
		return($hasil);
	}
	
	//cari semester
	function cari_semester($id_mhs){
		$query = "SELECT tb_angkatan.angkatan FROM tb_angkatan,tb_mhs WHERE tb_mhs.id_angkatan=tb_angkatan.id_angkatan AND tb_mhs.id_mhs = '" . $id_mhs . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		
		$query_view = "SELECT tahun_ajaran,semester FROM tb_periode WHERE status='1'";
		$data = query($query_view);
		extract(mysql_fetch_array($data));
		
		if($semester == 1){
			//ganjil
			$tahun = substr($tahun_ajaran,0,4);
			$semester = (($tahun - $angkatan)*2) + 1;
		}elseif($semester == 2){
			//genap
			$tahun = substr($tahun_ajaran,5,4);
			$semester = ($tahun - $angkatan)*2;
		}else{
			//pendek
			$semester = 0;
		}
		return($semester);
	}
	
	//cari id_periode sebelumnya
	function id_periode_sebelum($id_mhs){
		//isiin opt dari jumlah boleh cuti
		$jml_smt_blh_cuti = 4; 
		$ips_dipakai = cari_ket_ips($id_mhs);
		//
		$id_periode = 0;
		//menggunakan id_mhs untuk jaga2 cuti akademik utk mahasiswa bersangkutan
		$angkatan = cari_angkatan($id_mhs);
		
		$query_view = "SELECT tahun_ajaran,semester FROM tb_periode WHERE status='1'";
		$data = query($query_view);
		extract(mysql_fetch_array($data));
		$jml_cek = 0;
		
		if($semester == 1){
			//ganjil
			$tahun = substr($tahun_ajaran,0,4);
		}elseif($semester == 2){
			//genap
			$tahun = substr($tahun_ajaran,5,4);
		}else{
			//pendek
			$id_periode = 0;
			$jml_cek = 1;
		}
		
		if($ips_dipakai == 2 && $jml_cek == 0){
			$i = 1;
			while($jml_cek == 0 && $tahun > 1945){
				if($semester == 1){
					$tahun = $tahun;
					$tahun_ajaran = $tahun-1 . "/" . $tahun;
					$semester = 2;
				}elseif($semester == 2){
					$tahun = $tahun-1;
					$tahun_ajaran = $tahun . "/" . ($tahun+1);
					$semester = 1;
				}
				//cek ada gk periode itu, logikanya sih gak ada, kecuali cuti
				$query = "SELECT DISTINCT(tb_periode.id_periode) AS id_periode
					FROM tb_krs_$angkatan,tb_mk_penawaran,tb_periode 
					WHERE 
					tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
					AND tb_mk_penawaran.id_periode = tb_periode.id_periode 
					AND tb_krs_$angkatan.id_mhs = '" . $id_mhs . "'
					AND tb_periode.tahun_ajaran = '" . $tahun_ajaran . "'
					AND tb_periode.semester = '" . $semester . "'";
				$data = query($query);
				$jml_cek = mysql_num_rows($data);
				//cek
				if($jml_cek == 0){
					$id_periode = 0;
					if($i >= $jml_smt_blh_cuti){
						break;
					}
				}else{
					extract(mysql_fetch_array($data));
					$id_periode = $id_periode;
					break;
				}
				$i++;
			}
		}elseif($ips_dipakai == 1 && $jml_cek == 0){
			$i = 1;
			while($jml_cek == 0 && $tahun > 1945){
				if($semester == 1){
					$tahun = $tahun-1;
					$tahun_ajaran = $tahun . "/" . ($tahun+1);
					$semester = 1;
				}elseif($semester == 2){
					$tahun = $tahun-1;
					$tahun_ajaran = ($tahun-1) . "/" . $tahun;
					$semester = 2;
				}
				//cek ada gk periode itu, logikanya sih gak ada, kecuali cuti
				$query = "SELECT DISTINCT(tb_periode.id_periode) AS id_periode
					FROM tb_krs_$angkatan,tb_mk_penawaran,tb_periode 
					WHERE 
					tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
					AND tb_mk_penawaran.id_periode = tb_periode.id_periode 
					AND tb_krs_$angkatan.id_mhs = '" . $id_mhs . "'
					AND tb_periode.tahun_ajaran = '" . $tahun_ajaran . "'
					AND tb_periode.semester = '" . $semester . "'";
				$data = query($query);
				$jml_cek = mysql_num_rows($data);
				//cek
				if($jml_cek == 0){
					$id_periode = 0;
					if($i >= $jml_smt_blh_cuti){
						break;
					}
				}else{
					extract(mysql_fetch_array($data));
					$id_periode = $id_periode;
					break;
				}
				$i++;
			}
		}else{
			$id_periode = 0;
		}
		return($id_periode);
	}
	
	function cari_sks($id_mhs){
		$nim = cari_detail_mhs($id_mhs,1);
		$angkatan = cari_angkatan($id_mhs);
		
		$query = "SELECT tb_mk.sks AS sks FROM tb_krs_$angkatan,tb_mk_penawaran,tb_mk WHERE tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran AND tb_mk_penawaran.id_mk=tb_mk.id_mk AND tb_krs_$angkatan.id_mhs='$id_mhs' AND NOT ISNULL(id_bobot_nilai) AND tb_mk_penawaran.publish='1'";
		$data = query($query);
		$jml_cek = mysql_num_rows($data);
		
		if($jml_cek == 0){
			$sks = 0;
		}else{
			while($baris = mysql_fetch_array($data)){
				$jml_sks = $jml_sks + $baris["sks"];
			}
			$sks = $jml_sks;
		}
		return $sks;
	}
	
	function jml_peserta_mk($id_penawaran){
		$jml_peserta = 0;
		$query = "SELECT tb_angkatan.angkatan FROM tb_angkatan";
		$data = query($query);
		
		while($baris = mysql_fetch_array($data)){
			$angkatan = $baris["angkatan"];
			$query_2 = "SELECT * FROM tb_krs_$angkatan WHERE id_penawaran = '" . $id_penawaran . "'";
			$data_2 = query($query_2);
			$jml_peserta = $jml_peserta + mysql_num_rows($data_2);
		}
		
		return $jml_peserta;
	}
	
	function cek_kelas_oke($id_mhs,$id_penawaran){
		$ok = 0;
		
		$jml_peserta = "";
		
		$query = "SELECT tb_angkatan.angkatan FROM tb_angkatan";
		$data = query($query);
		
		while($baris = mysql_fetch_array($data)){
			$angkatan = $baris["angkatan"];
			$query_2 = "SELECT * FROM tb_krs_$angkatan WHERE id_penawaran = '" . $id_penawaran . "' AND id_mhs !='" . $id_mhs . "'";
			$data_2 = query($query_2);
			$jml_peserta = $jml_peserta + mysql_num_rows($data_2);
		}
		
		$query_3 = "SELECT tb_mk_penawaran.kapasitas_kelas FROM tb_mk_penawaran WHERE id_penawaran = '" . $id_penawaran . "'";
		$data_3 = query($query_3);
		$baris_3 = mysql_fetch_array($data_3);
		$kapasitas_kelas = $baris_3["kapasitas_kelas"];
		
		if($jml_peserta < $kapasitas_kelas){
			$ok = 1;
		}
		
		return $ok;
	}
	
	//cari ips 
	function cari_ips_periode($id_periode,$id_mhs){
		$jml_sks = 0;
		$jml_bobot = 0;
		
		$nim = cari_detail_mhs($id_mhs,1);
		$angkatan = cari_angkatan($id_mhs);
		
		$query = "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT  tb_krs_$angkatan.id_penawaran,tb_krs_$angkatan.id_bobot_nilai,tb_mk.sks AS sks FROM tb_krs_$angkatan,tb_mk_penawaran,tb_mk WHERE tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran AND tb_mk_penawaran.id_mk=tb_mk.id_mk AND tb_mk_penawaran.id_periode='$id_periode' AND tb_krs_$angkatan.id_mhs='$id_mhs' AND NOT ISNULL(id_bobot_nilai) AND tb_mk_penawaran.publish='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
		$data = query($query);
		$jml_cek = mysql_num_rows($data);
		if($jml_cek == 0){
			$ips = 0;
		}else{
			while($baris = mysql_fetch_array($data)){
				$jml_sks = $jml_sks + $baris["sks"];
				$jml_bobot = $jml_bobot + get_bobot_untuk_ipk($baris["id_penawaran"],$baris["id_bobot_nilai"],$baris["sks"]);
			}
			$ips = $jml_bobot / $jml_sks;
		}
		if(!is_float($ips)){
			return $ips;
		}else{
			return number_format($ips,2);
		}
	}
	//cari sks ips 
	function cari_sks_periode($id_periode,$id_mhs){
		$jml_sks = 0;
		$jml_bobot = 0;
		
		$nim = cari_detail_mhs($id_mhs,1);
		$angkatan = cari_angkatan($id_mhs);
		
		$query = "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT  tb_krs_$angkatan.id_penawaran,tb_krs_$angkatan.id_bobot_nilai,tb_mk.sks AS sks FROM tb_krs_$angkatan,tb_mk_penawaran,tb_mk WHERE tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran AND tb_mk_penawaran.id_mk=tb_mk.id_mk AND tb_mk_penawaran.id_periode='$id_periode' AND tb_krs_$angkatan.id_mhs='$id_mhs' AND NOT ISNULL(id_bobot_nilai) AND tb_mk_penawaran.publish='1' AND tb_krs_$angkatan.status='4' AND tb_krs_$angkatan.aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
		$data = query($query);
		$jml_cek = mysql_num_rows($data);
		if($jml_cek == 0){
			$ips = 0;
		}else{
			while($baris = mysql_fetch_array($data)){
				$jml_sks = $jml_sks + $baris["sks"];
				$jml_bobot = $jml_bobot + get_bobot_untuk_ipk($baris["id_penawaran"],$baris["id_bobot_nilai"],$baris["sks"]);
			}
			$ips = $jml_bobot / $jml_sks;
		}
		return $jml_sks;
	}
	//cari ips 
	function cari_ips_periode_adv($query_periode,$id_mhs){
		$jml_sks = 0;
		$jml_bobot = 0;
		
		$nim = cari_detail_mhs($id_mhs,1);
		$angkatan = cari_angkatan($id_mhs);
		
		$query = "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT  tb_krs_$angkatan.id_penawaran,tb_krs_$angkatan.id_bobot_nilai,tb_mk.sks AS sks FROM tb_krs_$angkatan,tb_mk_penawaran,tb_mk WHERE tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran AND tb_mk_penawaran.id_mk=tb_mk.id_mk AND tb_mk_penawaran.id_periode IN ($query_periode) AND tb_krs_$angkatan.id_mhs='$id_mhs' AND NOT ISNULL(id_bobot_nilai) AND tb_mk_penawaran.publish='1' AND tb_krs_$angkatan.status='4' AND tb_krs_$angkatan.aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
		$data = query($query);
		$jml_cek = mysql_num_rows($data);
		if($jml_cek == 0){
			$ips = 0;
		}else{
			while($baris = mysql_fetch_array($data)){
				$jml_sks = $jml_sks + $baris["sks"];
				$jml_bobot = $jml_bobot + get_bobot_untuk_ipk($baris["id_penawaran"],$baris["id_bobot_nilai"],$baris["sks"]);
			}
			$ips = $jml_bobot / $jml_sks;
		}
		if(!is_float($ips)){
			return $ips;
		}else{
			return number_format($ips,2);
		}
	}
	//cari sks ips 
	function cari_sks_periode_adv($query_periode,$id_mhs){
		$jml_sks = 0;
		$jml_bobot = 0;
		
		$nim = cari_detail_mhs($id_mhs,1);
		$angkatan = cari_angkatan($id_mhs);
		
		$query = "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT  tb_krs_$angkatan.id_penawaran,tb_krs_$angkatan.id_bobot_nilai,tb_mk.sks AS sks FROM tb_krs_$angkatan,tb_mk_penawaran,tb_mk WHERE tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran AND tb_mk_penawaran.id_mk=tb_mk.id_mk AND tb_mk_penawaran.id_periode IN ($query_periode) AND tb_krs_$angkatan.id_mhs='$id_mhs' AND NOT ISNULL(id_bobot_nilai) AND tb_mk_penawaran.publish='1' AND tb_krs_$angkatan.status='4' AND tb_krs_$angkatan.aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
		$data = query($query);
		$jml_cek = mysql_num_rows($data);
		if($jml_cek == 0){
			$ips = 0;
		}else{
			while($baris = mysql_fetch_array($data)){
				$jml_sks = $jml_sks + $baris["sks"];
				$jml_bobot = $jml_bobot + get_bobot_untuk_ipk($baris["id_penawaran"],$baris["id_bobot_nilai"],$baris["sks"]);
			}
			$ips = $jml_bobot / $jml_sks;
		}
		return $jml_sks;
	}
	//cari bobot ips
	function cari_bobot_periode_adv($query_periode,$id_mhs){
		$jml_sks = 0;
		$jml_bobot = 0;
		
		$nim = cari_detail_mhs($id_mhs,1);
		$angkatan = cari_angkatan($id_mhs);
		
		$query = "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT  tb_krs_$angkatan.id_penawaran,tb_krs_$angkatan.id_bobot_nilai,tb_mk.sks AS sks FROM tb_krs_$angkatan,tb_mk_penawaran,tb_mk WHERE tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran AND tb_mk_penawaran.id_mk=tb_mk.id_mk AND tb_mk_penawaran.id_periode IN ($query_periode) AND tb_krs_$angkatan.id_mhs='$id_mhs' AND NOT ISNULL(id_bobot_nilai) AND tb_mk_penawaran.publish='1' AND tb_krs_$angkatan.status='4' AND tb_krs_$angkatan.aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
		$data = query($query);
		$jml_cek = mysql_num_rows($data);
		if($jml_cek == 0){
			$ips = 0;
		}else{
			while($baris = mysql_fetch_array($data)){
				$jml_sks = $jml_sks + $baris["sks"];
				$jml_bobot = $jml_bobot + get_bobot_untuk_ipk($baris["id_penawaran"],$baris["id_bobot_nilai"],$baris["sks"]);
			}
			$ips = $jml_bobot / $jml_sks;
		}
		return $jml_bobot;
	}
	//cari banyak sks yang diambil
	function sks_dpt_diambil($id_mhs,$ips){
		//cari id_angkatan
		$query = "SELECT id_angkatan FROM tb_mhs WHERE id_mhs='" . $id_mhs . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		//cari 
		$query = "SELECT * FROM tb_batas_sks WHERE id_angkatan='" . $id_angkatan . "' ORDER BY batas_ips";
		$data = query($query);
		if(get_jumlah($query) == 0){
			if($ips >= 3){
				$sks = 25;
			}elseif($ips >= 2){
				$sks = 21;
			}else{
				$sks = 19;
			}
			$sks = $sks . "#1";
		}else{
			$sks = 18 . "#1";
			while($baris = mysql_fetch_array($data)){
				if($ips >= $baris["batas_ips"]){
					$sks = $baris["sks_dpt_diambil"] . "#" . $baris["toleransi_lebih"];
				}
			}
		}
		return $sks;
	}
	
	//cek status prasyarat
	function cek_syarat_mk($id_mk_prasyarat,$id_mhs,$pil){
		$query_periode = "SELECT * FROM tb_periode WHERE status='1'";
		$data_periode = query($query_periode);
		$baris_periode = mysql_fetch_array($data_periode);
		$id_periode = $baris_periode["id_periode"];
		//0 : sudah ambil
		//1 : sudah ambil dan lulus
		//2 : paralel
		$syarat = 0;
		$angkatan = cari_angkatan($id_mhs);
		//cari opt_nilai
		//1 = terbaik
		//2 = terbaru
		$nilai_dipakai = get_nilai_terpakai($id_mhs);
		if($nilai_dipakai == 1){
			$query_cek_dlm2 = "SELECT 
								tb_mk.kode,tb_mk.nama,tb_mk.sks,
								tb_bobot_nilai.nilai_huruf AS nilai_huruf, 
								MAX(tb_bobot_nilai.bobot_ipk) AS bobot_ipk,
								tb_krs_$angkatan.id_bobot_nilai,
								tb_krs_$angkatan.id_penawaran,
								tb_bobot_nilai.status_lulus
							FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,tb_bobot_nilai
							WHERE
								tb_mk.id_mk = tb_mk_penawaran.id_mk
								AND tb_bobot_nilai.id_bobot_nilai = tb_krs_$angkatan.id_bobot_nilai
								AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
								AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "'
								AND NOT ISNULL(tb_krs_$angkatan.id_bobot_nilai)
								AND tb_mk_penawaran.publish='1'
								AND tb_krs_$angkatan.status='4' 
								AND tb_krs_$angkatan.aktif='1' 
								AND tb_mk.id_mk='" . $id_mk_prasyarat . "'
								AND tb_mk_penawaran.id_periode != '" . $id_periode . "'
							GROUP BY tb_mk.kode";
		}else{
			$query_cek_dlm2 = "SELECT 
							  tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_bobot_nilai.nilai_huruf,
									tb_bobot_nilai.status_lulus
							  FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,tb_bobot_nilai,
								(SELECT MAX(tb_mk_penawaran.id_penawaran) AS id_penawaran
								 FROM 
									tb_mk,tb_mk_penawaran,tb_krs_$angkatan 
								 WHERE 
									tb_mk.id_mk = tb_mk_penawaran.id_mk 
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran 
									AND tb_krs_$angkatan.id_mhs='$id_mhs' 
									AND NOT ISNULL(tb_krs_$angkatan.id_bobot_nilai)
									AND tb_mk_penawaran.publish='1' 
									AND tb_krs_$angkatan.aktif='1' 
									AND tb_mk.id_mk='" . $id_mk_prasyarat . "'
									AND tb_mk_penawaran.id_periode != '" . $id_periode . "'
									AND tb_krs_$angkatan.status='4' GROUP BY tb_mk.kode) 
								 AS fil_id
						   WHERE 
						   	  tb_krs_$angkatan.id_bobot_nilai = tb_bobot_nilai.id_bobot_nilai 
						   	  AND tb_krs_$angkatan.id_mhs='$id_mhs'
							  AND tb_mk.id_mk = tb_mk_penawaran.id_mk 
							  AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
							  AND tb_mk_penawaran.id_penawaran = fil_id.id_penawaran";
		}
		//
		$data_cek_dlm2 = query($query_cek_dlm2);
		if($pil == 0){
			$jml_cek_dlm2 = mysql_num_rows($data_cek_dlm2);
			if($jml_cek_dlm2 != 0){
				$syarat = 1;
			}	
		}elseif($pil == 1){
			$jml_cek_dlm2 = mysql_num_rows($data_cek_dlm2);
			if($jml_cek_dlm2 != 0){
				$baris_cek_dlm2 = mysql_fetch_array($data_cek_dlm2);
				//syarat lulus
				if($baris_cek_dlm2["status_lulus"] == "1"){
					$syarat = 1;
				}
			}	
		}elseif($pil == 2){
			$jml_cek_dlm2 = mysql_num_rows($data_cek_dlm2);
			if($jml_cek_dlm2 != 0){
				$baris_cek_dlm2 = mysql_fetch_array($data_cek_dlm2);
				//syarat lulus
				if($baris_cek_dlm2["status_lulus"] == "1"){
					$syarat = 1;
				}
			}	
		}
		return $syarat;
	}
	function cek_masa_krs(){
		$penanda = 0;
		$query_periode = "SELECT * FROM tb_periode WHERE status='1'";
		$data_periode = query($query_periode);
		$baris_periode = mysql_fetch_array($data_periode);
		$id_periode = $baris_periode["id_periode"];
		$krs_awal = $baris_periode["krs_awal"];
		$krs_akhir = $baris_periode["krs_akhir"];
		$perubahan_krs_awal = $baris_periode["krs_awal"];
		$perubahan_krs_akhir = $baris_periode["krs_akhir"];
		
		$date_now = date("Y-m-d");
		
		$beda_awal_q = "SELECT DATEDIFF('$date_now','$krs_awal') as beda_awal";
		$data_awal = query($beda_awal_q);
		extract(mysql_fetch_array($data_awal));
		$beda_akhir_q = "SELECT DATEDIFF('$krs_akhir','$date_now') as beda_akhir";
		$data_akhir = query($beda_akhir_q);
		extract(mysql_fetch_array($data_akhir));
		
		if($beda_awal >= 0 && $beda_akhir >= 0){
			return true;
		}else{
			return false;
		}
	}
	
	function cari_ipk($id_mhs){
		$nim_mhs = cari_detail_mhs($id_mhs,1);
		$angkatan = cari_angkatan($id_mhs);
		
		$bobot_tot = 0;
		$sks_tot = 0;
		
		//cari opt_nilai
		//1 = terbaik
		//2 = terbaru
		$nilai_dipakai = get_nilai_terpakai($id_mhs);
		
		for($i=1;$i<=8;$i++){
			$sks_tot_1 = 0;
			$bobot_1 = 0;
			if($nilai_dipakai == 1){
				$query_smt = "SELECT 
									tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_bobot_nilai.nilai_huruf AS nilai_huruf, 
									MAX(tb_bobot_nilai.bobot_ipk) AS bobot_ipk,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_krs_$angkatan.id_penawaran
								FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,tb_bobot_nilai
								WHERE
									tb_mk.id_mk = tb_mk_penawaran.id_mk
									AND tb_bobot_nilai.id_bobot_nilai = tb_krs_$angkatan.id_bobot_nilai
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
									AND tb_mk.semester='" . $i . "' 
									AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "'
									AND NOT ISNULL(tb_krs_$angkatan.id_bobot_nilai)
									AND tb_mk_penawaran.publish='1'
									AND tb_krs_$angkatan.status='4'
									AND tb_krs_$angkatan.aktif='1'  
								GROUP BY tb_mk.kode";
			}else{
				$query_smt = "SELECT 
							  		tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_bobot_nilai.nilai_huruf AS nilai_huruf, 
									tb_bobot_nilai.bobot_ipk AS bobot_ipk,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_krs_$angkatan.id_penawaran
							  FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,tb_bobot_nilai,
								(SELECT MAX(tb_mk_penawaran.id_penawaran) AS id_penawaran
								 FROM 
									tb_mk,tb_mk_penawaran,tb_krs_$angkatan 
								 WHERE 
									tb_mk.id_mk = tb_mk_penawaran.id_mk 
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran 
									AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "' 
									AND NOT ISNULL(tb_krs_$angkatan.id_bobot_nilai)
									AND tb_mk_penawaran.publish='1' 
									AND tb_mk.semester='" . $i . "' 
									AND tb_krs_$angkatan.status='4' 
									AND tb_krs_$angkatan.aktif='1' 
									GROUP BY tb_mk.kode) 
								 AS fil_id
						      WHERE 
							  	  tb_krs_$angkatan.id_bobot_nilai = tb_bobot_nilai.id_bobot_nilai
								  AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "' 
								  AND tb_mk.id_mk = tb_mk_penawaran.id_mk 
								  AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
								  AND tb_mk_penawaran.id_penawaran = fil_id.id_penawaran";
			}
			$data_smt = query($query_smt);
			$jml_smt = get_jumlah($query_smt);
			if($jml_smt != 0){
				while($baris_smt = mysql_fetch_array($data_smt)){
					$bobot_1 = $bobot_1 + get_bobot_untuk_ipk($baris_smt["id_penawaran"],$baris_smt["id_bobot_nilai"],$baris_smt["sks"]);
					$sks_tot_1 = $sks_tot_1 + $baris_smt["sks"];
				}
			}
			$sks_tot = $sks_tot + $sks_tot_1;
			$bobot_tot = $bobot_tot + $bobot_1;	
		}
		if($bobot_tot == 0){
			$ipk = 0;
		}else{
			$ipk = $bobot_tot/$sks_tot;
		}
		if(!is_float($ipk)){
			return $ipk;
		}else{
			return number_format($ipk,2);
		}
	}

function cari_ipk_persemester($id_mhs, $semester_search){
		$nim_mhs = cari_detail_mhs($id_mhs,1);
		$angkatan = cari_angkatan($id_mhs);
		
		$bobot_tot = 0;
		$sks_tot = 0;
		
		//cari opt_nilai
		//1 = terbaik
		//2 = terbaru
		$nilai_dipakai = get_nilai_terpakai($id_mhs);
		
		for($i=1;$i<=$semester_search;$i++){
			$sks_tot_1 = 0;
			$bobot_1 = 0;
			if($nilai_dipakai == 1){
				$query_smt = "SELECT 
									tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_bobot_nilai.nilai_huruf AS nilai_huruf, 
									MAX(tb_bobot_nilai.bobot_ipk) AS bobot_ipk,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_krs_$angkatan.id_penawaran
								FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,tb_bobot_nilai
								WHERE
									tb_mk.id_mk = tb_mk_penawaran.id_mk
									AND tb_bobot_nilai.id_bobot_nilai = tb_krs_$angkatan.id_bobot_nilai
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
									AND tb_mk.semester='" . $i . "' 
									AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "'
									AND NOT ISNULL(tb_krs_$angkatan.id_bobot_nilai)
									AND tb_mk_penawaran.publish='1'
									AND tb_krs_$angkatan.status='4' 
								GROUP BY tb_mk.kode";
			}else{
				$query_smt = "SELECT 
							  		tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_bobot_nilai.nilai_huruf AS nilai_huruf, 
									tb_bobot_nilai.bobot_ipk AS bobot_ipk,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_krs_$angkatan.id_penawaran
							  FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,tb_bobot_nilai,
								(SELECT MAX(tb_mk_penawaran.id_penawaran) AS id_penawaran
								 FROM 
									tb_mk,tb_mk_penawaran,tb_krs_$angkatan 
								 WHERE 
									tb_mk.id_mk = tb_mk_penawaran.id_mk 
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran 
									AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "' 
									AND NOT ISNULL(tb_krs_$angkatan.id_bobot_nilai)
									AND tb_mk_penawaran.publish='1' 
									AND tb_mk.semester='" . $i . "' 
									AND tb_krs_$angkatan.status='4' GROUP BY tb_mk.kode) 
								 AS fil_id
						      WHERE 
							  	  tb_krs_$angkatan.id_bobot_nilai = tb_bobot_nilai.id_bobot_nilai
								  AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "' 
								  AND tb_mk.id_mk = tb_mk_penawaran.id_mk 
								  AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
								  AND tb_mk_penawaran.id_penawaran = fil_id.id_penawaran";
			}
			$data_smt = query($query_smt);
			$jml_smt = get_jumlah($query_smt);
			if($jml_smt != 0){
				while($baris_smt = mysql_fetch_array($data_smt)){
					$bobot_1 = $bobot_1 + get_bobot_untuk_ipk($baris_smt["id_penawaran"],$baris_smt["id_bobot_nilai"],$baris_smt["sks"]);
					$sks_tot_1 = $sks_tot_1 + $baris_smt["sks"];
				}
			}
			$sks_tot = $sks_tot + $sks_tot_1;
			$bobot_tot = $bobot_tot + $bobot_1;	
		}
		if($bobot_tot == 0){
			$ipk = 0;
		}else{
			$ipk = $bobot_tot/$sks_tot;
		}
		if(!is_float($ipk)){
			return $ipk;
		}else{
			return number_format($ipk,2);
		}
	}
	
	
	function cari_sks_tot($id_mhs){
		$angkatan = cari_angkatan($id_mhs);
		
		$bobot_tot = 0;
		$sks_tot = 0;
		
		//cari opt_nilai
		//1 = terbaik
		//2 = terbaru
		$nilai_dipakai = get_nilai_terpakai($id_mhs);
		
		for($i=1;$i<=8;$i++){
			$sks_tot_1 = 0;
			$bobot_1 = 0;
			if($nilai_dipakai == 1){
				$query_smt = "SELECT 
									tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_bobot_nilai.nilai_huruf AS nilai_huruf, 
									MAX(tb_bobot_nilai.bobot_ipk) AS bobot_ipk,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_krs_$angkatan.id_penawaran
								FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,tb_bobot_nilai
								WHERE
									tb_mk.id_mk = tb_mk_penawaran.id_mk
									AND tb_bobot_nilai.id_bobot_nilai = tb_krs_$angkatan.id_bobot_nilai
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
									AND tb_mk.semester='" . $i . "' 
									AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "'
									AND NOT ISNULL(tb_krs_$angkatan.id_bobot_nilai)
									AND tb_mk_penawaran.publish='1'
									AND tb_krs_$angkatan.status='4' 
									AND tb_krs_$angkatan.aktif='1'  
								GROUP BY tb_mk.kode";
			}else{
				$query_smt = "SELECT 
							  		tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_bobot_nilai.nilai_huruf AS nilai_huruf, 
									tb_bobot_nilai.bobot_ipk AS bobot_ipk,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_krs_$angkatan.id_penawaran
							  FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,tb_bobot_nilai,
								(SELECT MAX(tb_mk_penawaran.id_penawaran) AS id_penawaran
								 FROM 
									tb_mk,tb_mk_penawaran,tb_krs_$angkatan 
								 WHERE 
									tb_mk.id_mk = tb_mk_penawaran.id_mk 
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran 
									AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "' 
									AND NOT ISNULL(tb_krs_$angkatan.id_bobot_nilai)
									AND tb_mk_penawaran.publish='1' 
									AND tb_mk.semester='" . $i . "' 
									AND tb_krs_$angkatan.status='4' 
									AND tb_krs_$angkatan.aktif='1'  GROUP BY tb_mk.kode) 
								 AS fil_id
						      WHERE 
							  	  tb_krs_$angkatan.id_bobot_nilai = tb_bobot_nilai.id_bobot_nilai
								  AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "' 
								  AND tb_mk.id_mk = tb_mk_penawaran.id_mk 
								  AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
								  AND tb_mk_penawaran.id_penawaran = fil_id.id_penawaran";
			}
			$data_smt = query($query_smt);
			$jml_smt = get_jumlah($query_smt);
			if($jml_smt != 0){
				while($baris_smt = mysql_fetch_array($data_smt)){
					if($baris_smt["id_bobot_nilai"] != 0 && $baris_smt["id_bobot_nilai"] != ""){
						$bobot_1 = $bobot_1 + get_bobot_untuk_ipk($baris_smt["id_penawaran"],$baris_smt["id_bobot_nilai"],$baris_smt["sks"]);	
					}
					
					$sks_tot_1 = $sks_tot_1 + $baris_smt["sks"];
				}
			}
			$sks_tot = $sks_tot + $sks_tot_1;
			$bobot_tot = $bobot_tot + $bobot_1;	
		}
		return $sks_tot;
	}
	function cari_jml_peserta($id_penawaran){
		$query_build = "";
		$query_angkatan = "SELECT angkatan FROM tb_angkatan";
		$data_angkatan = query($query_angkatan);
		while($baris_angkatan = mysql_fetch_array($data_angkatan)){
			if($query_build != ""){
				$query_build = $query_build . " UNION ";
			}
			$query_build = $query_build . "SELECT * FROM tb_krs_" . $baris_angkatan["angkatan"] . " WHERE id_penawaran = '" . $id_penawaran . "'";
		}
		if($query_build != ""){
			$jml = get_jumlah($query_build);
		}else{
			$jml = 0;
		}
		return $jml;
	}
	
	function cari_detil_dosen($id_pegawai,$pil){
		//1 = nip
		//2 = nama
		$query = "SELECT id_pegawai,nip,CONCAT(IF((gelar_akademis_depan='' OR ISNULL(gelar_akademis_depan)),'',CONCAT(gelar_akademis_depan,' ')),
nama_lengkap,IF((gelar_akademis_belakang='' OR ISNULL(gelar_akademis_belakang)),'',CONCAT(' ',gelar_akademis_belakang))) AS nama_dosen FROM f_tb_master_pegawai WHERE f_tb_master_pegawai.id_pegawai='" . $id_pegawai. "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		if($pil == 1){
			$hasil = $nip;
		}elseif($pil == 2){
			$hasil = $nama_dosen;
		}
		return $hasil;
	}
	
	function ekstrak_info_mhs(){	
		$query = "SELECT * FROM tb_mhs WHERE nim = '{$_SESSION['nim']}'";		
		$result = query($query);
		$row = mysql_fetch_array($result);

		return $row;
	}
	function cek_masa_perbaikan_krs(){
		$penanda = 0;
		$query_periode = "SELECT * FROM tb_periode WHERE status='1'";
		$data_periode = query($query_periode);
		$baris_periode = mysql_fetch_array($data_periode);
		$id_periode = $baris_periode["id_periode"];
		$perubahan_krs_awal = $baris_periode["perubahan_krs_awal"];
		$perubahan_krs_akhir = $baris_periode["perubahan_krs_akhir"];
		
		$date_now = date("Y-m-d");
		
		$beda_awal_q = "SELECT DATEDIFF('$date_now','$perubahan_krs_awal') as beda_awal";
		$data_awal = query($beda_awal_q);
		extract(mysql_fetch_array($data_awal));
		
		$beda_akhir_q = "SELECT DATEDIFF('$perubahan_krs_akhir','$date_now') as beda_akhir";
		$data_akhir = query($beda_akhir_q);
		extract(mysql_fetch_array($data_akhir));
		
		if($beda_awal >= 0 && $beda_akhir >= 0){
			return true;
		}else{
			return false;
		}
	}
	//cari total nilai per penawaran pada mhs
	function hitung_tot_nilai($id_mhs,$id_penawaran){
		//cari bobot
		$query_detil_penawaran = "SELECT * FROM tb_mk_penawaran WHERE id_penawaran='" . $id_penawaran . "'";
		$data_detil_penawaran = query($query_detil_penawaran);
		$baris_detil_penawaran = mysql_fetch_array($data_detil_penawaran);
		
		$bobot_absensi = $baris_detil_penawaran["bobot_absensi"];
		$bobot_tugas = $baris_detil_penawaran["bobot_tugas"];
		$bobot_uts = $baris_detil_penawaran["bobot_uts"];
		$bobot_uas = $baris_detil_penawaran["bobot_uas"];
		$bobot_praktikum = $baris_detil_penawaran["bobot_praktikum"];
		$bobot_lain = $baris_detil_penawaran["bobot_lain"];
		
		$tot_bobot = $bobot_absensi + $bobot_tugas + $bobot_uts + $bobot_uas + $bobot_praktikum + $bobot_lain;
		//end cari bobot
		//cari nilai
		$angkatan = cari_angkatan($id_mhs);
		
		$query_nilai_mhs = "SELECT * FROM tb_krs_$angkatan WHERE id_penawaran='" . $id_penawaran . "' AND id_mhs='" . $id_mhs . "'";
		$data_nilai_mhs = query($query_nilai_mhs);
		$baris_nilai_mhs = mysql_fetch_array($data_nilai_mhs);
		
		$nilai_absensi = $baris_nilai_mhs["nilai_absensi"];
		$nilai_tugas = $baris_nilai_mhs["nilai_tugas"];
		$nilai_uts = $baris_nilai_mhs["nilai_uts"];
		$nilai_uas = $baris_nilai_mhs["nilai_uas"];
		$nilai_praktikum = $baris_nilai_mhs["nilai_praktikum"];
		$nilai_lain = $baris_nilai_mhs["nilai_lain"];
		//end cari nilai
		if($tot_bobot == 0){
			$tot_nilai = 0;
		}else{
			if($nilai_absensi != 0){
				$nilai_absensi = ($nilai_absensi*$bobot_absensi)/$tot_bobot;
			}
			if($nilai_tugas != 0){
				$nilai_tugas = ($nilai_tugas*$bobot_tugas)/$tot_bobot;
			}
			if($nilai_uts != 0){
				$nilai_uts = ($nilai_uts*$bobot_uts)/$tot_bobot;
			}
			if($nilai_uas != 0){
				$nilai_uas = ($nilai_uas*$bobot_uas)/$tot_bobot;
			}
			if($nilai_praktikum != 0){
				$nilai_praktikum = ($nilai_praktikum*$bobot_praktikum)/$tot_bobot;
			}
			if($nilai_lain != 0){
				$nilai_lain = ($nilai_lain*$bobot_lain)/$tot_bobot;
			}
			
			if($tot_bobot == 0){
				$tot_nilai = 0;
			}else{
				$tot_nilai = $nilai_absensi + $nilai_tugas + $nilai_uts + $nilai_uas + $nilai_praktikum + $nilai_lain;
			}
		}
		if(!is_float($tot_nilai)){
			return $tot_nilai;
		}else{
			return number_format($tot_nilai,2);
		}
	}
	function get_nilai_terpakai($id_mhs){
		$query = "SELECT nilai_terpakai FROM tb_angkatan WHERE id_angkatan IN (SELECT id_angkatan FROM tb_mhs WHERE id_mhs='" . $id_mhs . "')";
		$data = query($query);
		extract(mysql_fetch_array($data));
		return $nilai_terpakai;
		
	}
	function get_id_kurikulum($id_mk_penawaran){
		$query = "SELECT id_kurikulum FROM tb_periode WHERE id_periode = (SELECT id_periode FROM tb_mk_penawaran WHERE id_penawaran = '" . $id_mk_penawaran . "' LIMIT 1) LIMIT 1";
		$data = query($query);
		extract(mysql_fetch_array($data));
		return $id_kurikulum;
	}
	function get_nilai_huruf_bobot($id_nilai_bobot){
		$query = "SELECT nilai_huruf FROM tb_bobot_nilai WHERE id_bobot_nilai = '" . $id_nilai_bobot . "' LIMIT 1";
		$data = query($query);
		extract(mysql_fetch_array($data));
		return $nilai_huruf;
	}
	function get_bobot_untuk_ipk($id_penawaran,$id_bobot_nilai,$sks){
		$hasil = 0;
		//cari kurikulum
		if($id_bobot_nilai != ""){
			$query = "SELECT id_kurikulum FROM tb_periode WHERE id_periode = (SELECT id_periode FROM tb_mk_penawaran WHERE id_penawaran = '" . $id_penawaran . "' LIMIT 1) LIMIT 1";
			$data = query($query);
			extract(mysql_fetch_array($data));
			//end cari kurikulum
			$query_bobot_nilai = "SELECT * FROM tb_bobot_nilai WHERE id_kurikulum='" . $id_kurikulum . "' AND id_bobot_nilai='" . $id_bobot_nilai . "'";
			$data_bobot_nilai = query($query_bobot_nilai);
			extract(mysql_fetch_array($data_bobot_nilai));
			$hasil = $sks * $bobot_ipk;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	//Fungsi untuk nilai huruf
	function get_id_nilai_bobot($id_penawaran,$tot_nilai) {
		$id_bobot = 0;
		//cari kurikulum
		$query = "SELECT id_kurikulum FROM tb_periode WHERE id_periode = (SELECT id_periode FROM tb_mk_penawaran WHERE id_penawaran = '" . $id_penawaran . "' LIMIT 1) LIMIT 1";
		$data = query($query);
		extract(mysql_fetch_array($data));
		//end cari kurikulum
		$query_bobot_nilai = "SELECT * FROM tb_bobot_nilai WHERE id_kurikulum='" . $id_kurikulum . "' ORDER BY nilai_minimal";
		$data_bobot_nilai = query($query_bobot_nilai);
		while($baris_bobot_nilai = mysql_fetch_array($data_bobot_nilai)){
			if($tot_nilai >= $baris_bobot_nilai["nilai_minimal"]){
				$id_bobot = $baris_bobot_nilai["id_bobot_nilai"];
			}
		}
		return $id_bobot;
	}
	function romawi($n){
		$hasil = "";
		$iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20=>"XX",30=>"XXX",40=>"XL",50=>"L",60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",800=>"DCCC",900=>"CM",1000=>"M",2000=>"MM",3000=>"MMM");
		if(array_key_exists($n,$iromawi)){
			$hasil = $iromawi[$n];
		}elseif($n >= 11 && $n <= 99){
			$i = $n % 10;
			$hasil = $iromawi[$n-$i] . romawi($n % 10);
		}elseif($n >= 101 && $n <= 999){
			$i = $n % 100;
			$hasil = $iromawi[$n-$i] . romawi($n % 100);
		}else{
			$i = $n % 1000;
			$hasil = $iromawi[$n-$i] . romawi($n % 1000);
		}
		return $hasil;
	}
	function cari_status_bayar($id_mhs,$id_periode){
		if(get_value("tb_option_twitter","strict_krs_pembayaran") == 1){
			$jml_cek = 1;
		}else{
			$query = "SELECT * FROM tb_status_bayar WHERE id_mhs='" . $id_mhs . "' AND id_periode='" . $id_periode . "'";
			$jml_cek = get_jumlah($query);
		}
		return $jml_cek;
	}
	function get_jml_peserta_mk($id_penawaran){
		//build query
		$query_build = "";
		$query_angkatan = "SELECT * FROM tb_angkatan";
		$temp_angkatan = 1;
		$data_angkatan = query($query_angkatan);
		while($baris_angkatan = mysql_fetch_array($data_angkatan)){
			if($temp_angkatan == 1){
				$query_build = $query_build . "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran='" . $id_penawaran . "' AND tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}else{
				$query_build = $query_build . " UNION " . "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran='" . $id_penawaran . "' AND tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}
			$temp_angkatan++;
		}	
			
		$query_build = $query_build . " ORDER BY nim";
		//end build query
		return get_jumlah($query_build);
	}
	function get_nilai_setor($id_penawaran){
		//build query
		$query_build = "";
		$query_angkatan = "SELECT * FROM tb_angkatan";
		$temp_angkatan = 1;
		$data_angkatan = query($query_angkatan);
		while($baris_angkatan = mysql_fetch_array($data_angkatan)){
			if($temp_angkatan == 1){
				$query_build = $query_build . "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran='" . $id_penawaran . "' AND tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4'  AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1' AND (ISNULL(tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai) OR tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai='' OR tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai=0)) AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}else{
				$query_build = $query_build . " UNION " . "SELECT a.*,tb_bobot_nilai.nilai_huruf FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran='" . $id_penawaran . "' AND tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4'  AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1' AND (ISNULL(tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai) OR tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai='' OR tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai=0)) AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}
			$temp_angkatan++;
		}	
			
		$query_build = $query_build . " ORDER BY nim";
		//end build query
		//return berapa yang nilainya kosong
		return get_jumlah($query_build);
	}
	function get_query_build_krs($id_penawaran){
		//build query
		$query_build = "";
		$query_angkatan = "SELECT * FROM tb_angkatan";
		$temp_angkatan = 1;
		$data_angkatan = query($query_angkatan);
		while($baris_angkatan = mysql_fetch_array($data_angkatan)){
			if($temp_angkatan == 1){
				$query_build = $query_build . "SELECT a.*,tb_bobot_nilai.nilai_huruf,'" . $baris_angkatan["angkatan"] . "' AS angkatan FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran='" . $id_penawaran . "' AND tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}else{
				$query_build = $query_build . " UNION " . "SELECT a.*,tb_bobot_nilai.nilai_huruf,'" . $baris_angkatan["angkatan"] . "' AS angkatan FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran='" . $id_penawaran . "' AND tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}
			$temp_angkatan++;
		}	
			
		$query_build = $query_build . " ORDER BY nim";
		//end build query
		return $query_build;
	}
	function get_raw_query_build_krs(){
		//build query
		$query_build = "";
		$query_angkatan = "SELECT * FROM tb_angkatan";
		$temp_angkatan = 1;
		$data_angkatan = query($query_angkatan);
		while($baris_angkatan = mysql_fetch_array($data_angkatan)){
			if($temp_angkatan == 1){
				$query_build = $query_build . "SELECT a.id_mhs,a.nim,a.id_penawaran FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE  tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}else{
				$query_build = $query_build . " UNION " . "SELECT a.id_mhs,a.nim,a.id_penawaran FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1') AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}
			$temp_angkatan++;
		}	
			
		$query_build = $query_build . " ORDER BY nim";
		//end build query
		return $query_build;
	}
	function get_raw_nilai_setor(){
		//build query
		$query_build = "";
		$query_angkatan = "SELECT * FROM tb_angkatan";
		$temp_angkatan = 1;
		$data_angkatan = query($query_angkatan);
		while($baris_angkatan = mysql_fetch_array($data_angkatan)){
			if($temp_angkatan == 1){
				$query_build = $query_build . "SELECT a.id_mhs,a.nim,a.id_penawaran FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1' AND (ISNULL(tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai) OR tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai='' OR tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai=0)) AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}else{
				$query_build = $query_build . " UNION " . "SELECT a.id_mhs as jml,a.nim,a.id_penawaran FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1' AND (ISNULL(tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai) OR tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai='' OR tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai=0)) AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}
			$temp_angkatan++;
		}	
		//end build query
		//return berapa yang nilainya kosong
		return $query_build;
	}
	function get_raw_query_mhs_periode($id_periode){
		//build query
		$query_build = "";
		$query_angkatan = "SELECT * FROM tb_angkatan";
		$temp_angkatan = 1;
		$data_angkatan = query($query_angkatan);
		while($baris_angkatan = mysql_fetch_array($data_angkatan)){
			if($temp_angkatan == 1){
				$query_build = $query_build . "SELECT a.* FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE  tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1' AND tb_krs_" . $baris_angkatan["angkatan"] . ".id_mk_penawaran=(SELECT id_penawaran FROM tb_mk_penawaran WHERE id_periode='" . $id_periode . "')) AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}else{
				$query_build = $query_build . " UNION " . "SELECT a.* FROM (SELECT tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs AS id_mhs,tb_krs_" . $baris_angkatan["angkatan"] . ".id_bobot_nilai,tb_krs_" . $baris_angkatan["angkatan"] . ".id_penawaran AS id_penawaran,tb_mhs.nim AS nim,tb_mhs.nama AS nama,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_absen,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_tugas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uts,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_uas,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_praktikum,tb_krs_" . $baris_angkatan["angkatan"] . ".nilai_lain FROM tb_krs_" . $baris_angkatan["angkatan"] . ",tb_mhs WHERE tb_krs_" . $baris_angkatan["angkatan"] . ".id_mhs = tb_mhs.id_mhs AND tb_krs_" . $baris_angkatan["angkatan"] . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1' AND tb_krs_" . $baris_angkatan["angkatan"] . ".id_mk_penawaran=(SELECT id_penawaran FROM tb_mk_penawaran WHERE id_periode='" . $id_periode . "')) AS a LEFT JOIN tb_bobot_nilai ON tb_bobot_nilai.id_bobot_nilai = a.id_bobot_nilai";
			}
			$temp_angkatan++;
		}	
			
		$query_build = $query_build . " ORDER BY nim";
		//end build query
		return $query_build;
	}
	function get_something_angkatan($opt,$id_periode,$id_angkatan){
		//cari angkatan
		//1 . cari jml_register
		//2 . cari jml_mhs
		$query_angkatan = "SELECT * FROM tb_angkatan WHERE id_angkatan = '" . $id_angkatan . "'";
		$data_angkatan = query($query_angkatan);
		$baris_angkatan = mysql_fetch_array($data_angkatan);
		$angkatan = $baris_angkatan["angkatan"];
		
		if($opt == 1){
			$query = "SELECT COUNT(DISTINCT(id_mhs)) AS jml_reg FROM tb_krs_" . $angkatan . " WHERE tb_krs_" . $angkatan . ".status='4' AND tb_krs_" . $baris_angkatan["angkatan"] . ".aktif='1' AND tb_krs_" . $angkatan . ".id_penawaran IN (SELECT tb_mk_penawaran.id_penawaran FROM tb_mk_penawaran WHERE tb_mk_penawaran.id_periode='" . $id_periode . "')";
			$data = query($query);
			extract(mysql_fetch_array($data));
			return $jml_reg;
		}
		elseif($opt == 2){
			$query = "SELECT COUNT(DISTINCT(id_mhs)) AS jml_mhs FROM tb_mhs WHERE id_angkatan='" . $id_angkatan . "'";
			$data = query($query);
			extract(mysql_fetch_array($data));
			return $jml_mhs;
		}
	}
	function redirect_closing_periode($id_periode,$redirect_url){
		//status closing
		$query_periode = "SELECT * FROM tb_periode WHERE id_periode='" . $id_periode . "'";
		$data_periode = query($query_periode);
		$baris_periode = mysql_fetch_array($data_periode);
		$status_closing = $baris_periode["status_closing"];
		if($status_closing == 4){
			if($redirect_url == 0){
				redirect("periode-closing.php?id_periode=" . $id_periode);
			}else{
				redirect($redirect_url);
			}
		}
		//
	}
	function redirect_closing_periode_nonadmin($id_periode,$redirect_url,$status){
		//status closing
		$query_periode = "SELECT * FROM tb_periode WHERE id_periode='" . $id_periode . "'";
		$data_periode = query($query_periode);
		$baris_periode = mysql_fetch_array($data_periode);
		$status_closing = $baris_periode["status_closing"];
		if($status_closing >= $status){
			if($redirect_url == ""){
				redirect("index.php");
			}else{
				redirect($redirect_url);
			}
		}
		//
	}
	function check_closing_periode($id_periode,$status){
		//status closing
		$query_periode = "SELECT * FROM tb_periode WHERE id_periode='" . $id_periode . "'";
		$data_periode = query($query_periode);
		$baris_periode = mysql_fetch_array($data_periode);
		$status_closing = $baris_periode["status_closing"];
		if($status_closing >= $status){
			return 1;
		}else{
			return 0;
		}
		//
	}
	function cari_ket_ips($id_mhs){
		//cari id_angkatan
		$query = "SELECT id_angkatan FROM tb_mhs WHERE id_mhs='" . $id_mhs . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		//
		$query = "SELECT ket_batas_sks FROM tb_angkatan WHERE id_angkatan='" . $id_angkatan . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		//
		return $ket_batas_sks;
	}
	function cari_sks_tot_khs($id_mhs){
		$angkatan = cari_angkatan($id_mhs);
		
		$bobot_tot = 0;
		$sks_tot = 0;
		
		//cari opt_nilai
		//1 = terbaik
		//2 = terbaru
		
		for($i=1;$i<=8;$i++){
			$sks_tot_1 = 0;
			$bobot_1 = 0;
			if($nilai_dipakai == 1){
				$query_smt = "SELECT 
									tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_krs_$angkatan.id_penawaran
								FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan
								WHERE
									tb_mk.id_mk = tb_mk_penawaran.id_mk
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
									AND tb_mk.semester='" . $i . "' 
									AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "'
									AND tb_krs_$angkatan.status='4' 
									AND tb_krs_$angkatan.aktif='1' 
								GROUP BY tb_mk.kode";
			}else{
				$query_smt = "SELECT 
							  		tb_mk.kode,tb_mk.nama,tb_mk.sks,
									tb_krs_$angkatan.id_bobot_nilai,
									tb_krs_$angkatan.id_penawaran
							  FROM tb_mk,tb_mk_penawaran,tb_krs_$angkatan,
								(SELECT tb_mk_penawaran.id_penawaran AS id_penawaran
								 FROM 
									tb_mk,tb_mk_penawaran,tb_krs_$angkatan 
								 WHERE 
									tb_mk.id_mk = tb_mk_penawaran.id_mk 
									AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran 
									AND tb_mk.semester='" . $i . "'
									AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "' 
									AND tb_krs_$angkatan.status='4' 
									AND tb_krs_$angkatan.aktif='1') 
								 AS fil_id
						      WHERE 
							  	  tb_mk.id_mk = tb_mk_penawaran.id_mk 
								  AND tb_krs_$angkatan.id_mhs='" . $id_mhs . "'
								  AND tb_krs_$angkatan.id_penawaran = tb_mk_penawaran.id_penawaran
								  AND tb_mk_penawaran.id_penawaran = fil_id.id_penawaran";
			}
			$data_smt = query($query_smt);
			$jml_smt = get_jumlah($query_smt);
			if($jml_smt != 0){
				while($baris_smt = mysql_fetch_array($data_smt)){
					$bobot_1 = $bobot_1 + get_bobot_untuk_ipk($baris_smt["id_penawaran"],$baris_smt["id_bobot_nilai"],$baris_smt["sks"]);
					$sks_tot_1 = $sks_tot_1 + $baris_smt["sks"];
				}
			}
			$sks_tot = $sks_tot + $sks_tot_1;
			$bobot_tot = $bobot_tot + $bobot_1;	
		}
		return $sks_tot;
	}
	function redirect_if_not_pengampu($id_penawaran){
		$penanda = 0;
		if($_SESSION[ses_userType] == '1' || $_SESSION[ses_userType] == '3') {
			//pegawai or dosen
			$id_bersangkutan = $_SESSION[id_user];
			$query = "SELECT * FROM tb_team_pengampu WHERE id_penawaran='" . $id_penawaran . "' AND id_pengampu='" . $id_bersangkutan . "'";
			if(get_jumlah($query) != 0){
				$penanda = 1;
			}
		}
		if($penanda == 0){
			$_SESSION["message"] = "bukan.pengampu";
			redirect("matakuliah_ampu.php");
		}
	}
	function insert_log_nilai($id_penawaran,$id_mhs,$id_nilai_sebelum,$id_nilai_sesudah){
		$jenis_user = $_SESSION[ses_userType];
		$id_bersangkutan = $_SESSION[id_user];
		$query = "INSERT INTO tb_log_nilai(id_user,jenis_user,id_penawaran,id_mhs,id_nilai_sebelum,id_nilai_sesudah) VALUES('$id_bersangkutan','$jenis_user','$id_penawaran','$id_mhs','$id_nilai_sebelum','$id_nilai_sesudah')";
		$data = query($query);
	}
	function redirect_belum_publish($id_penawaran){
		$penanda = 0;
		$query = "SELECT publish FROM tb_mk_penawaran WHERE id_penawaran='" . $id_penawaran . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		if($publish == 1){
			$penanda = 1;
		}
		if($penanda == 0){
			$_SESSION["message"] = "belum.publish";
			redirect("view_nilai.php");
		}
	}
	function insert_batas_sks($id_angkatan){
		$query = "INSERT INTO tb_batas_sks(id_angkatan,batas_ips,sks_dpt_diambil,toleransi_lebih) VALUES($id_angkatan,'2','18','1'),($id_angkatan,'2.5','20','1'),($id_angkatan,'3','24','1')";
		$data = query($query);
	}
	function insert_bobot_nilai($id_kurikulum){
		$query = "INSERT INTO tb_bobot_nilai(id_kurikulum,nilai_minimal,nilai_huruf,bobot_ipk,status_lulus) VALUES($id_kurikulum,'80','A','4','1'),($id_kurikulum,'65','B','3','1'),($id_kurikulum,'55','C','2','1'),($id_kurikulum,'40','D','1','2'),($id_kurikulum,'0','E','0','2')";
		$data = query($query);
	}
	function redirect_if_not_pa($id_mhs){
		$penanda = 0;
		$id_bersangkutan = $_SESSION[id_user];
		$query = "SELECT * FROM tb_mhs WHERE id_mhs='" . $id_mhs . "' AND pa='" . $id_bersangkutan . "'";
		if(get_jumlah($query) != 0){
			$penanda = 1;
		}
		if($penanda == 0){
			$_SESSION["message"] = "bukan.pa";
		}
	}
	function convert_to_id_mk($id_penawaran){
		$query = "SELECT id_mk FROM tb_mk_penawaran WHERE id_penawaran=$id_penawaran";
		$data= query($query);
		extract(mysql_fetch_array($data));
		return $id_mk;
	}

	/**
	 * Fungsi - fungsi pendukung
	 * oleh : Wayan Jimmy
	 * 
	 */
	function remove_white_spaces($str){
		$str = preg_replace('/\s+/', '', $str);
		return $str;
	}

	function truncate_words($text, $maxLength = 3)
	{
	    // explode the text into an array of words
	    $wordArray = explode(' ', $text);

	    // do we have too many?
	    if( sizeof($wordArray) > $maxLength )
	    {
	        // remove the unwanted words
	        $wordArray = array_slice($wordArray, 0, $maxLength);

	        // turn the word array back into a string and add our ...
	        return implode(' ', $wordArray);
	    }

	    // if our array is under the limit, just send it straight back
	    return $text;
	}

	function beauty_date($val){
		$datetime = explode(' ', $val);

		$date = $datetime[0];

		$arr_date = explode('-', $date);

		$day = $arr_date[2];
		$month = $arr_date[1];
		$year = $arr_date[0];

		$str = $day . " ";
		switch ($month) {
			case 1 :
				$str .= "Januari";
				break;				
			case 2 :			
				$str .= "Februari";
				break;			
			case 3 :
				$str .= "Maret";
				break;		
			case 4 :
				$str .= "April";
				break;	
			case 5 :
				$str .= "Mei";
				break;	
			case 6 :
				$str .= "Juni";
				break;	
			case 7 :
				$str .= "Juli";
				break;	
			case 8 :
				$str .= "Agustus";
				break;	
			case 9 :
				$str .= "September";
				break;	
			case 10:
				$str .= "Oktober";
				break;
			case 11:
				$str .= "November";
				break;
			case 12:
				$str .= "Desember";
				break;
		}	

		$str .= " " . $year;
		return $str;
	}

	function import_date_format($date_in){
		$arr_date = explode('/', $date_in);		
		$day = $arr_date[0];
		$month = $arr_date[1];
		$year = $arr_date[2];		

		return $year . "-" . $month . "-" . $day;
	}

	function get_current_page(){
		return basename($_SERVER['PHP_SELF']);
	}

	function set_message($message_id){
		$_SESSION["message"] = $message_id;
	}

	function get_profil_seo(){
		$query = "SELECT * FROM tb_profil_seo LIMIT 1";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function get_id_kaprodi(){
		$query = "SELECT id_kaprodi FROM tb_option_twitter";
		$result = query($query);
		$row = mysql_fetch_array($result);

		return $row[0];
	}

	function get_info_kaprodi(){
		$query = "SELECT id_kaprodi FROM tb_option_twitter";
		$result = query($query);
		$row = mysql_fetch_array($result);
		$id_kaprodi = $row[0];

		$query = "SELECT 
					gelar_akademis_depan,
					nama_lengkap,
					gelar_akademis_belakang,
					nip
				FROM f_tb_master_pegawai WHERE id_pegawai = '{$id_kaprodi}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		$str = "";
		if(!empty($row['gelar_akademis_depan'])){
			$str .= $row['gelar_akademis_depan'] . ". ";
		}
		$str .= $row['nama_lengkap'];
		if(!empty($row['gelar_akademis_belakang'])){
			$str .= ". " . $row['gelar_akademis_belakang'];
		}					
		$arr = array(
			'nama_lengkap' => $str,
			'nip' => $row['nip']
		);
		return $arr;
	}

	/**
	 * Fungsi - fungsi pendukung ekivalensi
	 * oleh : Wayan Jimmy
	 * 
	 */

	function get_matakuliah_by_kode($kode){
		$query = "SELECT nama FROM tb_mk WHERE kode = '{$kode}';";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}



	function cuti_get_pengaturan(){
		$query = "SELECT min_smt_cuti, jeda_smt_cuti, banyak_smt_cuti, total_smt_cuti, deskripsi_cuti FROM tb_option_twitter";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}
	
	function get_row_cuti_akademik($id_cuti_akademik){
		$query = "SELECT tb_cuti_akademik.waktu_pengajuan,
						tb_cuti_akademik.id_cuti_akademik,
						tb_cuti_akademik.id_mhs,
						tb_mhs.nim,
						tb_mhs.nama,                            
						tb_cuti_akademik.keterangan_cuti,
						tb_cuti_akademik.lama_cuti,
						tb_periode.id_periode,
						tb_periode.semester,
						tb_periode.tahun_ajaran,
						tb_periode.nama AS 'nama_periode',
						tb_cuti_akademik.status,
						tb_cuti_akademik.komentar
					FROM tb_cuti_akademik INNER JOIN
						tb_mhs 
					ON (tb_cuti_akademik.id_mhs = tb_mhs.id_mhs)
					INNER JOIN tb_periode
					ON (tb_cuti_akademik.id_periode = tb_periode.id_periode)
					WHERE tb_cuti_akademik.id_cuti_akademik = '{$id_cuti_akademik}'";

		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function get_all_cuti_kategori(){
		$query = "SELECT * FROM tb_cuti_kategori";
		$result = query($query);
		return $result;
	}

	function get_firstid_cuti_kategori(){
		$query = "SELECT id_cuti_kategori FROM tb_cuti_kategori ORDER BY id_cuti_kategori ASC LIMIT 1";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function get_cuti_status($id_cuti_akademik){
		$query = "SELECT status FROM tb_cuti_akademik WHERE id_cuti_akademik = '{$id_cuti_akademik}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function print_cuti_status($status){
		if($status == CUTI_BELUM_DISETUJUI){
            $str = "<span class='label label-default'>Belum Disetujui</span>";
        }else if($status == CUTI_DISETUJUI){
            $str = "<span class='label label-success'>Disetujui</span>";
        }else if($status == CUTI_DITOLAK){
            $str = "<span class='label label-warning'>Ditolak</span>";
        }else if($status == CUTI_SEDANG_BERLANGSUNG){
			$str = "<span class='label label-info'>Sedang Berlangsung</span>";        	               	        
        }else if($status == CUTI_TELAH_BERLANGSUNG){
        	$str = "<span class='label label-inverse'>Telah Berlangsung</span>";        	               	        
        }
        return $str;
	}

	function change_cuti_status($new_status, $id_cuti_akademik){
		$status = $new_status;

		$query = "UPDATE tb_cuti_akademik SET status = '{$status}' WHERE id_cuti_akademik = '{$id_cuti_akademik}'";
		$result = query($query);
		return $result;		
	}

	function cek_sedang_cuti(){
		$query = "SELECT MAX(id_cuti_akademik) 
					FROM tb_cuti_akademik 
				WHERE id_mhs = '{$_SESSION['id_user']}' AND status = '". CUTI_SEDANG_BERLANGSUNG ."' ";					
		$result = query($query);		

		$row = mysql_fetch_array($result);
		if(empty($row[0])){
			return false;
		}else{
			return true;
		}
	}

	function get_current_user_cuti_akademik(){
		$query = "SELECT MAX(id_cuti_akademik) AS 'id_cuti_akademik' 
					FROM tb_cuti_akademik 
				WHERE id_mhs = '{$_SESSION['id_user']}'";		
		$result = query($query);
		$row = mysql_fetch_array($result);
		$id_cuti_akademik = $row[0];

		$result = get_row_cuti_akademik($id_cuti_akademik);
		return $result;
	}

	function get_all_cuti_mohon_aktif($filter){
		$query = "SELECT 
				    MAX(tb_cuti_mohon_aktif.id_cuti_mohon_aktif),
				    tb_cuti_mohon_aktif.id_cuti_akademik,
				    tb_cuti_mohon_aktif.waktu,
				    tb_cuti_mohon_aktif.pesan,					    
				    tb_cuti_akademik.status,
				    tb_cuti_akademik.id_mhs,
				    tb_cuti_akademik.status_konfirmasi
				 FROM 
				    tb_cuti_mohon_aktif INNER JOIN tb_cuti_akademik 
				ON (tb_cuti_mohon_aktif.id_cuti_akademik = tb_cuti_akademik.id_cuti_akademik) ";					
		if($filter == 0){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW())";
		}else if($filter == -1){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW() - INTERVAL 1 DAY)";			
		}else if($filter == -2){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW() - INTERVAL 2 DAY)";			
		}else if($filter == -7){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) <= DATE(NOW())
           				AND DATE(tb_cuti_mohon_aktif.waktu) >= DATE(NOW() - INTERVAL 7 DAY)";           				
		}else if($filter == -30){			
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) <= DATE(NOW() - INTERVAL 0 DAY)
                    AND DATE(tb_cuti_mohon_aktif.waktu) >= DATE(NOW() - INTERVAL 31 DAY)";
		}else if($filter == -99){			
		}		

		$query .= "AND tb_cuti_akademik.status = '4' GROUP BY tb_cuti_mohon_aktif.id_cuti_akademik ORDER BY tb_cuti_mohon_aktif.waktu DESC";
		$result = query($query);
		return $result;		
	}

	function count_cuti_mohon_aktif_paginate($filter){
		$query = "SELECT 
				    MAX(tb_cuti_mohon_aktif.id_cuti_mohon_aktif),
				    tb_cuti_mohon_aktif.id_cuti_akademik,
				    tb_cuti_mohon_aktif.waktu,
				    tb_cuti_mohon_aktif.pesan,					    
				    tb_cuti_akademik.status,
				    tb_cuti_akademik.id_mhs,
				    tb_cuti_akademik.status_konfirmasi
				 FROM 
				    tb_cuti_mohon_aktif INNER JOIN tb_cuti_akademik 
				ON (tb_cuti_mohon_aktif.id_cuti_akademik = tb_cuti_akademik.id_cuti_akademik) ";					
		if($filter == 0){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW())";
		}else if($filter == -1){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW() - INTERVAL 1 DAY)";			
		}else if($filter == -2){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW() - INTERVAL 2 DAY)";			
		}else if($filter == -7){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) <= DATE(NOW())
           				AND DATE(tb_cuti_mohon_aktif.waktu) >= DATE(NOW() - INTERVAL 7 DAY)";           				
		}else if($filter == -30){			
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) <= DATE(NOW() - INTERVAL 0 DAY)
                    AND DATE(tb_cuti_mohon_aktif.waktu) >= DATE(NOW() - INTERVAL 31 DAY)";
		}else if($filter == -99){			
		}		

		$query .= "AND tb_cuti_akademik.status = '4' GROUP BY tb_cuti_mohon_aktif.id_cuti_akademik ORDER BY tb_cuti_mohon_aktif.waktu DESC ";
		$result = query($query);
		$num_rows = mysql_num_rows($result);
		return $num_rows / 3;
	}

	function get_all_cuti_mohon_aktif_paginate($filter, $page){
		$query = "SELECT 
				    MAX(tb_cuti_mohon_aktif.id_cuti_mohon_aktif),
				    tb_cuti_mohon_aktif.id_cuti_akademik,
				    tb_cuti_mohon_aktif.waktu,
				    tb_cuti_mohon_aktif.pesan,					    
				    tb_cuti_akademik.status,
				    tb_cuti_akademik.id_mhs,
				    tb_cuti_akademik.status_konfirmasi
				 FROM 
				    tb_cuti_mohon_aktif INNER JOIN tb_cuti_akademik 
				ON (tb_cuti_mohon_aktif.id_cuti_akademik = tb_cuti_akademik.id_cuti_akademik) ";					
		if($filter == 0){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW())";
		}else if($filter == -1){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW() - INTERVAL 1 DAY)";			
		}else if($filter == -2){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) = DATE(NOW() - INTERVAL 2 DAY)";			
		}else if($filter == -7){
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) <= DATE(NOW())
           				AND DATE(tb_cuti_mohon_aktif.waktu) >= DATE(NOW() - INTERVAL 7 DAY)";           				
		}else if($filter == -30){			
			$query .= "WHERE DATE(tb_cuti_mohon_aktif.waktu) <= DATE(NOW() - INTERVAL 0 DAY)
                    AND DATE(tb_cuti_mohon_aktif.waktu) >= DATE(NOW() - INTERVAL 31 DAY)";
		}else if($filter == -99){			
		}		

		$query .= "AND tb_cuti_akademik.status = '4' AND tb_cuti_akademik.status_konfirmasi = '1' GROUP BY tb_cuti_mohon_aktif.id_cuti_akademik ORDER BY tb_cuti_mohon_aktif.waktu DESC ";
		$query .= "LIMIT {$page}, 3";
		$result = query($query);
		return $result;		
	}

	function cek_konfirmasi_mohon_cuti($id_cuti_akademik){
		$query = "SELECT status_konfirmasi FROM tb_cuti_akademik WHERE id_cuti_akademik = '{$id_cuti_akademik}'";
		$result = query($query);
		$row = mysql_fetch_array($result);

		if($row[0] != 1){
			return true;
		}else{
			return false;
		}
	}

	function boleh_cuti(){
		$semester = cari_semester($_SESSION['nim']);

		$query = "SELECT min_smt_cuti FROM tb_option_twitter";		
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];

		if($semester >= $row[0]){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Fungsi - fungsi berhubungan dengan proses master akademik
 	 * oleh : Wayan Jimmy
 	 * 
	 */

	function get_status_perkawinan($status_perkawinan){
		if($status_perkawinan == 1){
			return "Kawin";
		}else{
			return "Belum Kawin";
		}
	}

	//Tabel Jenis Identitas
	function get_all_jenis_identitas(){
		$query = "SELECT * FROM tb_jenis_identitas;";
		$result = query($query);
		return $result;
	}

	function get_row_jenis_identitas($id_jenis_identitas){
		$query = "SELECT * FROM tb_jenis_identitas WHERE id_jenis_identitas = '{$id_jenis_identitas}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function delete_row_jenis_identitas($id_jenis_identitas){
		$query = "DELETE FROM tb_jenis_identitas WHERE id_jenis_identitas = '{$id_jenis_identitas}'";
		$result = query($query);
		return $result;
	}

	//Tabel Hubungan Keluarga
	function get_all_hubungan_keluarga(){
		$query = "SELECT * FROM tb_hubungan_keluarga ORDER BY id_hubungan";
		$result = query($query);
		return $result;
	}

	function get_row_hubungan_keluarga($id_hubungan){
		$query = "SELECT * FROM tb_hubungan_keluarga WHERE id_hubungan = '{$id_hubungan}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function delete_row_hubungan($id_hubungan){
		$query = "DELETE FROM tb_hubungan_keluarga WHERE id_hubungan = '{$id_hubungan}'";
		$result = query($query);
		return $result;
	}

	function get_hubungan_keluarga_by_id($id_hubungan){
		$query = "SELECT hubungan FROM tb_hubungan_keluarga WHERE id_hubungan = '{$id_hubungan}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	//Tabel Tingkat Pendidikan
	function get_all_tingkat_pendidikan(){
		$query = "SELECT * FROM tb_tingkat_pendidikan ORDER BY id_tingkat_pendidikan";
		$result = query($query);
		return $result;
	}

	function get_row_tingkat_pendidikan($id_tingkat_pendidikan){
		$query = "SELECT * FROM tb_tingkat_pendidikan WHERE id_tingkat_pendidikan = '{$id_tingkat_pendidikan}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function get_tingkat_pendidikan_by_id($id_tingkat_pendidikan){
		$query = "SELECT tingkat_pendidikan FROM tb_tingkat_pendidikan WHERE id_tingkat_pendidikan = '{$id_tingkat_pendidikan}'";
		$result = query($query);	
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function delete_row_tingkat_pendidikan($id_tingkat_pendidikan){
		$query = "DELETE FROM tb_tingkat_pendidikan WHERE id_tingkat_pendidikan = '{$id_tingkat_pendidikan}'";
		$result = query($query);
		return $result;
	}

	//Tabel Jenis Kelamin
	function get_all_jenis_kelamin(){
		$query = "SELECT * FROM tb_jenis_kelamin";
		$result = query($query);
		return $result;
	}

	function get_jenis_kelamin_by_id($id_jenis_kelamin){
		$query = "SELECT jenis_kelamin FROM tb_jenis_kelamin WHERE id_jenis_kelamin = '{$id_jenis_kelamin}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function import_jenis_kelamin(){
		$query = "SELECT id_jenis_kelamin FROM tb_jenis_kelamin WHERE jenis_kelamin = 'Laki-laki'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		$id_laki = $row[0];

		$query = "SELECT id_jenis_kelamin FROM tb_jenis_kelamin WHERE jenis_kelamin = 'Perempuan'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		$id_perempuan = $row[0];		

		$arr = array(
			"id_laki" => $id_laki,
			"id_perempuan" => $id_perempuan
		);
		return $arr;
	}

	//Tabel Konsentrasi
	function get_all_konsentrasi(){
		$query = "SELECT * FROM tb_konsentrasi";
		$result = query($query);
		return $result;
	}

	//Tabel Agama
	function get_all_agama(){
		$query = "SELECT * FROM tb_agama ORDER BY id_agama";
		$result = query($query);
		return $result;	
	}

	function get_row_agama($id_agama){
		$query = "SELECT * FROM tb_agama WHERE id_agama = '{$id_agama}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function delete_row_agama($id_agama){
		$query = "DELETE FROM tb_agama WHERE id_agama = '{$id_agama}'";
		$result = query($query);
		return $result;
	}

	function get_agama_by_id($id_agama){
		$query = "SELECT nama FROM tb_agama WHERE id_agama = '{$id_agama}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];	
	}

	//Tabel Golongan Darah
	function get_all_gol_darah(){
		$query = "SELECT * FROM tb_gol_darah";
		$result = query($query);
		return $result;
	}

	function get_gol_darah_by_id($id_gol_darah){
		$query = "SELECT nama FROM tb_gol_darah WHERE id_gol_darah = '{$id_gol_darah}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	//Tabel Negara
	function get_all_negara(){
		$query = "SELECT * FROM tb_negara ORDER BY id_negara";
		$result = query($query);				
		return $result;
	}

	function get_row_negara($id_negara){
		$query = "SELECT * FROM tb_negara WHERE id_negara = '{$id_negara}'";
		$result = query($query);		
		$row = mysql_fetch_array($result);
		return $row;
	}

	function delete_row_negara($id_negara){
		$query = "DELETE FROM tb_negara WHERE id_negara = '{$id_negara}'";
		$result = query($query);
		return $result;	
	}

	//Tabel Provinsi
	function get_all_provinsi(){
		$query = "SELECT
                    tb_provinsi.id_provinsi
                    , tb_provinsi.nama AS nama
                    , tb_negara.id_negara
                    , tb_negara.nama AS nama_negara
                FROM
                    tb_provinsi
                    INNER JOIN tb_negara 
                        ON (tb_provinsi.id_negara = tb_negara.id_negara)
                ORDER BY tb_negara.id_negara";
		$result = query($query);
		return $result;
	}

	function get_row_provinsi($id_provinsi){
		$query = "SELECT * FROM tb_provinsi WHERE id_provinsi = '{$id_provinsi}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function delete_row_provinsi($id_provinsi){
		$query = "DELETE FROM tb_provinsi WHERE id_provinsi = '{$id_provinsi}'";
		$result = query($query);
		return $result;		
	}

	//Tabel Kabupaten
	function get_all_kabupaten(){
		 $query = "SELECT
                    tb_kabupaten.id_kabupaten
                    , tb_kabupaten.nama AS nama_kabupaten
                    , tb_provinsi.id_provinsi
                    , tb_provinsi.nama AS nama_provinsi
                    , tb_negara.id_negara
                    , tb_negara.nama AS nama_negara
                FROM
                    tb_provinsi
                    INNER JOIN tb_negara 
                        ON (tb_provinsi.id_negara = tb_negara.id_negara)
                    INNER JOIN tb_kabupaten 
                        ON (tb_kabupaten.id_provinsi = tb_provinsi.id_provinsi)";
        $result = query($query);        
		return $result;
	}

	function get_all_provinsi_by_negara($id_negara){
		$query = "SELECT * FROM tb_provinsi WHERE id_negara = '{$id_negara}'";
		$result = query($query);
		return $result;
	}

	function get_row_kabupaten($id_kabupaten){
		$query = "SELECT * FROM tb_kabupaten WHERE id_kabupaten = '{$id_kabupaten}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function delete_row_kabupaten($id_kabupaten){
		$query = "DELETE FROM tb_provinsi WHERE id_provinsi = '{$id_kabupaten}'";
		$result = query($query);
		return $result;
	}

	//Tabel kecamatan
	function get_all_kecamatan(){
		$query = "SELECT 
					tb_kecamatan.id_kecamatan,
					tb_kecamatan.nama AS 'nama_kecamatan',
					tb_kabupaten.nama AS 'nama_kabupaten',
					tb_provinsi.nama AS 'nama_provinsi',
					tb_negara.nama AS 'nama_negara'
				FROM 
					tb_kecamatan
				INNER JOIN tb_kabupaten ON (tb_kecamatan.id_kabupaten = tb_kabupaten.id_kabupaten)
				INNER JOIN tb_provinsi ON (tb_kabupaten.id_provinsi = tb_provinsi.id_provinsi)
				INNER JOIN tb_negara ON(tb_provinsi.id_negara = tb_negara.id_negara)
				ORDER BY id_kecamatan";
		$result = query($query);
		return $result;
	}

	function get_row_kecamatan($id_kecamatan){
		$query = "SELECT 
					tb_kecamatan.id_kecamatan,
					tb_kecamatan.id_kabupaten, 
					tb_kecamatan.nama,
					tb_kabupaten.id_provinsi,
					tb_provinsi.id_negara
				FROM tb_kecamatan 
				INNER JOIN tb_kabupaten ON (tb_kecamatan.id_kabupaten = tb_kabupaten.id_kabupaten)
				INNER JOIN tb_provinsi ON (tb_kabupaten.id_provinsi = tb_provinsi.id_provinsi) 
				WHERE tb_kecamatan.id_kecamatan = '{$id_kecamatan}'";
				
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}	

	function delete_row_kecamatan($id_kecamatan){
		$query = "DELETE FROM tb_kecamatan WHERE id_kecamatan = '{$id_kecamatan}'";
		$result = query($query);
		return $result;
	}

	//Tabel Fakultas
	function get_all_fakultas(){
		$query = "SELECT
                    tb_fakultas.id_fakultas, tb_universitas.nama as nama_univ
                    , tb_fakultas.nama
                FROM
                    tb_fakultas,tb_universitas
                WHERE 
                    tb_universitas.id_universitas = tb_fakultas.id_universitas
                ORDER BY id_fakultas";
        $result = query($query);
        return $result;
	}

	function get_row_fakultas($id_fakultas){               
		$query = "SELECT * FROM tb_fakultas WHERE id_fakultas = '{$id_fakultas}'";
        $result = query($query);
        $row = mysql_fetch_array($result);
        return $row;
	}

	//Tabel Jurusan
	function get_all_jurusan(){
		$query = "SELECT
	                tb_jurusan.id_jurusan, tb_fakultas.nama as nama_fakultas
	                , tb_jurusan.nama
	            FROM
	                tb_jurusan,tb_fakultas
	            WHERE 
	                tb_fakultas.id_fakultas = tb_jurusan.id_fakultas
	            ";
	    $result = query($query);
	    return $result;
	}

	function get_row_jurusan($id_jurusan){
		$query = "SELECT * FROM tb_jurusan WHERE id_jurusan = '{$id_jurusan}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	//Fungsi kurikulum
	function get_all_kurikulum(){
		$query = "SELECT * FROM tb_kurikulum ORDER BY id_kurikulum";
		$result = query($query);		
		return $result;
	}	

	//Profil lulusan
	function get_row_profil_lulusan($id_profil_lulusan){
		$query = "SELECT * FROM tb_kurikulum_profil_lulusan WHERE id_profil_lulusan = '{$id_profil_lulusan}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	//Tabel Periode
	function get_all_periode(){
		$query = "SELECT * FROM tb_periode";
		$result = query($query);
		return $result;
	}

	function get_all_periode_now_and_on(){
		$query = "SELECT * FROM tb_periode";
		$result = query($query);
		return $result;
	}

	function get_nama_periode($id_periode){
		$query = "SELECT nama FROM tb_periode WHERE id_periode = '{$id_periode}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	//Tabel Jalur Masuk
	function get_all_jalur_masuk(){
		$query = "SELECT * FROM tb_jalur_masuk";
		$result = query($query);
		return $result;
	}

	function get_jalur_masuk_by_id($id_jalur_masuk){
		$query = "SELECT nama FROM tb_jalur_masuk WHERE id_jalur_masuk = '{$id_jalur_masuk}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function get_row_jalur_masuk($id_jalur_masuk){
		$query = "SELECT * FROM tb_jalur_masuk WHERE id_jalur_masuk = '{$id_jalur_masuk}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function delete_row_jalur_masuk($id_jalur_masuk){
		$query = "DELETE FROM tb_jalur_masuk WHERE id_jalur_masuk = '{$id_jalur_masuk}'";
		$result = query($query);
		return $result;
	}

	//Tabel Program
	function get_all_program(){
		$query = "SELECT * FROM tb_program";
		$result = query($query);
		return $result;
	}

	//Tabel Angkatan
	function get_all_angkatan(){
		$query = "SELECT * FROM tb_angkatan ORDER BY angkatan";
		$result = query($query);
		return $result;		
	}

	function count_all_angkatan(){
		$query = "SELECT * FROM tb_angkatan ORDER BY angkatan";
		$result = query($query);
		return mysql_num_rows($result);
	}

	function get_angkatan_by_id($id_angkatan){
		$query = "SELECT angkatan FROM tb_angkatan WHERE id_angkatan = '{$id_angkatan}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	// Mahasiswa
	function yes_nim($nim){
		$query = "SELECT nim FROM tb_mhs WHERE nim = '{$nim}'";
		$result = query($query);
		$num_rows = mysql_num_rows($result);

		if($num_rows == 0 && is_numeric($nim)){
			return true;
		}else{
			return false;
		}		
	}		

	function get_nim_by_id($id_mhs){
		$query = "SELECT nim FROM tb_mhs WHERE id_mhs = '{$id_mhs}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function get_id_by_nim($nim){
		$query = "SELECT id_mhs FROM tb_mhs WHERE nim = '{$nim}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function get_pp_by_id($id_mhs){
		$query = "SELECT pp FROM tb_mhs WHERE id_mhs = '{$id_mhs}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function get_thumb_ava($id_mhs){
		$file_name = get_pp_by_id($id_mhs);
		if($file_name == "50.jpg"){
			return show_ava($id_mhs);
		}else{
			return "pp/thumb_" . $file_name;
		}		
	}

	function update_pp($nim, $file_name){
		$query = "UPDATE tb_mhs SET pp = '{$file_name}' WHERE nim = '{$nim}'";
		$result = query($query);		
	}	

	function get_row_mhs($id_mhs){
		$query = "SELECT * FROM tb_mhs WHERE id_mhs = '{$id_mhs}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;		
	}	

	function get_row_tab_info($id_mhs){
		$query = "SELECT 
					nim,
                    nama,
                    nama_cetak,
                    tempat_lahir,
                    tgl_lahir,
                    id_agama,
                    jk,
                    id_gol_darah,                    
                    id_jenis_identitas,                    
                    no_identitas,                    
                    status_perkawinan,                    
                    tgl_masuk,
                    id_jalur_masuk,
                    id_angkatan,
                    pa
                FROM tb_mhs WHERE id_mhs = '{$id_mhs}'";
        $result = query($query);
        $row = mysql_fetch_array($result);
        return $row;
	}

	function get_row_tab_alamat($id_mhs){
		$query = "SELECT
					alamat_asal,
					alamat_tinggal,
					alamat_surat,
					kodepos
				FROM tb_mhs WHERE id_mhs = '{$id_mhs}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function get_row_tab_kontak($id_mhs){
		$query = "SELECT 
					email,
					website,
					facebook,
					twitter,
					hp,
					telepon_rumah
				FROM tb_mhs WHERE id_mhs = '{$id_mhs}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row;
	}

	function cut_phone_number($phone_number){
		$new_phone_number = substr($phone_number, 3, strlen($phone_number));
		return $new_phone_number;		
	}

	function get_mhs_keluarga($id_mhs){
		$query = "SELECT 
			    tb_mhs_keluarga.id_keluarga,
			    tb_mhs_keluarga.nama,
			    tb_hubungan_keluarga.hubungan,
			    tb_jenis_kelamin.jenis_kelamin,
			    tb_mhs_keluarga.tgl_lahir,
			    tb_mhs_keluarga.pekerjaan
			FROM tb_mhs_keluarga
			INNER JOIN tb_hubungan_keluarga ON (tb_mhs_keluarga.id_hubungan = tb_hubungan_keluarga.id_hubungan)
			INNER JOIN tb_jenis_kelamin ON (tb_mhs_keluarga.id_jenis_kelamin = tb_jenis_kelamin.id_jenis_kelamin)
			WHERE tb_mhs_keluarga.id_mhs = '{$id_mhs}'";
		$result = query($query);
		return $result;		
	}

	function get_nama_keluarga_by_id($id_keluarga){
		$query = "SELECT nama FROM tb_mhs_keluarga WHERE id_keluarga = '{$id_keluarga}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	function get_mhs_pendidikan($id_mhs){
		$query = "SELECT 
				    tb_mhs_pendidikan.id_pendidikan,
				    tb_mhs_pendidikan.nama,
				    tb_mhs_pendidikan.alamat,
				    tb_mhs_pendidikan.tahun_masuk,
				    tb_mhs_pendidikan.tahun_lulus,
				    tb_tingkat_pendidikan.tingkat_pendidikan,
				    tb_tingkat_pendidikan.id_tingkat_pendidikan
				FROM tb_mhs_pendidikan 
				INNER JOIN tb_tingkat_pendidikan ON (tb_mhs_pendidikan.id_tingkat_pendidikan = tb_tingkat_pendidikan.id_tingkat_pendidikan)
				WHERE id_mhs = '{$id_mhs}' ORDER BY tb_mhs_pendidikan.tahun_masuk";
		$result = query($query);
		return $result;

	}

	function get_nama_pendidikan_by_id($id_pendidikan){
		$query = "SELECT nama FROM tb_mhs_pendidikan WHERE id_pendidikan = '{$id_pendidikan}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		return $row[0];		
	}

	//Dosen Tabel Baru
	function get_all_dosen(){
		$query = "SELECT 
				    id_pegawai, 
				    gelar_akademis_depan, 
				    nama_lengkap, 
				    gelar_akademis_belakang, 
				    tanda
				FROM f_tb_master_pegawai WHERE tanda = 1";
		$result = query($query);
		return $result;
	}

	function get_nama_dosen_by_id($id_pegawai){
		$query = "SELECT 
				    id_pegawai, 
				    gelar_akademis_depan, 
				    nama_lengkap, 
				    gelar_akademis_belakang, 
				    tanda
				FROM f_tb_master_pegawai WHERE id_pegawai = '{$id_pegawai}'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		$str = "";
		if(!empty($row['gelar_akademis_depan'])){
			$str .= $row['gelar_akademis_depan'] . ". ";
		}
		$str .= $row['nama_lengkap'];
		if(!empty($row['gelar_akademis_belakang'])){
			$str .= ". " . $row['gelar_akademis_belakang'];
		}					
		return $str;
	}	

	function get_ortu_mhs(){
		$query = "SELECT 
				    tb_mhs_keluarga.id_keluarga,
				    tb_mhs_keluarga.nama,
				    tb_mhs_keluarga.id_hubungan,    
				    tb_hubungan_keluarga.hubungan
				FROM tb_mhs_keluarga
				INNER JOIN tb_hubungan_keluarga ON (tb_mhs_keluarga.id_hubungan = tb_hubungan_keluarga.id_hubungan)
				WHERE id_mhs = '{$_SESSION['id_user']}' AND (tb_hubungan_keluarga.hubungan = 'Ayah' OR tb_hubungan_keluarga.hubungan = 'Ibu')";
		$result = query($query);			
		return $result;
	}

	function is_current_mhs_by_nim($nim){
		if($_SESSION["ses_userType"] == 2 && $_SESSION['nim'] == $nim){
			return true;
        }else{
        	return false;
        }
	}
	//header mahasiswa
	function tampil_header_mhs($id_mhs){
		//<hr style='height: 2px;margin: 0px;'>
		echo "<table width='100%'>
					<tr>
						<td style='padding-right: 15px; padding-bottom: 15px;' width='115'>
							<img class='thumbnail' src='" . show_ava($id_mhs) . "' width='100'>
						</td>
						<td valign='top' style='padding-top: 15px;text-align:left'>
							<h4 style='margin-top: 5px;'>
								<a href='" . profil_mhs($id_mhs) . "' target='_blank'>" . cari_detail_mhs($id_mhs,2) . "</a>
							</h4>
							
							NIM. " . cari_detail_mhs($id_mhs,1) . "
						</td>
					</tr>
				</table>";
	}
	//link mahasiswa
	function tampil_url_mhs($id_mhs){
		$link = "<a href='" . profil_mhs($id_mhs) . "' target='_blank'>" . cari_detail_mhs($id_mhs,2) . "</a>";
		return $link;
	}
	//link penawaran_mk
	function tampil_url_penawaran($id_penawaran,$nama_penawaran){
		$link = "<a href='penawaran_matakuliah-detail.php?id=" . $id_penawaran . "' target='_blank'>" . $nama_penawaran . "</a>";
		return $link;
	}
	//link penawaran_mk
	function tampil_url_mk($id_penawaran,$nama_mk){
		$query = "SELECT tb_mk_penawaran.id_mk as id_mk FROM tb_mk_penawaran WHERE tb_mk_penawaran.id_penawaran='" . $id_penawaran . "'";
		$data = query($query);
		extract(mysql_fetch_array($data));
		
		$link = "<a href='matakuliah_view-detail.php?id=" . $id_mk . "' target='_blank'>" . $nama_mk . "</a>";
		return $link;
	}
	//isi krs blok
	function isi_blok_krs($id_mhs){
		$angkatan = cari_angkatan($id_mhs);
		//isi krs
		//validasi dulu
		$query_cek = "SELECT tb_angkatan.krs_block as krs_block FROM tb_angkatan WHERE id_angkatan=(SELECT id_angkatan FROM tb_mhs WHERE id_mhs='$id_mhs')";
		$data_cek = query($query_cek);
		extract(mysql_fetch_array($data_cek));
		if($krs_block == 2){
			//ambil blok
			$query_isi = "SELECT tb_krs_block.id_penawaran as id_penawaran FROM tb_krs_block WHERE tb_krs_block.id_angkatan=(SELECT id_angkatan FROM tb_mhs WHERE id_mhs='$id_mhs')";
			$data_isi = query($angkatan);
			while($baris_isi = mysql_fetch_array($data_isi)){
				$query_insert = "INSERT INTO tb_krs_$angkatan(id_mhs,id_penawaran,status) VALUES('$id_mhs','" . $baris_isi[id_penawaran] . "','4')";
				$data_insert($query_insert);
			}
		}
	}
	
?>
