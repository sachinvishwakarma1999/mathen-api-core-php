<?php include('config.php'); 
include('api.php');
isset($_GET['cat_id']) ?
	$cat_id = $_GET['cat_id'] : "";

$conn->set_charset('utf8');
///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/';
$sql="select *,concat('".$baseUrl."',wip.productimage) as product_img,wp.productname as productname from whole_product as wp JOIN whole_imageupload as wip ON wp.id=wip.pid where wp.cat_id='$cat_id' LIMIT 20";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "related product listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);

/////http://api.manthanonline.in/getRelatedProducts.php?cat_id=00103
 ?>

