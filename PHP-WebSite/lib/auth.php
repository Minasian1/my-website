<?php

$login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

$password = md5($password."abc");

$mysqli = new mysqli("localhost", "root", "", "php-website");

$result = $mysqli->query("SELECT * FROM `users` WHERE `login`='$login' AND `password`='$password'");

$user = $result->fetch_assoc();
if(!$user){
    echo "Username or password is incorrect";
    exit();
}
$mysqli->close();

header('Location: /MyFirstProject/PHP-WebSite/index.php');
