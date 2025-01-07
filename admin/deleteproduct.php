<?php
include '../db.php';

if (!empty($_GET['id'])) {
    $sql = $con->prepare("SELECT * FROM product_info WHERE id = ?");
    $sql->bind_param('i', $_GET['id']);
    if ($sql->execute()) {
        $res = $sql->get_result();
        $data = $res->fetch_assoc();

        if (!empty($data)) {
            $img = $data['img'];

            if (file_exists('./productsimages/' . $img)) {
                unlink('./productsimages/' . $img);

                $deleteSql = $con->prepare("DELETE FROM product_info WHERE id = ?");
                $deleteSql->bind_param('i', $_GET['id']);
                $deleteSql->execute();
            }
        }

        header('Location: manageproduct.php');
    } else {
        echo $sql->error;
    }
} else {
    echo $_GET['id'];
}
?>