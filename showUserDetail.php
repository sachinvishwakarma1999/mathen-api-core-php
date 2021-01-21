<?php include('config.php'); 
include('api.php');

	$conn->set_charset('utf8');
 	isset($_POST['userid']) ?
	$userid = $_POST['userid'] : "";

	$sql=$conn->query("SELECT id,concat('https://www.manthanonline.in/',`user_image`) as user_image,gender,Dob,`emailid`,`fname` as Fullname,`mname`,`lname`,(SELECT sum(`amount`) FROM `whole_wallet_transactions`where `transaction_type`='Cashback' AND  `user_email`=emailid) as cashback,(SELECT sum(`amount`) FROM `whole_wallet_transactions`where `transaction_type`='Reward' AND  `user_email`=emailid) as reward,`companyname`,`billing_address`,`billing_housenumber`,
		`billing_city`,`billing_state`,`billing_zip`,`billing_country`,`billing_mobile`, 
		`billing_mobile`,`dtitle`, concat_ws(' ',`dfname`,`dlname`) as deliverName,`deliver_address`,`deliver_housenumber`,`deliver_city`,`deliver_state`,`deliver_country`,`deliver_zip`,`deliver_phone` FROM `whole_user_registration` where id='$userid'");
	$row=$sql->fetch_assoc();
	$message = "User Detail";
	$result = $row;
	$data = array("message"=>$message,"result"=>$result);
	responseSuccess($data);


 ?>

