<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$err = [];

$username = $name = $email = $mob = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['uname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mob = $_POST['contact'];


    $namepat = '/^[a-zA-Z\s]+$/';
    $usernamepat = '/^[a-zA-Z0-9_]{3,15}$/';
    $emailpat = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';
    $mobpat = '/^\d{10}$/';


    if (preg_match($usernamepat, $username)) {
        $sql = $con->prepare("SELECT username FROM user_info WHERE id = ?");
        $sql->bind_param("i", $_GET['id']);
        if ($sql->execute()) {
            $res = $sql->get_result();
            $user = $res->fetch_assoc();
            if ($user['username'] != $username) {
                $query = $con->prepare("SELECT username FROM user_info");
                if ($query->execute()) {
                    $res = $query->get_result();
                    $usernames = $res->fetch_all();
                    if (in_array($username, $usernames)) {
                        $err[] = "username is not available";
                    }
                } else {
                    $err[] = $query->error;
                }
            }
        }
    } else {
        $err[] = "please enter a valid username";
    }

    if (strlen($name) < 0 || !preg_match($namepat, $name)) {
        $err[] = "Name should contain only character";
    }

    if (!preg_match($emailpat, $email)) {
        $err[] = "please enter a valid email";
    }

    if (!preg_match($mobpat, $mob)) {
        $err[] = "Mobile no contain only digit and it should be less than 10";
    }

    if (empty($err)) {
        $sql = $con->prepare("UPDATE user_info SET username=?,name=?,email=?,contact=? WHERE id = ?");
        $sql->bind_param("ssssi", $username, $name, $email, $mob, $_GET['id']);
        if (!$sql->execute()) {
            $err[] = $sql->error;
        } else {
            $username = '';
            $name = '';
            $mob = '';
            $email = '';

            header("Location:usermanagement.php");
        }
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

        .user-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: none;
            box-shadow: 0 0 50px lightgrey;
            border-radius: 25px;
            height: 400px;
        }

        .user-form span {
            color: red;
            font-size: 12px;
            margin-bottom: 50px;
        }
    </style>
    </style>
</head>

<body>
    <?php
    include 'frame.php';
    ?>

    <div class="main-content">
        <div class="container">
            <div class="card user-form">
                <div class="title">
                    <h3>Update User</h3>
                </div>
                <div class="card-body">
                    <?php
                    $query = $con->prepare("SELECT * FROM user_info WHERE id = ?");
                    $query->bind_param("s", $_GET['id']);
                    $user;
                    if ($query->execute()) {
                        $res = $query->get_result();
                        $user = $res->fetch_assoc();
                    } else {
                        $err[] = $query->error;
                    }
                    ?>
                    <form action="" method="post" class="register">
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="form-floating mb-3 col-6">
                                <input type="text" class="form-control" name="uname" id="uname" value="<?php echo $user['username']; ?>" />
                                <label for="uname">Username</label>
                            </div>
                            <div class="form-floating mb-3 col-6">
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $user['name']; ?>" />
                                <label for="name">Name</label>
                            </div>
                            <div class="form-floating mb-3 col-6">
                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $user['email']; ?>" />
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3 col-6">
                                <input type="text" class="form-control" name="contact" id="contact" value="<?php echo $user['contact']; ?>" />
                                <label for="contact">Contact</label>
                            </div>
                            <div class="form-floating mb-3 col-12 text-center">
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