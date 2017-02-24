<?php 
include 'includes/core.php';
$type= $_GET['t'];

if ($type=='1') {
	$service = makeSafe($_POST['txtService']);
	$server = makeSafe($_POST['txtServer']);
	$id_group_contact = makeSafe($_POST['txtGroupContact']);
	$message = makeSafe($_POST['txtMessage']);
	//
	$queryx = "SELECT * FROM tb_service WHERE id_service='" . $service . "'";
	$resultx = mysqli_query($id_mysql,$queryx);
	$rowx = mysqli_fetch_array($resultx);
	//
	$outbox_table = $rowx['outbox_table'];
    $outbox_isi = $rowx['outbox_content'];
    $outbox_date = $rowx['outbox_date'];
    $outbox_flag = $rowx['outbox_flag'];
    $outbox_recipient = $rowx['outbox_recipient'];
    $outbox_server = $rowx['outbox_server'];
    //
	$query = "";
	//
	$query_grup = "SELECT c.contact_id FROM tb_contact_group_det gd INNER JOIN tb_contact c ON c.id_contact=gd.id_contact WHERE id_contact_group='".$id_group_contact."'";
	$result_grup = mysqli_query($id_mysql,$query_grup);
	while($row_grup = $result_grup->fetch_assoc()) {
		$query .= "INSERT INTO " .$outbox_table. "(" .$outbox_isi. "," .$outbox_date. "," .$outbox_recipient. "," .$outbox_server. ") VALUES ('".$message."',NOW(),'".$row_grup['contact_id']."','".$server."');";
	}
	//
	try {
		$result = mysqli_multi_query($id_mysql,$query);
		if ($result) {
			echo "1";
		}else{
			echo "Error executing query." . $query;
		}	
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}

?>