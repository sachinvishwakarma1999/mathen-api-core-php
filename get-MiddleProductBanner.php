<?php include('config.php'); 
include('api.php');
$sql="select * from whole_product where displayflag='1' ORDER BY id DESC";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "deals listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);


 ?>

