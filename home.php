<!DOCTYPE html>
<?php
include('firebase.php');
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
    <h1>Welcome <?php echo $user; ?></h1>

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
        <input type="submit" value="Trix it" name="submit2"/>//Change this plz
    </form>
    <?php
        if(isset($_POST["submit2"])) {
            $post = $_POST["post"];
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
            }
        } else {
            echo "You have no posts yet!";
        }
    ?>
</body>
</html>