<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$conn->set_charset('utf8');
isset($_POST['email']) ?
	$email = $_POST['email'] : "";
// $records=[];
////header("Access-Control-Allow-Origin");
$baseUrl = 'https://www.manthanonline.in/productimage/thumb/';
$sql="select wo.oid, wb.bid,wo.orderinistatus,wo.waybill_no,wo.paytype,wo.deliverdate,wb.quantity,wo.emailid,wo.shipping,sum(wb.subtotal) as subtotal,count(wb.id) as countid from whole_order as wo JOIN whole_basket as wb ON wo.bid=wb.bid  where wo.userid='$email' GROUP BY wb.bid";
$result=$conn->query($sql);
$i=0;
while($row=$result->fetch_assoc())
{
	$records[$i]['totalOrder']=$row;
	$sqlsel=$conn->query("SELECT `productid`,wo.waybill_no,wo.oid,wb.`productname`,wb.`quantity`,wb.`subtotal`,wb.`costprice`,wb.`disccode`,if(wb.disccode=' ',0,ceil(((wb.costprice-wb.disccode)/wb.costprice)*100))as disPercent,(select concat('$baseUrl',productimage) from whole_imageupload where pid=wb.productid AND mainimage='1' order by id DESC limit 1 ) as product_img FROM `whole_basket` as wb join whole_order as wo on wo.bid=wb.`bid` where wo.oid=".$row['oid']."");
	while($row1=$sqlsel->fetch_object())
	{

		$records[$i]['basketDetail'][]=$row1;
	}
	$i+=1;
}



if(count($records)>0)
{
	$message = "My order listing";
	$result = $records;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "Nothing To show";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}

/////http://api.manthanonline.in/getOrders.php?email=info@manthanonline.in
 ?>

