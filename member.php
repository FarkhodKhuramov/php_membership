<?php
session_start();
$userid = $_SESSION['id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-qeuiv="Content-Type" content="text/html; charset=utf-8">
<title>Member System - Members</title> 
</head>
<body>
    <?php
    if ($userid && $username) {
        echo "Welcome <b>$username</b>, <a href = './logout.php'>Logout</a>";
    } else {

        echo "Please login to access the current page. <a href = './login.php'>Login page<a/>";
    }
    
    ?>
</body>
