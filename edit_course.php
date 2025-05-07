<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: courses.php");
    exit();
}

$course_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch course details
$result = $conn->query("SELECT * FROM courses WHERE id='$course_id' AND user_id='$user_id'");
$course = $result->fetch_assoc();

if (!$course) {
    header("Location: courses.php");
    exit();
}

// Update Course
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $semester = $_POST['semester'];

    $sql = "UPDATE courses SET course_name='$course_name', course_code='$course_code', semester='$semester' WHERE id='$course_id' AND user_id='$user_id'";
    $conn->query($sql);
    header("Location: courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Course</h2>
    <form method="POST">
        <input type="text" name="course_name" class="form-control" value="<?php echo $course['course_name']; ?>" required><br>
        <input type="text" name="course_code" class="form-control" value="<?php echo $course['course_code']; ?>" required><br>
        <input type="text" name="semester" class="form-control" value="<?php echo $course['semester']; ?>"><br>
        <button type="submit" class="btn btn-success">Update Course</button>
        <a href="courses.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
