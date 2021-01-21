<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/bannerimages/';
$sql="select *,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners where bposition='HomeOfferBannerMiddle' ORDER BY id DESC LIMIT 0,3";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "banner listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);


 ?>

