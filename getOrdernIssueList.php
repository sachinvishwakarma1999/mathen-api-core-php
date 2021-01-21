<?php include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
isset($_POST['email']) ?
$email = $_POST['email'] : "";
$newemail=trim($email);
$sql=$conn->query("SELECT `Iid`,`issue_name` FROM `whole_orders_issues` where `display_flag`='1'");
$records=[];
while($row=$sql->fetch_object())
{
	$records['issues'][]=$row;
}
$sql1=$conn->query("SELECT `oid`,wb.bid,wb.productname,wb.productid FROM `whole_order` as  wo join whole_basket as wb on wb.`bid`=wo.`bid`
join whole_product as wp on wp.`id`=wb.`productid` where wo.emailid ='$newemail'");
while($row1=$sql1->fetch_object())
{
	$records['orderList'][]=$row1;
}


	$message = "Issue list";
	$result = $records;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
?>