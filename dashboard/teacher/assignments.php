<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <h2>Assignments</h2>
    <div class="mb-3">
        <a href="add_assignment.php" class="btn btn-primary">Add New Assignment</a>
    </div>
    <div class="assignments">
        <?php
        $user_id = $_SESSION['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assignment_id']) && isset($_POST['status']) && isset($_POST['deadline'])) {
            $assignment_id = $_POST['assignment_id'];
            $status = $_POST['status'];
            $deadline = $_POST['deadline'];
            $conn->query("UPDATE `assignments` SET `status` = '$status', `deadline` = '$deadline' WHERE `id` = '$assignment_id' AND `teacher_id` = '$user_id'");
            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
            exit();
        }

        $sql = $conn->query("SELECT a.*, c.title as course_title FROM `assignments` a JOIN `courses` c ON a.course_id = c.id WHERE a.teacher_id = '$user_id' ORDER BY a.created_at DESC");

        if ($sql->num_rows > 0) {
            echo "<ul class='list-group'>";
            while ($row = $sql->fetch_assoc()) {
                $filePath = $row['file'];
                $fileName = basename($filePath);
                $status = $row['status'];
                $courseTitle = $row['course_title'];
                $deadline = $row['deadline'];
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                echo "<div>";
                echo "<strong>{$row['title']}</strong><br>";
                echo "{$row['description']}<br>";
                echo "<small>Course: {$courseTitle}</small>";
                echo "</div>";
                echo "<div>";
                echo "<a href='$filePath' download='$fileName' class='btn btn-sm btn-primary'>Download</a>";
                echo "<form method='POST' action='' style='display:inline; margin-left: 10px;'>";
                echo "<input type='hidden' name='assignment_id' value='{$row['id']}'>";
                echo "<select name='status' onchange='this.form.submit()' class='form-select form-select-sm' style='width: auto; display: inline-block;'>";
                echo "<option value='active'" . ($status == 'active' ? ' selected' : '') . ">Active</option>";
                echo "<option value='blocked'" . ($status == 'blocked' ? ' selected' : '') . ">Blocked</option>";
                echo "<option value='completed'" . ($status == 'completed' ? ' selected' : '') . ">Completed</option>";
                echo "<option value='pending'" . ($status == 'pending' ? ' selected' : '') . ">Pending</option>";
                echo "</select>";
                echo "<input type='date' name='deadline' value='$deadline' onchange='this.form.submit()' class='form-control form-control-sm' style='width: auto; display: inline-block; margin-left: 10px;'>";
                echo "</form>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='alert alert-warning' role='alert'>No assignments found.</div>";
        }
        ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>