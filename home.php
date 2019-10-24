<!DOCTYPE html>
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
<html>
<head></head>
<body>
    <h1 class="alert alert-warning alert-dismissible fade show" role="alert">Welcome, <strong><?php echo $user; ?></strong><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div></h1>

    <?php
        //$command = escapeshellcmd('python webscraper.py');
        //shell_exec($command);
        $jsonn = readData('data.txt');
        $politico = $jsonn["politico"];
        for($i = 1; $i < sizeof($politico); $i++) {
            echo "<div>";
            echo "<a href='";
            echo $politico[$i]["link"];
            echo "'>Link</a>";
            echo "<div>";
            echo $politico[$i]["head"];
            echo "</div></div>";
        }
    ?>

    <form action="home.php" method="POST">
        <input name="logout" type="submit" value="logout"/>
    </form>
    <?php
        if(isset($_POST["logout"])) {
            $_SESSION["user"] = "invalid";
            header("Location: http://localhost/socialmediaapp/index.php");
        }
    ?>

    <form action="home.php" method="POST">
        <h3>Make a post</h3>
        <textarea name="post">Write your post here:</textarea>
        <input type="submit" value="Post!" name="submit2"/> 
    </form>
    <?php
        if(isset($_POST["submit2"])) {
            $post = stripper($_POST["post"]);
            submitPost($firebase, $user, $post);
        }
    ?>

    <h1>Your Posts:</h1>
    <?php
        $posts = getAllPosts($firebase, $user);
        if(!empty($posts)) {
            //print_r($posts);
            foreach($posts as $key => $value) {
                echo "Date: " . $value["date"];
                echo "<br/>Post: " . $value["post"];
                echo "<br/><br/>";//Plz css this

                $date = $value["date"];
                $Post = $value["post"];

            }
        } else {
            echo "You have no posts yet!";
        }
    ?>
