<?php include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
isset($_POST['email']) ?
$email = $_POST['email'] : "";
///header("Access-Control-Allow-Origin");
$sql="SELECT SUM(amount) as cashbktotal FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Cashback'";
$result=$conn->query($sql);
 // $rowcount= $resultotp->num_rows;
$row =$result->fetch_assoc();
$totalcashbk[0]['cashbktotal']= $row["cashbktotal"];
$sqlamt="SELECT amount as cashbkAmt FROM `whole_wallet_transactions` WHERE user_email='".$email."' and transaction_type='Cashback'";
$resultAmt=$conn->query($sqlamt);
$records=[];
$i=0;
while($rowAmt=$resultAmt->fetch_assoc())
{
	$records[]=$rowAmt;
}
if(count($records)>0)
{
	$newArr = array();
	$newArr=array_merge($totalcashbk,$records);

	$message = "My Cashback";
	$result = $newArr;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "No Cashback";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}
 ?>

