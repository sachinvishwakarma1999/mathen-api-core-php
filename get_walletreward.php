<?php include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
isset($_POST['email']) ?
$email = $_POST['email'] : "";
///header("Access-Control-Allow-Origin");
$sqlcredit=$conn->query("SELECT sum(`amount`) as rewardtotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Reward' AND date_format(`created_at`,'%Y-%m-%d')>DATE_SUB(curdate(), INTERVAL 25 DAY) AND `type`='Credit'");
 // $rowcount= $resultotp->num_rows;
$rowcredit =$sqlcredit->fetch_assoc();
$sqldebit=$conn->query("SELECT sum(`amount`) as rewardtotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Reward' AND date_format(`created_at`,'%Y-%m-%d')>DATE_SUB(curdate(), INTERVAL 25 DAY) AND `type`='Debit'");
 // $rowcount= $resultotp->num_rows;
$rowdebit =$sqldebit->fetch_assoc();
$totalReward['totalreward']= $rowcredit["rewardtotal"]-$rowdebit['rewardtotal'];


 $sqlamt="SELECT transaction_id as id,amount as rewardbonus,transaction_type,date_format(created_at,'%d-%m-%Y') as created_at,details,type,date_format(DATE_ADD(date_format(`created_at`,'%Y-%m-%d'), INTERVAL 25 DAY),'%d-%m-%Y') as expire_date   FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Reward'";
$resultAmt=$conn->query($sqlamt);
$records=[];
$i=0;
while($rowAmt=$resultAmt->fetch_assoc())
{
	$totalReward['rewardbonus'][$i]=$rowAmt;
	$i++;
}

$sqlcredit=$conn->query("SELECT sum(`amount`) as cashbktotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Cashback' AND date_format(`created_at`,'%Y-%m-%d')>DATE_SUB(curdate(), INTERVAL 25 DAY) AND `type`='Credit'");
$rowcredit =$sqlcredit->fetch_assoc();

$sqldebit=$conn->query("SELECT sum(`amount`) as cashbktotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Cashback' AND date_format(`created_at`,'%Y-%m-%d')>DATE_SUB(curdate(), INTERVAL 25 DAY) AND `type`='Debit'");
$rowdebit =$sqldebit->fetch_assoc();

$totalReward['cashbktotal']= $rowcredit["cashbktotal"]-$rowdebit['cashbktotal'];

$sqlamt="SELECT transaction_id as id,amount as cashbkAmt,transaction_type,date_format(created_at,'%d-%m-%Y') as created_at,details,type,date_format(DATE_ADD(date_format(`created_at`,'%Y-%m-%d'), INTERVAL 25 DAY),'%d-%m-%Y') as expire_date FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Cashback'";
$resultAmt=$conn->query($sqlamt);
$records=[];
$i=0;
while($rowAmt=$resultAmt->fetch_assoc())
{
	$totalReward['cashbkAmt'][$i]=$rowAmt;
	$i++;
}
$totalReward['myWalletAmt']=$totalReward['cashbktotal']+$totalReward['totalreward'];
if(count($totalReward)>0)
{
	$message = "My Rewards";
	$result = $totalReward;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "No Rewards";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}
 ?>

