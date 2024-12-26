<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php
include '../../db.php';

$quiz_id = $_GET['id'];

// Fetch quiz details
$sql = $conn->query("SELECT * FROM `quizes` WHERE `id` = '$quiz_id'");
$quiz = $sql->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $question = $_POST['question'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $course_id = $_POST['course_id'];
    $options = implode(',', $_POST['options']); // Assuming options are stored as comma-separated values

    // Update quiz details in the database
    $sql = $conn->query("UPDATE `quizes` SET `title` = '$title', `question` = '$question', `status` = '$status', `deadline` = '$deadline', `course_id` = '$course_id', `options` = '$options' WHERE `id` = '$quiz_id'");
    if ($sql) {
        echo "<script>alert('Quiz updated successfully.'); window.location.href = 'quizes.php';</script>";
    } else {
        echo "<script>alert('Error updating quiz.');</script>";
    }
}

// Fetch all courses for the dropdown
$teacher_id = $_SESSION['id'];
$sqlCourses = $conn->query("SELECT * FROM `courses` WHERE FIND_IN_SET('$teacher_id', `teacher_id`)");

$options = explode(',', $quiz['options']); // Assuming options are stored as comma-separated values
?>

<div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Quiz</h5>
        </div>
        <div class="modal-body">
            <form method="POST">
                <div class="form-group">
                    <label for="title">Quiz Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($quiz['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="question">Quiz Question</label>
                    <textarea class="form-control" id="question" name="question" required><?php echo htmlspecialchars($quiz['question']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" <?php echo $quiz['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="blocked" <?php echo $quiz['status'] == 'blocked' ? 'selected' : ''; ?>>Blocked</option>
                        <option value="completed" <?php echo $quiz['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="pending" <?php echo $quiz['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="<?php echo date('Y-m-d\TH:i', strtotime($quiz['deadline'])); ?>" required>
                </div>
                <div class="form-group">
                    <label for="course_id">Course</label>
                    <select class="form-control" id="course_id" name="course_id" required>
                        <?php while ($course = $sqlCourses->fetch_assoc()): ?>
                            <option value="<?php echo $course['id']; ?>" <?php echo $course['id'] == $quiz['course_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($course['title']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="options">Options</label>
                    <?php foreach ($options as $index => $option): ?>
                        <input type="text" class="form-control mb-2" name="options[]" value="<?php echo htmlspecialchars($option); ?>" required>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>