<?php
session_start();

include '../db.php';

$error = [];
$username = $pass = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    if (!empty($username) && !empty($pass)) {
        $sql = $con->prepare("SELECT * FROM admin WHERE username = ?");
        $sql->bind_param("s", $username);
        if ($sql->execute()) {
            $res = $sql->get_result()->fetch_assoc();
            $_SESSION['user'] = $res['username'];
            if ($username == $res['username'] && $pass == $res['password']) {
                header('Location:panel.php');
            } else {
                $error[] = "enter valid username and password";
            }
        } else {
            $error[] = $sql->error;
        }
    } else {
        $error[] = "username and password should not be empty";
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
        body {
            background-image: url("../images/projectImages/nvbg.jpg");
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            width: 350px;
            height: 340px;
            border: 2px solid black;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            margin-bottom:200px ;
        }

        .login-form h2 {
            margin: 15px 0;
        }

        .login-form span {
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
    <main>
        <div class="container my-5 login-form bg-dark">
            <h2>Admin Login</h2>

            <form action="" method="post" class="login">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" />
                    <label for="username">Enter username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="pass" name="pass" />
                    <label for="pass">Enter Password</label>
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