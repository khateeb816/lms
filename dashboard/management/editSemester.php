<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php' ?>
<?php
include '../../db.php';

$semester_id = $_GET['id'];

// Fetch semester details
$sql = $conn->query("SELECT * FROM `semesters` WHERE `id` = '$semester_id'");
$semester = $sql->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $courses = isset($_POST['courses']) ? implode(',', $_POST['courses']) : '';
    $fees = $_POST['fees'];

    // Update semester details in the database
    $sql = $conn->query("UPDATE `semesters` SET `title` = '$title', `courses` = '$courses', `fees` = '$fees' WHERE `id` = '$semester_id'");
    if ($sql) {
        echo "<script>alert('Semester updated successfully.'); window.location.href = 'semesters.php';</script>";
    } else {
        echo "<script>alert('Error updating semester.');</script>";
    }
}

// Fetch all courses for the multi-select dropdown
$sqlCourses = $conn->query("SELECT * FROM `courses`");
$selectedCourses = explode(',', $semester['courses']);
?>

<div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Semester</h5>
        </div>
        <div class="modal-body">
            <form method="POST">
                <div class="form-group">
                    <label for="title">Semester Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($semester['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="courses">Courses</label>
                    <select class="form-control" id="courses" name="courses[]" multiple required>
                        <?php while ($course = $sqlCourses->fetch_assoc()): ?>
                            <option value="<?php echo $course['id']; ?>" <?php echo in_array($course['id'], $selectedCourses) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($course['title']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fees">Fees</label>
                    <input type="number" class="form-control" id="fees" name="fees" value="<?php echo htmlspecialchars($semester['fees']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary my-2">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php' ?>