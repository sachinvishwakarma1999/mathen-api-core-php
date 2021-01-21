<?php
$hostname="localhost";
$dbuser="root";
$dbpassword="";
$dbname="manthano_manthan";	
$conn= new mysqli($hostname,$dbuser,$dbpassword,$dbname);
if($conn->connect_error)
{
	die('connection failled');
}
else
{
	//echo 'connect successfully';
}
?>