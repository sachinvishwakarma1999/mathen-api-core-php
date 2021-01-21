<?php include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
///header("Access-Control-Allow-Origin");
	isset($_POST['mobile']) ?
	$mobile = $_POST['mobile'] : "";

    isset($_POST['otp']) ?
    $otp = $_POST['otp'] : ""; 
    $newMob=trim($mobile);
    
    if($mobile!='')
    {
        $sqlOtp="SELECT passwordverifycode FROM `whole_user_registration` WHERE `billing_mobile`='$mobile' OR emailid='$mobile'";
             $resultotp=$conn->query($sqlOtp);
             $rowcount= $resultotp->num_rows;
             $row =$resultotp->fetch_assoc();
             if ($row["passwordverifycode"]==$otp) 
             {
                $Errmessage='';
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
        $message = "OTP match.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
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

