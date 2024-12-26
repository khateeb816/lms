<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <h2>Quizzes</h2>
    <div class="quizzes">
        <?php
        $user_id = $_SESSION['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id']) && isset($_POST['selected_option'])) {
            $quiz_id = $_POST['quiz_id'];
            $selected_option = $_POST['selected_option'];

            // Insert or update the quiz submission
            $sqlSubmission = $conn->query("SELECT * FROM quiz_submissions WHERE quiz_id = '$quiz_id' AND student_id = '$user_id'");
            if ($sqlSubmission->num_rows > 0) {
                $conn->query("UPDATE quiz_submissions SET selected_option = '$selected_option' WHERE quiz_id = '$quiz_id' AND student_id = '$user_id'");
            } else {
                $conn->query("INSERT INTO quiz_submissions (quiz_id, student_id, selected_option) VALUES ('$quiz_id', '$user_id', '$selected_option')");
            }

            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
            exit();
        }

        $sql = $conn->query("SELECT q.*, c.title as course_title FROM `quizes` q JOIN `courses` c ON q.course_id = c.id WHERE q.status = 'active' ORDER BY q.created_at DESC");

        if ($sql->num_rows > 0) {
            echo "<ul class='list-group'>";
            while ($row = $sql->fetch_assoc()) {
                $quiz_id = $row['id'];
                $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                $question = htmlspecialchars($row['question'], ENT_QUOTES, 'UTF-8');
                $courseTitle = $row['course_title'];
                $status = $row['status'];
                $deadline = $row['deadline'];
                $options = explode(',', $row['options']); // Assuming options are stored as comma-separated values

                // Check if the quiz has been submitted by the student
                $sqlSubmission = $conn->query("SELECT * FROM quiz_submissions WHERE quiz_id = '$quiz_id' AND student_id = '$user_id'");
                $submission = $sqlSubmission->fetch_assoc();
                $submittedOption = $submission ? $submission['selected_option'] : null;
                $submitted = $submission ? true : false;
                $marks = $submission ? $submission['marks'] : "Pending";

                // Check if the deadline is over and the quiz is not submitted
                if (!$submitted && strtotime($deadline) < time()) {
                    $status = 'blocked';
                }

                $bgColor = $submitted ? 'bg-light-green' : ($status == 'blocked' ? 'bg-light-red' : '');
                $disabled = $submitted || $status == 'blocked' ? 'disabled' : '';

                echo "<li class='list-group-item d-flex justify-content-between align-items-center $bgColor'>";
                echo "<div>";
                echo "<strong>$title</strong><br>";
                echo "$question<br>";
                echo "<small>Course: {$courseTitle}</small><br>";
                echo "<small>Deadline: {$deadline}</small><br>";
                echo "<small>Marks: {$marks}</small>";
                echo "<form action='' method='POST'>";
                echo "<input type='hidden' name='quiz_id' value='$quiz_id'>";
                echo "<ol class='mt-2'>";
                foreach ($options as $option) {
                    $option = htmlspecialchars($option, ENT_QUOTES, 'UTF-8');
                    $checked = $submittedOption == $option ? 'checked' : '';
                    echo "<li><input type='radio' name='selected_option' value='$option' $disabled $checked required> $option</li>";
                }
                echo "</ol>";
                echo "<button type='submit' class='btn btn-sm btn-primary mt-2' $disabled>Submit</button>";
                echo "</form>";
                echo "</div>";
                echo "<div>";
                if ($submitted) {
                    echo "<span class='badge bg-success'>Submitted</span>";
                } elseif ($status == 'blocked') {
                    echo "<span class='badge bg-danger'>Not submitted</span>";
                }
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

<style>
.bg-light-green {
    background-color: #d4edda !important;
}
.bg-light-red {
    background-color: #f8d7da !important;
}
</style>