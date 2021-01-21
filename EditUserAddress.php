<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");

isset($_GET['userid']) ?
	 $userid = $_GET['userid'] : "";

	isset($_GET['address']) ?
	$address = $_GET['address'] : "";

	isset($_GET['housenumber']) ?
	$housenumber = $_GET['housenumber'] : "";



	isset($_GET['city']) ?
	$city = $_GET['city'] : "";

	isset($_GET['state']) ?
	$state = $_GET['state'] : "";

	isset($_GET['country']) ?
	$country = $_GET['country'] : "";

	isset($_GET['zipcode']) ?
	$zipcode = $_GET['zipcode'] : "";


	if ($address=='') {
		$Errmessage = "Address is required.";
	}


	if ($zipcode=='') {
		$Errmessage = "Zip code is required.";
	}

if ($Errmessage=='') {
	 $sql="UPDATE whole_user_registration SET deliver_address='$address',deliver_housenumber='$housenumber',deliver_city='$city',deliver_state='$state',deliver_country='$country',deliver_zip='$zipcode' WHERE id='$userid'";
   
	$result = $query=$conn->query($sql);
}
else
   {
   	$result=0;
   }



	 if($result==1){
		$message = "address updated successfully.";
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseSuccess($data);
	 }else{

      if ($Errmessage=='') {
		$message = "Something went wrong, Please contact to admin.";
       } else
       {
       	$message =$Errmessage;
       }
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
	}
/////http://gkssoftware.com/grvapi/EditUserAddress.php?userid=67&address=aaa&housenumber=sss&city=mmm&state=ppp&country=fff&zipcode=123
 ?>

