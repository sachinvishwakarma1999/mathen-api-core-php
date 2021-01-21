<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$conn->set_charset('utf8');
isset($_POST['email']) ?
$email = $_POST['email'] : "";
$pageno = 1;
$offset = 0;
isset($_POST['page_no']) ?
$pageno = $_POST['page_no'] : "";
$no_of_records_per_page = 10;
$offset = ($pageno-1) * $no_of_records_per_page;
////header("Access-Control-Allow-Origin");
$newemail=trim($email);

$sql1=$conn->query("select sum(wp.costprice) as costTotal,sum(if(wp.discountcodes='0.00',wp.costprice,wp.discountcodes)) as Total from whole_user_registration as wur JOIN whole_whishlist as wish ON wur.emailid=wish.`emailid` join whole_product as wp on wp.id=wish.productid join whole_category as wc on wc.cat_id=wp.cat_id where wur.emailid='$newemail' ");
$row1=$sql1->fetch_assoc();
$baseUrl = 'https://www.manthanonline.in/productimage/';
$sql="select wish.wid as wishId,wp.id as prodID,wp.productname, wp.discountcodes,wp.costprice,wur.emailid,wimg.id as imgId,wp.sellingprice,(SELECT avg(`rating`) FROM `whole_rating` WHERE `product_id`=wp.id ) as rating,(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by  `product_id`) as ratingcount,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,wc.categoryname,concat('".$baseUrl."',wimg.productimage) as productimage,variantname,variantvalue from whole_user_registration as wur JOIN whole_whishlist as wish ON wur.emailid=wish.`emailid`  JOIN whole_imageupload as wimg ON wish.`productid`=wimg.pid join whole_product as wp on wp.id=wish.productid join whole_category as wc on wc.cat_id=wp.cat_id where wur.emailid='$newemail'   AND wimg.mainimage='1' AND wimg.productimage!='' LIMIT $offset,$no_of_records_per_page";
$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
	$records['data'][]=$row;
}
if(count($records)>0)
{
	$message = "My Wishlist";
	$records['total']=$row1['Total'];
	$records['costTotal']=$row1['costTotal'];
	$result = $records;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "Nothing to show";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}
/////http://api.manthanonline.in/getOrders.php?email=info@manthanonline.in
 ?>

