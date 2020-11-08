<?php 
session_start();
include '627connection.php';
//Check if there is an existing user logged in.
if (isset($_SESSION['username'])){
    echo "Welcome!" .  $_SESSION['username'] . "<br />";
    echo "<a href='627Logout.php'> Logout </a>";
}else{
    header("Location: http://localhost/gallery/627login.php");
}

?>