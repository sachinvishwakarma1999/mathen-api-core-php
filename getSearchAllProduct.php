<?php include('config.php'); 
include('api.php');

// $sql="SELECT `id`,`productname`,`cat_id`,`subcat_id`,`subsubcat_id` FROM `whole_product` ORDER BY `id` DESC ";
// $data=$conn->query($sql);
// while($row = $data->fetch_object())
// {
// 	$record[]=$row;
// }
// $message = "product listing";
// $result = $record;
// $data = array("message"=>$message,"result"=>$result);
// responseSuccess($data);

$conn->set_charset('utf8');

// $search = $_POST['search'];

	$ch=$conn->query("select cat_id,`parent`,categoryname,cat_type from whole_category  where  displayflag='1' order by sortid asc");

	$num = $ch->num_rows;

	if($num>0){
	while ($row =$ch->fetch_assoc() ){ 
	 
	 $response[] = array("catid"=>$row['cat_id'],
	    	"subCat"=>'  '.$row['parent'],
	    	"categoryname"=>'  '.$row['categoryname'],
	    	"cat_type"=>'  '.$row['cat_type']);



	$ch2=$conn->query("select cat_id,`parent`,categoryname,cat_type from whole_category where parent='".$row['cat_id']."' and cat_id !='".$row['cat_id']."' AND displayflag='1' order by sortid asc");
	$num2= $ch2->num_rows;

	if($num2 > 0){
	while ($row2 =$ch2->fetch_assoc()){


	 $response[] = array("catid"=>$row2['cat_id'],
	    	"subCat"=>'  '.$row2['parent'],
	    	"categoryname"=>'  '.$row2['categoryname'],
	    	"cat_type"=>'  '.$row2['cat_type']);

	$ch3=$conn->query("select cat_id,`parent`,categoryname,cat_type from whole_category where parent='".$row2['cat_id']."' and cat_id !='".$row['cat_id']."' AND displayflag='1'  order by sortid asc");
	$num3= $ch3->num_rows;

	if($num3 > 0){
	while ($row3 = $ch3->fetch_assoc()){

	    $response[] = array("catid"=>$row3['cat_id'],
	    	"subCat"=>'  '.$row3['parent'],
	    	"categoryname"=>'  '.$row3['categoryname'],
	    	"cat_type"=>'  '.$row2['cat_type']);

	        }//end while 
          } //end if
         }//end while 
       } //end if
	  }//end while 
    }
    $out = array();
	foreach ($response as $row) {
	    $out[$row['categoryname']] = $row;
	}
	$array = array_values($out);
   	$message = "Search List";
	$result = $array;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);
?>