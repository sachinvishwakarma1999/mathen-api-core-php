<?php
include('config.php');
include('api.php');
$curl = curl_init();

$waybill=$_GET['waybill'];
curl_setopt_array($curl, array(
CURLOPT_URL => "https://track.delhivery.com/api/packages/json/?token=b06e6f9144e35065f5a8b9c03857218d1a9c1173&waybill=".$waybill."&verbose=2",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER =>array(
"cache-control: no-cache",
"postman-token: 34baa12e-7513-4917-4d3d-2bf931be1016"
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
 	$message = "Your Order Tracking Detail";
	$result = $response;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
?>