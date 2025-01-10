    <?php
    session_start();
    include 'db.php';

    if (empty($_SESSION['user'])) {
        header('Location:login.php');
    } else {

        if (!empty($_GET['id'])) {
            $cartname = $_SESSION['user'] . "_cart";
            $fetchcart = $con->prepare("SELECT * FROM `" . $cartname . "` WHERE pid = ?");
            $fetchcart->bind_param("i", $_GET['id']);
            $fetchcart->execute();
            $res = $fetchcart->get_result();


            
            if ($res->num_rows > 0) {
                $item = $res->fetch_assoc();

                //if product is available with same size then update quantity
                if ($item['size'] == "M") {
                    $newquant = $item['quantity']+1;
                    $updtquantity = $con->prepare("UPDATE `" . $cartname . "` set quantity=? WHERE pid = ?");
                    $updtquantity->bind_param("ii", $newquant, $_GET['id']);


                    if ($updtquantity->execute()) {
                        header("Location:index.php");
                    } else {
                        echo $updtquantity->error;
                    }
                }
            } else {
                $insertItem = $con->prepare("INSERT INTO `" . $cartname . "` (pid) VALUES (?)");
                $insertItem->bind_param("i", $_GET['id']);
                if ($insertItem->execute()) {
                    header("Location:index.php");
                } else {
                    echo $updtquantity->error;
                }
            }
        }
    }

    ?>