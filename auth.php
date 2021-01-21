<?php
include('config.php');
include('api.php');

function verfyToken($headers){
    echo 'aa'; die;
    $token = $headers['token'];

 $sqlQ = "SELECT * FROM tokens WHERE token='$token'";
   $rslt = $conn->query($sqlQ);
   $rowcount= $rslt->num_rows;
  if($rowcount === 0){
      	$data = array("message"=>'Authorization failed',"result"=>[]);
		responseError($data);
  }
  else{
      return 'sdfas';
  }
}
?>