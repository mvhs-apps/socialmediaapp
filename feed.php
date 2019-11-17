<?php

function feed(&$firebase, $user){
    $posts = readData('data.txt');

    return $posts;
}
