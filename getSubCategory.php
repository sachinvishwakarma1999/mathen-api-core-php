<?php 
try{
include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
isset($_GET['cat_id']) ?
	$cat_id = $_GET['cat_id'] : "";
///header("Access-Control-Allow-Origin");
$sql="SELECT cat_id, uploadimage, headerimage FROM whole_category WHERE cat_id='".$cat_id."' and displayflag='1'";
$result=$conn->query($sql);
$records=[];
$parent = [];

$upload_image = '';
$header_image = '';
$main_cat_id = $cat_id;


while($row=$result->fetch_object())
{
	
	if(!empty($row->uploadimage)){
		$upload_image = $row->uploadimage;
	}
	if(!empty($row->headerimage)){
		$upload_image = $row->headerimage;
	}
}

/// sub categories
$sql="SELECT * FROM whole_category WHERE parent='".$cat_id."' and displayflag='1' order by sortid desc";

$result=$conn->query($sql);
$subParent = [];
$subParents = [];
while($row=$result->fetch_object())
{
//$subParent[]=$row->cat_id;
//$subParents[$row->cat_id] = $row->parent;
//$row->subCategories = [];
$records[$row->cat_id]=$row;
}
		$message = "Sub category listing";
		$result = array_values($records);
		$data = array("message"=>$message,"result"=>$result,"uploadimage"=>$upload_image,"headerimage"=>$header_image,"main_cat_id"=>$main_cat_id);
		responseSuccess($data);
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage(); die;
}


 ?>

