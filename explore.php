<?php
include('firebase.php');
include('navbar.php');
include_once('includes.php');
$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
session_start();
$user = stripper($_SESSION["user"]);
if($user == "invalid" || !isset($user) || $user == "") {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="explore.css" rel="stylesheet">
</head>
<body>

<div class='px-2 card-grid'>
<?php
//$command = escapeshellcmd('python webscraper.py');
//shell_exec($command);
            $jsonn = readData('data.json');
            foreach($jsonn as $site => $list){
                echo "<h2 class='m-2 my-3 full-width'>" . ucwords($site) . "</h2>";
                foreach($list as $item){
                    $link = $item["link"];
                    echo "<!-- Card -->
                    <div class='card'>

            <!-- Card image -->
            <div class='view overlay'>
                <img class='card-img-top' src='https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg' alt='Card image cap'>
                <a href='$link'>
            <div class='mask rgba-white-slight'></div>
                </a>
            </div>

            <!-- Card content -->
            <div class='card-body'>

            <!-- Title -->
            <a href='$link'><h4 class='card-title'>
            {$item["head"]}
            </a></h4></div>

        </div>
        <!-- Card -->";
    }
}
?>

</div>

<body>

</html>