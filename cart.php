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
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/cart.css">
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
            <h1>Shopping Cart</h1>
    </header>
    <main>
        <div class="container my-5 cart">
            <?php
            $carttotal = 0;
            $cartname = $_SESSION['user'] . "_cart";
            $orders = [];
            $sql = "SELECT p.*,c.pid,c.quantity,c.size FROM product_info p JOIN `" . $cartname . "` c ON p.id = c.pid";
            $cartitems = $con->prepare($sql);
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
                        "id" => $row['pid'],
                        "quant" => $row['quantity'],
                        "size" => $row['size'],
                        "amt" => $total,
                        "uid" => $_SESSION['uid'],
                        "email" => $_SESSION['uemail'],
                        "contact" => $_SESSION['ucontact'],
                        "Address" => null,
                        "payment" => 1
                    ];
                    echo  '</div>';
                    $count++;

                    if ($count % 3 == 0) {
                        echo '</div><div class="row justify-content-start align-items-center g-1 my-5">';
                    }
                }

                //create the container which will provide the address to select if user ordered something before otherwise give option to insert the address

            }else {
            //if there is no cart item present in the cart
                echo "<h1 class='text-white'>Oops! cart is empty</h1>";

            }
            echo '</div>';

            //saving array in session to use in order page
            $_SESSION['orders'] = $orders;
            ?>


            <!-- Cart Summary -->
            <div class="row align-items-center justify-content-between">
                <div class="col-4 text-start mx-5">
                    <h4 class="text-white">Total :<?php echo $carttotal ?></h4>
                </div>
                <div class="col-4 text-end">
                    <a href="insertOrder.php"><button class="btn btn-dark btn-outline-success">Proceed to Checkout</button></a>
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