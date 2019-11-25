<?php

function feed(&$firebase, $user){
    $posts = [];

    $yourPosts = getAllPosts($firebase, $user);
    if(!empty($yourPosts)){
        foreach($yourPosts as $key => $value){
            $posts[$key] = $value;
        }
    }

    $users = getAllLogins($firebase);
    $otherPeoplesPosts = [];
    foreach($users as $value){
        $username = readByKey("username", $value);
        if($username == $user){
            continue;
        }
        $otherUserPosts = getAllPosts($firebase, $username);
        if(empty($otherUserPosts)){
            continue;
        }
        foreach($otherUserPosts as $post){
            if(rand(1, 100) > 75){
                $otherPeoplesPosts[] = $post;
            }
        }
    }
    #echo json_encode($otherPeoplesPosts);
    foreach($otherPeoplesPosts as $key => $value){
        $posts[] = $value;
    }
    

    $news = readData('data.json');
    foreach($news as $key => $entry){
        foreach($entry as $key => $value){
            $posts[] = $value;
        }
    }
    #echo json_encode($newsFlatter);


    return $posts;
}

