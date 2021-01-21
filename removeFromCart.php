<?php include('config.php'); 
	include('api.php');
	$conn->set_charset('utf8');
	isset($_POST['basketId']) ?
	$basketId = $_POST['basketId'] : "";

	$conn->query("DELETE FROM `whole_basket` WHERE `id`='$basketId'");
	
	$message = "Item removed from Cart";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);

?>