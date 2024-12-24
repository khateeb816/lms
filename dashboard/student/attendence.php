<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
$user_id = $_SESSION['id'];

// Fetch attendance records for the student
$sqlAttendance = $conn->query("SELECT * FROM `attendence` WHERE `student_id` = '$user_id' ORDER BY `date` DESC");
$attendanceRecords = [];
while ($row = $sqlAttendance->fetch_assoc()) {
    $attendanceRecords[] = $row;
}
?>

<div class="container-fluid">
    <h2>Attendance</h2>
    <table id="attendanceTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
                <th>Teacher</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($attendanceRecords as $record) {
                // Fetch teacher name
                $teacher_id = $record['teacher_id'];
                $sqlTeacher = $conn->query("SELECT name FROM `users` WHERE `id` = '$teacher_id'");
                $teacher = $sqlTeacher->fetch_assoc();

                // Fetch semester title
                $semester_id = $record['semester_id'];
                $sqlSemester = $conn->query("SELECT title FROM `semesters` WHERE `id` = '$semester_id'");
                $semester = $sqlSemester->fetch_assoc();

                echo "
                    <tr>
                        <td>" . htmlspecialchars($record['Date'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($record['status'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($teacher['name'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($semester['title'], ENT_QUOTES, 'UTF-8') . "</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    new DataTable('#attendanceTable');
</script>

<?php include './includes/footer.php'; ?>