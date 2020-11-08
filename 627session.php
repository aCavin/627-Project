<?php 
session_start();

//Check if there is an existing user logged in.
if (isset($_SESSION['username'])){
    echo $_SESSION['username'];
}
else
{
    header("Location: http:localhost/gallery/627login.php");
}

?>
