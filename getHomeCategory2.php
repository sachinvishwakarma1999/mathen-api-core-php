<?php include('config.php'); 
include('api.php');
isset($_GET['cat_id']) ?
$cat_id = $_GET['cat_id'] : "";


///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/bannerimages/';
$sql="select * from whole_product_strip as wps INNER JOIN whole_itemstrips as wis ON wps.stripid=wis.id INNER JOIN whole_product as wp ON wps.productid=wp.id where wps.stripflag='1' and wps.stripid='3' LIMIT 10";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "home category listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
/////http://api.manthanonline.in/getHomeCategory.php
 ?>

