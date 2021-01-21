<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$Errmessage="";


isset($_POST['buttonID']) ?
$buttonID = $_POST['buttonID'] : "";


isset($_POST['userid']) ?
$userid = $_POST['userid'] : "";

isset($_POST['aid']) ?
$aid = $_POST['aid'] : "";

isset($_POST['adressType']) ?
$adressType = $_POST['adressType'] : "";

isset($_POST['name']) ?
$name = $_POST['name'] : "";	

isset($_POST['mobile']) ?
$mobile = $_POST['mobile'] : "";	

isset($_POST['pincode']) ?
$pincode = $_POST['pincode'] : "";

isset($_POST['city']) ?
$city = $_POST['city'] : "";

isset($_POST['state']) ?
$state = $_POST['state'] : "";

isset($_POST['adress']) ?
$adress = $_POST['adress'] : "";

isset($_POST['nearest']) ?
$nearest = $_POST['nearest'] : "";

isset($_POST['deliverTime']) ?
$deliverTime = $_POST['deliverTime'] : "";

isset($_POST['country']) ?
$country = $_POST['country'] : "";

isset($_POST['alternate_mobile']) ?
$alternate_mobile = $_POST['alternate_mobile'] : "";

if($buttonID==1)
{
	$sql=$conn->query("UPDATE `whole_user_address` SET  `address`='$adress',`landmark`='$nearest',`city`='$city',`state`='$state',`country`='$country',`zipcode`='$pincode',`delivery_time`='$deliverTime',`name`='$name',`mobile`='$mobile',alternate_mobile='$alternate_mobile' where aid='$aid'");
	$message1 = "address updated successfully.";
}
else
{
	$sql=$conn->query("INSERT INTO `whole_user_address`(`id`, `address`, `landmark`, `city`, `state`, `country`, `zipcode`, `delivery_time`, `address_type`,`name`,`mobile`,`alternate_mobile`) VALUES ('$userid','$adress','$nearest','$city','$state','$country','$pincode','$deliverTime','$adressType','$name','$mobile','$alternate_mobile')");
	$message1 = "address added successfully.";
}
if($sql==1)
{
	$message = $message1;
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "Something went wrong, Please try later.";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}


/////http://gkssoftware.com/grvapi/AddUserAddress.php?userid=67&address=aaa&housenumber=sss&city=mmm&state=ppp&country=fff&zipcode=123
 ?>

