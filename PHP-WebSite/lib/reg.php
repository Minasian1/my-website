<?php

$login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

$mysqli = new mysqli("localhost", "root", "", "php-website");


if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
}

$password = md5($password."abc");

$mysqli->query("INSERT INTO `users` (`login`, `username`, `email`, `password`) 
               VALUES ('$login', '$username', '$email', '$password')");

$mysqli->close();

header('Location: /MyFirstProject/PHP-WebSite/index.php');
