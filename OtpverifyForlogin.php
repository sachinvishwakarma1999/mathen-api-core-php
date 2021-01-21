<?php include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
///header("Access-Control-Allow-Origin");
	isset($_POST['phone']) ?
	$phone = $_POST['phone'] : "";

    isset($_POST['otp']) ?
    $otp = $_POST['otp'] : ""; 
    isset($_POST['token']) ?
    $neToken = $_POST['token'] : "";
    $newMob=trim($phone);
    if($phone!='')
    {
        
         $sqlOtp="SELECT id,concat('https://www.manthanonline.in/',`user_image`) as user_image,gender,Dob,emailid,billing_mobile,concat_ws(' ',`fname`,`mname`,`lname`) as name,(SELECT sum(`amount`) FROM `whole_wallet_transactions`where `transaction_type`='Cashback' AND  `user_email`=emailid) as wallet,`deliver_address`,`deliver_housenumber`,`deliver_city`,`deliver_state`,`deliver_country`,`deliver_zip`,`deliver_phone`,varificationcode FROM `whole_user_registration` WHERE (`billing_mobile`='$phone' OR   emailid='$phone') AND varificationcode='$otp'";
             $resultotp=$conn->query($sqlOtp);
             $rowcount= $resultotp->num_rows;
             if ($rowcount>0) 
             {
                $conn->query("UPDATE `whole_user_registration` SET  `token`='$neToken',`login_type`='OTP Login' WHERE (`billing_mobile`='$phone' OR   emailid='$phone') AND varificationcode='$otp'");
                $Errmessage='';
                $row = $resultotp->fetch_assoc();
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
                $arr['token']=base64_encode($arr['uid']);
             }
             else
             {
                $Errmessage="OTP does not match.";
             }
    }
    else
    {
        $Errmessage = "Please enter mobile number.";
    }
	
    if ($Errmessage=='') {
        $token = md5($token);
        $conn->query('insert into tokens (token) VALUES ("'.$token.'")');
        $message = 'login successfully';
        $result = $arr;
        $token=$arr['token'];
        $data = array("message"=>$message,"token"=>$token,"result"=>$result);
        responseSuccess($data);
    }
    else
    {
        $message=$Errmessage;
    	$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
    }

/////http://gkssoftware.com/grvapi/ChangePassword.php?userid=67&old_password=1122&new_password=1124
 ?>

