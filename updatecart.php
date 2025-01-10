<?php
session_start();
include 'db.php';

if (empty($_SESSION['user'])) {
    header('Location:login.php');
} else {

    if (!empty($_GET['pid'])) {
        if (!empty($_POST['size']) || !empty($_POST['quantity'])) {
            $cartname = $_SESSION['user'] . "_cart";
            $fetchcart = $con->prepare("SELECT * FROM `" . $cartname . "` WHERE pid = ?");
            $fetchcart->bind_param("i", $_GET['pid']);
            $fetchcart->execute();
            $res = $fetchcart->get_result();

            if ($res->num_rows > 0) {
                $item = $res ->fetch_assoc();
                
                //updating the product quantity and size
                if (!empty($_POST['quantity'] && !empty($_POST['size']))) {
                    $newquant = $_POST['quantity'];
                    $updtquantity = $con->prepare("UPDATE `" . $cartname . "` set quantity=?,size=? WHERE pid = ?");
                    $updtquantity->bind_param("isi",$newquant,$_POST['size'],$_GET['pid']);
                    

                    if($updtquantity->execute()){
                        header("Location:cart.php");
                    }else{
                        echo $updtquantity->error;
                    }
                }
            }
        }
    }
}
