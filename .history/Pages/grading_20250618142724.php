<?php
// Database connection
include '../database/db.php';

// Check if ID is provided in the query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. No ID provided.");
}

$response_id = intval($_GET['id']);

// Fetch the specific response
$response_query = "SELECT * FROM responses WHERE id = ?";
$stmt = $conn->prepare($response_query);
$stmt->bind_param("i", $response_id);
$stmt->execute();
$response_result = $stmt->get_result();
$response = $response_result->fetch_assoc();
$stmt->close();

if (!$response) {
    die("Response not found.");
}

// Fetch student name
$student_id = $response['student_id'];
$student_name = '';
$student_query = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($student_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($student_name);
$stmt->fetch();
$stmt->close();

// Fetch assignment title and course_id
$assignment_id = $response['assignment_id'];
$assignment_title = '';
$course_id = null;
$assignment_query = "SELECT title, course_id FROM assignments WHERE id = ?";
$stmt = $conn->prepare($assignment_query);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$stmt->bind_result($assignment_title, $course_id);
$stmt->fetch();
$stmt->close();

if (!$course_id) {
    die("Course ID not found for the assignment.");
}

// Handle form submission for grading
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grade = $_POST['grade'];
    $remarks = $_POST['remarks'] ?? '';

    // Insert the grade into the grades table
    $insert_query = "INSERT INTO grades (student_id, course_id, assignment_id, grade, remarks) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param(
        "iiiss",
        $response['student_id'],
        $course_id,
        $assignment_id,
        $grade,
        $remarks
    );
    if ($stmt->execute()) {
        echo "<script>alert('Grade submitted successfully!'); window.location.href='mark_assignments.php';</script>";
    } else {
        echo "<script>alert('Failed to submit grade. Please try again.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Grade Assignment</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Student Name: <?php echo htmlspecialchars($student_name); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Assignment: <?php echo htmlspecialchars($assignment_title); ?></h6>
                <p class="card-text">
                    <a href="../uploads/<?php echo htmlspecialchars($response['file_name']); ?>" target="_blank">View Assignment</a>
                </p>
                <form method="POST">
                    <div class="mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <input type="text" class="form-control" id="grade" name="grade" required>
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Grade</button>
                    <a href="mark_assignments.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>