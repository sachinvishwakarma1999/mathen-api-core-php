<?php include('config.php'); 
include('api.php');
// include('filterMenuList.php');
$conn->set_charset('utf8');
$pageno = 1;
$offset = 0;
$no_of_records_per_page = 20;
isset($_GET['cat_id']) ?
$cat_id = $_GET['cat_id'] : "";

isset($_GET['subcat_id']) ?
$subcat_id = $_GET['subcat_id'] : "";

isset($_GET['filterData']) ?
$filterData = $_GET['filterData'] : "";
$str="";

isset($_GET['pageno']) ?
$pageno = $_GET['pageno'] : "";

$offset = ($pageno-1) * $no_of_records_per_page;
if(!empty($_GET['pageno'])){
		$pageno = $_GET['pageno'];
	}
$records=[];
if(count($filterData)>0)
{
	for($i=0;$i<count($filterData);$i++)
	{
		for($j=0;$j<count($filterData[$i]);$j++)
		{
			if($filterData[$i]==$filterData[0])
			{
				$data=explode('--',$filterData[$i][$j]);
				// print_r($data);
				$str1="";
				$str="AND if(`discountcodes`=0,`costprice`,`discountcodes`)between '".$data[0]."' AND '".$data[1]."'";
				// $pr1=$data[0];
				// $pr2=$data[1];
			}
			else
			{
				$str1="AND varpid=if(varpid='".$filterData[$i][$j]."','".$filterData[$i][$j]."',0)";
				$str="AND FIND_IN_SET ('".$filterData[$i][$j]."',wp.`variant`)";
			}
			$sql=$conn->query("SELECT wp.id,wp.costprice,wp.discountcodes,wp.qty,wp.productname,(SELECT avg(`rating`) FROM `whole_rating` WHERE
			`product_id`=wp.id group by  product_id) as rating,
			(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by `product_id`) as ratingcount,
			if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
			(select concat('$baseUrl',productimage) from whole_imageupload where pid=wp.id AND mainimage='1' $str1 limit 1 ) as product_img,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid') IS NULL,0,1) as FavStatus,
			if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1)) as wishid from whole_product as wp WHERE wp.cat_id=".$cat_id." and wp.subcat_id=".$subcat_id." $str LIMIT $offset,$no_of_records_per_page");
			if($sql->num_rows>0)
			{
				while($row=$sql->fetch_assoc())
				{
					$records[] =$row;
				}
			}
		}
	}
}
else
{
	$errMsg="Please select";
}




// $baseUrl = 'https://www.manthanonline.in/productimage/';
// $sql="select wp.id, wp.costprice,wp.discountcodes,wp.productname,(SELECT avg(`rating`) FROM `whole_rating` WHERE
// `product_id`=wp.id group by  product_id) as rating,
// (SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by `product_id`) as ratingcount,
// if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
// (select concat('$baseUrl',productimage) from whole_imageupload where pid=wp.id AND mainimage='1' order by id DESC limit 1 ) as product_img from whole_product as wp
//  where wp.productname!='' AND MATCH(wp.productname) AGAINST  ('$p_name') 
//  $str ";
// $result=$conn->query($sql);
// $records=[];
// while($row=$result->fetch_object())
// {
// $records[]=$row;
// }
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
?>