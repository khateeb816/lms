<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assignment_id']) && isset($_FILES['submission_file'])) {
    $assignment_id = $_POST['assignment_id'];
    $user_id = $_SESSION['id'];
    $target_dir = "assignmentSolutions/";
    $target_file = $target_dir . basename($_FILES["submission_file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["submission_file"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
    } else {
        if (move_uploaded_file($_FILES["submission_file"]["tmp_name"], '../' . $target_file)) {
            // Insert submission into the database
            $stmt = $conn->prepare("INSERT INTO assignment_submissions (assignment_id, student_id, file) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $assignment_id, $user_id, $target_file);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>The file " . htmlspecialchars(basename($_FILES["submission_file"]["name"])) . " has been uploaded.</div>";
                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
                exit();
            } else {
                echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assignment_id'])) {
    if (isset($_POST['status']) && isset($_POST['deadline'])) {
        $assignment_id = $_POST['assignment_id'];
        $status = $_POST['status'];
        $deadline = $_POST['deadline'];
        $conn->query("UPDATE `assignments` SET `status` = '$status', `deadline` = '$deadline' WHERE `id` = '$assignment_id' AND `teacher_id` = '$user_id'");
        echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
        exit();
    } elseif (isset($_POST['delete'])) {
        $assignment_id = $_POST['assignment_id'];
        
        // Fetch the file path before deleting the assignment
        $result = $conn->query("SELECT `file` FROM `assignments` WHERE `id` = '$assignment_id' AND `teacher_id` = '$user_id'");
        $assignment = $result->fetch_assoc();
        $filePath = "../../" . $assignment['file'];

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
?>

<div class="container-fluid">
    <h2>Assignments</h2>
    <div class="mb-3">
        <a href="add_assignment.php" class="btn btn-primary">Add New Assignment</a>
    </div>
    <div class="assignments">
        <?php
        $user_id = $_SESSION['id'];

        // Fetch semester_id for the student
        $sqlSemester = $conn->query("SELECT semester_id FROM `users` WHERE `id` = '$user_id' AND `role` = 'student'");
        $semester = $sqlSemester->fetch_assoc();
        $semester_id = $semester['semester_id'];

        // Fetch courses field from semesters table
        $sqlCourses = $conn->query("SELECT courses FROM `semesters` WHERE `id` = '$semester_id'");
        $semesterCourses = $sqlCourses->fetch_assoc();
        $course_ids = explode(',', $semesterCourses['courses']);

        // Fetch assignments grouped by course
        if (!empty($course_ids)) {
            $course_ids_str = implode(',', array_map('intval', $course_ids));
            $sql = $conn->query("SELECT a.*, c.title as course_title FROM `assignments` a JOIN `courses` c ON a.course_id = c.id WHERE a.course_id IN ($course_ids_str) ORDER BY a.course_id, a.created_at DESC");

            $currentCourse = '';
            if ($sql->num_rows > 0) {
                while ($row = $sql->fetch_assoc()) {
                    $assignment_id = $row['id'];
                    $filePath = $row['file'];
                    $fileName = basename($filePath);
                    $status = $row['status'];
                    $deadline = $row['deadline'];
                    $courseTitle = $row['course_title'];

                    // Check if the assignment has been submitted by the student
                    $sqlSubmission = $conn->query("SELECT * FROM `assignment_submissions` WHERE `assignment_id` = '$assignment_id' AND `student_id` = '$user_id'");
                    $submission = $sqlSubmission->fetch_assoc();
                    $submitted = $submission ? true : false;
                    $marks = $submission ? $submission['marks'] : 'Pending';


                    // Check if the deadline is over and the assignment is not submitted
                    if (!$submitted && strtotime($deadline) < time()) {
                        $status = 'blocked';
                    }

                    $bgColor = $submitted ? 'bg-light-green' : ($status == 'blocked' ? 'bg-light-red' : '');

                    if ($currentCourse != $courseTitle) {
                        if ($currentCourse != '') {
                            echo "</ul>";
                        }
                        $currentCourse = $courseTitle;
                        echo "<h3>Course: {$courseTitle}</h3>";
                        echo "<ul class='list-group mb-4'>";
                    }

                    echo "<li class='list-group-item d-flex justify-content-between align-items-center $bgColor'>";
                    echo "<div>";
                    echo "<strong>{$row['title']}</strong><br>";
                    echo "{$row['description']}<br>";
                    echo "<small>Course: {$courseTitle}</small><br>";
                    echo "<small>Deadline: {$deadline}</small><br>";
                    echo "<small>Marks: $marks</small>";
                    echo "</div>";
                    echo "<div>";
                    echo "<a href='$filePath' download='$fileName' class='btn btn-sm btn-primary'>Download</a>";
                    if ($submitted) {
                        echo "<span class='badge bg-success'>Submitted</span>";
                    } elseif ($status == 'blocked') {
                        echo "<span class='badge bg-danger'>Not submitted</span>";
                    } else {
                        echo "<form method='POST' action='' enctype='multipart/form-data' style='display:inline; margin-left: 10px;'>";
                        echo "<input type='hidden' name='assignment_id' value='$assignment_id'>";
                        echo "<input type='file' name='submission_file' required>";
                        echo "<button type='submit' class='btn btn-sm btn-success'>Submit</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<div class='alert alert-warning' role='alert'>No assignments found.</div>";
            }
        } else {
            echo "<div class='alert alert-warning' role='alert'>No courses found.</div>";
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
                echo "<small>Deadline: {$deadline}</small>";
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
                echo "</form>";
                echo "<a href='update_assignment.php?id={$row['id']}' class='btn btn-sm btn-warning' style='margin-left: 10px;'>Update</a>";
                echo "<form method='POST' action='' style='display:inline; margin-left: 10px;'>";
                echo "<input type='hidden' name='assignment_id' value='{$row['id']}'>";
                echo "<button type='submit' name='delete' class='btn btn-sm btn-danger'>Delete</button>";
                echo "</form>";
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

<style>
.bg-light-green {
    background-color: #d4edda !important;
}
.bg-light-red {
    background-color: #f8d7da !important;
}
</style>