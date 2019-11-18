<?php

function feed(&$firebase, $user){
    $posts = [];

    $yourPosts = getAllPosts($firebase, $user);
    foreach($yourPosts as $key => $value){
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
