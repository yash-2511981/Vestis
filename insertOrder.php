<?php
session_start();
include 'db.php';
if (empty($_SESSION['user'])) {
    header('Location:login.php');
} else {
    $date = new DateTime('now');
    $orderdate = $date->format("D, d M");
    
    $deliverydate = $date->modify('+7 days');
    $exchangedate = $deliverydate->modify('+7 days');

    $deliverydate = $deliverydate->format("D, d M");
    $exchangedate = $exchangedate->format("D, d M");

    $finalOrders = $_SESSION['updatedorders'];
    $count = 0;
    foreach ($finalOrders as &$order) {
        $insertorder = $con->prepare("INSERT INTO orders_info(uid,pid,quantity,size,amt,email,contact,address,pincode,order_status,pay_meth,pay_status,order_date,delivery_date,exchangedate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $insertorder->bind_param("iiisisisiisiss", $order['uid'], $order['pid'], $order['quantity'], $order['size'], $order['amt'], $order['email'], $order['contact'], $order['address'], $order['pincode'], $order['order_status'], $order['paymeth'], $order['paystatus'], $orderdate, $deliverydate,$exchangedate);
        $insertorder->execute();
        $insertorder->close();
        $count++;
    }

    if (count($finalOrders) == $count) {
        $emptycart = $con->prepare("TRUNCATE TABLE `" . $_SESSION['user'] . "_cart`");
        if ($emptycart->execute()) {
            header("location:orders.php");
        }
    }
}
?>
