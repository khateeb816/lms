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

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id']) && isset($_POST['status']) && isset($_POST['deadline'])) {
            $quiz_id = $_POST['quiz_id'];
            $status = $_POST['status'];
            $deadline = $_POST['deadline'];
            $conn->query("UPDATE `quizes` SET `status` = '$status', `deadline` = '$deadline' WHERE `id` = '$quiz_id' AND `teacher_id` = '$user_id'");
            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
            exit();
        }

        $sql = $conn->query("SELECT * FROM `quizes` WHERE `teacher_id` = '$user_id' ORDER BY `created_at` DESC");

        if ($sql->num_rows > 0) {
            echo "<ul class='list-group'>";
            while ($row = $sql->fetch_assoc()) {
                $quiz_id = $row['id'];
                $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                $question = htmlspecialchars($row['question'], ENT_QUOTES, 'UTF-8');
                $status = $row['status'];
                $deadline = $row['deadline'];
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
                echo "</div>";
                echo "<div>";
                echo "<form method='POST' action='' style='display:inline; margin-left: 10px;'>";
                echo "<input type='hidden' name='quiz_id' value='$quiz_id'>";
                echo "<select name='status' onchange='this.form.submit()' class='form-select form-select-sm' style='width: auto; display: inline-block;'>";
                echo "<option value='pending'" . ($status == 'pending' ? ' selected' : '') . ">Pending</option>";
                echo "<option value='active'" . ($status == 'active' ? ' selected' : '') . ">Active</option>";
                echo "<option value='blocked'" . ($status == 'blocked' ? ' selected' : '') . ">Blocked</option>";
                echo "<option value='completed'" . ($status == 'completed' ? ' selected' : '') . ">Completed</option>";
                echo "</select>";
                echo "<input type='date' name='deadline' value='$deadline' onchange='this.form.submit()' class='form-control form-control-sm' style='width: auto; display: inline-block; margin-left: 10px;'>";
                echo "</form>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='alert alert-warning' role='alert'>No quizzes found.</div>";
        }
        ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>