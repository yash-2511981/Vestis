<?php
include '../db.php';

if(!empty($_GET['id'])){

    //trying to find the username which will help us to find the cart of the user in database
    $query = $con->prepare("SELECT username FROM user_info WHERE id = ?");
    $query->bind_param('i',$_GET['id']);
    $query->execute();
    $query->bind_result($username);
    $query->fetch();
    $query->close();

    //cart name
    $tablename = $username."_cart";

    //deleting cart of the user from the database cause we are deleting the user so we might dont need it
    $deletetable = $con->prepare("DROP TABLE`" . $tablename . "`");
    $deletetable->execute();

    $sql = $con->prepare("DELETE FROM user_info WHERE id = ?");
    $sql->bind_param('i',$_GET['id']);
    if($sql->execute()){
        header('Location:usermanagement.php');
    }else{
        echo $sql->error;
    }
}else{
    echo $_GET['id'];
}
?>