<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
$userid=0;
isset($_REQUEST['userid']) ?
$userid = $_REQUEST['userid'] : "";


///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/bannerimages/';
$sqltop="select `id`,`cat_id`, `sub_cat_id`, `sub_sub_cat_id`,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners where bposition='HomeOfferBannerTop' ORDER BY id DESC LIMIT 0,3";
 $resultTop=$conn->query($sqltop);

$topBan['topBan']=[];
while($row=$resultTop->fetch_assoc())
{
	$topBan['topBan'][]=$row;
}


$sqlMid="select id,`cat_id`, `sub_cat_id`, `sub_sub_cat_id`,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners where bposition='HomeOfferBannerMiddle' ORDER BY id DESC LIMIT 0,3";
$resultMid=$conn->query($sqlMid);

$Midban['Midban']=[];
while($row=$resultMid->fetch_assoc())
{
	$Midban['Midban'][]=$row;
}

$sqlRight="select id as ProdID,`cat_id`, `sub_cat_id`, `sub_sub_cat_id`,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners where bposition='HomeRightSideBanner' ORDER BY id DESC LIMIT 1";
$resultRight=$conn->query($sqlRight);

$RigBan['RigBan']=[];
while($row=$resultRight->fetch_assoc())
{
	$RigBan['RigBan'][]=$row;
}

$sqlSlider="select id as ProdID,`cat_id`, `sub_cat_id`, `sub_sub_cat_id`,concat('".$baseUrl."',uploadimage) as banner_img_url from whole_banners WHERE bposition ='Mobile Banner' ORDER BY id DESC LIMIT 5";
$resultSlid=$conn->query($sqlSlider);

$SliderBan['slider']=[];
while($row=$resultSlid->fetch_assoc())
{
	$SliderBan['slider'][]=$row;
}

 $sql="select id as ProdID,productname,wp.discountcodes,wp.costprice,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
if((SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1)) as wishid from whole_product as wp where wp.displayflag='1' and wp.dealoffer='DealsofTheDay' ORDER BY wp.id DESC LIMIT 4";
$result=$conn->query($sql);

$result1=[];
while($row = $result->fetch_assoc()){
	$result1[]=$row;
}

$data=[];
for($i=0;$i<count($result1);$i++)
{
	$sqlimg="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result1[$i]['ProdID']."' and mainimage='1'";
	$resultimg=$conn->query($sqlimg);
	$data[$i] = $resultimg->fetch_assoc();
}

$dealsArr['dealsOfday'] = array();
foreach($result1 as $key=>$val){ // Loop though one array
    $val2 = $data[$key]; // Get the values from the other array
    $dealsArr['dealsOfday'][$key] = $val + $val2; // combine 'em
}

$sqlTopsel="SELECT productid as ProdID,wp.productname,wp.discountcodes,wp.costprice,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
if((SELECT `wid` FROM `whole_whishlist` where `productid`=productid AND `userid`='$userid' limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1)) as wishid  FROM `whole_basket` as wb join whole_order as wo on wo.bid=wb.`bid` join whole_product as wp on wp.`id`= wb.productid where wo.cancelstatus='0' group by wp.id order by max(wb.`id`) DESC limit 4";
$resultTopsel=$conn->query($sqlTopsel);

$result2=[];
while($row = $resultTopsel->fetch_assoc()){
	$result2[]=$row;
}

$data2 = [];
for($i=0;$i<count($result2);$i++)
{
	$sqlimg1="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result2[$i]['ProdID']."' and mainimage='1'";
	$resultimg1=$conn->query($sqlimg1);
	$data2[$i] = $resultimg1->fetch_assoc();
}

$TopSel['TopSel'] = array();
foreach($result2 as $key=>$val){ // Loop though one array
    $val2 = $data2[$key]; // Get the values from the other array
    $TopSel['TopSel'][$key] = $val + $val2; // combine 'em
}
$catArr=[];
$sqlcat="select `cat_id`,`categoryname`,concat('https://www.manthanonline.in/categoryimages/',`appimage`) as headerimage ,concat('https://www.manthanonline.in/categoryimages/',`appiconimage`) as appicon from whole_category where parent='0' and displayflag='1' order by sortid desc";
$resultcat=$conn->query($sqlcat);

$catArr['category']=[];
while($row=$resultcat->fetch_assoc())
{
	$catArr['category'][]=$row;
} 

$sqllatest="select id as ProdID,productname,wp.discountcodes,wp.costprice,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,if((SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1)) as wishid from whole_product as wp where wp.displayflag='1' and wp.dealoffer='' ORDER BY wp.id DESC LIMIT 4";
$resultlatest=$conn->query($sqllatest);

$result3 = [];
while($row = $resultlatest->fetch_assoc()){
	$result3[]=$row;
}

$data3=[];
for($i=0;$i<count($result3);$i++)
{
	$sqlimg2="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result3[$i]['ProdID']."' and mainimage='1'";
	$resultimg2=$conn->query($sqlimg2);
	$data3[$i] = $resultimg2->fetch_assoc();
}

$latestArr['Latest'] = array();
foreach($result3 as $key=>$val){ // Loop though one array
    $val2 = $data3[$key]; // Get the values from the other array
    $latestArr['Latest'][$key] = $val + $val2; // combine 'em
}

$recentarr['recent'] = array();
if($userid!='')
{
	$sqlrecent="SELECT wp.id as ProdId,wp.productname as ProdName,wp.costprice, wp.discountcodes,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
	(SELECT avg(`rating`) FROM `whole_rating` WHERE `product_id`=wp.id ) as rating,(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by  `product_id`) as ratingcount,wc.categoryname,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1)) as wishid,(SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`=wp.id and mainimage='1' limit 1) as product_image
	FROM `whole_recentview` as wr join whole_product as wp on wp.id=wr.`productid` join whole_category as wc on wc.cat_id=wp.cat_id where userid ='$userid' order by wr.id desc limit 10";
	$result4=[];
	$resultrecent=$conn->query($sqlrecent);
	while($row = $resultrecent->fetch_assoc()){
		$recentarr['recent'][]=$row;
	}
}
$sql5="select id as ProdID,productname,wp.discountcodes,wp.costprice,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
if((SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=id AND `userid`='$userid' limit 1)) as wishid from whole_product as wp where wp.displayflag='1' and wp.dealoffer='BudgetFriendlyFurniture' ORDER BY wp.id DESC LIMIT 4";
	$result5=$conn->query($sql5);

	
	$result6=[];
	while($row = $result5->fetch_assoc()){
		$result6[]=$row;
	}
	
	$data=[];
	for($i=0;$i<count($result6);$i++)
	{
		$sqlimg="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result6[$i]['ProdID']."' and mainimage='1'";
		$resultimg=$conn->query($sqlimg);
		$data[$i] = $resultimg->fetch_assoc();
	}

	$BudArr['Budgetfriendly'] = array();
	foreach($result1 as $key=>$val){ // Loop though one array
	    $val2 = $data[$key]; // Get the values from the other array
	    $BudArr['Budgetfriendly'][$key] = $val + $val2; // combine 'em
	}

$records=array_merge($SliderBan,$topBan,$Midban,$RigBan,$dealsArr,$TopSel,$catArr,$latestArr,$recentarr,$BudArr);


$data4520 = array();
$message = "banner listing";
$result = $records;

$data4520['result'] = $message;
$data4520['message'] = $result;

$data4520['statusCode'] = 200;
$data4520['status'] = 1;
echo json_encode($data4520);
exit();

 ?>



