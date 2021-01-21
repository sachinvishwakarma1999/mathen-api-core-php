<?php
include('config.php');
include('api.php');

	isset($_POST['type']) ?
	$type = $_POST['type'] : "";
	
	isset($_POST['email']) ?
	$email = $_POST['email'] : "";

	isset($_POST['fname']) ?
	$fname = $_POST['fname'] : "";

	isset($_POST['mname']) ?
	$mname = $_POST['mname'] : "";

	isset($_POST['lname']) ?
	$lname = $_POST['lname'] : "";

	isset($_POST['token']) ?
	$neToken = $_POST['token'] : "";
	$sqlSel=$conn->query("SELECT * FROM `whole_user_registration` where `emailid`='$email'");
	if($sqlSel->num_rows==0)
	{

		$insertQ=$conn->query("INSERT INTO `whole_user_registration`(`fb_email`,`emailid`,`token`,`login_type`,`fname`,`mname`,`lname`) Values ('$email','$email','$neToken','$type','$fname','$mname','$lname')");
	}
	else
	{
		$insertQ=$conn->query("UPDATE `whole_user_registration` SET   `fb_email` ='$email',`token`='$neToken',`login_type`='$type' where `emailid`='$email'");
	}
	$sqlQ=$conn->query("SELECT *,id,concat('https://www.manthanonline.in/',`user_image`) as user_image,gender,Dob,emailid,billing_mobile,concat_ws(' ',`fname`,`mname`,`lname`) as name,(SELECT sum(`amount`) FROM `whole_wallet_transactions`where `transaction_type`='Cashback' AND  `user_email`=emailid) as wallet,`deliver_address`,`deliver_housenumber`,`deliver_city`,`deliver_state`,`deliver_country`,`deliver_zip`,`deliver_phone` from whole_user_registration WHERE `emailid`='$email'");
   $rowcount= $sqlQ->num_rows;
   

   if ($rowcount == 1) {
   	$row = $sqlQ->fetch_assoc();
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
   	// $arr['token']=base64_encode($arr['uid']);
   } else
   {
   	$Errmessage = "Invalid Login.";
   }
   if($Errmessage==""){
	    // $token = md5(rand(10,10));
	    // $conn->query('insert into tokens (token) VALUES ("'.$token.'")');
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
?>