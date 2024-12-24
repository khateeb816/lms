<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<div class="container-fluid">
    <h2>Add New Quiz</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $question = $_POST['question'];
        $options = implode(',', [$_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['option4']]);
        $teacher_id = $_SESSION['id'];

        $sql = $conn->prepare("INSERT INTO `quizes` (`title`, `question`, `options`, `teacher_id`) VALUES (?, ?, ?, ?)");
        $sql->bind_param("sssi", $title, $question, $options, $teacher_id);
        if ($sql->execute()) {
            echo "<div class='alert alert-success'>The quiz has been added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql->error . "</div>";
        }
    }
    ?>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="option1" class="form-label">Option 1</label>
            <input type="text" class="form-control" id="option1" name="option1" required>
        </div>
        <div class="mb-3">
            <label for="option2" class="form-label">Option 2</label>
            <input type="text" class="form-control" id="option2" name="option2" required>
        </div>
        <div class="mb-3">
            <label for="option3" class="form-label">Option 3</label>
            <input type="text" class="form-control" id="option3" name="option3" required>
        </div>
        <div class="mb-3">
            <label for="option4" class="form-label">Option 4</label>
            <input type="text" class="form-control" id="option4" name="option4" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include './includes/footer.php'; ?>