<?php
session_start();
include 'db.php';
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
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
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            overflow-x: hidden;
            background-color: rgb(38, 38, 38);
        }

        .userlogo button {
            height: 60px;
            width: 60px;
            background: transparent;
            border: none;
        }

        .userlogo ul {
            width: auto;
            height: auto;
        }

        .header {
            position: relative;
            height: 500px;
            width: auto;
        }

        .header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            background-image: url("images/projectImages/nvbg2.jpg");
            background-size: cover;
            z-index: -1;

        }

        .header h1 {
            text-align: center;
            color: white;
            margin-top: 100px;
            font-weight: bolder;
            font-size: 50px;
            font-family: 'Rubik Vinyl', cursive;
        }

        .dropdown-menu {
            min-width: 100px;
            /* Optional: control the width */
            padding: 5px 0;
        }

        .main h1 {
            font-weight: bolder;
            text-align: center;
            margin: 15px 0;
            color: darkgrey;
            text-shadow: 3px 3px 5px grey;
        }

        .products {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
        }

        .main .product {
            height: 330px;
            width: 240px;
            border: none;
            text-align: start;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 15px;
            background-color: transparent;
            word-wrap: break-word;
        }

        .product img {
            border-radius: 15px;
            height: 250px;
            width: 230px;
            box-shadow: 0 0 60px black;

        }

        .product span {
            color: darkgrey;
        }

        .product #pname {
            font-weight: bolder;
            font-size: 17px;
            margin: 20px 0 1px 5px;
        }

        #pname #desc {
            font-size: 13px;
            font-weight: normal;
            margin: 1px 0 4px 5px;
        }

        .product #price {
            font-weight: bold;
            font-size: 15px;
            margin: 1px 0 1px 5px;
        }

        #cart {
            position: relative;
            height: 50px;
            width: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 10px;
        }

        #cartlogo {
            height: 38px;
            width: 38px;
        }

        #cart-count {
            position: absolute;
            top: 37%;
            /* Adjust to bring it closer to the corner */
            right: 23%;
            /* Adjust to bring it closer to the corner */
            height: 22px;
            /* Adjust size of the count badge */
            width: 22px;
            /* Adjust size of the count badge */
            background-color: transparent;
            /* Green color for the badge */
            border-radius: 50%;
            /* Circular badge */
            color: white;
            /* White text color */
            font-size: 12px;
            /* Font size to fit inside the badge */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <header>
        <div class="header">
            <nav class="navbar navbar-expand-sm navbar-dark">
                <a class="navbar-brand mx-5" href="index.php"><img src="images/projectImages/logo.png"
                        class="img-fluid rounded" alt="" height="60px" width="60px" /></a>
                <div class="container mx-0">
                    <div class="collapse navbar-collapse" id="collapsibleNavId">
                        <ul class="navbar-nav me-auto mt-2 mt-lg-0 g-3">
                            <li class="nav-item m-2">
                                <a class="nav-link active" href="index.php" aria-current="page">Home
                                    <span class="visually-hidden">(current)</span></a>
                            </li>
                            <li class="nav-item dropdown m-2">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Categories</a>';
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownId">
                                    <?php
                                    $sql = $con->prepare("SELECT * FROM category");
                                    $categories;
                                    if ($sql->execute()) {
                                        $categories = $sql->get_result();
                                        while ($row = $categories->fetch_assoc()) {
                                            echo "<a class='dropdown-item' href='?category=".$row['name']."'>" . $row['name'] . "</a>";
                                        }
                                    }
                                    ?>
                                </div>
                            </li>
                            <li class="nav-item dropdown m-2">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Brands</a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownId">
                                    <?php
                                    $sql = $con->prepare("SELECT * FROM brands");
                                    if ($sql->execute()) {
                                        $res = $sql->get_result();
                                        while ($row = $res->fetch_assoc()) {
                                            echo "<a class='dropdown-item' href='?brand_name=".$row['name']."'>".$row['name']."</a>";
                                        }
                                    }
                                    ?>
                                </div>
                            </li>
                        </ul>
                        <form class="d-flex my-2 my-lg-0">
                            <input class="form-control me-sm-2" type="text" placeholder="Search" />
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                                Search
                            </button>
                        </form>
                    </div>
                </div>
                <?php
                    if (isset($_SESSION['user'])) {
                        $sql = $con->prepare("SELECT COUNT(*) AS count FROM cart");
                        $sql->execute();
                        $res =$sql->get_result();
                        $cartItem = $res->fetch_assoc();

                        echo '<a href="cart.php" id="cart"><span id="cart-count">'.$cartItem['count'].'</span><img src="./images/projectImages/svg/cart.svg" alt="" id="cartlogo"></a>';
                    }
                ?>
                <div class="dropdown userlogo">
                    <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="images/projectImages/user.png" alt="" height="35px" width="35px">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <?php
                        if (isset($_SESSION['user'])) {
                            $username = $_SESSION['user'];
                            echo "<li><a class='dropdown-item' href='profile.php'>$username</a></li>";
                            echo "<li><a class='dropdown-item' href='logout.php'>LogOut</a></li>";
                        } else {
                            echo "<li><a class='dropdown-item' href='login.php'>Sign In</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </nav>

            <h1>Elevate Your Style with Vestis!</h1>
        </div>
    </header>
    <main>
        <div class="container container-fluid  main">
            <h1>Best Deals Of The Week</h1>

            <div class="container products my-5">
                <?php
                
                $fetchbrand = isset($_GET['brand_name']) ? $_GET['brand_name'] : null;
                
                $fetchcategory = isset($_GET['category']) ? $_GET['category'] : null;
                
                $sqlquery = "SELECT * FROM product_info LIMIT 8";

                $res = $con->query($sql);

                $count = 0;
                echo '<div class="row justify-content-center align-items-center g-1 my-5">';
                if ($res->num_rows > 0) {

                    while ($row = $res->fetch_assoc()) {
                        echo '<div class="col-12 col-sm-6 col-md-3 my-1">';
                        echo '<div class="card product">';
                        echo '<img class="card-img-top" src="./admin/productsimages/' . $row['img'] . '" alt="Title" />';
                        echo '<span id="pname">' . $row['name'] . '<span id="desc">(' . $row['description'] . ')</span></span>';
                        echo '<span id="price">Rs.' . $row['price'] . '</span>';
                        echo '<div class="container text-center">';
                        echo '<a href="addtocart.php?id=' . $row['id'] . '"><button class="btn btn-dark btn-outline-success">Add to Cart</button></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        $count++;

                        if ($count % 4 == 0) {
                            echo '</div><div class="row justify-content-center align-items-center g-2 my-5">';
                        }
                    }
                } else {
                    echo "no product found";
                }

                echo '</div>';

                ?>
            </div>
        </div>
    </main>

    <?php
    include 'footer.html';
    ?>
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