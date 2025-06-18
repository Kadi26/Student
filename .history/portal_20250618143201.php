<?php
session_start();
// echo "SESSION: ";
// print_r($_SESSION);
$id = $_GET['uid'];

if(!isset($id)){
    header('location: ./auth/index.php');
}


include "./database/db.php";

$get_user = "SELECT * FROM users where id = $id";

$result = mysqli_query($conn,$get_user);
$user = mysqli_fetch_assoc($result);



$name = $user['name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
        }
        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #0052d4, #4364f7, #6fb1fc);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand, .nav-link {
            color:#111 !important;
        }

        .nav-link:hover {
            color:#fff !important;
        }
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            width: 250px;
            background: #fff;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            font-weight: 500;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            background: linear-gradient(135deg, #0052d4, #4364f7);
            color: white;
            border-radius: 8px;
        }
        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        /* Card Styling */
        .card {
            background: linear-gradient(135deg, #0052d4, #4364f7);
            color: white;
            border: none;
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .btn-light {
            background: white;
            color: #0052d4;
            border: none;
            transition: 0.3s;
        }
        .btn-light:hover {
            background: #e0e0e0;
        }
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
            }
            .card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- <li class="nav-item"><a class="nav-link text-light" href="#">Profile</a></li> -->
                <li class="nav-item"><a class="nav-link text-light" href="./auth/index.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar d-none d-md-block p-3">
    <h4 class="text-center">User Menu</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="./pages/course_registration.php?uid='<?=$id?>'"><i class="bi bi-journal-text"></i> Course Registration</a></li>
        <li class="nav-item"><a class="nav-link " href="./pages/submit_assignment.php?uid=<?=$id?>"><i class="bi bi-clipboard-check"></i> Assignments</a></li>
        <li class="nav-item"><a class="nav-link" href="./pages/view_grades.php?uid=<?=$id?>"><i class="bi bi-bar-chart-line"></i> Grades</a></li>
        <li class="nav-item"><a class="nav-link" href="./pages/view_messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
    </ul>
</div>

<!-- Main Content -->
<main class="main-content mt-5">
    <div class="container-fluid">
        <h2 class="mb-4">Welcome <?=$name?></h2>
        <p>Select an option from the sidebar.</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <div class="card-body">
                        <i class="bi bi-journal-text card-icon"></i>
                        <h5 class="card-title">Course Registration</h5>
                        <p class="card-text">Enroll in available courses.</p>
                        <a href="./pages/course_registration.php?uid=<?=$id?>" class="btn btn-light">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <div class="card-body">
                        <i class="bi bi-clipboard-check card-icon"></i>
                        <h5 class="card-title">Assignment Tracking</h5>
                        <p class="card-text">Check and submit assignments.</p>
                        <a href="./pages/submit_assignment.php?uid=<?=$id?>" class="btn btn-light">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <div class="card-body">
                        <i class="bi bi-bar-chart-line card-icon"></i>
                        <h5 class="card-title">Grades</h5>
                        <p class="card-text">View your course grades.</p>
                        <a href="./pages/view_grades.php?uid=<?=$id?>" class="btn btn-light">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
