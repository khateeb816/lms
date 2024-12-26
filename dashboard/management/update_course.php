<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php' ?>
<?php
include '../../db.php';

$course_id = $_GET['id'];

// Fetch course details
$sql = $conn->query("SELECT * FROM `courses` WHERE `id` = '$course_id'");
$course = $sql->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $teacher_id = $_POST['teacher_id'];

    // Update course details in the database
    $sql = $conn->query("UPDATE `courses` SET `title` = '$title', `description` = '$description', `teacher_id` = '$teacher_id' WHERE `id` = '$course_id'");
    if ($sql) {
        echo "<script>alert('Course updated successfully.'); window.location.href = 'courses.php';</script>";
    } else {
        echo "<script>alert('Error updating course.');</script>";
    }
}

// Fetch all teachers for the dropdown
$sqlTeachers = $conn->query("SELECT * FROM `users` WHERE `role` = 'teacher'");
?>

<div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Course</h5>
        </div>
        <div class="modal-body">
            <form method="POST">
                <div class="form-group">
                    <label for="title">Course Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Course Description</label>
                    <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="teacher_id">Teacher</label>
                    <select class="form-control" id="teacher_id" name="teacher_id" required>
                        <?php while ($teacher = $sqlTeachers->fetch_assoc()): ?>
                            <option value="<?php echo $teacher['id']; ?>" <?php echo $teacher['id'] == $course['teacher_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($teacher['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php' ?>