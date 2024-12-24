<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="bg-light rounded p-4">
                <h6 class="mb-3">Students</h6>
                <ul class="list-group">
                    <?php
                    $teacher_id = $_SESSION['id'];
                    $sqlStudents = "
                        SELECT DISTINCT u.* 
                        FROM `users` u
                        JOIN `semesters` s ON u.semester_id = s.id
                        JOIN `courses` c ON FIND_IN_SET(c.id, s.courses)
                        WHERE u.role = 'student' AND FIND_IN_SET('$teacher_id', c.teacher_id)
                    ";
                    $resultStudents = $conn->query($sqlStudents);

                    if ($resultStudents->num_rows > 0) {
                        while ($student = $resultStudents->fetch_assoc()) {
                            echo "<li class='list-group-item'>";
                            echo "<a href='?student_id={$student['id']}'>{$student['name']}</a>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>No students found.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="col-md-8">
            <div class="bg-light rounded p-4">
                <h6 class="mb-3">Messages</h6>
                <div class="messages-box" style="height: 400px; overflow-y: scroll;">
                    <?php
                    if (isset($_GET['student_id'])) {
                        $student_id = $_GET['student_id'];
                        $sqlMessages = "SELECT * FROM `live_chat` WHERE `teacher_id` = '$teacher_id' AND `student_id` = '$student_id' ORDER BY `created_at` ASC";
                        $resultMessages = $conn->query($sqlMessages);

                        if ($resultMessages->num_rows > 0) {
                            while ($message = $resultMessages->fetch_assoc()) {
                                $sender = $message['sender'] == 'teacher' ? 'You' : 'Student';
                                $messageClass = $message['sender'] == 'teacher' ? 'message-teacher' : 'message-student';
                                $messageAlign = $message['sender'] == 'teacher' ? 'justify-content-end' : 'justify-content-start';
                                echo "<div class='d-flex $messageAlign mb-2'>";
                                echo "<div class='p-3 rounded $messageClass' style='max-width: 75%;'>";
                                echo "<strong>{$sender}:</strong> {$message['message']}<br>";
                                echo "<small><em>{$message['created_at']}</em></small>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<div class='alert alert-warning'>No messages found.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-info'>Select a student to view messages.</div>";
                    }
                    ?>
                </div>
                <?php if (isset($_GET['student_id'])): ?>
                <form action="" method="POST" class="mt-3">
                    <div class="input-group">
                        <input type="hidden" name="student_id" value="<?php echo $_GET['student_id']; ?>">
                        <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message']) && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $message = $_POST['message'];
    $teacher_id = $_SESSION['id'];

    $sqlSendMessage = $conn->prepare("INSERT INTO `live_chat` (`teacher_id`, `student_id`, `message`, `sender`) VALUES (?, ?, ?, 'teacher')");
    $sqlSendMessage->bind_param("iis", $teacher_id, $student_id, $message);

    if ($sqlSendMessage->execute()) {
        echo "<script>window.location.href = 'live_chat.php?student_id=$student_id'</script>";
    }
}
?>

<style>
.message-student {
    background-color: #e2e3e5;
    border-radius: 15px;
    padding: 10px;
    margin: 10px 0;
    text-align: left;
}
.message-teacher {
    background-color: #007bff;
    color: white;
    border-radius: 15px;
    padding: 10px;
    margin: 10px 0;
    text-align: right;
}
</style>