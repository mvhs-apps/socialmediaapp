<!DOCTYPE html>
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
<html>
<head>
    <link href="posting.css" rel="stylesheet">
</head>
<body>
    <h1 class="alert alert-warning alert-dismissible fade show" role="alert">Welcome, <strong><?php echo $user; ?></strong><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div></h1>

    <form action="home.php" method="POST">
        <input name="logout" type="submit" value="logout"/>
    </form>
    <?php
        if(isset($_POST["logout"])) {
            $_SESSION["user"] = "invalid";
            header("Location: index.php");
        }
    ?>

    <form action="home.php" method="POST">
        <h3>New Post:</h3>
        <textarea name="post" placeholder="Post here:"></textarea>
        <input type="submit" value="Post!" name="submit2"/> 
    </form>
    <?php
        if(isset($_POST["submit2"])) {
            $post = $_POST["post"];
            submitPost($firebase, $user, $post);
        }
    ?>

    <h3>Your Posts:</h3>
    <div class="posting-container grid">
    <?php
        if(isset($_POST["remove"])) {
            $num = preg_replace('/[^0-9]/', '', $_POST["whichpost"]);
            removePost($firebase, $num, $user);
        }

        $posts = getAllPosts($firebase, $user);
        if(!empty($posts)) {
            //print_r($posts);
            foreach($posts as $key => $value) {

                $date = $value["date"];
                $Post = $value["post"];
                $Post = htmlentities($Post, ENT_QUOTES); // prevent html injection

                echo "
                    <div class='posting'>
                        <span>Posted $date</span>
                        <span class='posting-content'>$Post</span>
                        <form action='home.php' method='POST'>
                            <input type='hidden' name='whichpost' value='$key'/>
                            <input class='btn btn-danger btn-sm btn-block' type='submit' name='remove' value='Remove this post'/>
                        </form>
                    </div>
                ";

            }
        } else {
            echo "You have no posts yet!";
        }
    ?>
    </div>
