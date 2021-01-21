<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
$sql="select * from whole_category where displayflag=1";
$result=$conn->query($sql);
while($row=$result->fetch_object())
{
echo $records=$row->cat_id; echo $records=$row->categoryname; 
echo "<br>";
}

// $message = "category listing";
// 		$result = $records;
// 		$data = array("message"=>$message,"result"=>$result);
// 		responseSuccess($data);



"select * from `".$sufix."category` where parent='0' and displayflag='1' order by sortid desc limit 7"


"select * from `".$sufix."category` where parent='".$rows['cat_id']."' and displayflag='1' and cat_type='subcategory' order by sortid desc"


"select * from `".$sufix."category` where parent='".$rowsub['cat_id']."' and displayflag='1' and cat_type='sub-subcategory' order by sortid desc"




 ?>

