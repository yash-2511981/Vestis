<?php
session_start();
include 'db.php';

if (empty($_SESSION['user'])) {
    header('Location:login.php');
} else {
    
    if (!empty($_GET['pid'])) {
        $newquant = ($_POST['quantity'] <= 0) ? 1 : $_POST['quantity'];
        $size = $_POST['size'];
        if (!empty($newquant) && !empty($size)) {
            echo "hi";
    
            //updating the product quantity and size
            $updtquantity = $con->prepare("UPDATE cart set quantity=?,size=? WHERE pid = ? AND uid = ?");
            $updtquantity->bind_param("isii", $newquant, $size, $_GET['pid'],$_SESSION['uid']);


            if ($updtquantity->execute()) {
                header("Location:cart.php");
            } else {
                echo $updtquantity->error;
            }
        }
    }
}
