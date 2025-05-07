<?php

// database connection
include '../database/db.php';

// check if ID is provided in the query string
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
    die("Invalid request. No ID provided.");
}

$user_id = $_GET['uid'];

// fetch the specific user
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found.");
}

// fetch user grades WHERE student_id = user_id
$grade_query = "SELECT * FROM grades WHERE student_id = ?";
$stmt = $conn->prepare($grade_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$grades = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $grades[] = $row;
    }
}
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">View Grades</h1>
        <h2 class="text-center mb-4">Student: <?php echo htmlspecialchars($user['name']); ?></h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>Course</th>
                <th>Assignment</th>
                <th>Grade</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $total_score = 0;
            foreach ($grades as $grade): 
                $total_score += $grade['grade'];
            ?>
                <tr>
                <?php
                // fetch course name
                $course_id = $grade['course_id'];
                $course_query = "SELECT course_name FROM courses WHERE id = ?";
                $stmt = $conn->prepare($course_query);
                $stmt->bind_param("i", $course_id);
                $stmt->execute();
                $stmt->bind_result($course_name);
                $stmt->fetch();
                $stmt->close();
                ?>
                <td><?php echo htmlspecialchars($course_name); ?></td>
                <?php
                // fetch assignment title
                $assignment_id = $grade['assignment_id'];
                $assignment_query = "SELECT title FROM assignments WHERE id = ?";
                $stmt = $conn->prepare($assignment_query);
                $stmt->bind_param("i", $assignment_id);
                $stmt->execute();
                $stmt->bind_result($assignment_title);
                $stmt->fetch();
                $stmt->close();
                ?>
                <td><?php echo htmlspecialchars($assignment_title); ?></td>
                <td><?php echo htmlspecialchars($grade['grade']); ?></td>
                <td><?php echo htmlspecialchars($grade['remarks']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr class="table-secondary">
                <td colspan="2" class="text-end"><strong>Total Score:</strong></td>
                <td colspan="2"><?php echo htmlspecialchars($total_score); ?></td>
            </tr>
            </tfoot>
        </table>
    </div>
