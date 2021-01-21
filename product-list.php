<?php
include('config.php');
include('api.php');
$headers = apache_request_headers();
$token = $headers['token'];

 $sqlQ = "SELECT * FROM tokens WHERE token='$token'";
   $rslt = $conn->query($sqlQ);
   $rowcount= $rslt->num_rows;
  if($rowcount === 0){
      	$data = array("message"=>'Authorization failed',"result"=>[]);
		responseError($data);
  }
  else{
      $data = array("message"=>'Product listing',"result"=>[]);
		responseSuccess($data);
  }

?>