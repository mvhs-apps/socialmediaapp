<?php
include_once('includes.php');

function stripper($string ){//is nosql injection a thing? Do we need this? A little overzealous ==> no spaces or punctuation
    $res = preg_replace("/[^a-zA-Z ]/", "", $string);
    return $res;
}

function createAccount($username, $password, $userid, &$firebase) {
    // https://www.php.net/manual/en/function.password-hash.php
    if(empty($username)){
        return null;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo $hash;
    $user = [
        'username' => $username,
        'password' => $hash,
        'userid' => $userid
    ];
    $firebase->set('Logins/' . $username, $user);
    return $user;
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
    $hash = strval(
            $firebase->get('Logins/' . $username . '/password'));
    $hash = trim($hash, '"');
    if(stripper($hash) == $password && password_needs_rehash($hash, PASSWORD_DEFAULT)){ // if pasword is stored as plaintext
        $firebase->set("Logins/$username/password", password_hash($password, PASSWORD_DEFAULT));
        return true;
    }

    if(password_verify(strval($password), $hash)) {
        if(password_needs_rehash($hash, PASSWORD_DEFAULT)){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $firebase->set("Logins/$username/password", $hash); // update password if the cost is too low ==> too easy to break
        }
        return true;
    }else {
        return false;
    }
}

function getCurrentDate() {
    return date("d-m-y h:i A");
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

function removePost(&$firebase, $num, $user) {
    $firebase->delete("Posts/$user/$num");
}

function readData($file) {
    $json = fopen($file, "r") or die("Unable to open file!");
    return json_decode(fread($json,filesize('data.txt')), true);
}