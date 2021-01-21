<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
	$conn->set_charset('utf8');
    isset($_POST['userid']) ?
	$userid = $_POST['userid'] : "";

	isset($_POST['old_password']) ?
	$old_password = $_POST['old_password'] : ""; 

	isset($_POST['new_password']) ?
	$new_password = $_POST['new_password'] : "";
	
	isset($_POST['cnfrm_password']) ?
	$cnfrm_password = $_POST['cnfrm_password'] : "";

	$encrOldPass=MD5($old_password);
	$sqlSel="SELECT * FROM `whole_user_registration` where `password`='$encrOldPass'  AND `id`='$userid'";
	$query=$conn->query($sqlSel);
	$rowcount=$query->num_rows;
	if($rowcount==1)
	{
		if ($new_password == $cnfrm_password) {
		 $newpassword=MD5($cnfrm_password);
		  $sql="UPDATE whole_user_registration SET password='$newpassword' WHERE id='$userid'";
	        $result = $query=$conn->query($sql);
	        $errorMsg="";
		}
	    else
	    {
	        $result=0;
	        $errorMsg="New Password and Confirm Password doesn't match.";
	    }
	}
	else
	{
		$result=0;
		$errorMsg="Old Password is wrong.";
	}
	
	if($result==1){
		$message = "Password update successfully.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
	}else{

        $message =$errorMsg ;
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
	}
/////http://gkssoftware.com/grvapi/ChangePassword.php?userid=67&old_password=1122&new_password=1124
 ?>

