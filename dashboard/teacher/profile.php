<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';
include '../../db.php';

$id = $_GET['id'];
$sql = $conn->query("SELECT * FROM `users` WHERE `id` = '$id'");
$user = $sql->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $id = $_POST['id'];

    if ($conn->query("UPDATE `users` SET `name` = '$name' , `email` = '$email' , `number` = '$number' WHERE `id` = '$id'")) {
        echo ("<script> window.location.href = 'profile.php?id=$id'; </script>");
        exit();
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: rgb(99, 39, 120);
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #BA68C8;
    }

    .profile-button {
        background: rgb(99, 39, 120);
        box-shadow: none;
        border: none;
    }

    .profile-button:hover {
        background: #682773;
    }

    .profile-button:focus {
        background: #682773;
        box-shadow: none;
    }

    .profile-button:active {
        background: #682773;
        box-shadow: none;
    }

    .back:hover {
        color: #682773;
        cursor: pointer;
    }

    .labels {
        font-size: 11px;
    }

    .add-experience:hover {
        background: #BA68C8;
        color: #fff;
        cursor: pointer;
        border: solid 1px #BA68C8;
    }
</style>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" src="<?php echo "../../{$user['profile']}" ?>" style="width: 150px; height:150px;">
                <span class="font-weight-bold"><?php echo $user['name']; ?></span>
                <span class="text-black-50"><?php echo $user['email']; ?></span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <form action="" method="POST" class="p-3 py-5">
                <h6 class="text-right"><?php echo isset($_GET['msg'])? $_GET['msg']:''; ?></h6>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" placeholder="Name" value="<?php echo $user['name']; ?>" name="name"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" name="number" placeholder="Enter phone number" value="<?php echo $user['number']; ?>"></div>
                    <div class="col-md-12"><label class="labels">Email</label><input type="email" class="form-control" name="email" placeholder="Enter email" value="<?php echo $user['email']; ?>"></div>
                    <input type="hidden" class="form-control" name="id" value="<?php echo $user['id']; ?>">
                </div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" >Save Profile</button></div>
            </form>

            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="resetPassword.php" method="POST" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Reset Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <label class="labels">Current Password</label><input type="password" class="form-control" name="oldPassword"  >
                        <label class="labels">New Password</label><input type="password" class="form-control" name="newPassword"  >
                        <label class="labels">Confirm New Password</label><input type="password" class="form-control" name="confirmNewPassword"  >
                        <input type="hidden" class="form-control" name="id" value="<?php echo $user['id']; ?>" >
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" >Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 text-center"><button class="btn btn-warning" type="button" id="myModalBtn">Reset Password</button></div>
        </div>
    </div>
</div>


<script>
    document.querySelector('#myModalBtn').addEventListener('click', function (event) {
        event.preventDefault(); 
        const myModal = new bootstrap.Modal(document.querySelector('#myModal'));
        myModal.show();
    });
</script>
<?php include './includes/footer.php' ?>
