<?php
include_once('includes.php');

function stripper($string ){
    $res = preg_replace("/[^a-zA-Z]/", "", $string);
    return $res;
}

function createAccount($username, $password, $userid, &$firebase) {
    $user = [
        'username' => $username,
        'password' => $password,
        'userid' => $userid
    ];
    print_r($user);
    $firebase->set('Logins/' . $username, $user);
}

function getAllLogins(&$firebase) {
    return json_decode($firebase->get('Logins'), true);
}

function userExist(&$firebase, $username) {
    $logins = getAllLogins($firebase);
    foreach($logins as $key => $value) {
        //print_r($key);
        if($username == strval($key)) {
            return true;
        }
    }
    return false;
}

function genUserid() {
    return ((date('H')+9)*(date('s')+4)*7);
}

function verifyPassword(&$firebase, $username, $password) {
    if(stripper(strval($firebase->get('Logins/' . $username . '/password'))) == strval($password)) {
        return true;
    }else {
        return false;
    }
}