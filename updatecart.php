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
            $cartname = $_SESSION['user'] . "_cart";


            //updating the product quantity and size
            $updtquantity = $con->prepare("UPDATE `" . $cartname . "` set quantity=?,size=? WHERE pid = ?");
            $updtquantity->bind_param("isi", $newquant, $size, $_GET['pid']);


            if ($updtquantity->execute()) {
                header("Location:cart.php");
            } else {
                echo $updtquantity->error;
            }
        }
    }
}
