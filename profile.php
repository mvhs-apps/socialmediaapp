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
        <div class="content">
            <?php 
                if(isSet($_POST["displayName"])){
                    $data = [
                        "displayName" => stripper($_POST["displayName"])
                    ];
                    $firebase->update('Logins/' . $user , $data);
                }
                $userData = getUserData($firebase, $user);
            ?>
            <form class="full-width py-2" action='profile.php' method='POST'>
                <h3>Update Your Profile:</h3>
                Display Name:<br/>
                <input type="text" name="displayName" value="<?php echo $userData["displayName"] ?>" />
                <input class='btn btn-primary btn-sm btn-block' type='submit' name='update' value='Save'/>
            </form>
            <h3 class="full-width">Your Posts:</h3>
            <div class="posting-container grid">
            <?php
                if(isset($_POST["remove"])) {
                    $num = preg_replace('/[^0-9]/', '', $_POST["whichpost"]);
                    removePost($firebase, $num, $user);
                }

                include("posting.php");

                $posts = getAllPosts($firebase, $user);
                postings($posts, $user, $firebase);
                if(empty($posts)){
                    echo "You have no posts yet!<br>";
                    echo "Your posts will show up here";
                }
            ?>
            </div>
        </div>
    <body>
<html>