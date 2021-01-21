<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");
    $conn->set_charset('utf8');
    isset($_GET['pid']) ?
    $pid = $_GET['pid'] : "";

    isset($_GET['colorid']) ?
    $colorid = $_GET['colorid'] : "";

    isset($_GET['sizeid']) ?
    $sizeid = $_GET['sizeid'] : "";

    if(($sizeid!="" || $sizeid!=0) && ($colorid!="" || $colorid!=0))
    {
        $sql=$conn->query("SELECT `product_id`, if(`qty`=0,'Out Of Stock',qty) as qty,`price` FROM `whole_product_combination` where `size_id`='$sizeid' AND `color_id`='$colorid' AND `product_id`='$pid'");
        if($sql->num_rows>0)
        {
        	$result1=$sql->fetch_assoc();
        }
        else
        {
        	$result1=[];
        }
    }
    else
    {
        $result1=[];
    }
    if(count($result1)>0)
    {
    	$message = "Cobination details";
	    $result = $result1;
	    $data = array("message"=>$message,"result"=>$result);
	    responseSuccess($data);
    }
    else
    {
    	$message = "Nothing to show";
	    $result = [];
	    $data = array("message"=>$message,"result"=>$result);
	    responseError($data);
    }
?>