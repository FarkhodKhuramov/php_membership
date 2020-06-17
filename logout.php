<?php
session_start();
$userid = $_SESSION['id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-qeuiv="Content-Type" content="text/html; charset=utf-8">
<title>Member System - Logout</title> 
</head>
<body>
<?php
    if ($userid && $username) {
        session_destroy();
        echo "You have been logged out. <a href = './member.php'>Member</a>"; 
    } else {
        echo "You are not logged in.";
    }
    
?>
</body>