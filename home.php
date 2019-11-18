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
        <link href="posting.css" rel="stylesheet">
        <link href="general.css" rel="stylesheet">
    </head>
    <body>
        <?php 
            include('navbar.php');
        ?>
        <h4 class="alert alert-info alert-dismissible fade show" role="alert">
            Welcome, <strong><?php echo getUserData($firebase, $user)["displayName"]; ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </h4>
        <div class="content">

            <form action="home.php" method="POST">
                <h3 class="full-width">New Post:</h3>
                <textarea class="full-width" name="post" placeholder="Post here:"></textarea>
                <input class='butt btn btn-primary btn-sm btn-block' type="submit" value="Post!" name="submit"/> 
            </form>
            <?php
                if(isset($_POST["submit"])) {
                    $post = $_POST["post"];
                    submitPost($firebase, $user, $post);
                }
            ?>

            <h3 class="full-width">Your Posts:</h3>
            <div class="posting-container grid">
            <?php
                if(isset($_POST["remove"])) {
                    $num = preg_replace('/[^0-9]/', '', $_POST["whichpost"]);
                    removePost($firebase, $num, $user);
                }

                include("feed.php");
                include("posting.php");

                $posts = feed($firebase, $user);
                #echo json_encode($posts);
                postings($posts, $user, $firebase);
                if(empty($posts)){
                    echo "Your feed is empty";
                }
            ?>
            </div>
        </div>
    <body>
<html>