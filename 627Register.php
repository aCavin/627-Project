<?php
session_start();
include '627connection.php';
?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<style>
.error {color: #FF0000;}
</style>
</HEAD>

<BODY>
<?php

//define variables and set empty values
$fnameErr = $lnameErr = $emailErr = $usernameErr = $password1Err = $password2Err = '';
$fname = $lname = $email = $username =  $password1 = $password2 = $successful = '';

//trim data from any form of injections
function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
	
//Check inputs if they are not empty.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_POST['fname'])){
		$fnameErr = 'First name is required.';
	}else{ 
		$fname = test_input($_POST['fname']);
	}
	if(empty($_POST['lname'])){
		$lnameErr = 'Last name is required.';
	}else{
		$lname = test_input($_POST['lname']);
	}
	if(empty($_POST['email'])){
		$emailErr = 'Email is required.';
	}else{
		$email = test_input($_POST['email']);
		//Validate if email is a valid email.
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$emailErr = 'Invalid email format.';
		}
	}
	if(empty($_POST['username'])){
		$usernameErr = 'Username is required.';
	}else{
		//Check if Username is already existing.
		$username = $_POST['username'];
		$sql = "SELECT Username FROM `627` WHERE Username = '$username'";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0){
		$usernameErr = 'Username is already existing. Kindly choose a new one.';	
		}else{
		$username = $_POST['username']; 
		}
	}
	
	//Check if password fields are not empty.
	if(empty($_POST['password1']) || empty($_POST['password2'])){
		$password1Err = 'Password is required.';
	}else{
		//Check if input passwords are the same.
		if ($_POST['password1'] == $_POST['password2'])
		{
			$password1 = test_input($_POST['password1']);
			//$options  = [
			//	'cost' =>  12,
			//];
			//$password1 = password_hash($password1, PASSWORD_BCRYPT, $options);
			$password = password_hash($password1, PASSWORD_DEFAULT); 
		}else
		{
		$password1Err = 'Password do not matched.';	
		}	
		
	}
	//Check for any errors if not errors were found, add data into the database.
	if(empty($fnameErr) && empty($lnameErr) && empty($emailErr) && empty($usernameErr) && empty($password1Err) && empty($password2Err)){
		
		$sql = "INSERT INTO `627`(`Firstname`,`Lastname`, `Email`, `Username`, `Pword`) VALUES ('$fname', '$lname', '$email', '$username', '$password')";
	
	if ($conn->query($sql) === TRUE) {
			$successful = "New account has been created.";
			echo "<br />" .  $password;
	} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
	}

		$conn->close();
 	}	
}

?>

<h2> Register </h2>
<p><span class="error">* required field</span></p>
<form method='post' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'>
		First Name: <input type="text" name="fname"> <span class="error"> <?php echo $fnameErr; ?> </span>
		<br />
		Last Name:  <input type="text" name="lname"> <span class="error"> <?php echo $lnameErr; ?> </span>
		<br />
		Email: <input type="text" name="email"> <span class="error"> <?php echo $emailErr; ?> </span>
		<br />
		Username: <input type="text" name="username"> <span class="error"> <?php echo $usernameErr; ?> </span>
		<br />
		Password: <input type="password" name="password1"> <span class="error"> <?php echo $password1Err; ?> </span>
		<br />
		Repeat password: <input type="password" name="password2"> <span class="error"> <?php echo $password1Err; ?> </span>
		<br />
		
		<input type="submit" name="register" value="Register">
		<br />
		<span class="error"> <?php echo $successful; ?> </span>
		<br />
		<p> Already have an account? <a href="627Login.php"> Login here </a>.
</form>


</BODY>

</HTML>
