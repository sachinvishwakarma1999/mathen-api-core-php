<?php include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
isset($_POST['email']) ?
$email = $_POST['email'] : "";
$pageno = 1;
$offset = 0;
isset($_POST['page_no']) ?
$pageno = $_POST['page_no'] : "";
$no_of_records_per_page = 10;
$offset = ($pageno-1) * $no_of_records_per_page;
$records=[];
$errMsg="";

$sql=$conn->query("select wo.oid,wo.waybill_no, wb.bid,wo.orderinistatus,wo.approve_status,wo.paytype,wo.deliverdate,wb.quantity,wo.emailid,wo.shipping,sum(wb.subtotal) as subtotal,count(wb.id) as countid from whole_order as wo JOIN whole_basket as wb ON wo.bid=wb.bid  where wo.userid='$email' GROUP BY wb.bid order by wo.oid LIMIT $offset,$no_of_records_per_page");
if($sql->num_rows>0)
{
	$i=0;
	while($row=$sql->fetch_assoc())
	{
		$records[$i]['totalOrder']=$row;
		$sqlsel=$conn->query("SELECT `productid`,wo.waybill_no,wo.oid,wb.`productname`,wb.`quantity`,wb.`subtotal`,wb.`costprice`,wb.`disccode`,if(wb.disccode=' ',0,ceil(((wb.costprice-wb.disccode)/wb.costprice)*100))as disPercent,(select concat('https://www.manthanonline.in/productimage/thumb/',productimage) from whole_imageupload where pid=wb.productid AND mainimage='1' order by id DESC limit 1 ) as product_img FROM `whole_basket` as wb join whole_order as wo on wo.bid=wb.`bid` where wo.oid=".$row['oid']."  ");
		while($row1=$sqlsel->fetch_assoc())
		{
			$records[$i]['basketDetail'][]=$row1;
		}
		$i+=1;
	}
}
else
{
	$errMsg="Nothing to Show";
}
if($errMsg=="")
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
