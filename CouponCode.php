<?php include('config.php'); 
	include('api.php');

	 $conn->set_charset('utf8');  
	isset($_POST['catid']) ?
	$catid = $_POST['catid'] : "";

	isset($_POST['subcatid']) ?
	$subcatid = $_POST['subcatid'] : "";

	isset($_POST['subsubcatid']) ?
	$subsubcatid = $_POST['subsubcatid'] : "";
	$responce=[];
	$sql=$conn->query("SELECT dis.`codeid`,dis.`disc_code`,dis.`type`,dis.`validfrom`,dis.`validto`,dis.`discountvalue`,dis.`MinimumOrder`  FROM `whole_discountcodes` as dis join whole_categoriescoupon  as co on co.CouponID=dis.`codeid` where  `validfrom` <= date_format(CURRENT_DATE,'%Y-%m-%d') AND `validto`>= date_format(CURRENT_DATE,'%Y-%m-%d') AND  `displayflag`='1' AND `type`='discount' AND (co.CategoryId='$catid' OR co.CategoryId='$subcatid'  OR co.CategoryId='$subsubcatid') ");
	while($row=$sql->fetch_object())
	{
		$responce[]=$row;
	}
	$sql1=$conn->query("SELECT dis.`codeid`,dis.`disc_code`,dis.`type`,dis.`validfrom`,dis.`validto`,dis.`discountvalue`,dis.`MinimumOrder`  FROM `whole_discountcodes` as dis  where `validfrom` <= date_format(CURRENT_DATE,'%Y-%m-%d') AND `validto`>= date_format(CURRENT_DATE,'%Y-%m-%d') AND `type`='cashback'");
	while($row1=$sql1->fetch_object())
	{
		$responce[]=$row1;
	}

	if(count($responce)>0)
	{
		$message = "Offer list";
		$result = $responce;
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