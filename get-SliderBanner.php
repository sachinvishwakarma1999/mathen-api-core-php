<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/bannerimages/';
$sql="select *,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners WHERE bposition ='Top Banner' ORDER BY id DESC LIMIT 5";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "Slider listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);


 ?>

