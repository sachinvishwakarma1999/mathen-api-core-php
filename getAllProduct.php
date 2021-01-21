<?php include('config.php'); 
include('api.php');
	$conn->set_charset('utf8');
	$cat_id = 0;
	$subcat_id = 0;
	$subsubcat_id = 0;
	$sqlWhere = '';
	$offset_min = 0;
	$offset_max = 10;


	if(!empty($_GET['cat_id'])){
		$cat_id = $_GET['cat_id'];
		$sqlWhere = "wp.cat_id=".$cat_id;
	}
	if(!empty($_GET['subcat_id']) && !empty($_GET['cat_id'])){
		$subcat_id = $_GET['subcat_id'];
		$sqlWhere = $sqlWhere." and wp.subcat_id=".$subcat_id;
	}
	if(!empty($_GET['subcat_id']) && !empty($_GET['cat_id']) && !empty($_GET['subsubcat_id'])){
		$subsubcat_id = $_GET['subsubcat_id'];
		$sqlWhere = $sqlWhere." and wp.subsubcat_id=".$subsubcat_id;
	}

	if(!empty($_GET['offset'])){
		$offset_min = $offset_max;
		$offset_max = $offset_max + $_GET['offset'];
	}
	

///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/';


/*
echo $sql="select *,concat('".$baseUrl."',wip.productimage) as product_img from whole_product as wp JOIN whole_imageupload as wip ON wp.id=wip.pid where wp.cat_id='$cat_id' AND wp.subcat_id='$subcat_id' ORDER BY wp.id DESC";
*/

$sql="SELECT *, concat('".$baseUrl."',wip.productimage) as product_img FROM whole_product as wp JOIN whole_imageupload as wip ON wp.id=wip.pid WHERE $sqlWhere ORDER BY wp.id DESC LIMIT $offset_min ,$offset_max";

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

