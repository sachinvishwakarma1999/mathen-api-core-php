<?php
include('config.php');
include('api.php');
	$conn->set_charset('utf8');
	isset($_POST['name']) ?
    $name = $_POST['name'] : "";

    isset($_POST['mname']) ?
    $mname = $_POST['mname'] : "";

    isset($_POST['lname']) ?
    $lname = $_POST['lname'] : "";
    
    isset($_POST['email']) ?
    $email = $_POST['email'] : "";
    
    isset($_POST['phone']) ?
    $phone = $_POST['phone'] : "";
    
    
    isset($_POST['password']) ?
    $password = $_POST['password'] : "";

    isset($_POST['otp']) ?
    $otp = $_POST['otp'] : "";
	
	isset($_POST['token']) ?
    $neToken = $_POST['token'] : "";
	if($otp!='')
	{
		$sqlOtp="SELECT `registerOTP` FROM `whole_temp_registerotp` where `billing_mobile`='$phone'";
             $resultotp=$conn->query($sqlOtp);
             $rowcount= $resultotp->num_rows;
             $row =$resultotp->fetch_assoc();
             if ($row["registerOTP"]==$otp) 
             {
                $upassword=MD5($password);	
				$sql="insert into whole_user_registration (fname,mname,lname,emailid,billing_mobile,password,token)value('$name','$mname','$lname','$email','$phone','$upassword','$neToken')";
			   
				$result = $query=$conn->query($sql);
				$sqlDel="DELETE FROM `whole_temp_registerotp` WHERE `billing_mobile`='$phone'";
				$result1 = $query=$conn->query($sqlDel);
             }
             else
             {
                $Errmessage="OTP does not match.";
             }
	}
	else
	{
		$Errmessage="Please enter OTP.";
	}
	
	if($Errmessage=='')
	{
		$message = "User registered successfully.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
		
	}else
	{
       	$message =$Errmessage;
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
	}
	
	
	//////////http://sarvohal.com/grvapi/add_api.php?fname=gaurav&lname=sharma&emailid=g@gmail.com&password=123456
	
	
	/// url = http://localhost/GRVAPI/add_api.php?name=gaurav&email=xx&password=gaurav@123#
	// gkssoftware.com/grvapi/register.php?name=gaurav&email=g@gmail.com&phone=9971&password=123456
?>
