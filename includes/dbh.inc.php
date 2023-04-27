<?php

$serverName = "sql305.epizy.com";
$DBusername = "epiz_34090101";
$DBpass = "sWsB9KNCkFod1";
$DBname = "epiz_34090101_attendancewebapp";

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'];
$websiteUrl = $protocol . $domain;

$myMail = "anaysah2003@gmail.com";

$conn = mysqli_connect($serverName,$DBusername,$DBpass,$DBname);

if(!$conn){
    die("connection failed". mysqli_connect_error());
}




