<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <h2>Add New Assignment</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $course_id = $_POST['course_id'];
        $deadline = $_POST['deadline'];
        $teacher_id = $_SESSION['id'];

        $target_dir = "uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newName = uniqid() . "." . $ext;
        $target_file = $target_dir . $newName;
        $uploadOk = 1;

        if (file_exists($target_file)) {
            echo "<div class='alert alert-danger'>Sorry, file already exists.</div>";
            $uploadOk = 0;
        }

        if ($_FILES["file"]["size"] > 5000000) { // 5MB limit
            echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "../" . $target_file)) {
                $sql = $conn->prepare("INSERT INTO `assignments` (`title`, `description`, `file`, `course_id`, `teacher_id`, `deadline`) VALUES (?, ?, ?, ?, ?, ?)");
                $sql->bind_param("sssiss", $title, $description, $target_file, $course_id, $teacher_id, $deadline);
                if ($sql->execute()) {
                    echo "<div class='alert alert-success'>The assignment has been uploaded successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $sql->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
            }
        }
    }

    $teacher_id = $_SESSION['id'];
    $courses_sql = $conn->query("SELECT * FROM `courses` WHERE FIND_IN_SET('$teacher_id', `teacher_id`)");
    ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Assignment Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Assignment Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="course_id">Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <?php while ($course = $courses_sql->fetch_assoc()): ?>
                    <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['title']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
        </div>
        <div class="form-group my-2">
            <label for="file">Assignment File</label>
            <input type="file" class="form-control-file" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Assignment</button>
    </form>
</div>

<?php include './includes/footer.php'; ?>