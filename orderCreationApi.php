<?php
include('config.php');
include('api.php');
$oid=$_POST['oid'];
$url="https://track.delhivery.com/waybill/api/bulk/json/?cl=MANTHANONLINE EXPRESS&token=b06e6f9144e35065f5a8b9c03857218d1a9c1173&count=1";
$waybill=file_get_contents($url);
$data['shipments'][0]['waybill']=file_get_contents($url);
$data['shipments'][0]['add']=$_POST['address'];
$data['shipments'][0]['phone']=$_POST['mobile'];
$data['shipments'][0]['payment_mode']=$_POST['paymode'];//Prepaid/COD/Pickup/REPL
$data['shipments'][0]['name']=$_POST['username'];
$data['shipments'][0]['pin']=$_POST['userpin'];
$data['shipments'][0]['order']=$_POST['oid'];
$data['shipments'][0]['cod_amount']=$_POST['cod_amount'];
$data['shipments'][0]['seller_gst_tin']=$_POST['sellerGST'];
$data['shipments'][0]['client_gst_tin']="";
$data['shipments'][0]['hsn_code']="fgf";
$data['shipments'][0]['gst_cess_amount']="";

$data['shipments'][0]['return_state']="UTTAR PRADESH";
$data['shipments'][0]['return_city']="Kanpur";
$data['shipments'][0]['return_country']="India";
$data['shipments'][0]['return_add']="24 NEW AZAD NAGAR BY PAAS ROAD NEAR MAHESH AND HONS";
$data['shipments'][0]['return_pin']="208011";

$data['pickup_location']['name']="MANTHANONLINE EXPRESS";
$data['pickup_location']['city']="Kanpur";
$data['pickup_location']['pin']="208011";
$data['pickup_location']['country']="India";
$data['pickup_location']['phone']="9511400991";
$data['pickup_location']['add']="24 NEW AZAD NAGAR BY PAAS ROAD NEAR MAHESH AND HONS";

$resultData=json_encode($data);
// print($resultData);
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://track.delhivery.com/api/cmu/create.json",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => "format=json&data=".$resultData."",
CURLOPT_HTTPHEADER =>array(
"authorization: Token b06e6f9144e35065f5a8b9c03857218d1a9c1173",
"cache-control: no-cache",
"content-type: application/json",
"postman-token: d7971ac5-2ef9-8eb3-1a2e-5eb7e9ca50d9"
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
	// print_r($response);
	$conn->query("UPDATE `whole_order`='$waybill' SET `waybill_no` where `oid`='$oid'");
	$message = "Your waybill generated";
	$result = $response;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
}
?>