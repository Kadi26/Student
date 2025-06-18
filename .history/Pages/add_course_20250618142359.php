<?php
session_start();

require '../database/db.php'; // Include database connection

$error = $success = "";

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $error = "Unauthorized: Please log in first.";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $course_name = trim($_POST['course_name']);
    $course_code = trim($_POST['course_code']);
    $semester = trim($_POST['semester']);
    $user_id = $_SESSION['user_id']; // ✅ Use dynamic user ID

    if (empty($course_name) || empty($course_code) || empty($semester)) {
        $error = "All fields are required.";
    } else {
        // Insert course
        $stmt = $conn->prepare("INSERT INTO courses (course_name, course_code, semester, user_id) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            $error = "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("sssi", $course_name, $course_code, $semester, $user_id);
            if ($stmt->execute()) {
                $success = "✅ Course added successfully!";
            } else {
                $error = "❌ Insert failed: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Add Course</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" name="course_name" id="course_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="course_code" class="form-label">Course Code</label>
            <input type="text" name="course_code" id="course_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="">Select Semester</option>
                <option value="Semester 1">Semester 1</option>
                <option value="Semester 2">Semester 2</option>
                <option value="Semester 3">Semester 3</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Course</button>
        <!-- <a href="admin_dashboard.php" class="btn btn-secondary">Back</a> -->
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
