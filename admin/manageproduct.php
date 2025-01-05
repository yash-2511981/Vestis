<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$err = [];
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/style1.css">
    <style>
        .manage-product .container {
            height: 500px;
            display: flex;
            flex-direction: column;
        }

        .new {
            margin: 15px 0;
            align-self: flex-end;
        }

        .product-img img{
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <?php
    include 'frame.php';
    ?>

    <div class="main-content manage-product">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Manage Products
                </div>
                <div class="card-body users">
                    <h5 class="card-title">All Products</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Category</th>
                                <th scope="col">Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $con->prepare("SELECT * FROM product_info");
                            if ($sql->execute()) {
                                $res = $sql->get_result();
                                while ($row = $res->fetch_assoc()) {
                                    echo "<tr>
                                                <td>" . $row['id'] . "</td>
                                                <td>" . $row['name'] . "</td>
                                                <td>" . $row['description'] . "</td>
                                                <td>" . $row['price'] . "</td>
                                                <td>" . $row['category'] . "</td>
                                                <td>
                                                <div class='product-img'>
                                                        <img src='./productsImages/".$row['img']."' alt='image' height='80px' width='80px'>
                                                </div>
                                                
                                                </td>
                                                <td>
                                                    <a href='updateproduct.php?id={$row['id']}' class='tool'>
                                                    <img src='../images/projectImages/svg/update.svg' alt='update' height='24' width='24'>
                                                    <span class='tool-name'>edit</span>
                                                    </a>
                                                    
                                                    <a href='deleteproduct.php?id={$row['id']}' class='tool'>
                                                    <img src='../images/projectImages/svg/delete.svg' alt='delete' height='' width=''>
                                                    <span class='tool-name'>delete</span>
                                                    </a>
                                                </td>       
                                         </tr>";
                                }
                            } else {
                                $err[] = $sql->error;
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <a href="insertproduct.php" class="new">
                <button class="btn btn-outline-dark btn-primary">Add Product</button>
            </a>
        </div>
    </div>
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>