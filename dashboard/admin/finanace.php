<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';

$sql = $conn->query("SELECT * FROM `users` WHERE `role` = 'student'");
$students = [];
while ($row = $sql->fetch_assoc()) {
    $students[] = $row;
}

?>


<div class="container-fluid p-2">
    <a href="add_user.php" class="btn btn-primary my-2">Add Student</a>
    <table id="studentTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Unpaid Fee</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
foreach ($students as $student) {
    
    $fee = $conn->query("SELECT `fees` FROM `semesters` WHERE `id` = '{$student['semester_id']}'")->fetch_assoc();
    $studentId = htmlspecialchars($student['id'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($student['status'], ENT_QUOTES, 'UTF-8');
    echo "<tr>
        <td>" . htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') . "</td>
        <td>" . htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') . "</td>
        <td>" . htmlspecialchars($student['fee_status'] == 'unpaid'? $fee['fees'] : 0, ENT_QUOTES, 'UTF-8') . "</td>
        <td><button class = 'btn btn-info'" . ($student['fee_status'] === 'paid'? 'disabled' : '') . " onclick = 'sendFeeAlert({$student['id']})' >Send Fee Alert</button> </td>
    </tr>";
}
?>



        </tbody>
    </table>
</div>


<script>
    new DataTable('#studentTable');

    function changeStatus(id) {
        let status = document.getElementById('status_' + id).value;
        window.location.href = 'changeStatus.php?status=' + status + '&id=' + id;
    }
    function sendFeeAlert(id) {
        if (confirm('Are you sure you want to send fee alert to this student?')) {
            window.location.href = 'sendFeeAlert.php?id=' + id + '&msg=You have pending fee';
        }
    }
</script>

<?php include './includes/footer.php' ?>