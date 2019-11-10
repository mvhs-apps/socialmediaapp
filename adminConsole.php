<?php
include('firebase.php');
include('navbar.php');
include_once('includes.php');
$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
session_start();
$user = stripper($_SESSION["user"]);
if($user != "admin") {
    header("Location: hom6e.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="general.css" rel="stylesheet">
</head>
<body>
<head>
    <link href="posting.css" rel="stylesheet">
</head>
<?php
$users = getAllLogins($firebase);
foreach($users as $k => $v) {
    echo "<h3 class='full-width'>\"$k\" Posts:</h3>
    <div class=\"posting-container grid\">";
    $posts = getAllPosts($firebase, $k);
    if(!empty($posts)) {
        foreach($posts as $key => $value) {

            $date = $value["date"];
            $Post = $value["post"];

            echo "
                    <div class='posting'>
                        <span>Posted $date</span>
                        <span class='posting-content'>$Post</span>
                        <form action='home.php' method='POST'>
                            <input type='hidden' name='whichpost' value='$key'/>
                            <input type='hidden' name='whichuser' value='$k'/>
                            <input type='submit' name='remove' value='Remove this post'/>
                        </form>
                    </div>
                ";

        }
    } else {
        echo "No Posts!";
    }
    if(isset($_POST["remove"])) {
        $num = preg_replace('/[^0-9]/', '', $_POST["whichpost"]);
        $user = preg_replace('/[^0-9]/', '', $_POST["whichuser"]);
        removePost($firebase, $num, $user);
    }
}
?>
</body>
</html>
