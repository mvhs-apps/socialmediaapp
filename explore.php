<?php
include('firebase.php');
include('navbar.php');
include_once('includes.php');
$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
session_start();
$user = stripper($_SESSION["user"]);
if($user == "invalid") {
    header("Location: http://localhost/socialmediaapp/index.php");
}
?>

<!DOCTYPE html>
<html>
<head></head>
<body>

<?php
//$command = escapeshellcmd('python webscraper.py');
//shell_exec($command);
$jsonn = readData('data.txt');
$politico = $jsonn["politico"];
for($i = 1; $i < sizeof($politico); $i++) {
    $link = $politico[$i]["link"];
    echo "<!-- Card -->
    <div class=\"card\">

    <!-- Card image -->
    <div class=\"view overlay\">
        <img class=\"card-img-top\" src=\"https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg\" alt=\"Card image cap\">
        <a href='$link'>
    <div class=\"mask rgba-white-slight\"></div>
        </a>
    </div>

    <!-- Card content -->
    <div class=\"card-body\">

    <!-- Title -->
    <a href='$link'><h4 class=\"card-title\">";
    echo $politico[$i]["head"];
    echo "</a></h4></div>

</div>
<!-- Card -->";
}
?>
<body>

</html>