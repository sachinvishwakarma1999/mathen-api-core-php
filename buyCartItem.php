<?php include('config.php'); 
	include('api.php');
	 $conn->set_charset('utf8');  
	isset($_POST['basketId']) ?
	$basketId = $_POST['basketId'] : "";

	isset($_POST['aid']) ?
	$aid = $_POST['aid'] : "";


	isset($_POST['payType']) ?
	$payType = $_POST['payType'] : "";

	// isset($_POST['DeviceID']) ?
	// $DeviceID = $_POST['DeviceID'] : "";
	if($payType==1)
	{
		$payTypeName="COD";
		$orderStatus="Order Placed";
		$approveStatus="Order Placed";
	}
	else if($payType==2)
	{
		$payTypeName="Online Payment";
		$orderStatus="Order Pending";
		$approveStatus="Order Placed";
	}
	// else if($payType==3)
	// {
	// 	$payTypeName="Online Payment";
	// 	$orderStatus="Order Pending";
	// 	$approveStatus="Order Placed";
	// }
	$DeviceID="";
	$newBasketId=explode(',',$basketId);
	if(count($newBasketId)>0)
	{
		$seladd=$conn->query("SELECT `id`,`address`,`landmark`,`city`,`state`,`country`,`zipcode`,`delivery_time` ,`address_type`,`name`,`mobile` FROM `whole_user_address` where `aid`='$aid'");
		$row=$seladd->fetch_assoc();
		$id=$row['id'];
		$address=$row['address'];
		$landmark=$row['landmark'];
		$city=$row['city'];
		$state=$row['state'];
		$country=$row['country'];
		$zipcode=$row['zipcode'];
		$name=$row['name'];
		$mobile=$row['mobile'];


		$total=0;
		for($i=0;$i<count($newBasketId);$i++)
		{
			$chkExist=$conn->query("SELECT * FROM `whole_order` where `bid`='".$newBasketId[$i]."'");
			if($chkExist->num_rows==0)
			{
				$chkBasketDetial=$conn->query("SELECT wb.`productid`,wb.`quantity`,wp.discountcodes,wp.costprice,wp.sellingprice,((if( wp.discountcodes='0.00',wp.costprice,wp.discountcodes))*wb.`quantity`)  as subtotal FROM `whole_basket` as wb join whole_product as wp on wp.id=wb.`productid` where wb.`bid`='".$newBasketId[$i]."'");
				$basDet=$chkBasketDetial->fetch_assoc();
				$quantity=$basDet['quantity'];
				$discountcodes=$basDet['discountcodes'];
				$costprice=$basDet['costprice'];
				$sellingprice=$basDet['sellingprice'];
				$subtotal=$basDet['subtotal'];
				$conn->query("INSERT INTO `whole_order`(`bid`, `totalcost`, `shipcharge`, `discountcode`, `quantity2`, `userid`, `orderdate`,`ordertime`, `emailid`, `deliver_fname`,  `deliver_address`,
	              `deliver_housenumber`, `deliver_city`, `deliver_state`, 
	              `deliver_country`, `deliver_zip`, 
	              `deliver_phone`,`cancelstatus`,  `displayflag`, 
	              `deliver_status`, `confirm_status`, `paytype`, 
	              `ipaddress`, `orderinistatus`, `ordermode`,`approve_status`) 
				
				select wb.bid,sum(subtotal),wb.`shipprice`,sum(if(wp.discountcodes='0.00',wp.costprice,wp.discountcodes)),sum(wb.quantity),
				wb.userid,DATE(now()),TIME(now()),wb.emailid,'$name','$address', '$landmark','$city','$state','$country','$zipcode','$mobile','0','1','0','0','$payTypeName','$DeviceID','$orderStatus', '$payTypeName','$approveStatus' from whole_basket as wb join whole_product as wp on wp.id=wb.productid join whole_user_registration as wur on wur.id=wb.userid where wb.bid='".$newBasketId[$i]."' AND wur.id='$id'");
				
				$conn->query("UPDATE `whole_basket` SET  `sellingprice`='$sellingprice',`costprice`='$costprice',`subtotal`='$subtotal',`orderstatus`='1',`disccode`='$discountcodes' where `bid`='".$newBasketId[$i]."' AND userid='$id'");

				$conn->query("UPDATE `whole_user_registration` SET `dfname`='$name',`deliver_address`='$address',`deliver_housenumber`='$landmark',`deliver_city`='$city',`deliver_state`='$state',`deliver_country`='$country',`deliver_zip`='$zipcode',`deliver_phone`='$mobile' where `id`='$id'");
			}
		}

	}
	else
	{
		$errMsg="Please select product.";

	}
	if($errMsg=="")
	{
		$message = "Order Placed";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
	}
	else
	{
		$message = "something went wrong.please try again";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
	}

?>