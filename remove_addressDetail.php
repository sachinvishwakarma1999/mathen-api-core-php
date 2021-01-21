<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$conn->set_charset('utf8');
isset($_POST['addressId']) ?
$addressId = $_POST['addressId'] : "";

$sql=$conn->query("DELETE FROM `whole_user_address` WHERE `aid`='$addressId'");

if($sql==1)
{
	$message = "Address deleted";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "Something went wrong,Please try again.";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}
?>