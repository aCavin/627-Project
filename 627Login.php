<?php 
session_start();
include '627connection.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>The 627 Project </title>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>

<?php 
function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$usernameErr = $passwordErr = '';
$username = $password = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_POST['uname']) || empty($_POST['pword'])){
	$usernameErr = $passwordErr = 'All fields are required.';
	}else{
		$username = test_input($_POST['uname']);
		$sql = "SELECT Username, Pword FROM `627` WHERE Username = '$username'";
		$result = $conn->query($sql);
	
			if($result->num_rows > 0 )
			{
				while ($row = $result->fetch_assoc())
				{
					$hash = $row['Pword'];
					$clean = test_input($_POST['pword']);

					if (password_verify($clean, $hash))
					{
						//echo 'Password is valid!' . $row['Pword'] . "You got this!"; 
						$_SESSION['username'] = $row['Username'];
						header ("Location: http://localhost/gallery/627Home.php");
					}else{
						$passwordErr = 'Password is Invalid!';
					}
				}
			}
	}
		
}
?>

<h2>Login to 627</h2>
<form method='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> '>
	Username: <input type="text" name="uname"><?php /*<span class="error"> <?php echo $usernameErr; ?></span> */ ?></br>	
	Password: <input type="password" name="pword"><?php /*<span class="error"> <?php echo $passwordErr; ?></span>*/?></br>
	<span class="error"> <?php 
	if($passwordErr == true){
		echo $passwordErr;
	}else{
		echo $usernameErr;
	}
	?>
	</span></br>
	
	<input type="submit">
</form>


</body>

</html>