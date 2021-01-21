<?php include('config.php'); 
	include('api.php');
	$conn->set_charset('utf8');
	isset($_POST['userid']) ?
	$userid = $_POST['userid'] : "";
 $sqltotal=$conn->query("SELECT sum(wb.`costprice`) as costTotal,sum(`quantity`*if(wp.discountcodes='0.00',wb.`costprice`,wp.discountcodes)) as Total
    FROM `whole_basket` as wb
    join whole_product as wp on wp.id=wb.`productid`
    join whole_user_registration as wur on wur.id=wb.userid  
where  `orderstatus`='0' AND `deliverstatus`='0' AND wb.`userid`='$userid'");
$row1 = $sqltotal->fetch_assoc();
$total= $row1['Total'];
$costTotal= $row1['costTotal'];

 $sql="SELECT wb.`id` as basketid,`productid`,wb.`productname`,`productimage`,
    `subtotal`,`quantity`,`productstatus`,wb.`costprice` AS costprice,(quantity*wb.`costprice`) as subCosttotal,
    wp.discountcodes,(`quantity`*if(wp.discountcodes='0.00',wb.`costprice`,wp.discountcodes)) as disccode,if(wp.discountcodes='0.00',0,
    ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,wp.`barcode`,
    wp.`pweight`,`shipprice`,wp.`suppliername`,variantname,variantvalue,Concat(`billing_housenumber`,`billing_address`,`billing_city`,`billing_state`,`billing_zip`,`billing_country`) as billing_address 
    FROM `whole_basket` as wb
    join whole_product as wp on wp.id=wb.`productid`
    join whole_user_registration as wur on wur.id=wb.userid  
where  `orderstatus`='0' AND `deliverstatus`='0' AND wb.`userid`='$userid'";

	$result=$conn->query($sql);
	$result1=[];
	while($row = $result->fetch_assoc()){
		$result1[]=$row;
	}
	if(count($result1)>0)
	{
		$message = "Your Cart";
		$result = $result1;
		$result['total']=$total;
		$result['costTotal']=$costTotal;
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