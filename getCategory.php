<?php 
try{
include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
///header("Access-Control-Allow-Origin");
$sql="select * from whole_category where parent='0' and displayflag='1' order by sortid desc limit 7";
$result=$conn->query($sql);
$records=[];
$parent = [];
while($row=$result->fetch_object())
{
$parent[]=$row->cat_id;
$row->subCategories = [];
$records[$row->cat_id]=$row;
}
/// sub categories
$parentIds = implode(',', $parent);
$sql="select * from whole_category where parent IN (".$parentIds.") and displayflag='1' order by sortid desc";
$result=$conn->query($sql);
$subParent = [];
$subParents = [];
while($row=$result->fetch_object())
{
$subParent[]=$row->cat_id;
$subParents[$row->cat_id] = $row->parent;
$row->subCategories = [];
$records[$row->parent]->subCategories[$row->cat_id]=$row;
}

// sub sub categories
$subParentIds = implode(',', $subParent);
$sql="select * from whole_category where parent IN (".$subParentIds.") and displayflag='1' order by sortid desc";
$result=$conn->query($sql);
while($row=$result->fetch_object())
{
$records[$subParents[$row->parent]]->subCategories[$row->parent]->subCategories[$row->cat_id]=$row;
}


$message = "category listing";
		$result = array_values($records);
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage(); die;
}


 ?>

