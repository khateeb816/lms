<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <h2>Assignment Solutions</h2>
    <div class="assignments">
        <?php
        $teacher_id = $_SESSION['id'];

        // Fetch assignments posted by this teacher along with course details
        $sqlAssignments = $conn->query("SELECT a.*, c.title as course_title FROM `assignments` a JOIN `courses` c ON a.course_id = c.id WHERE a.teacher_id = '$teacher_id' ORDER BY a.created_at DESC");

        if ($sqlAssignments->num_rows > 0) {
            echo "<ul class='list-group'>";
            while ($assignment = $sqlAssignments->fetch_assoc()) {
                $assignment_id = $assignment['id'];
                $title = htmlspecialchars($assignment['title'], ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars($assignment['description'], ENT_QUOTES, 'UTF-8');
                $deadline = $assignment['deadline'];
                $course_title = htmlspecialchars($assignment['course_title'], ENT_QUOTES, 'UTF-8');

                echo "<li class='list-group-item'>";
                echo "<strong>$title</strong><br>";
                echo "<small>Description: $description</small><br>";
                echo "<small>Course: $course_title</small><br>";
                echo "<small>Deadline: $deadline</small>";

                // Fetch submitted solutions for this assignment
                $sqlSolutions = $conn->query("SELECT * FROM `assignment_submissions` WHERE `assignment_id` = '$assignment_id' ORDER BY `created_at` DESC");

                if ($sqlSolutions->num_rows > 0) {
                    echo "<ul class='list-group mt-2'>";
                    while ($solution = $sqlSolutions->fetch_assoc()) {
                        $submission_id = $solution['id'];
                        $student_id = $solution['student_id'];
                        $file = $solution['file'];
                        $created_at = $solution['created_at'];
                        $marks = $solution['marks'];

                        // Fetch student details
                        $sqlStudent = $conn->query("SELECT `name` FROM `users` WHERE `id` = '$student_id' AND `role` = 'student'");
                        $student = $sqlStudent->fetch_assoc();
                        $student_name = htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8');

                        echo "<li class='list-group-item'>";
                        echo "<strong>Student: $student_name</strong><br>";
                        echo "<small>Submitted at: $created_at</small><br>";
                        echo "<a href='../../$file' download class='btn btn-sm btn-primary mt-2'>Download Solution</a>";

                        // Form to add marks
                        echo "<form method='POST' action=''>";
                        echo "<input type='hidden' name='submission_id' value='$submission_id'>";
                        echo "<div class='form-group mt-2'>";
                        echo "<label for='marks'>Marks:</label>";
                        echo "<input type='number' class='form-control' name='marks' value='$marks' required>";
                        echo "</div>";
                        echo "<button type='submit' class='btn btn-sm btn-success mt-2'>Save Marks</button>";
                        echo "</form>";

                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<div class='alert alert-info mt-2'>No solutions submitted.</div>";
                }

                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='alert alert-info'>No assignments found.</div>";
        }

        // Handle form submission to save marks
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submission_id']) && isset($_POST['marks'])) {
            $submission_id = $_POST['submission_id'];
            $marks = $_POST['marks'];
            $conn->query("UPDATE `assignment_submissions` SET `marks` = '$marks' WHERE `id` = '$submission_id'");
            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
            exit();
        }
        ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>