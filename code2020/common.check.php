<?php

session_start();

function check_login()
{
    $Server = "127.0.0.1";
    $database = "xidian2020";
    $uid = "root";
    $pwd = "root";
    $table = "user";
    $link = mysqli_connect($Server, $uid, $pwd, $database);

    @$username = trim($_SESSION['user_name']);
    @$userpass = trim($_SESSION['user_pass']);

    if (strlen($username) == 0 || strlen($userpass) == 0) {
        return 0;
    }

    $sql = "SELECT * FROM $table where user_name=$username";

    $data = mysqli_query($link, $sql);

    if ($data === false) {
        die(print_r(mysqli_error($link), true));
    } else {
        $i = 0;
        $row = mysqli_fetch_array($data, MYSQLI_ASSOC);

        if ($row === NULL) {

            return 0;
        } else {
            $user_pass = $row['user_pass'];
            $user_name = $row['user_name'];

            if (($user_pass == $userpass) && ($user_name == $username)) {
                return 1;
            } else {
                return 0;
            }
            //print_r($row_req);       
        }
    }
}

if (check_login() == 0) {

    $url = "login.html";
    if (isset($url)) {
        Header("HTTP/1.1 303 See Other");
        Header("Location: $url");
    }

    die(0);
} else {
    //222

}
