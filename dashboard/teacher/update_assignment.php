<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php
include '../../db.php';

$assignment_id = $_GET['id'];

// Fetch assignment details
$sql = $conn->query("SELECT * FROM `assignments` WHERE `id` = '$assignment_id'");
$assignment = $sql->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $course_id = $_POST['course_id'];
    $newFilePath = $assignment['file']; // Default to existing file path

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $tempPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $newName = uniqid() . "." . $ext;
        $newFilePath = "uploads/" . $newName;

        if (!is_dir('../uploads/')) {
            mkdir('../uploads/', 0755, true);
        }

        if (move_uploaded_file($tempPath, "../" . $newFilePath)) {
            // Delete the old file if a new file is uploaded successfully
            if (file_exists("../" . $assignment['file'])) {
                unlink("../" . $assignment['file']);
            }
            echo "File uploaded successfully as: " . htmlspecialchars($newName);
        } else {
            echo "Error: Failed to move the uploaded file.";
        }
    }

    // Update assignment details in the database
    $sql = $conn->query("UPDATE `assignments` SET `title` = '$title', `description` = '$description', `status` = '$status', `deadline` = '$deadline', `course_id` = '$course_id', `file` = '$newFilePath' WHERE `id` = '$assignment_id'");
    if ($sql) {
        echo "<script>alert('Assignment updated successfully.'); window.location.href = 'assignments.php';</script>";
    } else {
        echo "<script>alert('Error updating assignment.');</script>";
    }
}

// Fetch all courses for the dropdown
$sqlCourses = $conn->query("SELECT * FROM `courses`");
?>

<div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Assignment</h5>
        </div>
        <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Assignment Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($assignment['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Assignment Description</label>
                    <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($assignment['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" <?php echo $assignment['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="blocked" <?php echo $assignment['status'] == 'blocked' ? 'selected' : ''; ?>>Blocked</option>
                        <option value="completed" <?php echo $assignment['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="pending" <?php echo $assignment['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="<?php echo date('Y-m-d\TH:i', strtotime($assignment['deadline'])); ?>" required>
                </div>
                <div class="form-group">
                    <label for="course_id">Course</label>
                    <select class="form-control" id="course_id" name="course_id" required>
                        <?php while ($course = $sqlCourses->fetch_assoc()): ?>
                            <option value="<?php echo $course['id']; ?>" <?php echo $course['id'] == $assignment['course_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($course['title']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">Assignment File</label>
                    <input type="file" class="form-control-file" id="file" name="file">
                    <?php if ($assignment['file']): ?>
                        <a href="../<?php echo $assignment['file']; ?>" download>Download current file</a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>