<?php
include "db.php";
session_start();

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit();
}else{
    $oid = $_GET['oid'];

    if(!empty($oid)){
        $deleteorder = $con->prepare("DELETE FROM orders_info WHERE oid= ?");
        $deleteorder->bind_param("i",$oid);
        if($deleteorder->execute()){
            header("location:orders.php");
        }
    }
}
?>