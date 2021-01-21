<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");

isset($_GET['cat_id']) ?
	$cat_id = $_GET['cat_id'] : "";

	isset($_GET['subcat_id']) ?
	$subcat_id = $_GET['subcat_id'] : "";

header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/';
$sql="select *,concat('".$baseUrl."',wip.productimage) as product_img from whole_product as wp JOIN whole_imageupload as wip ON wp.id=wip.pid where wp.cat_id='$cat_id' AND wp.subcat_id='$subcat_id'";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}

$message = "product listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);

/////gkssoftware.com/grvapi/getProducts.php?cat_id=00193&subcat_id=00103
 ?>

