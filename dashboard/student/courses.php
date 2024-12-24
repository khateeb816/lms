<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
$user_id = $_SESSION['id'];

// Fetch semester_id for the student
$sqlSemester = $conn->query("SELECT semester_id FROM `users` WHERE `id` = '$user_id' AND `role` = 'student'");
$semester = $sqlSemester->fetch_assoc();
$semester_id = $semester['semester_id'];

// Fetch courses field from semesters table
$sqlCourses = $conn->query("SELECT courses FROM `semesters` WHERE `id` = '$semester_id'");
$semesterCourses = $sqlCourses->fetch_assoc();
$course_ids = explode(',', $semesterCourses['courses']);

// Fetch course details from courses table
$courses = [];
if (!empty($course_ids)) {
    $course_ids_str = implode(',', array_map('intval', $course_ids));
    $sql = $conn->query("SELECT * FROM `courses` WHERE `id` IN ($course_ids_str)");
    while ($row = $sql->fetch_assoc()) {
        $courses[] = $row;
    }
}
?>

<div class="container-fluid">
    <h2>Courses</h2>
    <table id="courseTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>S No.</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sNo = 1;
            foreach ($courses as $course) {
                echo "
                    <tr>
                        <td>{$sNo}</td>
                        <td>" . htmlspecialchars($course['title'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8') . "</td>
                    </tr>";
                $sNo++;
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    new DataTable('#courseTable');
</script>

<?php include './includes/footer.php'; ?>