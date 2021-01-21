<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/thumb/';
// $sql="select *,concat('".$baseUrl."',productimage) as product_image from whole_product JOIN  whole_imageupload as wimg ON whole_product.id=wimg.pid where whole_product.displayflag='1' and whole_product.dealoffer='DealsofTheDay' ORDER BY whole_product.id DESC LIMIT 6";


// $sql="select *,concat('".$baseUrl."',productimage) as product_image from whole_product as wp JOIN  whole_imageupload as wimg ON wp.id=wimg.pid where wp.displayflag='1' and wp.dealoffer='DealsofTheDay' ORDER BY wp.id DESC LIMIT 6";


// $sql="select *,concat('".$baseUrl."',productimage) as product_image from whole_product as wp INNER JOIN  whole_imageupload as wimg ON wp.id=wimg.pid where wp.displayflag='1' and wp.dealoffer='DealsofTheDay' ORDER BY wp.id DESC LIMIT 6";
$sql="select * from whole_product as wp where wp.displayflag='1' and wp.dealoffer='DealsofTheDay' ORDER BY wp.id DESC LIMIT 6";
$result=$conn->query($sql);
while($row = $result->fetch_assoc()){
	$result1[]=$row;
}
for($i=0;$i<count($result1);$i++)
{
	$sqlimg="SELECT pid, concat('".$baseUrl."',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result1[$i]['id']."'";
	$resultimg=$conn->query($sqlimg);
	$data[$i] = $resultimg->fetch_assoc();
}
$newArr = array();
foreach($result1 as $key=>$val){ // Loop though one array
    $val2 = $data[$key]; // Get the values from the other array
    $newArr[$key] = $val + $val2; // combine 'em
}
if(count($newArr)!=0)
{
	$message = "deals listing";
	$result = $newArr;
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


 ?>

