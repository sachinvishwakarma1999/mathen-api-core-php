<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
//header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/';
$sql="select *,concat('".$baseUrl."',wip.productimage) as product_img from whole_product as wp JOIN whole_imageupload as wip ON wp.id=wip.pid where wp.displayflag='1' and wp.dealoffer='BudgetFriendlyFurniture' ORDER BY wp.id DESC LIMIT 6";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "get budget friendly product";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);

/////http://gkssoftware.com/grvapi/get-budget-friendly.php
 ?>

