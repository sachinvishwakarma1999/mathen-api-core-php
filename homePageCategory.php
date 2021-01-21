<?php include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
$baseUrl = 'https://www.manthanonline.in/productimage/thumb/';
$userid =0;
isset($_GET['userid']) ?
$userid = $_GET['userid'] : "";

$sqlMain="SELECT * FROM `whole_itemstrips` where displayflag='1'";
$resultMain=$conn->query($sqlMain);
$mainArr=[];
while($row=$resultMain->fetch_object())
{
	$mainArr[]=$row;
}
foreach($mainArr as $row)
{
	$stripId=$row->id;
	$sqlstrips="select wp.id, itemstrips,wp.costprice,wp.discountcodes,wp.productname,(SELECT avg(`rating`) FROM `whole_rating` WHERE
	`product_id`=wp.id ) as rating,
	(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by `product_id`) as ratingcount,
	if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid' limit 1) IS NULL,0,1) as FavStatus,
	if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid'  limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.`id` AND `userid`='$userid' limit 1)) as wishid,
	(select concat('$baseUrl',productimage) from whole_imageupload where pid=wp.id AND mainimage='1' AND productimage!='' order by id DESC limit 1 ) as product_img from whole_product as wp
	 where  itemstrips='$stripId'  ";
	 $resultStrips=$conn->query($sqlstrips);
	 $record[$row->stripname]=[];
	 while($row1=$resultStrips->fetch_object())
		{
			$record[$row->stripname][]=$row1;

		}
	$record[$row->stripname]['viewAllLink']=$row->striplink;
	if($row->uploadimage1!="")
	{
		$record[$row->stripname]['bannerImg'][0]='https://www.manthanonline.in/bannerimages/'.$row->uploadimage1;
	}
	else
	{
		$record[$row->stripname]['bannerImg'][0]=$row->uploadimage1;
	}
	if($row->uploadimage2!="")
	{
		$record[$row->stripname]['bannerImg'][1]='https://www.manthanonline.in/bannerimages/'.$row->uploadimage2;
	}
	else
	{
		$record[$row->stripname]['bannerImg'][1]=$row->uploadimage2;
	}
	if($row->uploadimage3!="")
	{
		$record[$row->stripname]['bannerImg'][2]='https://www.manthanonline.in/bannerimages/'.$row->uploadimage3;
	}
	else
	{
		$record[$row->stripname]['bannerImg'][2]=$row->uploadimage3;
	}	
	$record[$row->stripname]['bannerlink'][0]=$row->imagelink1;
	$record[$row->stripname]['bannerlink'][1]=$row->imagelink2;
	$record[$row->stripname]['bannerlink'][2]=$row->imagelink3;	
}
	$message = "Item Strip listing";
	$result = $record;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);


 ?>

