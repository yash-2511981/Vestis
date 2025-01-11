<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location:login.php');
} else {
    print_r($_SESSION['orders']);
}
