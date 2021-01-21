<?php include('config.php'); 
include('api.php');

	// $cat_id = 0;
	// $subcat_id = 0;
	// $subsubcat_id = 0;
	$sqlWhere = '';
	$conn->set_charset('utf8');
	//Pagination for product  List
	$userid=0;
	$pageno = 1;
	$offset = 0;
	$no_of_records_per_page = 20;
	
	$cat_id = $_GET['cat_id'];
	$subcat_id = $_GET['subcat_id'];
	$subsubcat_id = $_GET['subsubcat_id'];
	isset($_GET['userid']) ?
	$userid = $_GET['userid'] : "";
	if(!empty($_GET['cat_id'])){
		
		$sqlWhere = "WHERE wp.cat_id=".$cat_id;
	}
	if(!empty($_GET['subcat_id']) && !empty($_GET['cat_id'])){
		
		$sqlWhere = $sqlWhere." and wp.subcat_id=".$subcat_id;
	}
	if(!empty($_GET['subcat_id']) && !empty($_GET['cat_id']) && !empty($_GET['subsubcat_id'])){
		$sqlWhere = $sqlWhere." and wp.subsubcat_id=".$subsubcat_id;
	}

	
	if(!empty($_GET['pageno'])){
		$pageno = $_GET['pageno'];
	}

	$offset = ($pageno-1) * $no_of_records_per_page;


	isset($_GET['sortID']) ?
	$sortID = $_GET['sortID'] : "";
	$str="";
	if($sortID==1)
	{
		$str="order by rating DESC";
	}
	else if($sortID==2)
	{
		$str="ORDER BY if(wp.discountcodes='0.00',wp.costprice,wp.discountcodes) ASC";
	}
	else if($sortID==3)
	{
		$str="ORDER BY if(wp.discountcodes='0.00',wp.costprice,wp.discountcodes) DESC";
	}
	else if($sortID==4)
	{
		$str="ORDER BY wp.id DESC";
	}
	else
	{
		$str="ORDER BY wp.id DESC";
	}
	

///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/thumb/';


/*
echo $sql="select *,concat('".$baseUrl."',wip.productimage) as product_img from whole_product as wp JOIN whole_imageupload as wip ON wp.id=wip.pid where wp.cat_id='$cat_id' AND wp.subcat_id='$subcat_id' ORDER BY wp.id DESC";
*/

$sql12 = "SELECT COUNT(id) as totalproductcount FROM whole_product as wp $sqlWhere ORDER BY wp.id DESC";
$result12 = $conn->query($sql12);
$row12 = $result12->fetch_object();


$TotalProduct = 0;
if(!empty($row12->totalproductcount)){
	$TotalProduct = $row12->totalproductcount;
}

$sql="SELECT wp.id,wp.costprice,wp.discountcodes,wp.qty,wp.productname,(SELECT avg(`rating`) FROM `whole_rating` WHERE
`product_id`=wp.id group by  product_id) as rating,
(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by `product_id`) as ratingcount,
if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
(select concat('$baseUrl',productimage) from whole_imageupload where pid=wp.id AND mainimage='1'  limit 1 ) as product_img,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid') IS NULL,0,1) as FavStatus,
if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1)) as wishid from whole_product as wp $sqlWhere  $str  LIMIT $offset,$no_of_records_per_page";

$result=$conn->query($sql);
$records=[];
while($row=$result->fetch_object())
{
$records[]=$row;
}
		
if(!empty($records) && is_array($records)){
		$message = "product listing";
		$result = $records;

		$data = array("message"=>$message,"result"=>$result,"totalproduct"=>$TotalProduct);
		responseSuccess($data);
}else{

	$sql1=$conn->query("SELECT `cat_id`,`parent`,`cat_type` FROM `whole_category` where `cat_id`='$cat_id' AND `parent`='$subcat_id'");
	if($sql1->num_rows>0)
	{
		$sqlWhere1="";
		$row2=$sql1->fetch_assoc();
		if($row2['cat_type']=='category')
		{
			$sqlWhere1 = "WHERE wp.cat_id=".$row2['cat_id'];
		}
		else if($row2['cat_type']=='subcategory')
		{
			$sqlWhere1 = "WHERE wp.cat_id=".$row2['parent']."  and wp.subcat_id=".$row2['cat_id'];
		}
		else if($row2['cat_type']=='sub-subcategory')
		{
			$sqlWhere1 = "WHERE  wp.subcat_id=".$row2['parent']." and wp.subsubcat_id=".$row2['cat_id'];
		}
		 $sql="SELECT wp.id, wp.costprice,wp.discountcodes,wp.qty,wp.productname,(SELECT avg(`rating`) FROM `whole_rating` WHERE
			`product_id`=wp.id group by  product_id) as rating,
			(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by `product_id`) as ratingcount,
			if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,
			(select concat('$baseUrl',productimage) from whole_imageupload where pid=wp.id AND mainimage='1'   limit 1 ) as product_img,if((SELECT `wid` FROM `whole_whishlist` where `productid`='$pid' AND `userid`='$userid') IS NULL,0,1) as FavStatus,if((SELECT `wid` FROM `whole_whishlist` where `productid`='$pid' AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`='$pid' AND `userid`='$userid' limit 1)) as wishid from whole_product as wp $sqlWhere1  order by id desc LIMIT $offset,$no_of_records_per_page";

			$result=$conn->query($sql);
			$records=[];
			while($row=$result->fetch_object())
			{
			$records[]=$row;
			}
					
			if(!empty($records) && is_array($records)){
					$message = "product listing";
					$result = $records;

					$data = array("message"=>$message,"result"=>$result,"totalproduct"=>$TotalProduct);
					responseSuccess($data);
			}else
			{
				$message = "There are no product";
				$result = "";
				$data = array("message"=>$message,"result"=>$result,"totalproduct"=>$TotalProduct);
				responseError($data);
			}

	}
	else
	{
		$message = "There are no product";
		$result = "";
		$data = array("message"=>$message,"result"=>$result,"totalproduct"=>$TotalProduct);
		responseError($data);
	}

	// 
}
		


/////gkssoftware.com/grvapi/getProducts.php?cat_id=00193&subcat_id=00103
 ?>

