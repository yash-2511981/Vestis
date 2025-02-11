<?php
include 'db.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('locatio:profile.php');
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">

    <style>
        .user-det {
            height: auto;
            width: 800px;

        }

        .profile{
            border-radius: 10px 10px 10px 10px;
            transition: border-radius 0.3s ease;
            background-color: black;
            color: lightgrey;
        }

        .update {
            border-radius: 10px;
            transition: opacity 0.2s ease,max-height 0.5s ease;
            max-height: 0;
            opacity: 0;
        }

        .update-active{
            max-height: 500px;
            opacity: 1;
        }

        .update label {
            color: lightgrey;
        }

        .update input {
            width: 80%;
            border: none;
            border-bottom: 2px solid #ccc;
            background-color: transparent;
            color: lightgrey;
            font-size: 15px;
            outline: none;
            margin-bottom: 15px;
        }

        .update input:focus {
            border-bottom-color: #4A90E2;
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
                    $sql = $con->prepare("SELECT COUNT(*) AS count FROM cart WHERE uid = ?");
                    $sql->bind_param('i', $_SESSION['uid']);
                    $sql->execute();
                    $res = $sql->get_result();
                    $cartItem = $res->fetch_assoc();

                    echo '<a href="cart.php" id="cart"><span id="cart-count">' . $cartItem['count'] . '</span><img src="./images/projectImages/svg/cart.svg" alt="" id="cartlogo"></a>';
                }
                ?>
                <div class="dropdown userlogo">
                    <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="images/projectImages/user.png" alt="" height="35px" width="35px">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end profile">
                        <?php
                        if (isset($_SESSION['user'])) {
                            $username = $_SESSION['user'];

                            echo "<h4 class='text-center'>Welcome $username !</h4>";
                            echo "<li><a class='dropdown-item' href='profile.php'>Profile</a></li>";
                            echo "<li><a class='dropdown-item' href='orders.php'>Orders</a></li>";
                            echo "<li><a class='dropdown-item' href='logout.php'>LogOut</a></li>";
                        } else {
                            echo "<li><a class='dropdown-item' href='login.php'>Sign In</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </nav>

            <h1>Your Profile!</h1>
        </div>
    </header>
    <main>
        <div lass="container">

            <!-- profile summary -->
            <div class="row justify-content-center align-items-center my-5">
                <div class="col-9 card d-flex flex-row align-items-center justify-content-between profile">
                    <div class="card-header d-flex flex-row align-items-center">
                        <div class="profilepic">
                            <img src="./images/projectImages/logo1.png" alt="" class="image rounded-circle bordered" height="70px" width="70px">
                        </div>
                        <div class="name ms-3 d-flex flex-column align-items-start">
                            <p class="m-1"><b>Hi!</b> Yash</p>
                        </div>
                    </div>
                    <div class="toggle-update-btn ms-3 mb-1">
                        <img src="./images/projectImages/svg/down.svg" alt="" height="40 px" id="down">
                    </div>
                </div>

                <!-- form for update profile -->
                <div class="update col-9 d-flex flex-column bg-black">
                    <form method="post">
                        <div class="row justify-content-between align-items-center g-2 my-2 ">
                            <div class="col-6 d-flex flex-column align-items-start">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email">
                            </div>
                            <div class="col-6 d-flex flex-column align-items-start">
                                <label for="contact">Contact No:</label>
                                <input type="text" name="contact" id="contact">
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-auto">
                            <button id="update-profile" class="btn btn-outline-success m-3">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded',()=>{
                    const profile =document.querySelector('.profile');
                    const updatewnd =document.querySelector('.update');
                    const dropdown =document.getElementById('down');

                    dropdown.addEventListener('click',()=>{
                        profile.classList.toggle('profile-update');
                        updatewnd.classList.toggle('update-active');

                        if(updatewnd.classList.contains('update-active')){
                            dropdown.src = "./images/projectImages/svg/up.svg"
                        }else{
                            dropdown.src = "./images/projectImages/svg/down.svg"
                        }
                    })
                })
            </script>

            <!-- purchased histroy -->
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-12 ">

                </div>
            </div>

        </div>
    </main>
    <footer>
        <?php
        include 'footer.html';
        ?>
    </footer>
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