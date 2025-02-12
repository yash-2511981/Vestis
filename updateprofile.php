<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user']) || !isset($_SESSION['uid'])){
    header('location:login.php');
}else{
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $getprevdet = $con->prepare("SELECT * FROM user_info WHERE id = ?");
        $getprevdet->bind_param("i",$_SESSION['uid']);
        $getprevdet->execute();
        $res= $getprevdet->get_result();
        $row = $res->fetch_assoc();

        $name = !empty($_POST['name']) ? $_POST['name']:$row['name'];
        $email = !empty($_POST['email']) ? $_POST['email']:$row['email'];
        $password = !empty($_POST['pass']) ? $_POST['pass']:$row['password'];
        $contact = !empty($_POST['contact']) ? $_POST['contact']:$row['contact'];

        $updateuserdet = $con->prepare("UPDATE user_info SET name = ? , email = ? , password = ?, contact = ? WHERE id = ?");
        $updateuserdet->bind_param("sssii",$name,$email,$password,$contact,$_SESSION['uid']);

        if($updateuserdet->execute()){
            header("location:profile.php");
        }
    }
}
?>