<!DOCTYPE html>
<?php
include('firebase.php');
include_once('includes.php');
$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
session_start();
if(!isset($_SESSION["user"])){
    $_SESSION["user"] = "invalid";
    header("Location: index.php");
}
$user = stripper($_SESSION["user"]);
if($user == "invalid" || $user == "" || isset($_POST["logout"])) {
    $_SESSION["user"] = "invalid";
    header("Location: index.php");
}
?>
<html>
    <head>
        <link href="general.css" rel="stylesheet">
        <link href="posting.css" rel="stylesheet">
    </head>
    <body>
        <?php 
            include('navbar.php');
        ?>
        <div class="content">
            <h3 class="full-width">News:</h3>
            <div class="posting-container grid">
            <?php
                if(isset($_POST["remove"])) {
                    $num = preg_replace('/[^0-9]/', '', $_POST["whichpost"]);
                    removePost($firebase, $num, $user);
                }

                include("posting.php");
                $posts = readData('data.json');
                sort($posts);
                if(!empty($posts)) {
                    foreach($posts as $key => $site){
                        postings($site, $user, $firebase);
                    }
                } else {
                    echo "You have no posts yet!<br>";
                    echo "Your posts will show up here";
                }
            ?>
            </div>
        </div>
    <body>
<html>