<?php
include('config.php');
include('api.php');

	$conn->set_charset('utf8');
	
		isset($_POST['email']) ?
	 $email = $_POST['email'] : "";
	
		isset($_POST['password']) ?
	$password = MD5($_POST['password']): "";
	
	isset($_POST['token']) ?
	$neToken = $_POST['token'] : "";
	$Errmessage="";
	
    $sqlQ="SELECT *,id,concat('https://www.manthanonline.in/',`user_image`) as user_image,gender,Dob,emailid,billing_mobile,concat_ws(' ',`fname`,`mname`,`lname`) as name,(SELECT sum(`amount`) FROM `whole_wallet_transactions`where `transaction_type`='Cashback' AND  `user_email`=emailid) as wallet,`deliver_address`,`deliver_housenumber`,`deliver_city`,`deliver_state`,`deliver_country`,`deliver_zip`,`deliver_phone` from whole_user_registration WHERE (emailid='$email' OR billing_mobile='$email' ) AND password='$password'";
   $rslt = $conn->query($sqlQ);
   $rowcount= $rslt->num_rows;
   

   if ($rowcount == 1) {
   	$conn->query("UPDATE `whole_user_registration` SET  `token`='$neToken',`login_type`='Normal Login' WHERE (emailid='$email' OR billing_mobile='$email' ) AND password='$password' ");
   	$row = $rslt->fetch_assoc();
   	$arr['uid']=$row['id'];
   	$arr['email']=$row['emailid'];
   	$arr['mobile']=$row['billing_mobile'];
   	$arr['name']=$row['name'];
   	$arr['walletBalance']=$row['wallet'];
   	$arr['deliver_address']=$row['deliver_address'];
   	$arr['deliver_housenumber']=$row['deliver_housenumber'];
   	$arr['deliver_city']=$row['deliver_city'];
   	$arr['deliver_state']=$row['deliver_state'];
   	$arr['deliver_country']=$row['deliver_country'];
   	$arr['deliver_zip']=$row['deliver_zip'];
   	$arr['deliver_phone']=$row['deliver_phone'];
   	$arr['token']=$neToken;
   } else
   {
   	$Errmessage = "Invalid emailid/password.";
   }


	if ($Errmessage=='') {
		$message=$arr['uid'];
		$result=1;
   	} else
   	{
   		$result=0;
   	}

   


	if($result==1){
	    $token = md5(rand(10,10));
	    $conn->query('insert into tokens (token) VALUES ("'.$token.'")');
		$message = 'login successfully';
		$result = $arr;
		$token=$arr['token'];
		$data = array("message"=>$message,"token"=>$token,"result"=>$result);
		responseSuccess($data);
		
	}else{

       if ($Errmessage=='') {
		$message = "Something went wrong, Please contact to admin.";
       } else
       {
       	$message =$Errmessage;
       }


		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
	}
	

	// http://api.manthanonline.in/login.php?email=g11@gmail.com&password=123456
?>
