<?Php
session_start();
include './db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Orders</title>
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Oswald:wght@200..700&family=Rubik+Vinyl&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Varela+Round&display=swap');

        body {
            background-color: rgb(38, 38, 38);
            overflow-x: hidden;
            box-sizing: border-box;
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
            background-image: url("./images/projectImages/nvbg2.jpg");
            height: 330px;
            background-size: cover;
            background-position: center 20%;
        }

        .header h1 {
            text-align: center;
            color: white;
            font-weight: bolder;
            font-size: 50px;
            font-family: 'Rubik Vinyl', cursive;
        }


        .dropdown-menu {
            min-width: 100px;
            /* Optional: control the width */
            padding: 5px 0;
        }

        .orders {
            height: 550px;
            width: auto;
            
        }

        .orders .order {
            height: 280px;
            width: 85%;
            border-radius: 15px;
            background-color: #282828;
            box-shadow: 0px 0px 50px black;
        }

        .order .status {
            height: 60px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border-radius: 15px 15px 0 0;
        }

        .status .status-inside{
            display: flex;
            align-items: center;
            justify-content: start;
        }

        .status .status-img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            background-color:rgb(94, 208, 94);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status .order-status {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            margin-left: 5px;
        }

        .order-status h6 {
            margin: 0;
        }

        .order .product {
            height: 110px;
            width: 100%;
            padding: 10px;
            display: flex;
            justify-content: space-evenly;
        }

        a {
            text-decoration-line: none;
        }

        .order .product .pimg {
            height: 100px;
            width: 100px;
            border-radius: 10px;
        }

        .order .product .pdetails {
            display: flex;
            flex-direction: column;
            margin-left: 10px;
            width: 78%;
            height: 100%;
        }

        .order .product .pdetails h6,
        p,
        span {
            margin: 1px 0;
            color: darkgrey;
        }

        .invoice {
            height: 100%;
            display: flex;
            align-items: end;
        }

        .invoice a {
            text-decoration-line: none;
            color: red;
        }

        .invoice #bill {
            visibility: hidden;
            opacity: 0;
        }

        .order .review {
            height: 50px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .review div input {
            height: auto;
            width: 50px;
            border-radius: 10px;
            border: 1px solid green;
            text-align: center;
        }

        .review div label{
            color: darkgrey;
        }

        .order .exchange {
            height: 60px;
            width: 100%;
            border-radius: 0 0 15px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
        }
    </style>

</head>

<body>
    <header>
        <div class="header">
            <nav class="navbar navbar-expand-sm navbar-dark ">
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
            <h1>Your Orders</h1>
    </header>

    <main>

    </main>
    <div class="container orders">
        <form action="">
            <div class="row justify-content-between align-items-center g-2 my-5">
                <div class="col-6 m-0">
                    <div class="order">
                        <div class="status">
                            <div class="status-inside">
                                <div class="status-img">
                                    <img src="./images/projectImages/svg/cart.svg" alt="">
                                </div>
                                <div class="order-status">
                                    <h6 id=""><b>Delivered</b></h6>
                                    <span id="date">on, Thu, 15 Dec</span>
                                </div>
                            </div>
                            <div>
                                <a href=""><img src="./images/projectImages/svg/cancel.svg" alt="" id="cancel"></a>
                            </div>
                        </div>
                        <div class="product">
                            <div class="pimg">
                                <img src="" alt="" width="100px">
                            </div>
                            <div class="pdetails">
                                <h6><b>BRAND</b></h6>
                                <span>DESCRIPTION</span>
                                <span>size</span>
                                <span>prize</span>
                            </div>
                            <div class="invoice">
                                <a href=""><img src="./images/projectImages/svg/receipt.svg" alt=""></a>
                            </div>
                        </div>
                        <div class="review">
                            <div>
                                <label for="review">Add Rating :</label>
                                <input type="number" name="review" id="review" min="1" max="5" step="1">
                            </div>

                            <a href="">
                                <h6><b>Add Review</b></h6>
                            </a>
                        </div>
                        <div class="exchange">
                            <span>Exchange/Return is available till thu,22 Dec</span>
                            <a href="">
                                <h6><b>Exchange/Refund</b></h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <footer>
        <?php
        include 'footer.html';
        ?>
    </footer>
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