<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php' ?>
<?php
include '../../db.php';

if (isset($_GET['user'])) {
    $sql = $conn->query("SELECT * FROM `users` WHERE `role` = '{$_GET['user']}'");
    $users = [];
    while ($row = $sql->fetch_assoc()) {
        $users[] = $row;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $users = $_POST['users'];
    $sql = $conn->query("INSERT INTO `alerts`(`title`, `message`, `user_id`) VALUES ('$title', '$description', '$users')");
    if($sql){

        echo('<script>window.location.href='.$_SERVER['HTTP_REFERER'].'?msg=Message sent successfully</script>');
    }
}

?>

<div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content rounded-0 border-0 p-4">
    <?php if (isset($_GET['msg'])) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    {$_GET['msg']}<script>setTimeout(()=>{
            document.querySelector('.alert').style.display = 'none';
        },3000)</script>
                      <button type='button' class='close btn' data-dismiss='alert' aria-label='Close' onclick = 'closeAlert()'>
                      </button>
                    </div>";
    } ?>
        <div class="modal-header border-0">
            <h3>Send Message</h3>
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
                        <select name="users" id="users" class="form-control mb-3">
                            <?php
                            foreach ($users as $user) {
                                echo "<option value='{$user['id']}'>{$user['name']} : {$user['email']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include './includes/footer.php' ?>