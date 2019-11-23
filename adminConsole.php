<?php
include('firebase.php');
include('navbar.php');
include_once('includes.php');
$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
session_start();
$user = stripper($_SESSION["user"]);
if($user != "admin") {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="general.css" rel="stylesheet">
    <link href="posting.css" rel="stylesheet">
</head>
<body>
<div class="content">
<div class="posting-container grid">
<?php
if(isset($_POST["remove"])) {
    $num = preg_replace('/[^0-9]/', '', $_POST["whichpost"]);
    $user = preg_replace('/[^0-9]/', '', $_POST["whichuser"]);
    removePost($firebase, $num, $user);
}
include("posting.php");
$users = getAllLogins($firebase);
foreach($users as $k => $v) {
    echo "<h3 class='full-width'>\"$k\" posts:</h3>";
    $posts = getAllPosts($firebase, $k);
    postings($posts, $k, $firebase);
    if(empty($posts)){
        echo "This user has no posts";
    }
    
}
?>
</div>
</div>
</body>
</html>
