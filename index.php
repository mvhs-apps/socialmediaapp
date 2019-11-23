<!DOCTYPE html>
<?php
include('firebase.php');
include_once('includes.php');
$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
session_start();
if(isset($_POST["logout"])){
    $_SESSION["user"] = "invalid";
}
?>
<html>
    <head>
        <link href="general.css" rel="stylesheet">
    </head>
    <body>
        <?php 
            include('navbar.php');
        ?>
        <div class='content'>
        <form action="index.php" method="post">
        <h1 class="full-width">Register</h1>
        Username: <input type="text" name="username" required/>
        Display Name: <input type="text" name="displayName"/>
        Password: <input type="password" name="password"/>
        <input type="submit" name="submitReg"/>
    </form>
    <form action="index.php" method="post">
        <h1 class="full-width">Login</h1>
        Username: <input type="text" name="logusername"/>
        Password: <input type="password" name="logpassword"/>
        <input type="submit" name="submitLog"/>
    </form>
    
    <?php
        function showAlert($content, $type = "info"){
            echo "<h5 class=\"alert alert-$type alert-dismissible fade show\" role=\"alert\">$content<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></h5>";
        }
        if(isset($_POST["submitReg"])) {
            $username = stripper($_POST["username"]);
            $displayName = stripper($_POST["displayName"]);
            $password = stripper($_POST["password"]);
            if(!userExist($firebase, $username)) {
                $result = createAccount($username, $password, $displayName, $firebase);
                if(!empty($result)){
                    echo showAlert("Account Creation Successsful", "sucess");
                }else {
                    echo showAlert("Account Creation Failure", "danger");
                }
            }else {
                echo showAlert("Username Already Taken", "danger");
            }

        }

        if(isset($_POST["submitLog"])) {
            $username = stripper($_POST["logusername"]);
            $password = stripper($_POST["logpassword"]);
            if(!userExist($firebase, $username)) {
                echo showAlert("Login Failed: Username doesn't exist", "warning");
            }else {
                if(verifyPassword($firebase, $username, $password)) {
                    $_SESSION["user"] = $username;
                    header("Location: home.php");
                }else {
                    echo showAlert("Login Failed: Incorrect Password", "warning");
                }
            }
        }
    ?>
        </div>
    <body>
<html>