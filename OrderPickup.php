<?php
include('config.php');
include('api.php');

$data['pickup_location']="MANTHANONLINE EXPRESS";
$data['pickup_time']=$_POST['pickup_time'];
$data['pickup_date']=$_POST['pickup_date'];
$data['expected_package_count']=$_POST['pack_count'];
$result=json_encode($data);

$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://track.delhivery.com/fm/request/new/",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => $result,
CURLOPT_HTTPHEADER =>array(
"authorization: Token b06e6f9144e35065f5a8b9c03857218d1a9c1173",
"cache-control: no-cache",
"content-type: application/json",
"postman-token: ace0f11c-c8e3-b7fc-51b3-50699b836a7b"
),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
	$message = $err;
	$result = "";
	$data = array("message"=>$message,"result"=>$result);
	responseError($data);
} else {
 	$message = "Your Order Pickup Detail";
	$result = $response;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
?>
