<?php
include '../db.php';

if(!empty($_GET['id'])){
    $sql = $con->prepare("DELETE FROM product_info WHERE id = ?");
    $sql->bind_param('i',$_GET['id']);
    if($sql->execute()){
        header('Location:manageproduct.php');
    }else{
        echo $sql->error;
    }
}else{
    echo $_GET['id'];
}
?>