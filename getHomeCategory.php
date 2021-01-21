<?php include('config.php'); 
include('api.php');

///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/bannerimages/';
$basePUrl = 'https://www.manthanonline.in/productimage/';

$sql="select *,concat('".$baseUrl."',wis.uploadimage1) as uploadimage1,concat('".$baseUrl."',wis.uploadimage2) as uploadimage2,concat('".$baseUrl."',wis.uploadimage3) as uploadimage3,concat('".$basePUrl."',wimg.productimage) as productimage from whole_itemstrips as wis JOIN whole_product_strip as wps ON wis.id=wps.stripid JOIN whole_product as wp ON wps.productid=wp.id JOIN whole_imageupload as wimg ON wp.id=wimg.pid where wis.displayflag='1'";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$stpr_ids=$row->id;
$records[]=$row;
}





$message = "home category listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);

/////http://api.manthanonline.in/getHomeCategory.php
 ?>

