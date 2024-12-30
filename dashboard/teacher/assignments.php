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

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assignment_id'])) {
            if (isset($_POST['status']) && isset($_POST['deadline'])) {
                $assignment_id = $_POST['assignment_id'];
                $status = $_POST['status'];
                $conn->query("UPDATE `assignments` SET `status` = '$status' WHERE `id` = '$assignment_id' AND `teacher_id` = '$user_id'");
                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
                exit();
            } elseif (isset($_POST['delete'])) {
                $assignment_id = $_POST['assignment_id'];
                
                // Fetch the file path before deleting the assignment
                $result = $conn->query("SELECT `file` FROM `assignments` WHERE `id` = '$assignment_id' AND `teacher_id` = '$user_id'");
                $assignment = $result->fetch_assoc();
                $filePath = "../" . $assignment['file'];

                // Delete the assignment from the database
                $conn->query("DELETE FROM `assignments` WHERE `id` = '$assignment_id' AND `teacher_id` = '$user_id'");

                // Delete the file from the server
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
                exit();
            }
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
                echo "<small>Course: {$courseTitle}</small><br>";
                echo "<small>Deadline: {$deadline}</small><br>";
                echo "<small>Status: {$status}</small>";
                echo "</div>";
                echo "<div>";
                echo "<a href='../$filePath' download='../$fileName' class='btn btn-sm btn-primary'>Download</a>";
                echo "<a href='update_assignment.php?id={$row['id']}' class='btn btn-sm btn-warning' style='margin-left: 10px;'>Update</a>";
                echo "<form method='POST' action='' style='display:inline; margin-left: 10px;'>";
                echo "<input type='hidden' name='assignment_id' value='{$row['id']}'>";
                echo "<button type='submit' name='delete' class='btn btn-sm btn-danger'>Delete</button>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='alert alert-info'>No assignments found.</div>";
        }
        ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>