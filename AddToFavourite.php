<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");

isset($_POST['pid']) ?
$pid = $_POST['pid'] : "";

isset($_POST['userid']) ?
$userid = $_POST['userid'] : "";



// isset($_POST['quantity']) ?
// $quantity = $_POST['quantity'] : "";

isset($_POST['email']) ?
$email = $_POST['email'] : "";

isset($_POST['color']) ?
$color = $_POST['color'] : "";

isset($_POST['size']) ?
$size = $_POST['size'] : "";

$VarientName="";
$colorSize="";
if($color!='')
{
	$VarientName.=ucfirst("color")."|";
	$colorSize.=ucfirst($color).'|';
}
if($size!='')
{
	$VarientName.=ucfirst("size")."|";
	$colorSize.=ucfirst($size).'|';
}
$productimg='';
$newvarientName=trim($VarientName,'|');
$newColorSizeName=trim($colorSize,'|');
$sqlChk=$conn->query("SELECT `wid`,if(`discountcodes`=0,`costprice`,`discountcodes`) as price FROM `whole_whishlist` where `productid`='$pid' AND `userid`='$userid' AND `emailid`='$email' AND `deliverstatus`='0' AND `orderstatus`='0'");
if($sqlChk->num_rows>0)
{
	$row=$sqlChk->fetch_assoc();
	$price=$row['price'];

	$result=$conn->query("UPDATE `whole_whishlist` SET `subtotal`='$price',`editdate`=DATE(now()) where wid=".$row['wid']."");
}
else
{
	$baseUrl = 'https://www.manthanonline.in/productimage/';
	$sql="INSERT INTO `whole_whishlist`(`productid`,comboid,`cat_id`, `subcat_id`, `subsubcat_id`, `productname`, `slug`, `description`,  `sellingprice`, `discountcodes`, `costprice`, `brand`,   `offername`, `displayflag`, `adddate`,  `productstatus`, `price`, `orderstatus`, `deliverstatus`, `basket_status`, `sku`, `barcode`, `pweight`,
	    `productimage`,  `subtotal`,`userid`, `emailid`,variantname,variantvalue)
	SELECT `id`,'0',`cat_id`,  `subcat_id`, `subsubcat_id`,  `productname`,`slug`, `shortdescription`, `sellingprice`,`discountcodes`, `costprice`, `brandname`, `offername`, '1',DATE(now()),`stockavailability`, `regularprice`,'0','0','1',`sku`, `barcode`,`pweight`,(SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) FROM `whole_imageupload` where `mainimage`='1' AND `productimage`!='' AND `pid`='$pid' order by `id` desc limit 1),(if(`discountcodes`=0,`costprice`,`discountcodes`)),'$userid','$email','$newvarientName','$newColorSizeName' from whole_product where `id`='$pid'";
	$result=$conn->query($sql);
}
if($result==1)
{
	$message = "Item added to favourite";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "something went wrong";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}
/////http://api.manthanonline.in/get1Orders.php?email=info@manthanonline.in
 ?>

