<?php
session_start();

define('HOST', 'localhost');
define("USER",'root');
define('PASSWORD', '');
define('DATABASE','login_singnup_php');

$conn=new mysqli(HOST,USER,PASSWORD,DATABASE);


if ($conn->connect_error) {
    echo 'could not connect to  db';
    die();
}