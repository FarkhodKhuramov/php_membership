<?php
session_start();
// $userid = $_SESSION['id'];
// $username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-qeuiv="Content-Type" content="text/html; charset=utf-8">
<title>Member System - Login</title> 
</head>
    <body>
        <?php
        if (isset($_GET['user'],$_GET['code'])){
            $user = $_GET['user'];
            $code = $_GET['code'];

            require("connect.php");

            $qry = mysqli_query($connection, "SELECT * FROM users WHERE username = '$user' AND active = 0");

            $rowcount = mysqli_num_rows($qry);

            if ($rowcount == 1) {
                $row = mysqli_fetch_assoc($qry);
                if ($row['code'] === $code) {
                    mysqli_query($connection, "UPDATE users SET code = '', active = 1 WHERE username = '$user'");
                    $qry = mysqli_query($connection, "SELECT * FROM users WHERE username = '$user' AND active = 0");
                    $rowcount = mysqli_num_rows($qry);
                    if ($rowcount == 0) {
                        echo "User activation successful. Please refer the <a href = './login.php'>Link</a> to login.";
                    } else {
                        echo "Sorry, user activation failed for unknown reason.";
                    }
                    
                } else {
                    echo "Activation code invalid.";
                }
                
            } else {
                echo "User <b>$user</b> not found.";
            }
            mysqli_close($connection);
        }else{
            echo "Not Found!";
        }
        ?>        
    </body>