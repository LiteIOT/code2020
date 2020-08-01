<?php
session_start();
$_SESSION["user_name"] = NULL;
$_SESSION["user_pass"] = NULL;

$url = "login.html";
if (isset($url)) {
  Header("HTTP/1.1 303 See Other");
  Header("Location: $url");
}
