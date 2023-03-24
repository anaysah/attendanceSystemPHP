<?php

$serverName = "localhost";
$DBusername = "root";
$DBpass = "";
$DBname = "attendancewebapp";

$myMail = "anaysah2003@gmail.com";

$conn = mysqli_connect($serverName,$DBusername,$DBpass,$DBname);

if(!$conn){
    die("connection failed". mysqli_connect_error());
}




