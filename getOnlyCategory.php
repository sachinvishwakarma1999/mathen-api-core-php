<?php 
try{
include('config.php'); 
include('api.php');
$conn->set_charset('utf8');

$userid=0;
isset($_GET['userid']) ?
$userid = $_GET['userid'] : "";
///header("Access-Control-Allow-Origin");
$sql="select *,0 as favStatus from whole_category where parent='0' and displayflag='1' order by sortid desc limit 7";
$result=$conn->query($sql);
$records=[];
$parent = [];
while($row=$result->fetch_assoc())
{
//$parent[]=$row->cat_id;
//$row->subCategories = [];
$records[]=$row;
}
$sqlQ=$conn->query("SELECT cat_id FROM `whole_favorite_category` where `user_id`='$userid'");
$row1=$sqlQ->fetch_assoc();

if($row1['cat_id']!=null || $row1['cat_id']!="")
{
	unset($records['favStatus']);
	$data=explode(',',$row1['cat_id']);
	$records1=$data;

	for($i=0;$i<count($records);$i++)
	{
		if(in_array($records[$i]['cat_id'], $data))
		{
			$records[$i]['favStatus']='1';
		}
		else
		{
			$records[$i]['favStatus']='0';
		}
	}
	$records1=$records;
}
else
{

	$records1=$records;
}

/// sub categories
/*$parentIds = implode(',', $parent);
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
}*/

// sub sub categories
/*$subParentIds = implode(',', $subParent);
$sql="select * from whole_category where parent IN (".$subParentIds.") and displayflag='1' order by sortid desc";
$result=$conn->query($sql);
while($row=$result->fetch_object())
{
$records[$subParents[$row->parent]]->subCategories[$row->parent]->subCategories[$row->cat_id]=$row;
}*/


$message = "category listing";
		$result = $records;
		$data = array("message"=>$message,"result"=>$records1);
		responseSuccess($data);
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage(); die;
}


 ?>

