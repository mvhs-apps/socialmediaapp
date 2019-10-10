<!DOCTYPE html>
<?php
include('firebase.php');
include_once('includes.php');
$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
session_start();
?>
<html>
<head>

</head>

<body>
    <form action="index.php" method="post">
        <h1>Register</h1>
        Username: <input type="text" name="username"/>
        Password: <input type="password" name="password"/>
        <input type="submit" name="submitReg"/>
    </form>
    <form action="index.php" method="post">
        <h1>Login</h1>
        Username: <input type="text" name="logusername"/>
        Password: <input type="password" name="logpassword"/>
        <input type="submit" name="submitLog"/>
    </form>
    <?php
        if(isset($_POST["submitReg"])) {
            $username = stripper($_POST["username"]);
            $password = stripper($_POST["password"]);
            if(!userExist($firebase, $username)) {
                createAccount($username, $password, genid(), $firebase);
                echo "Account Creation Successsful";
            }else {
                echo "Username Already Taken";
            }

        }

        if(isset($_POST["submitLog"])) {
            $username = stripper($_POST["logusername"]);
            $password = stripper($_POST["logpassword"]);
            if(!userExist($firebase, $username)) {
                echo "Login Failed: Username doesn't exist";
            }else {
                if(verifyPassword($firebase, $username, $password)) {
                    $_SESSION["user"] = $username;
                    header("Location: http://localhost/socialmediaapp/home.php");
                }else {
                    echo "Login Failed: Incorrect Password";
                }
            }
        }
    ?>
</body>
</html>