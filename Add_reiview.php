<?php include('config.php'); 
	include('api.php');
	$conn->set_charset('utf8');

	isset($_POST['productID']) ?
	$productID = $_POST['productID'] : "";

	isset($_POST['rating']) ?
	$rating = $_POST['rating'] : "";

	isset($_POST['fullname']) ?
	$fullname = $_POST['fullname'] : "";

	isset($_POST['emailaddress']) ?
	$emailaddress = $_POST['emailaddress'] : "";

	isset($_POST['comments']) ?
	$comments = $_POST['comments'] : "";

	isset($_POST['date']) ?
	$date = $_POST['date'] : "";

	isset($_POST['publish']) ?
	$publish = $_POST['publish'] : "";

	$sql=$conn->query("INSERT INTO `whole_reviews`(`productID`, `rating`, `fullname`, `emailaddress`, `comments`, `date`, `publish`) VALUES ('$productID','$rating','$fullname','$emailaddress','$comments','$date','$publish')");
	if($sql==1)
	{
		$message="Review Added";
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
?>