<?Php
session_start();
include 'db.php';

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

        .profile {
            min-width: 300px;
        }

        .orders {
            height: auto;
            width: auto;
        }

        .orders .order {
            height: auto;
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

        .status .status-inside {
            display: flex;
            align-items: center;
            justify-content: start;
        }

        .status .status-img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            background-color: rgb(94, 208, 94);
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

        #date,
        #desc,
        #size,
        #payment {
            font-size: 13px;
        }

        .order .product {
            height: 110px;
            width: 100%;
            padding: 10px 25px;
            display: flex;
            justify-content: space-evenly;
        }

        a {
            text-decoration-line: none;
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

        .review div label {
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
            margin-top: 10px;
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
            <h1>Your Orders</h1>
    </header>

    <main>

    </main>
    <div class="container orders">

        <?php
        $fetchorder = $con->prepare("SELECT o.oid, o.size, o.order_date, o.delivery_date, o.exchangedate, p.img, p.description, b.name, s.state, ps.paystate 
                            FROM orders_info o
                            INNER JOIN product_info p ON o.pid = p.id 
                            INNER JOIN brands b ON p.brand = b.id
                            INNER JOIN status s ON o.order_status = s.sid
                            INNER JOIN paystatus ps ON o.pay_status = ps.id 
                            WHERE o.uid = ?");
        $fetchorder->bind_param("i", $_SESSION['uid']);
        if ($fetchorder->execute()) {
            $orders = $fetchorder->get_result();
            echo '<div class="row d-flex justify-content-between align-items-center g-2 my-5">'; // Start the first row

            if ($orders->num_rows > 0) {
                $count = 0;
                while ($row = $orders->fetch_assoc()) {

                    // Start a new form for each order
                    if ($row['state'] != 'delivered') {

                        // Each order inside a col-6 (half width) column
                        echo '    <div class="col-md-6 mb-4">'; // Use col-md-6 for two orders in one row
                        echo '      <form action="" method="post">';

                        echo '        <div class="order">';
                        echo '            <div class="status">';
                        echo '                <div class="status-inside">';
                        echo '                    <div class="status-img">';
                        echo '                        <img src="./images/projectImages/svg/cube.svg" alt="">';
                        echo '                    </div>';
                        echo '                    <div class="order-status">';
                        echo '                        <h6><b>Order is ' . $row['state'] . '</b></h6>';
                        echo '                        <span id="date">Expected Delivery till ' . $row['delivery_date'] . '</span>';
                        echo '                    </div>';
                        echo '                </div>';
                        if ($row['state'] !== "delivered") {
                            echo '                <div>';
                            echo '                    <a href="deleteorder.php?oid=' . $row['oid'] . '"><img src="./images/projectImages/svg/cancel.svg" alt="" id="cancel"></a>';
                            echo '                </div>';
                        }
                        echo '            </div>';

                        // Product information
                        echo '            <div class="product">';
                        echo '                <div class="pimg">';
                        echo '                    <img src="./admin/productsimages/' . $row['img'] . '" alt="" width="100px" height="100px" class="rounded">';
                        echo '                </div>';
                        echo '                <div class="pdetails">';
                        echo '                    <h6><b>' . $row['name'] . '</b></h6>';
                        echo '                    <span id="desc">' . $row['description'] . '</span>';
                        echo '                    <span id="size">' . $row['size'] . '</span>';
                        echo '                    <span id="payment">Payment is ' . $row['paystate'] . '</span>';
                        echo '                </div>';

                        if ($row['paystate'] == "done") {
                            echo '                <div class="invoice">';
                            echo '                    <a href="invoice.php?oid=' . $row['oid'] . '"><img src="./images/projectImages/svg/receipt.svg" alt=""></a>';
                            echo '                </div>';
                        }
                        echo '            </div>';

                        // Review section for delivered orders
                        if ($row['state'] == "delivered") {
                            echo '            <div class="review">';
                            echo '                <div>';
                            echo '                    <label for="review">Add Rating :</label>';
                            echo '                    <input type="number" name="review" id="review" min="1" max="5" step="1">';
                            echo '                </div>';
                            echo '                <a href="">';
                            echo '                    <h6><b>Add Review</b></h6>';
                            echo '                </a>';
                            echo '            </div>';
                        }

                        // Exchange/Refund info
                        echo '            <div class="exchange">';
                        echo '                <span>Exchange/Return is available till ' . $row['exchangedate'] . '</span>';
                        echo '                <a href="">';
                        echo '                    <h6><b>Exchange/Return</b></h6>';
                        echo '                </a>';
                        echo '            </div>';

                        echo '        </div>';
                        echo '      </form>';
                        echo '    </div>'; // Close the col-6 div

                        // Increase the counter
                        $count++;

                        // After every 2 items, close the current row and start a new one
                        if ($count % 2 == 0) {
                            echo '</div><div class="row justify-content-between align-items-center g-2 my-5">'; // Start a new row after 2 orders
                        }
                    }
                }
            }

            echo '</div>'; // Close the last row
        } else {
            echo $ordererror[] = $fetchorder->error;
        }
        ?>
    </div>
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