<?php include('config.php'); 
include('api.php');
// isset($_GET['userid']) ?
// $userid = $_GET['userid'] : "";
$conn->set_charset('utf8');
$userid=0;
isset($_GET['keyword']) ?
$keyword = $_GET['keyword'] : "";

isset($_GET['userid']) ?
$userid = $_GET['userid'] : "";
$pageno = 1;
$offset = 0;
$no_of_records_per_page = 20;
if(!empty($_GET['pageno'])){
		$pageno = $_GET['pageno'];
}


$offset = ($pageno-1) * $no_of_records_per_page;

$view= [];
if($keyword=="1")
{
	 $sql="select id as ProdID,productname,wp.costprice,wp.discountcodes,(SELECT avg(`rating`) FROM `whole_rating` WHERE `product_id`=wp.id ) as rating,(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by  `product_id`) as ratingcount,wc.categoryname,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid' limit 1)) as wishid from whole_product as wp join whole_category as wc on wc.cat_id=wp.cat_id where wp.displayflag='1' and wp.dealoffer='DealsofTheDay' ORDER BY wp.id DESC LIMIT $offset,$no_of_records_per_page";
	$result=$conn->query($sql);
	while($row = $result->fetch_assoc()){
		$result1[]=$row;
	}
	for($i=0;$i<count($result1);$i++)
	{
		$sqlimg="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result1[$i]['ProdID']."' and mainimage='1'";
		$resultimg=$conn->query($sqlimg);
		$data[$i] = $resultimg->fetch_assoc();
	}
	foreach($result1 as $key=>$val){ // Loop though one array
	    $val2 = $data[$key]; // Get the values from the other array
	    $view[$key] = $val + $val2; // combine 'em
	}
}
if($keyword=="2")
{
	$sqlTopsel="SELECT productid as ProdID,wp.productname,wp.costprice,wp.discountcodes,(SELECT avg(`rating`) FROM `whole_rating` WHERE `product_id`=wp.id ) as rating,(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by  `product_id`) as ratingcount,wc.categoryname,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid' limit 1)) as wishid FROM `whole_basket` as wb join whole_order as wo on wo.bid=wb.`bid` join whole_product as wp on wp.`id`= wb.productid join whole_category as wc on wc.cat_id=wp.cat_id where wo.cancelstatus='0' group by wb.`bid` order by wb.`id` DESC LIMIT $offset,$no_of_records_per_page";
	$resultTopsel=$conn->query($sqlTopsel);
	while($row = $resultTopsel->fetch_assoc()){
		$result2[]=$row;
	}
	for($i=0;$i<count($result2);$i++)
	{
		$sqlimg1="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result2[$i]['ProdID']."'";
		$resultimg1=$conn->query($sqlimg1);
		$data2[$i] = $resultimg1->fetch_assoc();
	}
	foreach($result2 as $key=>$val){ // Loop though one array
	    $val2 = $data2[$key]; // Get the values from the other array
	    $view[$key] = $val + $val2; // combine 'em
	}
}

if($keyword=="3")
{
	$sqllatest="select id as ProdID,productname,wp.costprice,wp.discountcodes,(SELECT avg(`rating`) FROM `whole_rating` WHERE `product_id`=wp.id ) as rating,(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by  `product_id`) as ratingcount,wc.categoryname,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid' limit 1)) as wishid from whole_product as wp join whole_category as wc on wc.cat_id=wp.cat_id where wp.displayflag='1' and wp.dealoffer='' ORDER BY wp.id DESC LIMIT $offset,$no_of_records_per_page";
	$resultlatest=$conn->query($sqllatest);
	while($row = $resultlatest->fetch_assoc()){
		$result3[]=$row;
	}
	for($i=0;$i<count($result3);$i++)
	{
		$sqlimg2="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result3[$i]['ProdID']."'";
		$resultimg2=$conn->query($sqlimg2);
		$data3[$i] = $resultimg2->fetch_assoc();
	}
	foreach($result3 as $key=>$val){ // Loop though one array
	    $val2 = $data3[$key]; // Get the values from the other array
	    $view[$key] = $val + $val2; // combine 'em
	}
}
if($keyword=="4")
{
	$sqlrecent="SELECT wp.id as ProdId,wp.productname as ProdName,wp.costprice, wp.discountcodes,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
		(SELECT avg(`rating`) FROM `whole_rating` WHERE `product_id`=wp.id ) as rating,(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by  `product_id`) as ratingcount,wc.categoryname,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid' limit 1)) as wishid
		FROM `whole_recentview` as wr join whole_product as wp on wp.id=wr.`productid` join whole_category as wc on wc.cat_id=wp.cat_id where userid ='$userid' order by wr.id desc LIMIT $offset,$no_of_records_per_page";
		$resultrecent=$conn->query($sqlrecent);
		$result4=[];
		while($row = $resultrecent->fetch_assoc()){
			$result4[]=$row;
		}
		for($i=0;$i<count($result4);$i++)
		{
			$sqlimg3="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result4[$i]['ProdId']."'";
			$resultimg3=$conn->query($sqlimg3);
			$data4[$i] = $resultimg3->fetch_assoc();
		}
		foreach($result4 as $key=>$val){ // Loop though one array
		    $val2 = $data4[$key]; // Get the values from the other array
		    $view[$key] = $val + $val2; // combine 'em
		}
}

$message = "View All";
$result = $view;
$data = array("message"=>$message,"result"=>$result);
responseSuccess($data);


 ?>

