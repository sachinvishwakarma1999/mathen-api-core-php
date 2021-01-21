<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$conn->set_charset('utf8');
isset($_GET['userid']) ?
	$userid = $_GET['userid'] : "";

$sql="select * from whole_user_registration WHERE id ='$userid'";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "View user address";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);



	
/////gkssoftware.com/grvapi/GetUserAddress.php?userid=10
 ?>

