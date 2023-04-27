<?php

$serverName = "localhost";
$DBusername = "root";
$DBpass = "";
$DBname = "attendancewebapp";
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'];
$websiteUrl = $protocol . $domain;

$myMail = "anaysah2003@gmail.com";

$conn = mysqli_connect($serverName,$DBusername,$DBpass,$DBname);

if(!$conn){
    die("connection failed". mysqli_connect_error());
}




