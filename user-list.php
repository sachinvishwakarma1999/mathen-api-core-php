<?php include('config.php'); 
include('api.php');
$sql="select * from whole_user_registration";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "User listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);


 ?>

