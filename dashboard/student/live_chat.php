<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Teachers List -->
        <div class="col-md-4">
            <div class="bg-light rounded p-4">
                <h6 class="mb-3">Teachers</h6>
                <ul class="list-group">
                    <?php
                    $student_id = $_SESSION['id'];
                    $sqlTeachers = "
                        SELECT DISTINCT u.* 
                        FROM `users` u
                        JOIN `courses` c ON u.id = c.teacher_id
                        JOIN `semesters` s ON FIND_IN_SET(c.id, s.courses)
                        WHERE u.role = 'teacher' AND s.id = (SELECT semester_id FROM `users` WHERE id = '$student_id')
                    ";
                    $resultTeachers = $conn->query($sqlTeachers);

                    if ($resultTeachers->num_rows > 0) {
                        while ($teacher = $resultTeachers->fetch_assoc()) {
                            echo "<li class='list-group-item'>";
                            echo "<a href='?teacher_id={$teacher['id']}'>{$teacher['name']}</a>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>No teachers found.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Messages Box -->
        <div class="col-md-8">
            <div class="bg-light rounded p-4">
                <h6 class="mb-3">Messages</h6>
                <div class="messages-box" style="height: 400px; overflow-y: scroll;">
                    <?php
                    if (isset($_GET['teacher_id'])) {
                        $teacher_id = $_GET['teacher_id'];
                        $sqlMessages = "SELECT * FROM `live_chat` WHERE `teacher_id` = '$teacher_id' AND `student_id` = '$student_id' ORDER BY `created_at` ASC";
                        $resultMessages = $conn->query($sqlMessages);

                        if ($resultMessages->num_rows > 0) {
                            while ($message = $resultMessages->fetch_assoc()) {
                                $messageClass = $message['sender'] == 'student' ? 'message-student' : 'message-teacher';
                                echo "<div class='message $messageClass'>";
                                echo "<strong>{$message['sender']}:</strong> {$message['message']}<br>";
                                echo "<small class='text-muted'>{$message['created_at']}</small>";
                                echo "</div>";
                            }
                        } else {
                            echo "<div class='alert alert-info'>No messages found.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-info'>Select a teacher to view messages.</div>";
                    }
                    ?>
                </div>
                <?php
                if (isset($_GET['teacher_id'])) {
                    echo "<form action='' method='POST' class='mt-3'>";
                    echo "<input type='hidden' name='teacher_id' value='$teacher_id'>";
                    echo "<div class='input-group'>";
                    echo "<input type='text' name='message' class='form-control' placeholder='Type your message...' required>";
                    echo "<button type='submit' class='btn btn-primary'>Send</button>";
                    echo "</div>";
                    echo "</form>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>

<?php
// Handle message sending
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message']) && isset($_POST['teacher_id'])) {
    $teacher_id = $_POST['teacher_id'];
    $message = $_POST['message'];
    $student_id = $_SESSION['id'];

    $sqlSendMessage = $conn->prepare("INSERT INTO `live_chat` (`teacher_id`, `student_id`, `message`, `sender`) VALUES (?, ?, ?, 'student')");
    $sqlSendMessage->bind_param("iis", $teacher_id, $student_id, $message);

    if ($sqlSendMessage->execute()) {
        echo "<script>window.location.href = 'live_chat.php?teacher_id=$teacher_id'</script>";
    }
}
?>

<style>
.message-student {
    background-color: #d1ecf1;
    border-radius: 15px;
    padding: 10px;
    margin: 10px 0;
    text-align: right;
}
.message-teacher {
    background-color: #e2e3e5;
    border-radius: 15px;
    padding: 10px;
    margin: 10px 0;
    text-align: left;
}
</style>