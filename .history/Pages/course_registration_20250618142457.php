<?php
session_start();
echo "SESSION: ";
print_r($_SESSION);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../database/db.php"; 
$user_id = $_GET["uid"];

// Fetch available courses from database
$courses = [];
$query = "SELECT id, course_name FROM courses";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Fetch available semesters (Modify if stored in DB)
$semesters = [1 => "Semester 1", 2 => "Semester 2", 3 => "Semester 3"]; // Use integer keys for semesters

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST["course_id"];
    $semester = intval($_POST["semester"]); // Convert semester to an integer if required
    $user_id = $_GET["uid"];

    // Check if the user is already registered for the same course in the same semester
    $checkQuery = "SELECT * FROM enrollments WHERE user_id = ? AND course_id = ? AND semester = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("iis", $user_id, $course_id, $semester);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-warning'>You are already registered for this course in the selected semester.</div>";
    } else {
        // Insert into enrollments (assuming 'enrollments' table exists)
        $insertQuery = "INSERT INTO enrollments (user_id, course_id, semester) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iis", $user_id, $course_id, $semester);

        if ($stmt->execute()) {
            echo "<script>alert('Course registered successfully!'); window.location='../portal.php?uid=$user_id';</script>";
        } else {
            $message = "<div class='alert alert-danger'>Error registering course. Please try again.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
            color: #333;
        }
        .card {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 6px;
        }
        .btn-primary {
            background: #0056b3;
            border: none;
        }
        .btn-primary:hover {
            background: #004494;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Course Registration</h2>
        <div class="row justify-content-center">
                    <?php if (isset($message)) echo $message; ?>
                    <form method="POST" action="">
                <div class="card">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Select Course</label>
                            <select name="course_id" class="form-control" required>
                                <option value="">-- Select Course --</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id']; ?>"><?= htmlspecialchars($course['course_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Semester</label>
                            <select name="semester" class="form-control" required>
                                <option value="">-- Select Semester --</option>
                                <?php foreach ($semesters as $sem): ?>
                                    <option value="<?= $key; ?>"><?= $sem; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register Course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
