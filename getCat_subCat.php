<?php 
include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
///header("Access-Control-Allow-Origin");
$sql="select * from whole_category where parent='0' and displayflag='1' order by sortid desc limit 7";
$result=$conn->query($sql);
$records=[];
$parent = [];
$i=0;
while($row=$result->fetch_object())
{
	$records[$i]['Category']=[];
	$records[$i]['subCategory']=[];
	$records[$i]['Category']=$row;
	$result1=$conn->query("SELECT *, concat('https://www.manthanonline.in/categoryimages/',`appimage`) as appimage1,concat('https://www.manthanonline.in/categoryimages/',`appiconimage`) as appiconimage1 FROM whole_category where `parent`='".$row->cat_id."' and displayflag='1'");
	while($row1=$result1->fetch_object())
	{
		$records[$i]['subCategory'][]=$row1;
	}
	$i+=1;
}
$message = "category and sub category listing";
$result = $records;
$data = array("message"=>$message,"result"=>$result);
responseSuccess($data);
?>