<?php
session_start();

//Check if there is an existing user logged in. 
if (isset($_SESSION['username'])){
    session_unset();
    session_destroy();
    header("Location: http://localhost/gallery/627login.php");
}
else
{
    header("Location: http:localhost/gallery/627login.php");
}

?>