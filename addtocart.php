    <?php
    session_start();
    include 'db.php';

    if (empty($_SESSION['user'])) {
        header('Location:login.php');
    } else {

        if (!empty($_GET['id'])) {
            $fetchcart = $con->prepare("SELECT * FROM cart WHERE pid = ? AND uid=?");
            $fetchcart->bind_param("ii", $_GET['id'],$_SESSION['uid']);
            $fetchcart->execute();
            $res = $fetchcart->get_result();

            if ($res->num_rows > 0) {
                $item = $res->fetch_assoc();

                //if product is available with same size then update quantity
                if ($item['size'] == "M") {
                    $newquant = $item['quantity'] + 1;
                    $updtquantity = $con->prepare("UPDATE cart set quantity=? WHERE pid = ? AND uid = ?");
                    $updtquantity->bind_param("iii", $newquant, $_GET['id'],$_SESSION['uid']);


                    if ($updtquantity->execute()) {
                        header("Location:index.php");
                    } else {
                        echo $updtquantity->error;
                    }
                } else {
                    $insertItem = $con->prepare("INSERT INTO cart (pid,uid) VALUES (?,?)");
                    $insertItem->bind_param("ii", $_GET['id'],$_SESSION['uid']);
                    if ($insertItem->execute()) {
                        header("Location:index.php");
                    } else {
                        echo $updtquantity->error;
                    }
                }
            } else {
                //if there is no product is matched with given id then new product is inserted
                $insertItem = $con->prepare("INSERT INTO cart (pid,uid) VALUES (?,?)");
                $insertItem->bind_param("ii", $_GET['id'],$_SESSION['uid']);
                if ($insertItem->execute()) {
                    header("Location:index.php");
                } else {
                    echo $updtquantity->error;
                }
            }
        }
    }

    ?>