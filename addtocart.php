<?php
session_start();
include 'db.php';

if(empty($_SESSION['user'])){
    header('Location:login.php');
}else{

    $sql = $con->prepare("INSERT INTO cart(pid) VALUES (?)");
    $sql->bind_param("i",$_GET['id']);
    if($sql->execute()){
        header("location:index.php");
    }
}

?>


