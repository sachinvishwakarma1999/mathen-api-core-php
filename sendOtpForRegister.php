<?php include('config.php'); 
include('api.php');
include("../includes/libraries/mailfunction.php");
include("../includes/configurationadmin.php");
///header("Access-Control-Allow-Origin");
    $conn->set_charset('utf8');
    isset($_POST['name']) ?
    $name = $_POST['name'] : "";
    
    isset($_POST['email']) ?
    $email = $_POST['email'] : "";
    
    isset($_POST['phone']) ?
    $phone = $_POST['phone'] : "";
    
    
    isset($_POST['password']) ?
    $password = $_POST['password'] : "";
    
         $sqlQ = "SELECT * FROM whole_user_registration WHERE emailid='$email'";
        $rslt = $conn->query($sqlQ);
        $rowcount= $rslt->num_rows;

            if ($rowcount > 0) {
                $Errmessage1 = "email id already exist.";
            }

        $sqlQ1= "SELECT * FROM whole_user_registration WHERE billing_mobile='$phone'";
        $rslt1 = $conn->query($sqlQ1);
        $rowcount1= $rslt1->num_rows;

            if ($rowcount1 >0) {
                $Errmessage1 = "Mobile number already exist.";
            }

    
    if($Errmessage1=="")
    {
        function generateRandomString($length = 6) {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        $random=generateRandomString(6);
        $text=$random." is your Manthan Verification OTP code. This otp is for one time use.Please DO NOT share this OTP with anyone to ensure account security.";
        $fromc="info@manthanonline.in";
        $toc=$email;
        $subjectc="Manthan OTP";
        $message=$text;
        send_mail($toc, $subjectc, $message, $headers1, $fromc, '');
        $message= urlencode($text);
        $username="t1manthan";
        $password="22792604";
        $senderId="Manthn";
        $url="http://182.18.144.136/api/swsendSingle.asp"; 
        $data="username=".$username."&password=".$password."&sender=".$senderId."&sendto=".$phone."&message=".$message; 

        $selectPhone="SELECT * FROM `whole_temp_registerotp` WHERE `billing_mobile`='$phone'";
        $resotp = $conn->query($selectPhone);
        $rowcount= $resotp->num_rows;
         if ($rowcount==0) {
            $sqlInOtp="INSERT INTO `whole_temp_registerotp`(`billing_mobile`, `registerOTP`) VALUES ('$phone','$random')";
            $resultotp=$conn->query($sqlInOtp);
         }
         else
         {
             $sqlupOtp="UPDATE `whole_temp_registerotp` SET  `registerOTP`='$random' where  `billing_mobile`='$phone'";
             $resultotp=$conn->query($sqlupOtp);
         }
       
                
        function postdata($url,$data) 
        { 
            $objURL = curl_init($url); curl_setopt($objURL, 
            CURLOPT_RETURNTRANSFER,1); 
            curl_setopt($objURL,CURLOPT_POST,1); 
            curl_setopt($objURL, CURLOPT_POSTFIELDS,$data); 
            $retval = trim(curl_exec($objURL)); 
            curl_close($objURL);
            if($retval!=''){
                return "";
            }else{
                return "OTP can't send.";
            }
        } 
      $Errmessage= postdata($url,$data); 
    }
    else
    {
        $Errmessage = $Errmessage1;
    }
    
    if ($Errmessage=='') {
        $message = "OTP send to your Phone number.";
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

