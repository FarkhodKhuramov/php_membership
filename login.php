<?php
session_start();
$userid = $_SESSION['id'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-qeuiv="Content-Type" content="text/html; charset=utf-8">
<title>Member System - Login</title> 
</head>
<body>
    <?php
    if ($userid && $username) {
        echo "You are already logged in as <b>$username</b>. <a href = './member.php'>Click here</a> to go to the member page.";
    } else {
        $form = "<form action = './login.php' method = 'post'> 
        <table>
            <tr>
            <td>Username:</td>
            <td><input type = 'text' name = 'user'/></td>
            </tr>
            <tr>
            <td>Password:</td>
            <td><input type = 'password' name = 'password'/></td>
            </tr>
            <tr>
            <td></td>
            <td><input type = 'submit' name = 'loginbtn' value = 'Login'/></td>
            </tr>
            <tr>
            <td><a href = './register.php'>Register</a></td>
            <td><a href = './register.php'>Forgot your password?</a></td></td>
            </tr>
        </table>
        </form>";

        if ($_POST['loginbtn']) {
            $user = $_POST['user'];
            $password = $_POST['password'];
            
            if ($user) {
                if ($password) {
                    require("connect.php");

                    $password = md5(md5("Some1".$password."Salt2"));
                    // echo $password;
                    $query = mysqli_query($connection, "SELECT * FROM users WHERE username='$user';", MYSQLI_STORE_RESULT);
                    if (mysqli_num_rows($query)==1) {
                        $row = mysqli_fetch_assoc($query);
                        $dbid = $row['id'];
                        $dbuser = $row['username'];
                        $dbpass = $row['password'];
                        $dbactive = $row['active'];
                        // foreach ($row as $key => $value) {
                        //     echo $key . " = " . $value . "<br/>";
                        // }

                        if ($password == $dbpass) {
                            if ($dbactive == 1) {
                                // set session info
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbuser;

                                echo "You have logged in as <b>$dbuser</b>. <a href = './member.php'>Click here</a> to go to the member page.";
                            } else {
                                echo "You must activate your account. <hr/> $form";
                                
                            }
                            
                        } else {
                            echo "You did not enter correct password. <hr/> $form";
                        }
                        
                    } else {
                        echo "user not found. <hr/> $form"; 
                    }
                    
                    mysqli_close($connection);
                    
                }else {
                    echo "You must enter your password. $form";
                }
            }else {
                echo "You must enter your username. $form";
            }
        }else {
            echo $form;
        }
    }
    
    
    ?>
</body>
</html>

