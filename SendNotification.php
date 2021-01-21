<?php
include('api.php');
$server_key="AAAAvBGAAQ4:APA91bHjnB83neW6Mkn5XfUAzEE7pENI_IyTyuXnnFWzzAxFhsZmL7029slQDQE_0pg8AtV_O785qvWtPr1S_VfLYiyu0N6xYD28csneA7K9IgwdY54tTxU71uV3iun2LvzSn1CF8mbz"; // get this from Firebase project settings->Cloud Messaging
$user_token=$_GET['user_tokens'];
// $user_token="dmXc6Zm3BKA:APA91bH7tRPsFjlAWJ1MzO3B1henweekVpnPip8rXoQ048wP3oKuK0FRF2_4SSZgjYRVvT80tjr2Opm-XeySbzc9Je6uZGa2dRL_EOKUIC0VkDnMbkhV23wGo_-m7hU6X0TWofDAr3gw"; // Token generated from Android device after setting up firebase
$title = $_GET['title'];
$body = $_GET['msg'];
$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
$arrayToSend = array('to' => $user_token, 'notification' => $notification,'priority'=>'high');
$fields = json_encode($arrayToSend);

$url = 'https://fcm.googleapis.com/fcm/send';

$headers = array(
    'Content-Type:application/json',
  'Authorization:key='.$server_key
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
$result = curl_exec($ch);
if ($result === FALSE) {
    $message = "Notification Not Send";
    $result = 'FCM Send Error: ' .curl_error($ch);
    $data = array("message"=>$message,"result"=>$result);
    responseError($data);
}
else
{
    $message = "Notification Send";
    $result = $result;
    $data = array("message"=>$message,"result"=>$result);
    responseSuccess($data);
}
curl_close($ch);
?>