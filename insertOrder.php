<?php
session_start();
include 'db.php';
if (empty($_SESSION['user'])) {
    header('Location:login.php');
} else {
    $date = new DateTime('now');
    $orderdate = $date->format("D, d M");
    
    $deliverydate = (clone $date)->modify('+7 days');
    $exchangedate = (clone $date)->modify('+14 days');

    $deliverydate = $deliverydate->format("D, d M");
    $exchangedate = $exchangedate->format("D, d M");

    $finalOrders = $_SESSION['updatedorders'];
    $count = 0;
    foreach ($finalOrders as &$order) {
        $insertorder = $con->prepare("INSERT INTO orders_info(uid,pid,quantity,size,amt,email,contact,address,pincode,order_status,pay_meth,pay_status,order_date,delivery_date,exchangedate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $insertorder->bind_param("iiisisisiisisss", $order['uid'], $order['pid'], $order['quantity'], $order['size'], $order['amt'], $order['email'], $order['contact'], $order['address'], $order['pincode'], $order['order_status'], $order['paymeth'], $order['paystatus'], $orderdate, $deliverydate,$exchangedate);
        $insertorder->execute();
        $insertorder->close();
        $count++;
    }

    if (count($finalOrders) == $count) {
        $emptycart = $con->prepare("DELETE FROM cart WHERE uid = ?");
        $emptycart->bind_param('i',$_SESSION['uid']);
        if ($emptycart->execute()) {
            header("location:orders.php");
        }
    }
}
?>
