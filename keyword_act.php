<?php 
include 'includes/core.php';
$type= $_GET['t'];
if ($type=='1') {//insert Insert
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = "1";
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$nama_table = isset($_POST['selTb']) ? makeSafe($_POST['selTb']) : '';
	$jml_row_param = isset($_POST['DynInsertRow']) ? makeSafe($_POST['DynInsertRow']) : '';
	//
	$FieldIns = isset($_POST['FieldIns']) ? $_POST['FieldIns'] : '';
	$PrmIns = isset($_POST['PrmIns']) ? $_POST['PrmIns'] : '';
	try {
		$query = "INSERT INTO tb_operasi(id_host,id_jenis_operasi,id_jenis_sql,keyword,is_publik,nama_operasi,penanda_login) VALUES ('$id_host','$id_jenis_operasi','$id_jenis_sql','$keyword','$is_publik','$nama_operasi','$penanda_login')";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			$id_last = mysqli_insert_id($id_mysql);
			//table
			$query = "INSERT INTO tb_operasi_tabel(id_operasi,nama_tabel) VALUES('$id_last','$nama_table')";
			$result = mysqli_query($id_mysql,$query);
			//parameter
			for ($i=0; $i<count($FieldIns); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci) VALUES('$id_last','".$FieldIns[$i]."','".$PrmIns[$i]."','0')";
				$result = mysqli_query($id_mysql,$query);
			}
			echo "1";
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='1edit') {//edit Insert
	$id_operasi = isset($_POST['idOperasi']) ? makeSafe($_POST['idOperasi']) : '';
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = "1";
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$nama_table = isset($_POST['selTb']) ? makeSafe($_POST['selTb']) : '';
	$jml_row_param = isset($_POST['DynInsertRow']) ? makeSafe($_POST['DynInsertRow']) : '';
	//
	$FieldIns = isset($_POST['FieldIns']) ? $_POST['FieldIns'] : '';
	$PrmIns = isset($_POST['PrmIns']) ? $_POST['PrmIns'] : '';
	try {
		$query = "UPDATE tb_operasi SET id_host='$id_host',id_jenis_operasi='$id_jenis_operasi',id_jenis_sql='$id_jenis_sql',keyword='$keyword',is_publik='$is_publik',nama_operasi='$nama_operasi',penanda_login='$penanda_login' WHERE id_operasi='$id_operasi'";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			//table
			$query = "DELETE FROM tb_operasi_tabel WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			$query = "INSERT INTO tb_operasi_tabel(id_operasi,nama_tabel) VALUES('$id_operasi','$nama_table')";
			$result = mysqli_query($id_mysql,$query);
			//parameter
			$query = "DELETE FROM tb_operasi_parameter WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			for ($i=0; $i<count($FieldIns); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci) VALUES('$id_operasi','".$FieldIns[$i]."','".$PrmIns[$i]."','0')";
				$result = mysqli_query($id_mysql,$query);
			}
			echo '1';
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='2') {//insert Update
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = "1";
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$nama_table = isset($_POST['selTb']) ? makeSafe($_POST['selTb']) : '';
	$jml_row_param = isset($_POST['DynUpdateRow']) ? makeSafe($_POST['DynUpdateRow']) : '';
	//
	$FieldUpd = isset($_POST['FieldUpd']) ? $_POST['FieldUpd'] : '';
	$PrmUpd = isset($_POST['PrmUpd']) ? $_POST['PrmUpd'] : '';
	//
	$FieldUpd2 = isset($_POST['2FieldUpd']) ? $_POST['2FieldUpd'] : '';
	$PrmUpd2 = isset($_POST['2PrmUpd']) ? $_POST['2PrmUpd'] : '';
	$TypeUpd2 = isset($_POST['2TypeUpd']) ? $_POST['2TypeUpd'] : '';
	try {
		$query = "INSERT INTO tb_operasi(id_host,id_jenis_operasi,id_jenis_sql,keyword,is_publik,nama_operasi,penanda_login) VALUES ('$id_host','$id_jenis_operasi','$id_jenis_sql','$keyword','$is_publik','$nama_operasi','$penanda_login')";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			$id_last = mysqli_insert_id($id_mysql);
			//table
			$query = "INSERT INTO tb_operasi_tabel(id_operasi,nama_tabel) VALUES('$id_last','$nama_table')";
			$result = mysqli_query($id_mysql,$query);
			//parameter value
			for ($i=0; $i<count($FieldUpd); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci) VALUES('$id_last','".$FieldUpd[$i]."','".$PrmUpd[$i]."','0')";
				$result = mysqli_query($id_mysql,$query);
			}
			//parameter kunci
			for ($i=0; $i<count($FieldUpd2); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci,type) VALUES('$id_last','".$FieldUpd2[$i]."','".$PrmUpd2[$i]."','1','".$TypeUpd2[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			echo "1";
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='2edit') {//edit Update
	$id_operasi = isset($_POST['idOperasi']) ? makeSafe($_POST['idOperasi']) : '';
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = "1";
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$nama_table = isset($_POST['selTb']) ? makeSafe($_POST['selTb']) : '';
	$jml_row_param = isset($_POST['DynUpdatetRow']) ? makeSafe($_POST['DynUpdateRow']) : '';
	//
	$FieldUpd = isset($_POST['FieldUpd']) ? $_POST['FieldUpd'] : '';
	$PrmUpd = isset($_POST['PrmUpd']) ? $_POST['PrmUpd'] : '';
	//
	$FieldUpd2 = isset($_POST['2FieldUpd']) ? $_POST['2FieldUpd'] : '';
	$PrmUpd2 = isset($_POST['2PrmUpd']) ? $_POST['2PrmUpd'] : '';
	$TypeUpd2 = isset($_POST['2TypeUpd']) ? $_POST['2TypeUpd'] : '';
	try {
		$query = "UPDATE tb_operasi SET id_host='$id_host',id_jenis_operasi='$id_jenis_operasi',id_jenis_sql='$id_jenis_sql',keyword='$keyword',is_publik='$is_publik',nama_operasi='$nama_operasi',penanda_login='$penanda_login' WHERE id_operasi='$id_operasi'";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			//table
			$query = "DELETE FROM tb_operasi_tabel WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			$query = "INSERT INTO tb_operasi_tabel(id_operasi,nama_tabel) VALUES('$id_operasi','$nama_table')";
			$result = mysqli_query($id_mysql,$query);
			//parameter
			$query = "DELETE FROM tb_operasi_parameter WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			//parameter value
			for ($i=0; $i<count($FieldUpd); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci) VALUES('$id_operasi','".$FieldUpd[$i]."','".$PrmUpd[$i]."','0')";
				$result = mysqli_query($id_mysql,$query);
			}
			//parameter kunci
			for ($i=0; $i<count($FieldUpd2); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci,type) VALUES('$id_operasi','".$FieldUpd2[$i]."','".$PrmUpd2[$i]."','1','".$TypeUpd2[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			echo '1';
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='3') {//insert Delete
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = "1";
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$nama_table = isset($_POST['selTb']) ? makeSafe($_POST['selTb']) : '';
	$jml_row_param = isset($_POST['DynDeleteRow']) ? makeSafe($_POST['DynDeleteRow']) : '';
	//
	$FieldDel2 = isset($_POST['2FieldDel']) ? $_POST['2FieldDel'] : '';
	$PrmDel2 = isset($_POST['2PrmDel']) ? $_POST['2PrmDel'] : '';
	$TypeDel2 = isset($_POST['2TypeDel']) ? $_POST['2TypeDel'] : '';
	try {
		$query = "INSERT INTO tb_operasi(id_host,id_jenis_operasi,id_jenis_sql,keyword,is_publik,nama_operasi,penanda_login) VALUES ('$id_host','$id_jenis_operasi','$id_jenis_sql','$keyword','$is_publik','$nama_operasi','$penanda_login')";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			$id_last = mysqli_insert_id($id_mysql);
			//table
			$query = "INSERT INTO tb_operasi_tabel(id_operasi,nama_tabel) VALUES('$id_last','$nama_table')";
			$result = mysqli_query($id_mysql,$query);
			//parameter kunci
			for ($i=0; $i<count($FieldDel2); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci,type) VALUES('$id_last','".$FieldDel2[$i]."','".$PrmDel2[$i]."','1','".$TypeDel2[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			echo "1";
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='3edit') {//edit Delete
	$id_operasi = isset($_POST['idOperasi']) ? makeSafe($_POST['idOperasi']) : '';
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = "1";
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$nama_table = isset($_POST['selTb']) ? makeSafe($_POST['selTb']) : '';
	$jml_row_param = isset($_POST['DynDeleteRow']) ? makeSafe($_POST['DynDeleteRow']) : '';
	//
	$FieldDel2 = isset($_POST['2FieldDel']) ? $_POST['2FieldDel'] : '';
	$PrmDel2 = isset($_POST['2PrmDel']) ? $_POST['2PrmDel'] : '';
	$TypeDel2 = isset($_POST['2TypeDel']) ? $_POST['2TypeDel'] : '';
	try {
		$query = "UPDATE tb_operasi SET id_host='$id_host',id_jenis_operasi='$id_jenis_operasi',id_jenis_sql='$id_jenis_sql',keyword='$keyword',is_publik='$is_publik',nama_operasi='$nama_operasi',penanda_login='$penanda_login' WHERE id_operasi='$id_operasi'";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			//table
			$query = "DELETE FROM tb_operasi_tabel WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			$query = "INSERT INTO tb_operasi_tabel(id_operasi,nama_tabel) VALUES('$id_operasi','$nama_table')";
			$result = mysqli_query($id_mysql,$query);
			//parameter
			$query = "DELETE FROM tb_operasi_parameter WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			//parameter kunci
			for ($i=0; $i<count($FieldDel2); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci,type) VALUES('$id_operasi','".$FieldDel2[$i]."','".$PrmDel2[$i]."','1','".$TypeDel2[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			echo '1';
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='4') {//insert Function
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = isset($_POST['selSQL']) ? makeSafe($_POST['selSQL']) : '';
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	$NmOutput = isset($_POST['NmOutput']) ? makeSafe($_POST['NmOutput']) : '';
	
	//
	$nama_function = isset($_POST['selFunc']) ? makeSafe($_POST['selFunc']) : '';
	$jml_row_param = isset($_POST['DynFunctionRow']) ? makeSafe($_POST['DynFunctionRow']) : '';
	//
	$FieldFunc = isset($_POST['FieldFunc']) ? $_POST['FieldFunc'] : '';
	$PrmFunc = isset($_POST['PrmFunc']) ? $_POST['PrmFunc'] : '';
	try {
	$query = "INSERT INTO tb_operasi(id_host,id_jenis_operasi,id_jenis_sql,keyword,is_publik,nama_operasi,penanda_login) VALUES ('$id_host','$id_jenis_operasi','$id_jenis_sql','$keyword','$is_publik','$nama_operasi','$penanda_login')";
	$result = mysqli_query($id_mysql,$query);
	if($result) {
	  $id_last = mysqli_insert_id($id_mysql);
	  //table
	  $query = "INSERT INTO tb_operasi_prosedural(id_operasi,nama_prosedural,nama_hasil) VALUES('$id_last','$nama_function','$NmOutput')";
	  $result = mysqli_query($id_mysql,$query);
	  //parameter
	  for ($i=0; $i<count($FieldFunc); $i++) {
	    $query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci) VALUES('$id_last','".$FieldFunc[$i]."','".$PrmFunc[$i]."','0')";
	    $result = mysqli_query($id_mysql,$query);
	  }
	  echo "1";
	}else{
	  echo"Error executing query.";
	}
	mysqli_close($id_mysql);  
	}catch (Exception $e) {
	echo 'Error : ',  $e->getMessage(), "<br>";
	}
}elseif ($type=='4edit') {//edit Function
	$id_operasi = isset($_POST['idOperasi']) ? makeSafe($_POST['idOperasi']) : '';
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = isset($_POST['selSQL']) ? makeSafe($_POST['selSQL']) : '';
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	$NmOutput = isset($_POST['NmOutput']) ? makeSafe($_POST['NmOutput']) : '';
	//
	$nama_function = isset($_POST['selFunc']) ? makeSafe($_POST['selFunc']) : '';
	$jml_row_param = isset($_POST['DynFunctionRow']) ? makeSafe($_POST['DynFunctionRow']) : '';
	//
	$FieldFunc = isset($_POST['FieldFunc']) ? $_POST['FieldFunc'] : '';
	$PrmFunc = isset($_POST['PrmFunc']) ? $_POST['PrmFunc'] : '';
	try {
		$query = "UPDATE tb_operasi SET id_host='$id_host',id_jenis_operasi='$id_jenis_operasi',id_jenis_sql='$id_jenis_sql',keyword='$keyword',is_publik='$is_publik',nama_operasi='$nama_operasi',penanda_login='$penanda_login' WHERE id_operasi='$id_operasi'";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			//table
			$query = "DELETE FROM tb_operasi_prosedural WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			$query = "INSERT INTO tb_operasi_prosedural(id_operasi,nama_prosedural,nama_hasil) VALUES('$id_operasi','$nama_function','$NmOutput')";
			$result = mysqli_query($id_mysql,$query);
			//parameter
			$query = "DELETE FROM tb_operasi_parameter WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			for ($i=0; $i<count($FieldFunc); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci) VALUES('$id_operasi','".$FieldFunc[$i]."','".$PrmFunc[$i]."','0')";
				$result = mysqli_query($id_mysql,$query);
			}
			echo '1';
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='5') {//insert Procedure
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = isset($_POST['selSQL']) ? makeSafe($_POST['selSQL']) : '';
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';

	//
	$nama_procedure = isset($_POST['selFunc']) ? makeSafe($_POST['selFunc']) : '';
	$jml_row_param = isset($_POST['DynProcedureRow']) ? makeSafe($_POST['DynProcedureRow']) : '';
	//
	$FieldProc = isset($_POST['FieldProc']) ? $_POST['FieldProc'] : '';
	$PrmProc = isset($_POST['PrmProc']) ? $_POST['PrmProc'] : '';
	try {
	$query = "INSERT INTO tb_operasi(id_host,id_jenis_operasi,id_jenis_sql,keyword,is_publik,nama_operasi,penanda_login) VALUES ('$id_host','$id_jenis_operasi','$id_jenis_sql','$keyword','$is_publik','$nama_operasi','$penanda_login')";
	$result = mysqli_query($id_mysql,$query);
	if($result) {
	$id_last = mysqli_insert_id($id_mysql);
	//table
	$query = "INSERT INTO tb_operasi_prosedural(id_operasi,nama_prosedural,nama_hasil) VALUES('$id_last','$nama_procedure','')";
	$result = mysqli_query($id_mysql,$query);
	//parameter
	for ($i=0; $i<count($FieldProc); $i++) {
	  $query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci) VALUES('$id_last','".$FieldProc[$i]."','".$PrmProc[$i]."','0')";
	  $result = mysqli_query($id_mysql,$query);
	}
	echo "1";
	}else{
	echo"Error executing query.";
	}
	mysqli_close($id_mysql);  
	}catch (Exception $e) {
	echo 'Error : ',  $e->getMessage(), "<br>";
	}
}elseif ($type=='5edit') {//edit Procedure
	$id_operasi = isset($_POST['idOperasi']) ? makeSafe($_POST['idOperasi']) : '';
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = isset($_POST['selSQL']) ? makeSafe($_POST['selSQL']) : '';
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$nama_procedure = isset($_POST['selFunc']) ? makeSafe($_POST['selFunc']) : '';
	$jml_row_param = isset($_POST['DynProcedureRow']) ? makeSafe($_POST['DynProcedureRow']) : '';
	//
	$FieldProc = isset($_POST['FieldProc']) ? $_POST['FieldProc'] : '';
	$PrmProc = isset($_POST['PrmProc']) ? $_POST['PrmProc'] : '';
	try {
		$query = "UPDATE tb_operasi SET id_host='$id_host',id_jenis_operasi='$id_jenis_operasi',id_jenis_sql='$id_jenis_sql',keyword='$keyword',is_publik='$is_publik',nama_operasi='$nama_operasi',penanda_login='$penanda_login' WHERE id_operasi='$id_operasi'";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			//table
			$query = "DELETE FROM tb_operasi_prosedural WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			$query = "INSERT INTO tb_operasi_prosedural(id_operasi,nama_prosedural,nama_hasil) VALUES('$id_operasi','$nama_procedure','')";
			$result = mysqli_query($id_mysql,$query);
			//parameter
			$query = "DELETE FROM tb_operasi_parameter WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			for ($i=0; $i<count($FieldProc); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci) VALUES('$id_operasi','".$FieldProc[$i]."','".$PrmProc[$i]."','0')";
				$result = mysqli_query($id_mysql,$query);
			}
			echo '1';
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='6') {//insert Search
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = "1";
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$TableSearch = isset($_POST['TableSearch']) ? $_POST['TableSearch'] : '';
	//
	$FieldSearch = isset($_POST['FieldSearch']) ? $_POST['FieldSearch'] : '';
	$PrmSearch = isset($_POST['PrmSearch']) ? $_POST['PrmSearch'] : '';
	$TypOutputSearch = isset($_POST['TypOutputSearch']) ? $_POST['TypOutputSearch'] : '';
	//
	$OrderSearch = isset($_POST['OrderSearch']) ? $_POST['OrderSearch'] : '';
	$OrderTypeSearch = isset($_POST['OrderTypeSearch']) ? $_POST['OrderTypeSearch'] : '';
	//
	$FieldSearch2 = isset($_POST['2FieldSearch']) ? $_POST['2FieldSearch'] : '';
	$PrmSearch2 = isset($_POST['2PrmSearch']) ? $_POST['2PrmSearch'] : '';
	$TypeSearch2 = isset($_POST['2TypeSearch']) ? $_POST['2TypeSearch'] : '';
	//
	$Join1Search = isset($_POST['Join1Search']) ? $_POST['Join1Search'] : '';
	$Join2Search = isset($_POST['Join2Search']) ? $_POST['Join2Search'] : '';
	try {
		$query = "INSERT INTO tb_operasi(id_host,id_jenis_operasi,id_jenis_sql,keyword,is_publik,nama_operasi,penanda_login) VALUES ('$id_host','$id_jenis_operasi','$id_jenis_sql','$keyword','$is_publik','$nama_operasi','$penanda_login')";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			$id_last = mysqli_insert_id($id_mysql);
			//table
			for ($i=0; $i<count($TableSearch); $i++) {
				$query = "INSERT INTO tb_operasi_tabel(id_operasi,nama_tabel) VALUES('$id_last','".$TableSearch[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			//parameter output
			for ($i=0; $i<count($FieldSearch); $i++) {
				$query = "INSERT INTO tb_operasi_output(id_operasi,output,nama_output,jenis_output) VALUES('$id_last','".$FieldSearch[$i]."','".$PrmSearch[$i]."','".$TypOutputSearch[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			//parameter kunci
			for ($i=0; $i<count($FieldSearch2); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci,type) VALUES('$id_last','".$FieldSearch2[$i]."','".$PrmSearch2[$i]."','1','".$TypeSearch2[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			//parameter order by
			for ($i=0; $i<count($OrderSearch); $i++) {
				$query = "INSERT INTO tb_operasi_order_by(id_operasi,order_by,type) VALUES('$id_last','".$OrderSearch[$i]."','".$OrderTypeSearch[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			if(isset($_POST['Join1Search'])){
				//join
				for ($i=0; $i<count($Join1Search); $i++) {
					$query = "INSERT INTO tb_operasi_join(id_operasi,field_join) VALUES('$id_last','".$Join1Search[$i]."=".$Join2Search[$i]."')";
					$result = mysqli_query($id_mysql,$query);
				}
			}
			echo "1";
		}else{
			echo"Error executing query.";
		}
		mysqli_close($id_mysql);	
	}catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}elseif ($type=='6edit') {//insert Search
	$id_operasi = isset($_POST['idOperasi']) ? makeSafe($_POST['idOperasi']) : '';
	$id_host = isset($_POST['selHost']) ? makeSafe($_POST['selHost']) : '';
	$id_jenis_operasi = isset($_POST['selJenis']) ? makeSafe($_POST['selJenis']) : '';
	$id_jenis_sql = "1";
	//
	$keyword = isset($_POST['Keyw']) ? strtoupper(makeSafe($_POST['Keyw'])) : '';
	$is_publik = isset($_POST['selPub']) ? makeSafe($_POST['selPub']) : '';
	$nama_operasi = isset($_POST['NmKeyw']) ? makeSafe($_POST['NmKeyw']) : '';
	$penanda_login = isset($_POST['selLogin']) ? makeSafe($_POST['selLogin']) : '';
	//
	$TableSearch = isset($_POST['TableSearch']) ? $_POST['TableSearch'] : '';
	//
	$FieldSearch = isset($_POST['FieldSearch']) ? $_POST['FieldSearch'] : '';
	$PrmSearch = isset($_POST['PrmSearch']) ? $_POST['PrmSearch'] : '';
	$TypOutputSearch = isset($_POST['TypOutputSearch']) ? $_POST['TypOutputSearch'] : '';
	//
	$OrderSearch = isset($_POST['OrderSearch']) ? $_POST['OrderSearch'] : '';
	$OrderTypeSearch = isset($_POST['OrderTypeSearch']) ? $_POST['OrderTypeSearch'] : '';
	//
	$FieldSearch2 = isset($_POST['2FieldSearch']) ? $_POST['2FieldSearch'] : '';
	$PrmSearch2 = isset($_POST['2PrmSearch']) ? $_POST['2PrmSearch'] : '';
	$TypeSearch2 = isset($_POST['2TypeSearch']) ? $_POST['2TypeSearch'] : '';
	//
	$Join1Search = isset($_POST['Join1Search']) ? $_POST['Join1Search'] : '';
	$Join2Search = isset($_POST['Join2Search']) ? $_POST['Join2Search'] : '';
	try {
		$query = "UPDATE tb_operasi SET id_host='$id_host',id_jenis_operasi='$id_jenis_operasi',id_jenis_sql='$id_jenis_sql',keyword='$keyword',is_publik='$is_publik',nama_operasi='$nama_operasi',penanda_login='$penanda_login' WHERE id_operasi='$id_operasi'";
		$result = mysqli_query($id_mysql,$query);
		if($result) {
			//table
			$query = "DELETE FROM tb_operasi_tabel WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			for ($i=0; $i<count($TableSearch); $i++) {
				$query = "INSERT INTO tb_operasi_tabel(id_operasi,nama_tabel) VALUES('$id_operasi','".$TableSearch[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			//parameter output
			$query = "DELETE FROM tb_operasi_output WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			for ($i=0; $i<count($FieldSearch); $i++) {
				$query = "INSERT INTO tb_operasi_output(id_operasi,output,nama_output,jenis_output) VALUES('$id_operasi','".$FieldSearch[$i]."','".$PrmSearch[$i]."','".$TypOutputSearch[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			//parameter kunci
			$query = "DELETE FROM tb_operasi_parameter WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			for ($i=0; $i<count($FieldSearch2); $i++) {
				$query = "INSERT INTO tb_operasi_parameter(id_operasi,parameter,nama_parameter,is_kunci,type) VALUES('$id_operasi','".$FieldSearch2[$i]."','".$PrmSearch2[$i]."','1','".$TypeSearch2[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			//parameter order by
			$query = "DELETE FROM tb_operasi_order_by WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			for ($i=0; $i<count($OrderSearch); $i++) {
				$query = "INSERT INTO tb_operasi_order_by(id_operasi,order_by,type) VALUES('$id_operasi','".$OrderSearch[$i]."','".$OrderTypeSearch[$i]."')";
				$result = mysqli_query($id_mysql,$query);
			}
			//join
			$query = "DELETE FROM tb_operasi_join WHERE id_operasi='$id_operasi'";
			$result = mysqli_query($id_mysql,$query);
			//
			if(isset($_POST['Join1Search'])){
				for ($i=0; $i<count($Join1Search); $i++) {
					$query = "INSERT INTO tb_operasi_join(id_operasi,field_join) VALUES('$id_operasi','".$Join1Search[$i]."=".$Join2Search[$i]."')";
					$result = mysqli_query($id_mysql,$query);
				}
			}
			echo "1";
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
	$table = " ( SELECT op.id_operasi,op.id_host,hst.nama_host,sq.jenis_sql,jop.jenis_operasi,jop.id_jenis_operasi,sq.id_jenis_sql,op.nama_operasi,op.keyword,op.is_publik,op.penanda_login FROM tb_operasi op
INNER JOIN tb_host hst ON hst.id_host=op.id_host
INNER JOIN tb_jenis_sql sq ON sq.id_jenis_sql=op.id_jenis_sql
INNER JOIN tb_jenis_operasi jop ON jop.id_jenis_operasi=op.id_jenis_operasi) temp";
	 
	// Table's primary key
	$primaryKey = 'id_operasi';
	 
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
	    array( 'db' => 'id_operasi', 'dt' => 0 ),
	    array( 'db' => 'nama_host',   'dt' => 1 ),
	    array( 'db' => 'nama_operasi',   'dt' => 2 ),
	    array( 'db' => 'keyword',   'dt' => 3 ),
	    array( 'db' => 'jenis_operasi',   'dt' => 4 ),
	    array( 'db' => 'is_publik',
	    	   'dt' => 5,
	    	   'formatter' => function( $d, $row ) {
		            if($d == "1"){
		            	return "Publik";
		            }else{
		            	return "Privat";
		            }
		        }
	    ),
	    array( 'db' => 'penanda_login',
	    	   'dt' => 6,
	    	   'formatter' => function( $d, $row ) {
		           if($d == "1"){
		           	return "Dibutuhkan";
		           }else{
		           	return "-";
		           }
		        }
	    ),
	    array( 'db' => 'id_jenis_operasi',   'dt' => 7 ),
	    array( 'db' => 'id_jenis_sql',   'dt' => 8 ),
	    array( 
	    	'db'        => 'id_operasi',
	        'dt'        => 9,
	        'formatter' => function( $d, $row ) {
	        	//
	        	$p = '1a';
	        	return "<a href='keyword.php?dup=1&id=$d&p=$p'>"."<i class='fa fa-copy'></i>"."</a>&nbsp<a href='keyword.php?id=$d&p=$p'>"."<i class='fa fa-pencil'></i>"."</a>&nbsp<a href='keyword.php?del=1&id=$d'>"."<i class='fa fa-trash' onclick=\"return confirm('Are you sure you want to delete this keyword?')\"></i>"."</a>";
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