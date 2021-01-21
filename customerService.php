<?php
include('config.php');
include('api.php');
    $conn->set_charset('utf8');
	isset($_POST['oid']) ?
    $oid = $_POST['oid'] : "";

    isset($_POST['productid']) ?
    $productid = $_POST['productid'] : "";

    isset($_POST['issueid']) ?
    $issueid = $_POST['issueid'] : "";

    isset($_POST['name']) ?
    $name = $_POST['name'] : "";

	isset($_POST['email']) ?
    $email = $_POST['email'] : "";

    isset($_POST['phone']) ?
    $phone = $_POST['phone'] : "";

    $path = $_FILES['filepath']['name'];
    $path_tmp = $_FILES['filepath']['tmp_name'];
    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG'  ) 
        {
            $valid = 0;
            $error = 'You must have to upload jpg, jpeg or png file for Profile photo<br>';
        }
        else
        {
        	$valid=1;
	    	$newpicPath = 'customerIssues/issue_'.$oid.'_'.$productid.'.'.$ext;
	    	$str=", user_image='$newpicPath'";
        }
    } 
    else
    {
    	$newpicPath ="";
    }
    $sql=$conn->query("SELECT * FROM `whole_customer_query` where `oid`='$oid' AND `productid`='$productid' AND `issue_id`='$issueid' AND `customer_name`='$name' AND `email`='$email' AND `phone`='$phone' AND `solved_status`!='1'");
    if($sql->num_rows==0)
    {

    	$result=$conn->query("INSERT INTO `whole_customer_query`( `oid`, `productid`, `issue_id`, `customer_name`, `email`, `phone`, `file_path`) VALUES
    		('$oid','$productid','$issueid','$name','$email','$phone','$newpicPath')");
    	if($result==1)
    	{
    		$errMsg="";
    	}
    	else
    	{
    		$errMsg="Not Inserted";
    	}

    }
    if($errMsg=="")
    {
		$message ="Customer query inserted";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
    }
    else
    {
		$message ="something went wrong.please try again.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
    }
    


?>