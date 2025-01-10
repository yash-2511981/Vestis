<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if(!empty($_GET['pid'])){
    $tablename = $_SESSION['user']."_cart";
    $deleteitem = $con->prepare("DELETE FROM `".$tablename."` WHERE pid = ?");
    $deleteitem->bind_param('i',$_GET['pid']);
    
    if($deleteitem->execute()){
        header("Location:cart.php");
        $deleteitem->close();
    }else{
        echo $deleteitem->error;
    }



}
?>