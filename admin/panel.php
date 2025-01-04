<?php
session_start();


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
            <style>
        /* Sidebar Styling */
        .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        width: 250px;
        background-color: #343a40;
        color: white;
        padding-top: 20px;
        height: 100vh;
        }
        .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 12px 20px;
        font-size: 18px;
        }
        .sidebar a:hover {
        background-color: #007bff;
        }

        /* Main Content Styling */
        .main-content {
        margin-left: 250px;
        padding: 20px;
        margin-top: 50px;
        }

        /* Navbar Styling */
        .navbar {
        z-index: 100;
        }

        /* Make sidebar collapse on small screens */
        @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
        }
        .main-content {
            margin-left: 0;
        }
        }
    </style>
    </head>

    <body>
        <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-center text-white">Admin Panel</h2>
        <a href="#">Dashboard</a>
        <a href="#">Users</a>
        <a href="#">Products</a>
        <a href="#">Orders</a>
        <a href="#">Reports</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">Vestis Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Logout</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Manage users, products, orders, and more here.</p>

        <!-- Example Dashboard Card -->
        <div class="card mb-3">
            <div class="card-header">
            Dashboard Overview
            </div>
            <div class="card-body">
            <h5 class="card-title">Admin Statistics</h5>
            <p class="card-text">Here you can view and manage your platform’s data like users, orders, and more.</p>
            </div>
        </div>

        <!-- Example Table for Users -->
        <div class="card">
            <div class="card-header">
            User Management
            </div>
            <div class="card-body">
            <h5 class="card-title">Users List</h5>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>john_doe</td>
                    <td>john@example.com</td>
                    <td>Admin</td>
                    <td><button class="btn btn-primary">Edit</button></td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>jane_smith</td>
                    <td>jane@example.com</td>
                    <td>User</td>
                    <td><button class="btn btn-primary">Edit</button></td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
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