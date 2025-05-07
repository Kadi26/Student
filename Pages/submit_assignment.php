<?php
// Database connection
include '../database/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT a.id, a.course_id, a.title, c.course_name 
    FROM assignments a
    JOIN courses c ON a.course_id = c.id";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching assignments: " . $conn->error);
}

$assignments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $assignments[] = $row;
    }
}

$message = '';
$message_type = '';

// Respond to assignment
if (isset($_POST['respond'])) {
    $assignment_id = $_POST['assignment_id'];
    $student_id = isset($_GET['uid']) ? intval($_GET['uid']) : 0; // Fetch student ID from $_GET['uid']
    $file = $_FILES['file'];

    // File properties
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    // File extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    // Allowed extensions
    $allowed = ['pdf', 'doc', 'docx'];

    // Check if file is allowed
    if (in_array($file_ext, $allowed)) {
        // Check if file has error
        if ($file_error === 0) {
            // Check file size
            if ($file_size <= 2 * 1024 * 1024) { // 2MB limit
                $file_name_new = uniqid('', true) . '.' . $file_ext; // Generate a unique file name
                $file_destination = '../uploads/' . $file_name_new; // Define the file destination

                $stmt = $conn->prepare("INSERT INTO responses (assignment_id, student_id, file_name) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $assignment_id, $student_id, $file_name_new);

                if ($stmt->execute()) {
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        $message = 'Assignment submitted successfully.';
                        $message_type = 'success';
                    } else {
                        $message = 'Error uploading file.';
                        $message_type = 'danger';
                    }
                } else {
                    $message = 'Error: ' . $stmt->error;
                    $message_type = 'danger';
                }

                $stmt->close();
            } else {
                $message = 'File size too large. Maximum size is 2MB.';
                $message_type = 'warning';
            }
        } else {
            $message = 'Error uploading file.';
            $message_type = 'danger';
        }
    } else {
        $message = 'File type not allowed.';
        $message_type = 'warning';
    }
}

$conn->close();
?>
<?php if (!empty($message)): ?>
    <div class="alert alert-<?= htmlspecialchars($message_type); ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Assignments</h1>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($assignments)): ?>
                    <?php foreach ($assignments as $assignment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($assignment['id']); ?></td>
                            <td><?php echo htmlspecialchars($assignment['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No assignments found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Form for user to submit the assignment -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="assignment_id" class="form-label">Select Assignment</label>
                <select name="assignment_id" id="assignment_id" class="form-control" required>
                    <option value="">-- Select Assignment --</option>
                    <?php foreach ($assignments as $assignment): ?>
                        <option value="<?= htmlspecialchars($assignment['id']); ?>"><?= htmlspecialchars($assignment['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Upload File</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" name="respond" class="btn btn-primary">Submit Assignment</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
