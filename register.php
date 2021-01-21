<?php
include('config.php');
include('api.php');

	isset($_GET['name']) ?
	$name = $_GET['name'] : "";
	
		
	
		isset($_GET['email']) ?
	$email = $_GET['email'] : "";
	
	isset($_GET['phone']) ?
	$phone = $_GET['phone'] : "";
	
	
		isset($_GET['password']) ?
	$password = $_GET['password'] : "";

	if ($name=='') {
		$Errmessage = "name is required.";
	}
	
	else if ($email=='') {
		$Errmessage = "email id is required.";
	} else if($phone=='')
	{
         $Errmessage = "phone no is required.";
	} 
	else if($password=='')
	{
         $Errmessage = "password is required.";
	}  

	if ($email!='' && $name!='' && $phone!='' && $password!='') {


   $sqlQ = "SELECT * FROM whole_user_registration WHERE emailid='$email'";
   $rslt = $conn->query($sqlQ);
   $rowcount= $rslt->num_rows;

   if ($rowcount > 0) {
   	$Errmessage = "email id already exist.";
   }

	}

	
	if ($Errmessage=='') {
		$upassword=MD5($password);	
	$sql="insert into whole_user_registration (fname,emailid,billing_mobile,password)value('$name','$email','$phone','$upassword')";
   
	$result = $query=$conn->query($sql);
   } else
   {
   	$result=0;
   }

   


	if($result==1){
		$message = "User registered successfully.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
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
	
	
	//////////http://sarvohal.com/grvapi/add_api.php?fname=gaurav&lname=sharma&emailid=g@gmail.com&password=123456
	
	
	/// url = http://localhost/GRVAPI/add_api.php?name=gaurav&email=xx&password=gaurav@123#
	// gkssoftware.com/grvapi/register.php?name=gaurav&email=g@gmail.com&phone=9971&password=123456
?>
