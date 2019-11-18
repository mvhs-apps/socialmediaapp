<?php

function postings($posts, $user, &$firebase){
    sort($posts);
    if(!empty($posts)) {
        //print_r($posts);
        foreach($posts as $key => $value) {
            # -- get fields from post --
            $image = readByKey("image", $value, "https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg");

            $date = readByKey("date", $value);
            
            $Post = readByKey("body", $value);
            $Post = htmlentities($Post, ENT_QUOTES); // prevent html injection

            $username = readByKey("user", $value);

            $title = readByKey("head", $value);
            
            $link = readByKey("link", $value);

            $data = getUserData($firebase, $username);

            $displayName = readByKey("displayName", $data);
            
            # -- logic to change the markdown --
            $userUrl = "#";
            if($username == $user){
                $userUrl = "profile.php";
            }

            $userText = "by <a href='$userUrl'>$displayName</a>";
            if(empty($displayName)){
                $userText = "";
            }
            $dateText = " <wbr>on $date";
            if(empty($date)){
                $dateText = "";
            }
            $postedText = "Posted $userText $dateText";
            if(!$username && !$date){
                $postedText = "";
            }

            $deleteForm = "<form class='remove' action='home.php' method='POST'>
                <input type='hidden' name='whichpost' value='$key'/>
                <input class='butt btn btn-danger btn-sm btn-block' type='submit' name='remove' value='Remove this post'/>
            </form>";
            if($username != $user){
                $deleteForm = "";
            }

            echo "

                <div class='posting'>
                    <img class='posting-image' src='$image'/>
                    <div class='posting-body'>
                        <a href='$link'>
                            <h4>$title</h4>
                        </a>
                        <span>$postedText</span>
                        <a href='$link'>
                            <span class='posting-content'>$Post</span>
                        </a>
                    </div>
                    <div class='footer'>
                        <div class='footer-content'>
                            $deleteForm
                        </div>
                    </div>
                </div>
            ";

        }
    }
}