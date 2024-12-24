<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php' ?>
<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if ($conn->query("INSERT INTO `courses` ( `title` , `description` , `status`) VALUES ('$title' , '$description' , '$status')")) {
        $msg = "Course Added Successfully!";
        echo ("<script>window.location.href = 'courses.php?msg=$msg'</script>");
    }
}
?>

<div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content rounded-0 border-0 p-4">
        <div class="modal-header border-0">
            <h3>Add Course</h3>
        </div>
        <div class="modal-body">
            <div class="login">
                <form action="#" class="row" method="post">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="signupPhone" name="title" placeholder="Title" required>
                    </div>
                    <div class="col-12">
                        <textarea name="description" class="form-control mb-3" id="description" placeholder="Enter Description"></textarea>
                    </div>

                    <div class="col-12">
                        <select name="status" id="status" class="form-control mb-3">
                            <option value="pending">pending</option>
                            <option value="active">active</option>
                            <option value="block">block</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include './includes/footer.php' ?>