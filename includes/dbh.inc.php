<?php

$serverName = "localhost";
$DBusername = "root";
$DBpass = "";
$DBname = "authSystem";

$conn = mysqli_connect($serverName,$DBusername,$DBpass,$DBname);

if(!$conn){
    die("connection failed". mysqli_connect_error());
}




