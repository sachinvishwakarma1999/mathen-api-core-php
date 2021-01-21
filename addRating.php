<?php include('config.php'); 
	include('api.php');
	$conn->set_charset('utf8');

	isset($_POST['productID']) ?
	$productID = $_POST['productID'] : "";

	isset($_POST['user_id']) ?
	$user_id = $_POST['user_id'] : "";

	isset($_POST['emailid']) ?
	$emailid = $_POST['emailid'] : "";

	isset($_POST['rating']) ?
	$rating = $_POST['rating'] : "";

	isset($_POST['name']) ?
	$name = $_POST['name'] : "";

	isset($_POST['title']) ?
	$title = $_POST['title'] : "";

	isset($_POST['comments']) ?
	$comments = $_POST['comments'] : "";


	isset($_POST['ipaddress']) ?
	$ipaddress = $_POST['ipaddress'] : "";

	isset($_POST['adddate']) ?
	$adddate = $_POST['adddate'] : "";

	$sql1=$conn->query("select * from whole_rating where `product_id`='$productID' AND `emailid`='$emailid' ");
	if($sql1->num_rows == 0)
	{
		$sql=$conn->query("INSERT INTO `whole_rating`(`product_id`, `user_id`, `emailid`, `rating`, `name`, `title`, `comments`, `ratings`, `ipaddress`, `adddate`) VALUES ('$productID','$user_id','$emailid','$rating','$name','$title','$comments','1','$ipaddress',now())");
		if($sql==1)
		{
			$message="Rating Added";
			$result =[];
		    $data = array("message"=>$message,"result"=>$result);
		    responseSuccess($data);
		}
		else
		{
			$message="something went wrong.Please try again later.";
			$result =[];
		    $data = array("message"=>$message,"result"=>$result);
		    responseError($data);
		}
	}
	else
	{
		$message="Already exist";
		$result =[];
	    $data = array("message"=>$message,"result"=>$result);
	    responseError($data);
	}
	
?>