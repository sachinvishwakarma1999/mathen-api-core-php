<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
	$conn->set_charset('utf8');
    isset($_REQUEST['userid']) ?
	$userid = $_REQUEST['userid'] : "";

	isset($_POST['new_password']) ?
	$new_password = $_POST['new_password'] : "";
	
	isset($_POST['cnfrm_password']) ?
	$cnfrm_password = $_POST['cnfrm_password'] : "";

	isset($_POST['token']) ?
    $neToken = $_POST['token'] : ""; 

	$arr=[];
	if ($new_password == $cnfrm_password) {
		 $newpassword=MD5($cnfrm_password);
		  $sql="UPDATE whole_user_registration SET password='$newpassword',token='$neToken' WHERE id='$userid'";
	        $result = $query=$conn->query($sql);
	        if($result==1)
	        {
	        	$sqlQ="SELECT *,id,concat('https://www.manthanonline.in/',`user_image`) as user_image,gender,Dob,emailid,billing_mobile,concat_ws(' ',`fname`,`mname`,`lname`) as name,(SELECT sum(`amount`) FROM `whole_wallet_transactions`where `transaction_type`='Cashback' AND  `user_email`=emailid) as wallet,`deliver_address`,`deliver_housenumber`,`deliver_city`,`deliver_state`,`deliver_country`,`deliver_zip`,`deliver_phone` from whole_user_registration WHERE  id='$userid'";
			   $rslt = $conn->query($sqlQ);
			   $rowcount= $rslt->num_rows;
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
			   	$arr['token']=base64_encode($arr['uid']);
	        }
	        else
	        {
				$result=0;
	        }
	        
	}
    else
    {
        $result=0;
    }


	if(count($arr)>0){
		$message = "Password update successfully.";
		$result =$arr;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
	}else{

        $message = "Password doesn't match.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
	}
/////http://gkssoftware.com/grvapi/ChangePassword.php?userid=67&old_password=1122&new_password=1124
 ?>

