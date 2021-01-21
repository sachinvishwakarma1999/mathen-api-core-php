<?php
include('config.php'); 
include('api.php');
isset($_GET['pincode']) ?
$pincode = $_GET['pincode'] : "";

$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://track.delhivery.com/​c/api/pin-codes/json/?token=b06e6f9144e35065f5a8b9c03857218d1a9c1173&filter_codes=$pincode",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER =>array(
"cache-control: no-cache",
"postman-token: 44bb5b0f-0be7-434e-3e50-6c61138c2fe2"
),
));
$response= curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
	$message = "cURL Error #:" . $err;
    $result = [];
    $data = array("message"=>$message,"result"=>$result);
    responseError($data);
} else {
	$newarr=json_decode($response);
	$delivery_codes=$newarr->delivery_codes;
	if(count($delivery_codes)>0)
	{
		$message = "Delivery Available.";
	    $result = $delivery_codes;
	    $data = array("message"=>$message,"result"=>$result);
	    responseSuccess($data);
	}
	else
	{
		$message = "Delivery Not Available";
	    $result = [];
	    $data = array("message"=>$message,"result"=>$result);
	    responseError($data);
	}
	
}


