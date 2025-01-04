<?php
session_start();
include 'db.php';
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
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            overflow-x: hidden;
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
        }

        .main .product {
            height: 300;
            width: 230px;
            border: none;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product img {
            border-radius: 15px;
            height: 230px;
            width: 180px;

        }


        /* css for footer */
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
                        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="home.php" aria-current="page">Home
                                    <span class="visually-hidden">(current)</span></a>
                            </li>
                            <?php
                            if (isset($_SESSION['user'])) {
                                echo '<li class="nav-item">
                                <a class="nav-link" href=""></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Categories</a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownId">
                                    <a class="dropdown-item" href="#">Kids</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Brands</a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownId">
                                    <a class="dropdown-item" href="#">Nike</a>
                                </div>
                            </li>';
                            }
                            ?>
                        </ul>
                        <form class="d-flex my-2 my-lg-0">
                            <input class="form-control me-sm-2" type="text" placeholder="Search" />
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                                Search
                            </button>
                        </form>
                    </div>
                </div>
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
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-12 col-sm-6 col-md-3 m-3">
                        <div class="card product">
                            <img class="card-img-top" src="images/projectImages/nvbg.jpg" alt="Title" />

                            <h4 class="card-title">Productname</h4>
                            <p class="card-text">Price</p>
                            <a href="addtocart.php"><button class="btn btn-primary">Add to Cart</button></a>
                        </div>
                    </div>
                </div>
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