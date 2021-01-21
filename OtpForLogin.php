<?php include('config.php'); 
include('api.php');
include("../includes/libraries/mailfunction.php");
include("../includes/configurationadmin.php");
///header("Access-Control-Allow-Origin");
$conn->set_charset('utf8');
    isset($_POST['phone']) ?
    $phone = $_POST['phone'] : "";

    $sqlQ1= "SELECT * FROM whole_user_registration WHERE billing_mobile='$phone' OR   emailid='$phone'";
    $rslt1 = $conn->query($sqlQ1);
    $ro=$rslt1->fetch_assoc();
    $rowcount1= $rslt1->num_rows;

        if ($rowcount1 >0) {
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
            $toc=$ro['emailid'];
            $subjectc="Manthan OTP";
            $message=$text;
            send_mail($toc, $subjectc, $message, $headers1, $fromc, '');
            $message= urlencode($text);
            $username="t1manthan";
            $password="22792604";
            $senderId="Manthn";
            $url="http://182.18.144.136/api/swsendSingle.asp"; 
            $data="username=".$username."&password=".$password."&sender=".$senderId."&sendto=".$phone."&message=".$message; 

            $sqlupOtp="UPDATE `whole_user_registration` SET  `varificationcode`='$random' where `billing_mobile`='$phone' OR   emailid='$phone'";
             $resultotp=$conn->query($sqlupOtp);
                    
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
             $Errmessage="This Mobile number does not match with our record.";
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

