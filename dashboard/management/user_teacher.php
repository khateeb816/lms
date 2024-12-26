<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';

$sql = $conn->query("SELECT * FROM `users` WHERE `role` = 'teacher'");
$students = [];
while ($row = $sql->fetch_assoc()) {
    $students[] = $row;
}

?>


<div class="container-fluid">
<a href="add_user.php" class="btn btn-primary my-2">Add Teacher</a>

    <table id="studentTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Joined</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
foreach ($students as $student) {
    $studentId = htmlspecialchars($student['id'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($student['status'], ENT_QUOTES, 'UTF-8');
    echo "<tr>
        <td>" . htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') . "</td>
        <td>" . htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') . "</td>
        <td>" . htmlspecialchars($student['number'], ENT_QUOTES, 'UTF-8') . "</td>
        <td>" . htmlspecialchars($student['created_at'], ENT_QUOTES, 'UTF-8') . "</td>
        <td>
            <select name='status' id='status_$studentId' class='form-control form-select' onchange='changeStatus($studentId, this.value)'>
                <option value='pending'" . ($status == 'pending' ? " selected" : "") . ">Pending</option>
                <option value='active'" . ($status == 'active' ? " selected" : "") . ">Active</option>
                <option value='block'" . ($status == 'block' ? " selected" : "") . ">Block</option>
            </select>
        </td>
        <td>
        <a href = '../delete_user.php?id=$studentId' class='btn btn-danger'>Delete</a>
        <a href = './update_user.php?id=$studentId' class='btn btn-primary'>Edit</a>
        </td>
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
        window.location.href = "changeStatus.php?status=" + status + "&id=" + id;
    }
</script>

<?php include './includes/footer.php' ?>