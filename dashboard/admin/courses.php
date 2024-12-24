<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';

$sql = $conn->query("SELECT * FROM `courses`");
$students = [];
while ($row = $sql->fetch_assoc()) {
    $students[] = $row;
}

?>


<div class="container-fluid">
    <a href="add_course.php" class="btn btn-primary my-2">Add Course</a>
    <?php if (isset($_GET['msg'])) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    {$_GET['msg']}<script>setTimeout(()=>{
            document.querySelector('.alert').style.display = 'none';
        },3000)</script>
                      <button type='button' class='close btn' data-dismiss='alert' aria-label='Close' onclick = 'closeAlert()'>
                        <span aria-hidden='true'>&times;</span>
                      </button>
                    </div>";
    } ?>
    <table id="studentTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>S No.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Created at</th>
                <th>Assign to</th>
                <th>Status</th>
                <th>Button</th>
            </tr>
        </thead>
        <tbody>
            <?php


            $sNo = 1;
            foreach ($students as $student) {

                $oldTeachers = explode( ',', $student['teacher_id']);

                $sqlTeachers = $conn->query("SELECT * FROM `users` WHERE `role` = 'teacher'");
                $teachers = [];
                while ($row = $sqlTeachers->fetch_assoc()) {
                    $teachers[] = $row;
                }
                $id = htmlspecialchars($student['id'], ENT_QUOTES, 'UTF-8');
                $status = htmlspecialchars($student['status'], ENT_QUOTES, 'UTF-8');
                echo "    <form action='changeTeacher.php' method='POST'>
                        <tr>
                        <td>" . $sNo . "</td>
                        <td>" . htmlspecialchars($student['title'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($student['description'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($student['created_at'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>
                        ";
                echo "<select name='teacherss[]' id='teachers' multiple class='form-control'>";
                foreach ($teachers as $teacher) {
                    $selected = in_array($teacher['id'], $oldTeachers) ? 'selected' : '';
                    echo "<option value='{$teacher['id']}' $selected>{$teacher['name']}</option>";
                }
                echo "</select>";
                echo "
                        </td>
                        <input type='hidden' name='courseid' value='$id'>
                        <td>
                            <select name='status' id='status_$id' class='form-control' onchange='changeStatus($id, this.value)'>
                                <option value='pending'" . ($status == 'pending' ? " selected" : "") . ">Pending</option>
                                <option value='active'" . ($status == 'active' ? " selected" : "") . ">Active</option>
                                <option value='block'" . ($status == 'block' ? " selected" : "") . ">Block</option>
                            </select>
                        </td>
                        <td><button type = 'submit' class = 'btn btn-primary'>Change</td>

                    </tr>
                        </form>";
                $sNo++;
            }
            ?>



        </tbody>
    </table>
</div>
<script>
    new DataTable('#studentTable');

    function changeStatus(id) {
        let status = document.getElementById('status_' + id).value;
        window.location.href = "changeCourseStatus.php?status=" + status + "&id=" + id;
    }

    function closeAlert() {
        document.querySelector('.alert').style.display = 'none';
    }
</script>

<?php include './includes/footer.php' ?>