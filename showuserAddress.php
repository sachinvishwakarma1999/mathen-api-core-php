<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$conn->set_charset('utf8');
isset($_POST['userid']) ?
$userid = $_POST['userid'] : "";

$sql=$conn->query("SELECT * FROM `whole_user_address` WHERE `id`='$userid'");

if($sql->num_rows>0)
{
	while($row=$sql->fetch_assoc())
	{
		$data1[$row['address_type']][]=$row;
	}

	$message = "address updated successfully.";
	$result = $data1;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
else
{
	$message = "Nothing to show.";
	$result = [];
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
}
?>