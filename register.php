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
    // phpinfo();
    if ($_POST['submitbtn']) {
        $getuser = $_POST['user'];
        $getemail = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        if ($getuser) {
            if ($getemail) {
                if ($password) {
                    if ($password_confirm) {
                        if ($password === $password_confirm) {
                            if (strlen($getemail)>=7 && (strstr($getemail,"@")) && (strstr($getemail,"."))) {
                                require("./connect.php");
                                
                                $query = mysqli_query($connection, "SELECT * FROM users WHERE username = '$getuser' OR email = '$getemail';");
                                $code = md5(rand(1000,9999));

                                if( mysqli_num_rows($query) == 0 ){
                                    $password = md5(md5("Some1".$password."Salt2"));

                                    mysqli_query($connection, "INSERT INTO users(username, password, email, active, code)
                                                VALUES('$getuser', '$password', '$getemail', 0, '$code');");
                                    echo mysqli_error($connection);
                                    $query = mysqli_query($connection, "SELECT * FROM users WHERE username = '$getuser' OR email = '$getemail';");
                                    echo "mysqli_num_rows(query) = ";
                                    echo mysqli_num_rows($query);

                                    if( mysqli_num_rows($query) == 1 ){
                                        $site = "http://localhost:8080/php_membership";
                                        $webmaster = "Farhod <f.khurramov@gmail.com>";
                                        $headers = "From: $webmaster";
                                        $subject = "Activate your account";
                                        $message = "Please refer to the link below to activate your account.\n";
                                        $message .= "$site/activate.php?user=$getuser&code=$code";
                                        if(mail($getemail,$subject,$message,$headers)){
                                            $errormsg = "Activation email sent to $getemail";
                                            $getemail = "";
                                            $getuser = "";  
                                        }else{
                                            $errormsg = "Email send failed.";
                                        }
                                    }else{
                                        $errormsg = "Some error occured while registering your account.";                                    }
                                }else{
                                    echo "The user already registered";
                                }
                                mysqli_close($connection);
                            } else {
                                $errormsg = "You must enter a valid email to register";
                            }
                        } else {
                            $errormsg = "Your passwords do not match";
                        }
                    } else {
                        $errormsg = "You must retype your password to register";
                    }
                } else {
                    $errormsg = "You must enter your password to register";
                }
            }else{
                $errormsg = "You must enter your email to register";
            }
        }else{
            $errormsg = "You must enter your username to register";
        }
        
    }

    $form = "<form method = 'post' action = './register.php'>
    <table>
        <tr>
            <td></td>
            <td><font color='red'>$errormsg</font></td>
        </tr>
        <tr>
            <td>Username:</td>
            <td><input type = 'text' name = 'user' value = '$getuser'</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type = 'email' name = 'email' value = '$getemail'</td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type = 'password' name = 'password' value = ''</td>
        </tr>
        <tr>
            <td>Confirm password:</td>
            <td><input type = 'password' name = 'password_confirm' value = ''</td>
        </tr>
        <tr>
            <td></td>
            <td><input type = 'submit' name = 'submitbtn' value = 'Register'</td>
        </tr>
    </table>
    </form>";

    echo $form;     
    ?>
    
</body>