<?php include('config.php'); 
include('api.php');
	
	$product_id = 0;
	if(!empty($_GET['id'])){
		$product_id = $_GET['id'];
	}
	


	//02638
//https://www.manthanonline.in/productimage/ikall-k3310-basic-feature-phone-red-64mb-and-solar-powered-rechargeable-led-lantern-combo-afryt.jpg
///header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/';

/*$sql="SELECT *, concat('".$baseUrl."',wip.productimage) as product_img FROM whole_product as wp JOIN whole_imageupload as wip ON wp.id=wip.pid WHERE wp.id='".$product_id."' ";*/


//SELECT * FROM `whole_product_combination` 
//SELECT * FROM `whole_colorprice` WHERE `pid` = 3410 ORDER BY `pid` DESC

//SELECT * FROM `whole_product_combo` - Nothing

//SELECT * FROM `whole_product_strip` WHERE `productid` = 3410 

//SELECT * FROM `whole_variant` - Color and Size in all variant

//SELECT * FROM `whole_sizeprice`






$sql="SELECT `WP`.`id`,
			`WP`.`productname`, 
			`WP`.`slug`, 
			`WP`.`cat_id`,
			`WP`.`subcat_id`,
			`WP`.`subsubcat_id`,
			`WP`.`shortdescription`, 
			`WP`.`stockavailability`, 
			`WP`.`discountcodes`, 
			`WP`.`variantcode`, 
		    `WP`.`sizename`, 
		    `WP`.`sellpricevat`, 
		    `WP`.`mrp`, 
		    `WP`.`regularprice`, 
		  	`WP`.`costprice`, 
		  	`WP`.`sku`, 
		  	`WP`.`qty`, 
		  	`WP`.`barcode`, 
			`WP`.`bid`, 
			`WP`.`brandname`, 
			`WP`.`relatedproducts`, 
			`WP`.`featuredproduct`, 
			`WP`.`product_pagename`, 
			`WP`.`product_spec`, 
			`WP`.`itemstrips`, 
			`WP`.`delivertime`, 
			`WP`.`combo`, 
			`WP`.`monthly`, 
			`WP`.`pweight`, 
			`WP`.`suppliername`, 
			`WP`.`saddress`,
		    `WP`.`producttype`, 
		    `WP`.`isbnnumber`, 
		    `WP`.`publisher`, 
		    `WP`.`author`,
		    `WP`.`editor`,
		    `WP`.`binding`,
		    `WP`.`language`,
		    `WP`.`pdimensions`,
		    `WP`.`bestselling`,
		    `WP`.`noofpack`,
		    `WP`.`traderprice`,
		    `WP`.`dealoffer`,
		    `WP`.`variant_category`,
		    `WP`.`variant`,
		    `WP`.`approval`,
		    `WPC`.`size_id`,
		    `WPC`.`color_id`,
		    `WPC`.`price`,
		    `WPC`.`qty`,
		     CONCAT('$baseUrl',`WIP`.`productimage`) as ImgUrl

 FROM whole_product as `WP` 
 LEFT JOIN `whole_product_combination` as `WPC` ON `WP`.`id`=`WPC`.`product_id` 
 LEFT JOIN  `whole_imageupload` as `WIP` ON `WP`.`id`=`WIP`.`pid`
 WHERE `WP`.`id`='".$product_id."' ";



//SELECT * FROM `whole_product_combination` 
//SELECT * FROM `whole_colorprice` WHERE `pid` = 3410 ORDER BY `pid` DESC

//SELECT * FROM `whole_product_combo` - Nothing

//SELECT * FROM `whole_product_strip` WHERE `productid` = 3410 

//SELECT * FROM `whole_variant` - Color and Size in all variant

//SELECT * FROM `whole_sizeprice`


$result = $conn->query($sql);
$row = $result->fetch_object();
$records = [];
$data = array();
$records["product"] = $row;

$cat_id = $row->cat_id;
$variant_category = explode(',', $row->variant_category);



$sql_product_combination = "SELECT * FROM `whole_product_combination` WHERE product_id='".$product_id."'";
$result_product_combination = $conn->query($sql_product_combination);
$row_product_combination = $result_product_combination->fetch_object();



$sql_sizeprice = "SELECT * FROM `whole_sizeprice` WHERE pid='".$product_id."'";
$result_sizeprice = $conn->query($sql_sizeprice);
//$row_sizeprice = $result_sizeprice->fetch_object();
$sizeprice = [];
	while($row_sizeprice = $result_sizeprice->fetch_object()){
		$sizeprice[] = $row_sizeprice; 
	}

$records["sizeprice"] = $sizeprice;

$variant_catgory_data = [];
$variant_data = [];
foreach ($variant_category as $variant_id) {
	$sql_variant_catgory = "SELECT * FROM `whole_variant_category` WHERE id='".$variant_id."'";
	$result_variant_catgory = $conn->query($sql_variant_catgory);
	while($row_variant_catgory = $result_variant_catgory->fetch_object()){
		$sql_variant="SELECT * FROM `whole_variant` WHERE variant_category = '".$variant_id."'";
		//$sql_variant="SELECT * FROM `whole_variant` WHERE variant_category = '".$variant_id."' AND product_category='".$cat_id."'";
		$result_variant = $conn->query($sql_variant);
		while($row_variant = $result_variant->fetch_object()){

			$variant_data[] =$row_variant; 
		}
	}
}
print_r($variant_data);

// $sql_color_price = "SELECT * FROM `whole_colorprice` WHERE pid = '".$product_id."'";
// $result_color_price = $conn->query($sql_color_price);
// $row_color_price = $result_color_price->fetch_object();





// /*	$records["variant_data"] = $variant_data;
// 	echo '<br>';
// 	echo '<pre>';
// 	print_r($records);
// 	exit();
// */








// 	if(!empty($records) && is_array($records)){
// 			$data["message"] = "product details";
// 			$data["result"] = $records;
// 			$data['statusCode'] = 200;
// 				$data['status'] = 1;
// 		echo json_encode($data);
// 			echo json_encode($data);
// 			exit();
			
// 	}else{
// 		$data["message"] = "There are no product";
// 		$data["result"] = $records;
// 		$data['statusCode'] = 400;
// 		$data['status'] = 0;
// 		echo json_encode($data);
// 		exit();
// 	}

 ?>

