<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';

$sql = $conn->query("SELECT * FROM `users` WHERE `role` = 'student'");
$Semester = [];
while ($row = $sql->fetch_assoc()) {
    $Semester[] = $row;
}

$students = []; 

foreach ($Semester as $semester) {
    $sql = $conn->query("SELECT * FROM `semesters` WHERE `id` = '{$semester['semester_id']}'");
    $courses = [];
    while ($row = $sql->fetch_assoc()) {
        $courses = explode(',', $row['courses']); 
    }
    foreach ($courses as $course) {
        $sql = $conn->query("SELECT * FROM `courses` WHERE `id` = '{$course}'");
        while ($row = $sql->fetch_assoc()) {
            $teachers = explode(',', $row['teacher_id']);
            if (in_array($_SESSION['id'], $teachers)) {
                if (!isset($students[$semester['id']])) {
                    $students[$semester['id']] = $semester['name'];
                }
            }
        }
    }
}

$date = date('Y-m-d');
$semester_id = $_POST['semester_id'] ?? $semester['semester_id'];

$attendanceSet = false;
$sql = $conn->query("SELECT COUNT(*) as count FROM `attendence` WHERE `date` = '$date' AND `semester_id` = '$semester_id'");
if ($row = $sql->fetch_assoc()) {
    $attendanceSet = $row['count'] > 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$attendanceSet) {
    $attendanceData = $_POST['attendance'];
    $teacher_id = $_SESSION['id'];

    foreach ($attendanceData as $student_id => $status) {
        $sql = $conn->prepare("INSERT INTO `attendence` (`date`, `teacher_id`, `semester_id`, `student_id`, `status`) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `status` = VALUES(`status`)");
        $sql->bind_param('siiss', $date, $teacher_id, $semester_id, $student_id, $status);
        $sql->execute();
    }

    $msg = 'Attendance saved successfully!';
    echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}?msg=$msg'</script>";
}
?>

<div class="container-fluid">
    <?php if (isset($_GET['msg'])): ?>
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> <?php echo $_GET['msg']; ?>
            <button type='button' class='btn-close' onclick='closeAlert()'></button>
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.alert').classList.remove('show');
                document.querySelector('.alert').classList.add('hide');
            }, 3000);

            function closeAlert() {
                document.querySelector('.alert').style.display = 'none';
            }
        </script>
    <?php endif; ?>

    <?php if ($attendanceSet): ?>
        <div class='alert alert-info' role='alert'>
            <strong>Info!</strong> Attendance for today has been set.
        </div>
        <table id="studentTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>S No.</th>
                    <th>Student Name</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sNo = 1;
                foreach ($students as $id => $student) {
                    $attendanceStatus = '';
                    $sql = $conn->query("SELECT `status` FROM `attendence` WHERE `date` = '$date' AND `student_id` = '$id'");
                    if ($row = $sql->fetch_assoc()) {
                        $attendanceStatus = $row['status'];
                    }

                    echo "
                        <tr>
                            <td>{$sNo}</td>
                            <td>{$student}</td>
                            <td>{$attendanceStatus}</td>
                        </tr>";
                    $sNo++;
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <form method="POST" action="">
            <input type="hidden" name="semester_id" value="<?php echo $semester_id; ?>">
            <table id="studentTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>S No.</th>
                        <th>Student Name</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sNo = 1;
                    foreach ($students as $id => $student) {
                        echo "
                            <tr>
                                <td>{$sNo}</td>
                                <td>{$student}</td>
                                <td>
                                    <select name='attendance[{$id}]' class='form-control'>
                                        <option value='present'>Present</option>
                                        <option value='absent'>Absent</option>
                                        <option value='leave'>Leave</option>
                                    </select>
                                </td>
                            </tr>";
                        $sNo++;
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Save Attendance</button>
        </form>
    <?php endif; ?>
</div>
<script>
    new DataTable('#studentTable');

    function closeAlert() {
        document.querySelector('.alert').style.display = 'none';
    }
</script>

<?php include './includes/footer.php' ?>