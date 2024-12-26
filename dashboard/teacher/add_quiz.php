<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <h2>Add New Quiz</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $question = $_POST['question'];
        $status = $_POST['status'];
        $deadline = $_POST['deadline'];
        $options = implode(',', $_POST['options']); // Assuming options are stored as comma-separated values
        $course_id = $_POST['course_id'];
        $teacher_id = $_SESSION['id'];

        $sql = $conn->prepare("INSERT INTO `quizes` (`title`, `question`, `status`, `deadline`, `options`, `course_id`, `teacher_id`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("ssssssi", $title, $question, $status, $deadline, $options, $course_id, $teacher_id);
        if ($sql->execute()) {
            echo "<div class='alert alert-success'>The quiz has been added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql->error . "</div>";
        }
    }

    $teacher_id = $_SESSION['id'];
    $courses_sql = $conn->query("SELECT * FROM `courses` WHERE FIND_IN_SET('$teacher_id', `teacher_id`)");
    ?>

    <form method="POST">
        <div class="form-group">
            <label for="title">Quiz Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="question">Quiz Question</label>
            <textarea class="form-control" id="question" name="question" required></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="pending">Pending</option>
                <option value="active">Active</option>
                <option value="blocked">Blocked</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
        </div>
        <div class="form-group">
            <label for="course_id">Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <?php while ($course = $courses_sql->fetch_assoc()): ?>
                    <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['title']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="options">Options</label>
            <input type="text" class="form-control mb-2" name="options[]" required>
            <input type="text" class="form-control mb-2" name="options[]" required>
            <input type="text" class="form-control mb-2" name="options[]" required>
            <input type="text" class="form-control mb-2" name="options[]" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Quiz</button>
    </form>
</div>

<?php include './includes/footer.php'; ?>