<?php
session_start();
include "../database/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}


$user_id = $_SESSION['user_id'];

// Add Course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_course'])) {
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $semester = $_POST['semester'];

    $sql = "INSERT INTO courses (user_id, course_name, course_code, semester) VALUES ('$user_id', '$course_name', '$course_code', '$semester')";
    $conn->query($sql);
}

// Delete Course
if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    $conn->query("DELETE FROM courses WHERE id='$course_id' AND user_id='$user_id'");
}

// Fetch Courses
$courses = $conn->query("SELECT * FROM courses WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Courses</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Courses</h2>
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
    
    <h3 class="mt-4">Add Course</h3>
    <form method="POST">
        <input type="text" name="course_name" class="form-control" placeholder="Course Name" required><br>
        <input type="text" name="course_code" class="form-control" placeholder="Course Code" required><br>
        <input type="text" name="semester" class="form-control" placeholder="Semester"><br>
        <button type="submit" name="add_course" class="btn btn-primary">Add Course</button>
    </form>

    <h3 class="mt-4">Your Courses</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Semester</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $courses->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['course_name']; ?></td>
                    <td><?php echo $row['course_code']; ?></td>
                    <td><?php echo $row['semester']; ?></td>
                    <td>
                        <a href="edit_course.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="courses.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
