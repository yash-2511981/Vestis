<?Php
session_start();
include './db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$carterros = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['place_order']) && (!empty($_POST['address']) && strlen($_POST['address']) > 25) && !empty($_POST['pincode'])) {
        if (isset($_POST['checkout'])) {

            $neworders = $_SESSION['orders'];
            $paystatus = ($_POST['paymode'] == 'onlinepay') ? 5 : 1;
            foreach ($neworders as &$order) {
                $order['uid'] = $_SESSION['uid'];
                $order['email'] = $_SESSION['uemail'];
                $order['contact'] = $_SESSION['ucontact'];
                $order['address'] = $_POST['address'];
                $order['order_status'] = 3;
                $order['paymeth'] = $_POST['paymode'];
                $order['paystatus'] = $paystatus;
                $order['pincode'] = $_POST['pincode'];
            }

            $_SESSION['updatedorders'] = $neworders;
            if ($_POST['paymode'] == 'onlinepay') {
                header("location:insertOrder.php");
            }

            if ($_POST['paymode'] == 'cod') {
                header('location:insertOrder.php');
            }
        }
    } else {
        $carterros[] = "address and pincode should not be empty and address should be more than 50 char";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Cart</title>
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
    <link rel="stylesheet" href="./css/cart.css">

    <style>
        .custom-shadow {
            height: 230px;
            border-radius: 25px;
            box-shadow: 0px 0px 50px black;
        }

        .profile {
            min-width: 300px;
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

            <h1>Your Cart!</h1>
        </div>
    </header>
    <main>
        <div class="container my-5 cart">
            <?php
            $carttotal = 0;
            $orders = [];
            $sql = "SELECT p.*,c.pid,c.quantity,c.size FROM product_info p JOIN cart c ON p.id = c.pid WHERE uid = ?";
            $cartitems = $con->prepare($sql);
            $cartitems->bind_param('i', $_SESSION['uid']);
            $cartitems->execute();
            $res = $cartitems->get_result();

            echo '<div class="row justify-content-start align-items-center g-3 my-5">';
            if ($res->num_rows > 0) {
                $count = 0;

                while ($row = $res->fetch_assoc()) {
                    echo '<div class="cart-item col-12 m-3">';

                    echo    '<div class="product">';
                    echo        '<img src="./admin/productsimages/' . $row['img'] . '" alt="Product Image" class="img-fluid" width="150">';
                    echo        '<div class="pinfo">';
                    echo            '<div class="name-desc">';
                    echo                '<p id="pname">' . $row['name'] . '';
                    echo                '<p id="desc">(' . $row['description'] . ')</p>';
                    echo                '<p id="price" name="price">Price : ' . $row['price'] . '</p> </p>';
                    echo             '</div>';
                    echo        '</div>';
                    echo    '</div>';

                    echo    '<div class="cal-total">';
                    echo        '<form method="post" action="updatecart.php?pid=' . $row['pid'] . '">';
                    echo            '<label for="quantity">Quantity :</label>';
                    echo            '<input type="number" name="quantity" id="quantity" class="styled-input" value="' . $row['quantity'] . '">';
                    echo            '<label for="size">Size :</label>';
                    echo            '<select name="size" id="size" class="styled-select">';

                    //trying to select the size dynamically
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                    foreach ($sizes as $size) {
                        $selected = ($row['size'] == $size) ? 'selected' : '';
                        echo '<option value = "' . $size . '" ' . $selected . '>' . $size . '</>';
                    }
                    echo            '</select>';
                    echo            '<button type="submit" class="btn btn-sm btn-dark btn-outline-success">Update</button>';
                    echo        '</form>';
                    $total = $row['price'] * $row['quantity'];
                    $carttotal += $total;
                    echo        '<div>';
                    echo            '<p id="total">Total : ' . $total . '</p>';
                    echo            '<a href="removefromcart.php?pid=' . $row['id'] . '"><img src="./images/projectImages/svg/delete.svg" alt="" id="remove"></a>';
                    echo        '</div>';
                    echo    '</div>';

                    //using array to save the details of each product in array to process it on the order page to place order
                    $orders[] = [
                        "uid" => 0,
                        "pid" => $row['pid'],
                        "quantity" => $row['quantity'],
                        "size" => $row['size'],
                        "amt" => ($total += $total * 0.10),
                        "email" => null,
                        "contact" => null,
                        "address" => null,
                        "order_status" => null,
                        "paymeth" => null,
                        "paystatus" => null,
                        "pincode" => 000000
                    ];
                    echo  '</div>';
                    $count++;

                    if ($count % 3 == 0) {
                        echo '</div><div class="row justify-content-start align-items-center g-1 my-5">';
                    }
                }

                $getaddress = $con->prepare("SELECT address,pincode,oid FROM orders_info WHERE uid = ? ORDER BY oid DESC LIMIT 1");
                $getaddress->bind_param("i", $_SESSION['uid']);
                $getaddress->execute();
                $address = $getaddress->get_result();
                $add = $address->fetch_assoc();
                $previousaddress = !empty($add['address']) ? $add['address'] : "";
                $previouspin = !empty($add['pincode']) ? $add['pincode'] : "";
                //create the form for final checkout to place the order
                echo '<form method="post">';
                echo '  <input type="hidden" name="place_order" value="1">';
                echo '    <div class="row d-flex align-items-center justify-content-between my-5 mx-0 g-3 p-3 ">';
                echo '        <div class="col-8 d-flex flex-column p-3 custom-shadow mx-1">';
                echo '            <div class="col-12 col-md-8 mb-3">';
                echo '                <div class="form-floating">';
                echo '                    <textarea name="address" id="address" class="form-control styled-input" style="height: 100px;width:700px">' . $previousaddress . '</textarea>';
                echo '                    <label for="address">Address:</label>';
                echo '                </div>';
                echo '            </div>';
                echo '            <div class="col-12 col-md-4 mb-3 d-flex justify-content-around align-items-center">';
                echo '                <div class="form-floating">';
                echo '                    <input type="number" name="pincode" id="pincode" class="form-control styled-input" style="height: 40px;width:200px" value="' . $previouspin . '">';
                echo '                    <label for="pincode">Pincode:</label>';
                echo '                </div>';
                echo '                <div class="mx-5">';
                echo '                    <h5 class="text-white">Payment Options</h5>';
                echo '                </div>';
                echo '                <h1 class="text-white">:</h1>';
                echo '                <div class="d-flex align-items-center g-5 mx-5">';
                echo '                    <div class="form-check mx-3">';
                echo '                        <input class="form-check-input" type="radio" name="paymode" id="online" value="onlinepay" checked/>';
                echo '                        <label class="form-check-label text-white" for="online">Online</label>';
                echo '                    </div>';
                echo '                    <div class="form-check mx-3">';
                echo '                        <input class="form-check-input" type="radio" name="paymode" id="cod" value="cod" />';
                echo '                        <label class="form-check-label text-white" for="cod">COD</label>';
                echo '                    </div>';
                echo '                </div>';
                echo '            </div>';
                if (!empty($carterros)) {
                    foreach ($carterros as $err) {
                        echo '            <span class="text-danger text-center my-4 ">' . $err . '!</span>,';
                    }
                }
                echo '        </div>';

                echo '        <!-- Total Price and Checkout Button -->';
                echo '        <div class="col-3 d-flex flex-column align-items-center justify-content-evenly container custom-shadow mx-1">';
                echo '            <div class="mb-3">';
                echo '                <h6 class="text-danger fw-bold">CartTotal : <span class="text-success">' . $carttotal . '</span></h6>';
                echo '                <h6 class="text-danger fw-bold">Gst : <span class="text-success">';
                $gst = 0.10;
                $gst *= $carttotal;
                echo $gst;
                echo '                </span></h6>';
                $total = $gst + $carttotal;
                echo '                <h6 class="text-danger fw-bold">Total : <span class="text-success">' . $total  . '</span></h6>';
                echo '            </div>';
                echo '            <div class="mt-3">';
                echo '                <button type="submit" name="checkout" class="btn btn-dark btn-outline-success">Proceed to Checkout</button>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</form>';
            } else {
                //if there is no cart item present in the cart
                echo '<div class="container my-5 text-center p-5">';
                echo    '<h1 class="text-white">Oops! cart is empty.<img src="images/projectImages/svg/dissatisfied.svg" alt="sad face" height="60px" width="60px"></h1>';
                echo    '<a href="index.php"><button type="submit" name="continueshopping" class="btn btn-dark btn-outline-success btn-lg">Add New Product </button></a>';
                echo '</div>';
            }
            echo '</div>';

            //saving array in session to use in order page
            $_SESSION['orders'] = $orders;
            ?>
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