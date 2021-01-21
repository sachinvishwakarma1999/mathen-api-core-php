<?php include('config.php'); 
include('api.php');
	$conn->set_charset('utf8');
	isset($_POST['email']) ?
	$email = $_POST['email'] : "";
	$records=[];
	$sql=$conn->query("SELECT `id`,`heading`,`description`,`imageupload`,`metatitle` FROM `whole_static_pages` where `displayflag`='1'");

	while($row=$sql->fetch_assoc())
	{
		$records['menuList'][]=$row['heading'];
		$records['data'][]=$row;
	}
	$sqlcredit=$conn->query("SELECT sum(`amount`) as rewardtotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Reward' AND date_format(`created_at`,'%Y-%m-%d')>DATE_SUB(curdate(), INTERVAL 25 DAY) AND `type`='Credit'");
	 // $rowcount= $resultotp->num_rows;
	$rowcredit =$sqlcredit->fetch_assoc();
	$sqldebit=$conn->query("SELECT sum(`amount`) as rewardtotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Reward' AND date_format(`created_at`,'%Y-%m-%d')>DATE_SUB(curdate(), INTERVAL 25 DAY) AND `type`='Debit'");
	$rowdebit =$sqldebit->fetch_assoc();
	$rewardtotal= $rowcredit["rewardtotal"]-$rowdebit['rewardtotal'];

	$sqlcredit=$conn->query("SELECT sum(`amount`) as cashbktotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Cashback' AND date_format(`created_at`,'%Y-%m-%d')>DATE_SUB(curdate(), INTERVAL 25 DAY) AND `type`='Credit'");
	$rowcredit =$sqlcredit->fetch_assoc();

	$sqldebit=$conn->query("SELECT sum(`amount`) as cashbktotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Cashback' AND date_format(`created_at`,'%Y-%m-%d')>DATE_SUB(curdate(), INTERVAL 25 DAY) AND `type`='Debit'");
	$rowdebit =$sqldebit->fetch_assoc();

	$cashbktotal= $rowcredit["cashbktotal"]-$rowdebit['cashbktotal'];
	$records['mywallet']=$cashbktotal+$rewardtotal;


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