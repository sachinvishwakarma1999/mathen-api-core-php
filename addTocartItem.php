<?php include('config.php'); 
	include('api.php');
	isset($_POST['userid']) ?
	$userid = $_POST['userid'] : "";

	isset($_POST['pid']) ?
	$pid = $_POST['pid'] : "";

	isset($_POST['quantity']) ?
	$quantity = $_POST['quantity'] : "";

	isset($_POST['email']) ?
	$email = $_POST['email'] : "";

	isset($_POST['color']) ?
	$color = $_POST['color'] : "";

	isset($_POST['size']) ?
	$size = $_POST['size'] : "";
	

	$VarientName="";
	$colorSize="";
	if($color!='')
	{
		$VarientName.=ucfirst("color")."|";
		$colorSize.=ucfirst($color).'|';
	}
	if($size!='')
	{
		$VarientName.=ucfirst("size")."|";
		$colorSize.=ucfirst($size).'|';
	}
	$newvarientName=trim($VarientName,'|');
	$newColorSizeName=trim($colorSize,'|');
	$sqlselect="SELECT * FROM `whole_basket` WHERE `productid` AND `deliverstatus`='0' AND orderstatus='0' AND `userid`='$userid' AND productid='$pid' AND variantname='$newvarientName' AND variantvalue='$newColorSizeName'";
	$result=$conn->query($sqlselect);
	$rowcount= $result->num_rows;
	if($rowcount!=0)
	{
		$basket=$result->fetch_assoc();
		$oldQuan=$basket['quantity'];
		$newQuan=$oldQuan+$quantity;

		$sqlChk=$conn->query("SELECT `sellingprice`, `costprice`, $newQuan,($newQuan*(if(`discountcodes`='0.00',costprice,discountcodes))) as subtotal,`discountcodes`,`pweight` FROM `whole_product` WHERE `id`='$pid'");
		if($sqlChk->num_rows>0)
		{
			$row=$sqlChk->fetch_assoc();
			$sellPrice=$row['sellingprice'];
			$costprice=$row['costprice'];
			$subtotal=$row['subtotal'];
			$discountcodes=$row['discountcodes'];
			$pweight=$row['pweight']*$newQuan;
			$sql="UPDATE `whole_basket` SET  sellingprice='$sellPrice',`subtotal`='$subtotal',`quantity` ='$newQuan',disccode='$discountcodes',costprice='$costprice',pweight=$pweight where `id`='".$basket['id']."'";
			$result=$conn->query($sql);
		}
		
	}
	else
	{
		$sql1="INSERT INTO `whole_basketid`(`bid`, `adddate`) select (max(`bid`)+1),now() from whole_basketid";
		$result=$conn->query($sql1);
		$last_id = $conn->insert_id;
		 $sql= "INSERT INTO `whole_basket`(`bid`, `productid`, `cat_id`, `subcat_id`, `subsubcat_id`, `productname`, `slug`, `description`, `productimage`, `sellingprice`, `sellpricevat`, `costprice`, `brand`, `variantname`, `variantvalue`,`quantity`, `subtotal`, `userid`, `emailid`, `offername`, `displayflag`, `adddate`, `editdate`, `productstatus`, `price`,`disccode`, `orderstatus`, `deliverstatus`, `basket_status`, `barcode`, `pweight`,`comboid`,`sku`,   `vatvalue`, `vat`, `suppliername`)  SELECT '$last_id',`id`, `cat_id`, `subcat_id`, `subsubcat_id`, `productname`, `slug`,  `longdescription`,(SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) FROM `whole_imageupload`  where `pid` AND `mainimage`='1' AND pid='$pid' limit 1 ),`sellingprice`, `sellpricevat`,`costprice`,`brandname`, '$newvarientName','$newColorSizeName',$quantity,($quantity*`discountcodes`),'$userid','$email', `offername`, `displayflag`,`adddate`, `editdate`,`stockavailability`,`discountcodes`,`discountcodes`,'0','0','New Order',`barcode`,`pweight`,`combo`,`sku`,`vatvalue`, `vat`, `seller_id` FROM `whole_product` WHERE `id`='$pid'";
		$result=$conn->query($sql);
	}
	if($result==1)
	{
		$message="Item added to cart.";
		$result =[];
	    $data = array("message"=>$message,"result"=>$result);
	    responseSuccess($data);
	}
	else
	{
		$message="something went wrong.";
		$result =[];
	    $data = array("message"=>$message,"result"=>$result);
	    responseError($data);
	}
?>

