<?php
include('config.php');
include('api.php');

	isset($_POST['catId']) ?
	$catId = $_POST['catId'] : "";
	
	isset($_POST['userid']) ?
	$userid = $_POST['userid'] : "";

	$sql=$conn->query("SELECT * FROM `whole_favorite_category` where `user_id`='$userid'");

	if($sql->num_rows>0)
	{
		$result=$sql->fetch_assoc();
		$record=$conn->query("UPDATE `whole_favorite_category` SET  `cat_id`='$catId'
			where `id`='".$result['id']."'");
	}
	else
	{
		$record=$conn->query("INSERT INTO `whole_favorite_category`(`cat_id`, `user_id`) VALUES  ('$catId','$userid')");
	}
	if($record==1)
	{
		$message = "Successfull Added to Favourite Category.";
		$result1 = [];
		$data = array("message"=>$message,"result"=>$result1);
		responseSuccess($data);
	}
	else
	{
		$message = "Something went wrong please try again later";
		$result1 = [];
		$data = array("message"=>$message,"result"=>$result1);
		responseError($data);
	}

?>