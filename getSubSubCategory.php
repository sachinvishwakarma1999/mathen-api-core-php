<?php 
try{
include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
/// header("Access-Control-Allow-Origin");
$subcat_id = "";
if(!isset($_GET['subcat_id'])){
	$message = "Category id does not exist";
	$data = array("message"=>$message,"result"=>"");
	responseError($data);
}else{
	$subcat_id = $_GET['subcat_id'];
}

$sql = "SELECT cat_id, uploadimage, headerimage, imageflag FROM whole_category WHERE cat_id='".$subcat_id."' and displayflag='1'";
$result = $conn->query($sql);
$records = [];
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
$sql="SELECT * FROM whole_category WHERE parent='".$subcat_id."' and displayflag='1' order by sortid desc";

$result=$conn->query($sql);
$subParent = [];
$subParents = [];
while($row=$result->fetch_object())
{

/*$subParent[]=$row->cat_id;
$subParents[$row->cat_id] = $row->parent;
$row->subCategories = [];
$records[$row->parent]->subCategories[$row->cat_id]=$row;*/

$records[$row->cat_id]=$row;
}

// sub sub categories
/*$subParentIds = implode(',', $subParent);
$sql="select * from whole_category where parent IN (".$subParentIds.") and displayflag='1' order by sortid desc";
$result=$conn->query($sql);
while($row=$result->fetch_object())
{
$records[$subParents[$row->parent]]->subCategories[$row->parent]->subCategories[$row->cat_id]=$row;
}*/


		$message = "Sub Sub category listing";
		$result = array_values($records);
		//$data = array("message"=>$message,"result"=>$result);
		$data = array("message"=>$message,"result"=>$result,"uploadimage"=>$upload_image,"headerimage"=>$header_image);
		responseSuccess($data);
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage(); die;
}


 ?>


