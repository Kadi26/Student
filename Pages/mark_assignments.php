<?php
// Database connection
include '../database/db.php';

// Fetch responses
$sql = "SELECT * FROM responses";
$result = $conn->query($sql);

$responses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $responses[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Assignments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Mark Assignments</h1>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Assignment</th>
                    <th>Response</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($responses as $response): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($response['id']); ?></td>
                        <?php
                        // Fetch student name from the database
                        $student_id = $response['student_id'];
                        $student_name = '';
                        $student_query = "SELECT name FROM users WHERE id = ?";
                        $stmt = $conn->prepare($student_query);
                        $stmt->bind_param("i", $student_id);
                        $stmt->execute();
                        $stmt->bind_result($student_name);
                        $stmt->fetch();
                        $stmt->close();
                        ?>
                        <td><?php echo htmlspecialchars($student_name); ?></td>
                        <?php
                        // Fetch assignment title from the database
                        $assignment_id = $response['assignment_id'];
                        $assignment_title = '';
                        $assignment_query = "SELECT title FROM assignments WHERE id = ?";
                        $stmt = $conn->prepare($assignment_query);
                        $stmt->bind_param("i", $assignment_id);
                        $stmt->execute();
                        $stmt->bind_result($assignment_title);
                        $stmt->fetch();
                        $stmt->close();
                        ?>
                        <td><?php echo htmlspecialchars($assignment_title); ?></td>
                        <td><a href="../uploads/<?php echo htmlspecialchars($response['file_name']); ?>" target="_blank">View Assignment</a></td>
                        <td>
                            <?php
                            // Check if the assignment is already graded
                            $graded_query = "SELECT grade FROM grades WHERE assignment_id = ? AND student_id = ?";
                            $stmt = $conn->prepare($graded_query);
                            $stmt->bind_param("ii", $assignment_id, $student_id);
                            $stmt->execute();
                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                // If graded, show "Graded" button
                                echo '<button class="btn btn-success btn-sm" disabled>Graded</button>';
                            } else {
                                // If not graded, show "Grade" button
                                echo '<a href="grading.php?id=' . $response['id'] . '" class="btn btn-primary btn-sm">Grade</a>';
                            }
                            $stmt->close();
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
