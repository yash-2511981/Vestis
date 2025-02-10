<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if(!empty($_GET['pid'])){
    $deleteitem = $con->prepare("DELETE FROM cart WHERE pid = ? AND uid = ?");
    $deleteitem->bind_param('ii',$_GET['pid'],$_SESSION['uid']);
    
    if($deleteitem->execute()){
        header("Location:cart.php");
        $deleteitem->close();
    }else{
        echo $deleteitem->error;
    }



}
?>