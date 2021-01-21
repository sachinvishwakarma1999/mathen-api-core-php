<?php include('config.php'); 
include('api.php');
///header("Access-Control-Allow-Origin");

isset($_POST['userid']) ?
	 $userid = $_POST['userid'] : "";

	isset($_POST['name']) ?
	$fname = $_POST['name'] : "";

	isset($_POST['lname']) ?
	$lname = $_POST['lname'] : "";

	isset($_POST['mname']) ?
	$mname = $_POST['mname'] : "";

	isset($_POST['email']) ?
	$email = $_POST['email'] : "";


	isset($_POST['gender']) ?
	$gender = $_POST['gender'] : "";
	isset($_POST['dob']) ?
	$dob = $_POST['dob'] : "";

	isset($_POST['mobile']) ?
	$mobile = $_POST['mobile'] : "";

	$newpicPath="";
	$error="";
	$str="";

	$path = $_FILES['picpath']['name'];
    $path_tmp = $_FILES['picpath']['tmp_name'];
    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG'  ) 
        {
            $valid = 0;
            $error = 'You must have to upload jpg, jpeg or png file for Profile photo<br>';
        }
        else
        {
        	$valid=1;
	    	$newpicPath = 'uploads/Profile_'.$userid.'.'.$ext;
	    	$str=", user_image='$newpicPath'";
        }
    } 
    $editchk=$conn->query("SELECT * FROM `whole_user_registration` WHERE `billing_mobile` ='$mobile' and `id`!='$userid' ");
    if($editchk->num_rows>0)
    {
    	$error="Mobile number already exist.";
    }
    $editchk=$conn->query("SELECT * FROM `whole_user_registration` WHERE `id`!='$userid' and emailid='$email'");
    if($editchk->num_rows>0)
    {
    	$error="Email already exist.";
    }
    if($error=="")
    {

    	$sql="UPDATE whole_user_registration SET gender='$gender',Dob='$dob', fname='$fname',mname='$mname' ,lname='$lname',emailid='$email',billing_mobile='$mobile' $str WHERE id='$userid'";
   
		$result = $query=$conn->query($sql);
		if($result==1){
			move_uploaded_file( $path_tmp, '../'.$newpicPath );
			$message = "User updated successfully.";
			$result = [];
			$data = array("message"=>$message,"result"=>$result);
			responseSuccess($data);
		}else{
			$message = "Something went wrong, Please contact to admin.";
			$result = [];
			$data = array("message"=>$message,"result"=>$result);
			responseError($data);
		}
    }
    else
    {
    	$message = $error;
		$result = [];
		$data = array("message"=>$message,"result"=>$result);
		responseError($data);
    }
	
/////http://gkssoftware.com/grvapi/EditUserProfile.php?userid=67&name=gaurav&email=g@gmail.com&mobile=9971695047
 ?>

