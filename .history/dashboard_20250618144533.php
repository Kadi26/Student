

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding-top: 50px;
        }
        .sidebar .nav-link {
            color: #ccc;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: #007bff;
            color: white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h5 {
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Navbar for mobile -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-md-none">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="coursesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Courses
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="coursesDropdown">
                        <li><a class="dropdown-item" href="./pages/add_course.php">Add Course</a></li>
                        <li><a class="dropdown-item" href="./pages/view_courses.php">View Courses</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Users
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                        <li><a class="dropdown-item" href="./pages/view_users.php">View Users</a></li>
                        <li><a class="dropdown-item" href="./pages/add_users.php">Add User</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="assignmentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Assignments
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="assignmentsDropdown">
                        <li><a class="dropdown-item" href="./pages/set_assignment.php">Set Assignments</a></li>
                        <li><a class="dropdown-item" href="view_assignments.php">View Assignments</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="assignmentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Messages
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="assignmentsDropdown">
                        <li><a class="dropdown-item" href="./pages/set_assignment.php">Send Messages</a></li>
                        <li><a class="dropdown-item" href="view_assignments.php">View Messages</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar for desktop -->
<div class="sidebar d-none d-md-block">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="#">Dashboard</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="coursesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Manage Courses
            </a>
            <ul class="dropdown-menu" aria-labelledby="coursesDropdown">
                <li><a class="dropdown-item" href="./pages/add_course.php">Add Course</a></li>
                <li><a class="dropdown-item" href="./pages/view_courses.php">View Courses</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Manage Users
            </a>
            <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                <li><a class="dropdown-item" href="./pages/view_users.php">View Users</a></li>
                <li><a class="dropdown-item" href="./pages/add_users.php">Add User</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="assignmentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Assignments
            </a>
            <ul class="dropdown-menu" aria-labelledby="assignmentsDropdown">
                <li><a class="dropdown-item" href="./pages/set_assignment.php">Set Assignments</a></li>
                <li><a class="dropdown-item" href="./pages/mark_assignments.php">View Assignments</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="assignmentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Messages
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="assignmentsDropdown">
                        <li><a class="dropdown-item" href="./pages/send_message.php">Send Messages</a></li>
                        <li><a class="dropdown-item" href="./pages/view_messages.php">View Messages</a></li>
                    </ul>
                </li>
        <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>
    </ul>
</div>

<!-- Main Content -->
<main class="main-content">
    <h2>Welcome, Admin</h2>

    <!-- Dashboard Cards -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card p-3 text-center shadow-sm">
                <h5 class="text-primary">Total Users</h5>
                <p class="fs-3"><i class="bi bi-people text-dark"></i> <strong><?= $totalUsers; ?></strong></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center shadow-sm">
                <h5 class="text-success">Total Courses</h5>
                <p class="fs-3"><i class="bi bi-book text-dark"></i> <strong><?= $totalCourses; ?></strong></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center shadow-sm">
                <h5 class="text-danger">Total Assignments</h5>
                <p class="fs-3"><i class="bi bi-pencil text-dark"></i> <strong><?= $totalAssignments; ?></strong></p>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>