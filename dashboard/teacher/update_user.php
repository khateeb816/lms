<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php' ?>
<?php
include '../../db.php';

$user_id = $_GET['id'];

$sql = $conn->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
$user = $sql->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number = $_POST['number'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $newPath = $user['profile']; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tempPath = $_FILES['image']['tmp_name'];
        $imagename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($imagename, PATHINFO_EXTENSION));

        $newName = uniqid() . "." . $ext;
        $newPath = "images/users/" . $newName;

        if (!is_dir('../../images/users/')) {
            mkdir('../../images/users/', 0755, true);
        }

        if (move_uploaded_file($tempPath, "../../" . $newPath)) {
            echo "File uploaded successfully as: " . htmlspecialchars($newName);
        } else {
            echo "Error: Failed to move the uploaded file.";
        }
    }

    if ($password == $confirmPassword) {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = $conn->query("UPDATE `users` SET `number` = '$number', `name` = '$name', `email` = '$email', `password` = '$encryptedPassword', `profile` = '$newPath', `role` = '$role' WHERE `id` = '$user_id'");
        echo ("<script>window.location.href = '{$_SERVER['HTTP_REFERER']}'</script>");
    } else {
        echo "Password didn't match";
    }
}
?>

<div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update User</h5>
        </div>
        <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="number">Number</label>
                    <input type="text" class="form-control" id="number" name="number" value="<?php echo htmlspecialchars($user['number']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="student" <?php echo $user['role'] == 'student' ? 'selected' : ''; ?>>Student</option>
                        <option value="teacher" <?php echo $user['role'] == 'teacher' ? 'selected' : ''; ?>>Teacher</option>
                        <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div class="form-group">
                    <label for="image">Profile Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <?php if ($user['profile']): ?>
                        <img src="<?php echo '../../' . $user['profile']; ?>" alt="Profile Image" style="width: 100px; height: 100px; margin-top: 10px;">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php' ?>