    <?php
    session_start();
    include 'db.php';

    if(empty($_SESSION['user'])){
        header('Location:login.php');
    }else{

        $tablename = $_SESSION['user']."_cart";
        $sql = $con->prepare("INSERT INTO `".$tablename."` VALUES (?)");
        $sql->bind_param("i",$_GET['id']);
        if($sql->execute()){
            header("location:index.php");
        }
    }

    ?>