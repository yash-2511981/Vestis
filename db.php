<?php

$server = 'localhost';
$username = 'root';
$pass = '';
$dbname = 'vestis';

$con = mysqli_connect($server,$username,$pass,$dbname);
if(!$con){
    die("Connection Failed".mysqli_connect_error());
}

?>
