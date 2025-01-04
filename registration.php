<?php
include 'db.php';

$error = [];
$username = $name = $email = $pass = $mob = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $mob = $_POST['mobile'];


    $namepat = '/^[a-zA-Z\s]+$/';
    $usernamepat = '/^[a-zA-Z0-9_]{3,15}$/';
    $emailpat = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';
    $passpat = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    $mobpat = '/^\d{10}$/';


    if (preg_match($usernamepat, $username)) {
        $sql = $con->prepare("SELECT * FROM user_info WHERE username = ?");
        $sql->bind_param("s", $username);
        if ($sql->execute()) {
            $res = $sql->get_result();
            if ($res->num_rows > 0) {
                $error[] = "username is not available";
            }
        }
    } else {
        $error[] = "please enter a valid username";
    }

    if (strlen($name) < 0 || !preg_match($namepat, $name)) {
        $error[] = "Name should contain only character";
    }

    if (!preg_match($emailpat, $email)) {
        $error[] = "please enter a valid email";
    }

    if (!preg_match($passpat, $pass)) {
        $error[] = "Yash@123 password should be this type";
    }

    if (!preg_match($mobpat, $mob)) {
        $error[] = "Mobile no contain only digit and it should be less than 10";
    }

    if (empty($error)) {
        $sql = $con->prepare("INSERT INTO user_info(username,name,email,contact,password) VALUES (?,?,?,?,?)");
        $sql->bind_param("sssss", $username, $name, $email, $mob, $pass);
        if (!$sql->execute()) {
            $error[] = $sql->error;
        } else {
            $username = '';
            $name = '';
            $mob = '';
            $email = '';
            $pass = '';

            header("Location:login.php");
            exit();
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title> </title>
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
        .userlogo {
            margin-right: 35px;
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

        .dropdown-menu {
            min-width: 90px;
            /* Optional: control the width */
            padding: 5px 0;
        }

        body {
            background-image: url("images/projectImages/nvbg.jpg");
        }

        .registration-form {
            width: 600px;
            height: 550px;
            border: 2px solid black;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
        }

        .registration-form h2 {
            margin: 15px 0;
        }

        .registration-form span {
            margin-top: 5px;
            color: red;
            font-weight: lighter;
            font-size: small;
            width: 100%;
            text-wrap: wrap;
            text-align: center;
        }

        .register {
            width: 500px;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-items: center;
            margin: 0px 5px;
        }

        .register .buttons {
            display: flex;
            justify-content: center;
        }

        .buttons button {
            background: #121212;
            margin: 0 15px;
            height: auto;
            width: 100px;
            color: white;
        }

        .buttons button:hover {
            background-color: #28a745;
        }
    </style>
</head>

<body>
    <header>
        <div class="header bg-dark">
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                <a class="navbar-brand mx-5" href="home.php"><img src="images/projectImages/logo.png"
                        class="img-fluid rounded" alt="" height="60px" width="60px" /></a>
                <div class="container mx-0">
                    <div class="collapse navbar-collapse" id="collapsibleNavId">
                        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                            <li class="nav-item">
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
                <div class="dropdown userlogo">
                    <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="images/projectImages/user.png" alt="" height="35px" width="35px">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
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
        </div>
    </header>
    <main>
        <div class="container my-5 registration-form bg-dark">
            <h2>Registration Form</h2>

            <form action="" method="post" class="register">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" />
                    <label for="username">username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" />
                    <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" />
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="pass" name="pass" />
                    <label for="pass">Set Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="mobile" name="mobile" />
                    <label for="mobile">Contact No</label>
                </div>
                <div class="buttons">
                    <button type="submit" class="btn" name="submit">Submit</button>
                    <button type="reset" class="btn">Reset</button>
                </div>
            </form>
            <span>
                <?php
                if (!empty($error)) {
                    foreach ($error as $msg) {
                        echo " <span id='warning-msg'>$msg</span>,";
                    }
                }
                ?>
            </span>
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