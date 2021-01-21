<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/bannerimages/';
$sqltop="select *,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners where bposition='HomeOfferBannerTop' ORDER BY id DESC LIMIT 0,3";
 $resultTop=$conn->query($sqltop);
$topBan=[];
while($row=$resultTop->fetch_object())
{
	$topBan['topBan'][]=$row;
}
$sqlMid="select *,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners where bposition='HomeOfferBannerMiddle' ORDER BY id DESC LIMIT 0,3";
$resultMid=$conn->query($sqlMid);
$Midban=[];
while($row=$resultMid->fetch_object())
{
	$Midban['Midban'][]=$row;
}
$sqlRight="select *,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners where bposition='HomeRightSideBanner' ORDER BY id DESC LIMIT 1";
$resultRight=$conn->query($sqlRight);
$RigBan=[];
while($row=$resultRight->fetch_object())
{
	$RigBan['RigBan'][]=$row;
}

$sqlSlider="select *,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners WHERE bposition ='Top Banner' ORDER BY id DESC LIMIT 5";
$resultSlid=$conn->query($sqlSlider);
$SliderBan=[];
while($row=$resultSlid->fetch_object())
{
	$SliderBan['slider'][]=$row;
}
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
$dealsArr = array();
foreach($result1 as $key=>$val){ // Loop though one array
    $val2 = $data[$key]; // Get the values from the other array
    $dealsArr['dealsOfday'][$key] = $val + $val2; // combine 'em
}

$sqlTopsel="SELECT * FROM `whole_basket` as wb join whole_order as wo on wo.bid=wb.`bid` where wo.cancelstatus='0' group by wb.`bid` order by `id` DESC limit 9";
$resultTopsel=$conn->query($sql);
while($row = $resultTopsel->fetch_object()){
	$resultTopSel['Topselect'][]=$row;
}
$records=array_merge($SliderBan,$topBan,$Midban,$RigBan,$dealsArr,$resultTopSel);
// print_r($records);
$message = "banner listing";
$result = $records;
$data = array("message"=>$message,"result"=>$result);
responseSuccess($data);


 ?>

sss