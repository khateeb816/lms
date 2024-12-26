<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <h2>Quizzes</h2>
    <div class="mb-3">
        <a href="add_quiz.php" class="btn btn-primary">Add New Quiz</a>
    </div>
    <div class="quizzes">
        <?php
        $user_id = $_SESSION['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id'])) {
            if (isset($_POST['status']) && isset($_POST['deadline'])) {
                $quiz_id = $_POST['quiz_id'];
                $status = $_POST['status'];
                $deadline = $_POST['deadline'];
                $conn->query("UPDATE `quizes` SET `status` = '$status', `deadline` = '$deadline' WHERE `id` = '$quiz_id' AND `teacher_id` = '$user_id'");
                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
                exit();
            } elseif (isset($_POST['delete'])) {
                $quiz_id = $_POST['quiz_id'];
                $conn->query("DELETE FROM `quizes` WHERE `id` = '$quiz_id' AND `teacher_id` = '$user_id'");
                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
                exit();
            }
        }

        $sql = $conn->query("SELECT q.*, c.title as course_title FROM `quizes` q JOIN `courses` c ON q.course_id = c.id WHERE q.teacher_id = '$user_id' ORDER BY q.created_at DESC");

        if ($sql->num_rows > 0) {
            echo "<ul class='list-group'>";
            while ($row = $sql->fetch_assoc()) {
                $quiz_id = $row['id'];
                $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                $question = htmlspecialchars($row['question'], ENT_QUOTES, 'UTF-8');
                $status = $row['status'];
                $deadline = $row['deadline'];
                $course_id = $row['course_id'];
                $course_title = htmlspecialchars($row['course_title'], ENT_QUOTES, 'UTF-8');
                $options = explode(',', $row['options']); // Assuming options are stored as comma-separated values

                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                echo "<div>";
                echo "<strong>$title</strong><br>";
                echo "$question<br>";
                echo "<ol class='mt-2'>";
                foreach ($options as $option) {
                    echo "<li>" . htmlspecialchars($option, ENT_QUOTES, 'UTF-8') . "</li>";
                }
                echo "</ol>";
                echo "<small>Course: {$course_title} (ID: {$course_id})</small><br>";
                echo "<small>Deadline: {$deadline}</small>";
                echo "</div>";
                echo "<div>";
                echo "<form method='POST' action='' style='display:inline; margin-left: 10px;'>";
                echo "<input type='hidden' name='quiz_id' value='$quiz_id'>";
                echo "<select name='status' onchange='this.form.submit()' class='form-select form-select-sm' style='width: auto; display: inline-block;'>";
                echo "<option value='active'" . ($status == 'active' ? ' selected' : '') . ">Active</option>";
                echo "<option value='blocked'" . ($status == 'blocked' ? ' selected' : '') . ">Blocked</option>";
                echo "<option value='completed'" . ($status == 'completed' ? ' selected' : '') . ">Completed</option>";
                echo "<option value='pending'" . ($status == 'pending' ? ' selected' : '') . ">Pending</option>";
                echo "</select>";
                echo "</form>";
                echo "<a href='update_quiz.php?id={$quiz_id}' class='btn btn-sm btn-warning' style='margin-left: 10px;'>Edit</a>";
                echo "<form method='POST' action='' style='display:inline; margin-left: 10px;'>";
                echo "<input type='hidden' name='quiz_id' value='$quiz_id'>";
                echo "<button type='submit' name='delete' class='btn btn-sm btn-danger'>Delete</button>";
                echo "</form>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='alert alert-info'>No quizzes found.</div>";
        }
        ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>