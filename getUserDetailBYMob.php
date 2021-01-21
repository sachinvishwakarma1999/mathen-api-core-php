<?php include('config.php'); 
include('api.php');
include("../includes/libraries/mailfunction.php");
include("../includes/configurationadmin.php");
///header("Access-Control-Allow-Origin");
  //     isset($_REQUEST['userid']) ?
     // $userid = $_REQUEST['userid'] : "";
    $conn->set_charset('utf8');
    isset($_POST['mobile']) ?
    $mobile = $_POST['mobile'] : "";

    if($mobile!='')
    {
        $sqlCheckPass="SELECT * FROM `whole_user_registration` WHERE  `billing_mobile`='$mobile'";
             $resultPass=$conn->query($sqlCheckPass);
             $rowcount= $resultPass->num_rows;
             $ro=$resultPass->fetch_assoc();
             if ($rowcount!=1) {
                $Errmessage = "Mobile number does not match with our record.";
             }
             else
             {
                function generateRandomString($length = 4) {
                    $characters = '0123456789';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }
                $random=generateRandomString(6);
                $text="Your OTP is ".$random.".Please do not share your otp with anyone.";
                $fromc="info@manthanonline.in";
                $toc=$ro['emailid'];
                $subjectc="Manthan OTP";
                $message=$text;
                send_mail($toc, $subjectc, $message, $headers1, $fromc, '');
                  $message= urlencode($text);
                  // smsApiBeta($contact_number, $message);
                  $username="t1manthan";
                  $password="22792604";
                  $senderId="Manthn";
                  $url="http://182.18.144.136/api/swsendSingle.asp"; 
                  $data="username=".$username."&password=".$password."&sender=".$senderId."&sendto=".$mobile."&message=".$message; 
                  $sqlupOtp="UPDATE `whole_user_registration` SET  `passwordverifycode`='$random'where  `billing_mobile`='$mobile'";
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
    }
    else
    {
        $Errmessage = "Please enter mobile number.";
    }
    
    if ($Errmessage=='') {
        $message = "OTP send to your mobile number.";
        $result['id']=$ro['id'];
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

