<?php
include_once('includes.php');

function stripper($string ){//is nosql injection a thing? Do we need this? A little overzealous ==> no spaces or punctuation
    $res = preg_replace("/[^a-zA-Z ]/", "", $string);
    return $res;
}

function createAccount($username, $password, $userid, &$firebase) {
    $user = [
        'username' => $username,
        'password' => $password,
        'userid' => $userid
    ];
    $firebase->set('Logins/' . $username, $user);
}

function getAllLogins(&$firebase) {
    return json_decode($firebase->get('Logins'), true);
}

function userExist(&$firebase, $username) {
    $logins = getAllLogins($firebase);
    foreach($logins as $key => $value) {
        if($username == strval($key)) {
            return true;
        }
    }
    return false;
}

function genid() {
    return ((date('H')+9)*(date('s')+4)*7);
}

function verifyPassword(&$firebase, $username, $password) {
    if(stripper(strval($firebase->get('Logins/' . $username . '/password'))) == strval($password)) {
        return true;
    }else {
        return false;
    }
}

function getCurrentDate() {
    return date("d-m-Y H-i-s");
}

function submitPost(&$firebase, $username, $post) {
    $fpost = [
        'username' => $username,
        'post' => $post,
        'date' => getCurrentDate()
    ];
    $firebase->set('Posts/' . $username . '/' . genid(), $fpost);
}

function getAllPosts(&$firebase, $user) {
    return json_decode($firebase->get('Posts/' . $user), true);
}