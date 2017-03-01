<?php 
include 'includes/core.php';
$type= $_GET['t'];
$id_contact_group = '';
if(isset($_GET['selCG'])){
	$id_contact_group = $_GET['selCG'];
}
if($type=='1'){
	$contact_name = makeSafe($_POST['txtGroupContactName']);
	$id_service = makeSafe($_POST['selService']);

	$query = "UPDATE tb_contact_group SET id_service='".$id_service."',contact_group='".$contact_name."' WHERE id_contact_group='".$id_contact_group."'";
	try {
		$result = mysqli_query($id_mysql,$query);
		if ($result) {
			echo "1";
		}else{
			echo"Error executing query.";
		}	
	} catch (Exception $e) {
		echo 'Error : ',  $e->getMessage(), "<br>";
	}	
}
?>