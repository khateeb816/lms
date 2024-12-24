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
        $teacher_id = $_SESSION['id'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            echo "<div class='alert alert-danger'>Sorry, file already exists.</div>";
            $uploadOk = 0;
        }

        if ($_FILES["file"]["size"] > 5000000) { // 5MB limit
            echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx" && $fileType != "txt") {
            echo "<div class='alert alert-danger'>Sorry, only PDF, DOC, DOCX, & TXT files are allowed.</div>";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $sql = $conn->prepare("INSERT INTO `assignments` (`title`, `description`, `file`, `course_id`, `teacher_id`) VALUES (?, ?, ?, ?, ?)");
                $sql->bind_param("sssii", $title, $description, $target_file, $course_id, $teacher_id);
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
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="course_id" class="form-label">Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <option value="">Select Course</option>
                <?php
                while ($course = $courses_sql->fetch_assoc()) {
                    echo "<option value='{$course['id']}'>{$course['title']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">File</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include './includes/footer.php'; ?>