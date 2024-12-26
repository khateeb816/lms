<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';

$sql = $conn->query("SELECT * FROM `semesters`");
$students = [];
while ($row = $sql->fetch_assoc()) {
    $students[] = $row;
}

?>


<div class="container-fluid">
    <a href="add_semester.php" class="btn btn-primary my-2">Add semester</a>
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
                <th>Courses</th>
                <th>Created at</th>
                <th>Fees</th>
                <th>Status</th>
                <th>button</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php


            $sNo = 1;
            foreach ($students as $student) {
                $courses = [];
                $sqlCourses = $conn->query("SELECT * FROM `courses`");
                while($row = $sqlCourses->fetch_assoc()){
                    $courses[] = $row;
                }
                $id = htmlspecialchars($student['id'], ENT_QUOTES, 'UTF-8');
                $status = htmlspecialchars($student['status'], ENT_QUOTES, 'UTF-8');
                $selectedCourse = explode(',', $student['courses']);
                echo "<tr>
                        <td>" . $sNo . "</td>
                        <td>" . htmlspecialchars($student['title'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($student['description'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>
                        <form action='updateSemesterCourses.php' method='POST'>
                        <select name='courses[]' id='courses' multiple class='form-control'>";
                        foreach ($courses as $course) {
                            $selected = in_array($course['id'], $selectedCourse) ? 'selected' : '';

                            echo "<option value='{$course['id']}' $selected>" . $course['title'] . "</option>";
                        }
                        echo "
                        </select>
                        </td>
                        <td>" . htmlspecialchars($student['created_at'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($student['fees'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>
                            <select name='status' id='status_$id' class='form-control form-select' onchange='changeStatus($id, this.value)'>
                                <option value='pending'" . ($status == 'pending' ? " selected" : "") . ">Pending</option>
                                <option value='active'" . ($status == 'active' ? " selected" : "") . ">Active</option>
                                <option value='block'" . ($status == 'block' ? " selected" : "") . ">Block</option>
                            </select>
                        </td>
                        <input type='hidden' name='semesterid' value='$id'>
                        <td><button type = 'submit' class = 'btn btn-primary'>Update</button></td>
                        </form>
                        <td><a href='deleteSemester.php?id=$id' class='btn btn-danger'>Delete</a>
                        <a href='editSemester.php?id=$id' class='btn btn-primary'>Edit</a>
                        </td>
                        </tr>";
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
        window.location.href = "changesemesterStatus.php?status=" + status + "&id=" + id;
    }
    function changeTeacher(id){
        let teacher = document.getElementById('teacher_' + id).value;
        window.location.href = "changeTeacher.php?teacherid=" + teacher + "&semesterid=" + id;

    }
    function closeAlert(){
        document.querySelector('.alert').style.display = 'none';
    }
</script>

<?php include './includes/footer.php' ?>