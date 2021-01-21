<?php 
include('config.php'); 
include('api.php');
$oid=$_POST['orderId'];

$sql=$conn->query("UPDATE `whole_order` SET  `approve_status`='Cancel Order' where `oid`='$oid'");
if($sql==1)
{
	$message = "Order Cancelled";
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