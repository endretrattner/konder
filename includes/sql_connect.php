<?php

session_start();

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'konderbetyar');
define('KEPUTVONAL', $_SERVER['DOCUMENT_ROOT'] . '/konderbetyar/img/');
define('SECURE', 1);

//connect
$link = mysqli_connect("localhost", "root", "") or die(mysqli_errno($link));

//select db
$db = mysqli_select_db($link, "konderbetyar") or die(mysqli_errno($link));
if(!$link) {
    die("Sajnálom a csatlakozás sikertelen");
}

mysqli_set_charset($link, 'utf8');

require 'functions.php';

