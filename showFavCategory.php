<?php
include('config.php');
include('api.php');
	$conn->set_charset('utf8');
	isset($_POST['userid']) ?
	$userid = $_POST['userid'] : "";

	$sql=$conn->query("SELECT * FROM `whole_favorite_category` where `user_id`='$userid'");
	if($sql->num_rows>0)
	{
		$row=$sql->fetch_assoc();
		$newCat=explode(',',$row['cat_id']);
		$data=[];
		for($i=0;$i<count($newCat);$i++)
		{
			$cat=$conn->query("SELECT `cat_id`,`parent`,`cat_type`,`categoryname`,concat('https://www.manthanonline.in/categoryimages/',`uploadimage`) as uploadimage,concat('https://www.manthanonline.in/categoryimages/',`headerimage`) as headerimage  from `whole_category` where `cat_id`='".$newCat[$i]."'");
			if($cat->num_rows>0)
			{
				$row=$cat->fetch_assoc();
				$data[$i]=$row;
			}
		}
		 if(count($data)>0)
		 {
		 	$errMsg="";
		 }
		 else
		 {
		 	$errMsg="Nothing To Show";
		 }
	}
	else
	{
		$errMsg="Nothing To Show";
	}
	if($errMsg=="")
	{
		$message = "Favorite Category List.";
		$result =$data;
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
	}
	else
	{
		$message = $errMsg;
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
	}
?>