<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php' ?>
<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $title = $_POST['title'];
    $fees = $_POST['fees'];
    $description = $_POST['description'];
    $courses = $_POST['courses'];
    $courses = json_encode($courses);

    if ($conn->query("INSERT INTO `semesters` ( `title` , `description` , `status` , `fees` , `courses`) VALUES ('$title' , '$description' , '$status' , '$fees' , '$courses')")) {
        $msg = "Course Added Successfully!";
        echo ("<script>window.location.href = 'semesters.php.php?msg=$msg'</script>");
    }
}
?>

<div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content rounded-0 border-0 p-4">
        <div class="modal-header border-0">
            <h3>Add Semester</h3>
        </div>
        <div class="modal-body">
            <div class="login">
                <form action="#" class="row" method="post">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="signupPhone" name="title" placeholder="Title" required>
                    </div>
                    <div class="col-12">
                        <input type="number" class="form-control mb-3" id="signupPhone" name="fees" placeholder="Fees" required>
                    </div>
                    <div class="col-12">
                        <textarea name="description" class="form-control mb-3" id="description" placeholder="Enter Description"></textarea>
                    </div>
                    <div class="col-12">
                        <h4>Select Courses:</h4>
                        <?php
                        $sql = $conn->query("SELECT * FROM `courses`");
                        $courses = [];
                        while ($row = $sql->fetch_assoc()) {
                            $courses[] = $row;
                        }
                        foreach ($courses as $course) {
                            echo "<div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='{$course['id']}' name='courses[]' id='course{$course['id']}'> <label for='course{$course['id']}'>
                            {$course['title']}  </label>
                            </div>";
                        }

                        ?>
                    </div>

                    <div class="col-12">
                        <select name="status" id="status" class="form-control mb-3">
                            <option value="pending">pending</option>
                            <option value="active">active</option>
                            <option value="block">block</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Add Semester</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include './includes/footer.php' ?>