<?php include('config.php'); 
include('api.php');
isset($_GET['p_name']) ?
$p_name = $_GET['p_name'] : "";
$conn->set_charset('utf8');
$userid=0;
isset($_GET['userid']) ?
$userid = $_GET['userid'] : "";

$pageno = 1;
$offset = 0;
$no_of_records_per_page = 20; 
$offset = ($pageno-1) * $no_of_records_per_page;

$str="";
///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/';
$sql="SELECT wp.id, wp.costprice,wp.discountcodes,wp.qty,wp.productname,(SELECT avg(`rating`) FROM `whole_rating` WHERE
	`product_id`=wp.id group by  product_id) as rating,
	(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by `product_id`) as ratingcount,
	if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
	(select concat('$baseUrl',productimage) from whole_imageupload where pid=wp.id AND mainimage='1'   limit 1 ) as product_img,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid') IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1)) as wishid from whole_product as wp where `productname` like '%$p_name' ORDER BY wp.id DESC  LIMIT $offset,$no_of_records_per_page";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}
if(count($records)!=0)
{
	$message = "product listing";
	$result = $records;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "Nothing To Show";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}

/////http://api.manthanonline.in/getProductSearch.php?p_name=00193
 ?>


