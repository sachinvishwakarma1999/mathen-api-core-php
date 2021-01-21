<?php include('config.php'); 
	include('api.php');
	$conn->set_charset('utf8');
	isset($_POST['wishid']) ?
	$wishid = $_POST['wishid'] : "";

	$conn->query("DELETE FROM `whole_whishlist` WHERE `wid`='$wishid'");
	$message = "Item removed from wishlist";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);

?>