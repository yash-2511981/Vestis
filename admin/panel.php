<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
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
        .title {
            border-radius: 50px;
            height: 50px;
            width: 95%;
            margin: 15px 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: lightblue;
            box-shadow: 0 0 15px grey;
        }

        .stats {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: none;
            border-radius: 25px;
            height: 450px;
        }
    </style>
</head>

<body>
    <?php
    include 'frame.php';
    ?>
    <div class="main-content">
        <div class="container">

            <!-- Example Dashboard Card -->
            <div class="card mb-3 stats">
                <div class="title">
                    <h2 class="card-title">Dashboard</h2>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col">
                            <div class="stat-card">

                                <p class="card-text">Users</p>
                                <div>
                                    <img src="../images/projectImages/svg/man.svg" alt="Title" height="50px" width="70px" />
                                    <?php
                                    $sql = $con->prepare("SELECT COUNT(*) AS total_users FROM user_info");
                                    if ($sql->execute()) {
                                        $res = $sql->get_result();
                                        $usercount = $res->fetch_assoc();

                                        echo "<span>" . $usercount['total_users'] . "</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="stat-card">

                                <p class="card-text">Categories</p>
                                <div>
                                    <img src="../images/projectImages/svg/category.svg" alt="Title" height="40px" width="40px" />
                                    <?php
                                    $sql = $con->prepare("SELECT COUNT(*) AS total_users FROM user_info");
                                    if ($sql->execute()) {
                                        $res = $sql->get_result();
                                        $usercount = $res->fetch_assoc();

                                        echo "<span>" . $usercount['total_users'] . "</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="stat-card">

                                <p class="card-text">Product</p>
                                <div>
                                    <img src="../images/projectImages/svg/inventory.svg" alt="Title" height="40px" width="40px" />
                                    <?php
                                    $sql = $con->prepare("SELECT COUNT(*) AS total_users FROM user_info");
                                    if ($sql->execute()) {
                                        $res = $sql->get_result();
                                        $usercount = $res->fetch_assoc();

                                        echo "<span>" . $usercount['total_users'] . "</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="stat-card">

                                <p class="card-text">Orders</p>
                                <div>
                                    <img src="../images/projectImages/svg/orders.svg" alt="Title" height="40px" width="40px" />
                                    <?php
                                    $sql = $con->prepare("SELECT COUNT(*) AS total_users FROM user_info");
                                    if ($sql->execute()) {
                                        $res = $sql->get_result();
                                        $usercount = $res->fetch_assoc();

                                        echo "<span>" . $usercount['total_users'] . "</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
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