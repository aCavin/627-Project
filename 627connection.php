<?php 

$db = 'localhost';
$dbusername = 'root';
$password = '';
$database = '627';

//Create connection
$conn = new mysqli($db, $dbusername, $password, $database);

//Check connection
if($conn->connect_error){
		die('Connection failed:' . $conn->connect_error);
}else{
	
}


?>

