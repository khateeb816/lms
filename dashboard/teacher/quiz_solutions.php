<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <h2>Quiz Solutions</h2>
    <div class="quizzes">
        <?php
        $teacher_id = $_SESSION['id'];

        // Fetch quizzes added by this teacher
        $sqlQuizzes = $conn->query("SELECT * FROM `quizes` WHERE `teacher_id` = '$teacher_id' ORDER BY `created_at` DESC");

        if ($sqlQuizzes->num_rows > 0) {
            echo "<ul class='list-group'>";
            while ($quiz = $sqlQuizzes->fetch_assoc()) {
                $quiz_id = $quiz['id'];
                $title = htmlspecialchars($quiz['title'], ENT_QUOTES, 'UTF-8');
                $question = htmlspecialchars($quiz['question'], ENT_QUOTES, 'UTF-8');
                $deadline = $quiz['deadline'];

                echo "<li class='list-group-item'>";
                echo "<strong>$title</strong><br>";
                echo "<small>Question: $question</small><br>";
                echo "<small>Deadline: $deadline</small>";

                // Fetch submitted solutions for this quiz
                $sqlSolutions = $conn->query("SELECT * FROM `quiz_submissions` WHERE `quiz_id` = '$quiz_id' ORDER BY `created_at` DESC");

                if ($sqlSolutions->num_rows > 0) {
                    echo "<ul class='list-group mt-2'>";
                    while ($solution = $sqlSolutions->fetch_assoc()) {
                        $submission_id = $solution['id'];
                        $student_id = $solution['student_id'];
                        $selected_option = htmlspecialchars($solution['selected_option'], ENT_QUOTES, 'UTF-8');
                        $created_at = $solution['created_at'];
                        $marks = $solution['marks'];

                        // Fetch student details
                        $sqlStudent = $conn->query("SELECT `name` FROM `users` WHERE `id` = '$student_id' AND `role` = 'student'");
                        $student = $sqlStudent->fetch_assoc();
                        $student_name = htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8');

                        echo "<li class='list-group-item'>";
                        echo "<strong>Student: $student_name</strong><br>";
                        echo "<small>Selected Option: $selected_option</small><br>";
                        echo "<small>Submitted at: $created_at</small><br>";

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
            echo "<div class='alert alert-info'>No quizzes found.</div>";
        }

        // Handle form submission to save marks
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submission_id']) && isset($_POST['marks'])) {
            $submission_id = $_POST['submission_id'];
            $marks = $_POST['marks'];
            $conn->query("UPDATE `quiz_submissions` SET `marks` = '$marks' WHERE `id` = '$submission_id'");
            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
            exit();
        }
        ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>