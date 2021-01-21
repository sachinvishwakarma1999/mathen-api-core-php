<?php
include('config.php');
include('api.php');

	isset($_GET['fname']) ?
	$fname = $_GET['fname'] : "";
	
		isset($_GET['lname']) ?
	$lname = $_GET['lname'] : "";
	
		isset($_GET['emailid']) ?
	$emailid = $_GET['emailid'] : "";
	
		isset($_GET['password']) ?
	$password = $_GET['password'] : "";
	

	
	$sql="insert into whole_user_registration (fname,lname,emailid,password)value('$fname','$lname','$emailid','$password')";
   
	$result = $query=$conn->query($sql);
	if($result==1){
		$message = "User registered successfully.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
	}else{
		$message = "Something went wrong, Please contact to admin.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
	}
	
	
	//////////http://sarvohal.com/grvapi/add_api.php?fname=gaurav&lname=sharma&emailid=g@gmail.com&password=123456
	
	
	/// url = http://localhost/GRVAPI/add_api.php?name=gaurav&email=xx&password=gaurav@123#
	
?>
