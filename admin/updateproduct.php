<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$err = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['pname'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];

    $charpat = '/^[a-zA-Z\s]+$/';
    $descpat = '/^[a-zA-Z0-9\s]{1,24}$/';
    $intpat = '/^\d+$/';

    if (!empty($name) && !empty($price) && !empty($desc) && !empty($category)&& !empty($brand) && isset($_FILES['pimg'])) {
        if (!preg_match($charpat, $name)) {
            $err[] = "Enter valid name";
        }

        if (!preg_match($descpat, $desc)) {
            $err[] = "Description should be less than 24 characters";
        }
        if (!preg_match($intpat, $category)) {
            $err[] = "Enter valid category";
        }
        if (!preg_match($intpat, $price)) {
            $err[] = "Enter valid price";
        }

        if (empty($err)) {
            if ($_FILES['pimg']['error'] == 0) {
                $upload_folder = 'productsImages/';
                $fname = $_FILES['pimg']['name'];
                $f_tmp = $_FILES['pimg']['tmp_name'];
                $f_size = $_FILES['pimg']['size'];

                $ext =  strtolower(pathinfo($fname, PATHINFO_EXTENSION));
                $allowedFile = ['jpg', 'jpeg', 'png'];

                if (in_array($ext, $allowedFile)) {
                    if ($f_size <= 5000000) {
                        $f_newname = uniqid('', true) . '.' . $ext;

                        if (move_uploaded_file($f_tmp, $upload_folder . $f_newname)) {
                            $sql = $con->prepare("INSERT INTO product_info(name,description,price,category,img,brand) VALUES (?,?,?,?,?,?)");
                            $sql->bind_param("ssiisi", $name, $desc, $price, $category, $f_newname,$brand);
                            if ($sql->execute()) {
                                header('Location:manageproduct.php');
                            } else {
                                $err[] = $sql->error;
                            }
                        } else {
                            $err[] = "failed to upload a file";
                        }
                    } else {
                        $err[] = "files size should be less than 5mb";
                    }
                } else {
                    $err[] = "Only jpg,png and jpeg files are allowed";
                }
            } else {
                $err[] = $_FILES['pimg']['error'];
            }
        }
    } else {
        $err[] = "All fields are required, name and desc should contain only character and price should contain only numbers";
    }
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
</head>

<style>
    .title {
        border-radius: 50px;
        height: 50px;
        width: 75%;
        margin: 15px 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: lightblue;
        box-shadow: 0 0 15px grey;
    }

    .product-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        border: none;
        box-shadow: 0 0 50px lightgrey;
        border-radius: 25px;
        height: 450px;
    }

    .product-form span{
        color: red;
        font-size: 12px;
        margin-bottom: 50px;
    }
</style>

<body>
    <?php
    include 'frame.php';
    ?>

    <div class="main-content">
        <div class="container">
            <div class="card product-form">
                <div class="title">
                    <h3>Update Product</h3>
                </div>
                <div class="card-body">
                    <?php
                        $query = $con->prepare("SELECT * FROM product_info WHERE id = ?");
                        $query->bind_param("s",$_GET['id']);
                        $product;
                        if($query->execute()){
                            $res = $query->get_result();
                            $product = $res->fetch_assoc();
                            
                        }else{
                            $err[] = $query->error;
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="form-floating mb-3 col-6">
                                <input type="text" class="form-control" name="pname" id="pname" value="<?php echo $product['name']; ?>"/>
                                <label for="pname">Product Name</label>
                            </div>
                            <div class="form-floating mb-3 col-6">
                                <input type="text" class="form-control" name="price" id="price" value="<?php echo $product['price'];?>"/>
                                <label for="price">Price</label>
                            </div>
                            <div class="form-floating mb-3 col-6">
                                <select class="form-control" name="category" id="category">
                                    <option value="">Select Category</option>
                                    <?php
                                    $sql = $con->prepare("SELECT * FROM category");
                                    if ($sql->execute()) {
                                        $res = $sql->get_result();
                                        while ($row = $res->fetch_assoc()) {
                                            echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-floating mb-3 col-6">
                                <select class="form-control" name="brand" id="brand">
                                    <option value="">Select Brand</option>
                                    <?php
                                    $sql = $con->prepare("SELECT * FROM brands");
                                    if ($sql->execute()) {
                                        $res = $sql->get_result();
                                        while ($row = $res->fetch_assoc()) {
                                            echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-floating mb-3 col-6">
                                <input type="file" class="form-control" name="pimg" id="pimg" accept="image/*"/>
                                <label for="pimg">Upload Image</label>
                            </div>
                            <div class="form-floating mb-3 col-6">
                                <input type="text" class="form-control" name="desc" id="desc" value="<?php echo $product['description']; ?>"/>
                                <label for="desc">Description</label>
                            </div>
                            <div class="form-floating mb-3 col-12 text-center ">
                                <button class="btn btn-outline btn-primary mx-2 px-5" type="submit">Update</button>
                                <button class="btn btn-outline btn-danger mx-2 px-5" type="reset">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                <span>
                    <?php
                    if (!empty($err)) {
                        foreach ($err as $msg) {
                            echo "<span>$msg</span>";
                            
                        }
                    }
                    ?>
                </span>
            </div>
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