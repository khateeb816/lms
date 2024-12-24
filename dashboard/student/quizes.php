<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id']) && isset($_POST['selected_option'])) {
    $quiz_id = $_POST['quiz_id'];
    $selected_option = $_POST['selected_option'];
    $user_id = $_SESSION['id'];

    // Insert the quiz submission into the database
    $stmt = $conn->prepare("INSERT INTO quiz_submissions (quiz_id, student_id, selected_option) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $quiz_id, $user_id, $selected_option);

    if ($stmt->execute()) {
        $submission_success = true;
    } else {
        $submission_error = true;
    }

    $stmt->close();

    // Redirect to the same page after submission
    echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
    exit();
}
?>

<div class="container-fluid">
    <h2>Quizzes</h2>
    <div class="quizzes">
        <?php
        if (isset($submission_success) && $submission_success) {
            echo "<div class='alert alert-success'>Quiz submitted successfully!</div>";
        } elseif (isset($submission_error) && $submission_error) {
            echo "<div class='alert alert-danger'>There was an error submitting the quiz. Please try again.</div>";
        }

        $user_id = $_SESSION['id'];

        // Fetch semester_id for the student
        $sqlSemester = $conn->query("SELECT semester_id FROM `users` WHERE `id` = '$user_id' AND `role` = 'student'");
        $semester = $sqlSemester->fetch_assoc();
        $semester_id = $semester['semester_id'];

        // Fetch courses field from semesters table
        $sqlCourses = $conn->query("SELECT courses FROM `semesters` WHERE `id` = '$semester_id'");
        $semesterCourses = $sqlCourses->fetch_assoc();
        $course_ids = explode(',', $semesterCourses['courses']);

        // Fetch quizzes grouped by course
        if (!empty($course_ids)) {
            $course_ids_str = implode(',', array_map('intval', $course_ids));
            $sql = $conn->query("
                SELECT q.id, q.title, q.question, q.options, q.status, q.deadline, q.created_at, c.title as course_title 
                FROM `quizes` q 
                JOIN `courses` c ON q.teacher_id = c.teacher_id 
                WHERE c.id IN ($course_ids_str) 
                ORDER BY q.created_at DESC
            ");

            $displayedQuizzes = [];
            if ($sql->num_rows > 0) {
                echo "<ul class='list-group mb-4'>";
                while ($row = $sql->fetch_assoc()) {
                    $quiz_id = $row['id'];
                    if (in_array($quiz_id, $displayedQuizzes)) {
                        continue;
                    }
                    $displayedQuizzes[] = $quiz_id;

                    $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                    $question = htmlspecialchars($row['question'], ENT_QUOTES, 'UTF-8');
                    $courseTitle = $row['course_title'];
                    $status = $row['status'];
                    $deadline = $row['deadline'];
                    $options = explode(',', $row['options']); // Assuming options are stored as comma-separated values

                    // Check if the quiz has been submitted by the student
                    $sqlSubmission = $conn->query("SELECT selected_option FROM quiz_submissions WHERE quiz_id = '$quiz_id' AND student_id = '$user_id'");
                    $submission = $sqlSubmission->fetch_assoc();
                    $submittedOption = $submission ? $submission['selected_option'] : null;
                    $submitted = $submission ? true : false;

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
                    echo "<small>Deadline: {$deadline}</small>";
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
                echo "<div class='alert alert-warning' role='alert'>No quizzes found.</div>";
            }
        } else {
            echo "<div class='alert alert-warning' role='alert'>No courses found.</div>";
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