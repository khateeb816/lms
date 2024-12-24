<?php include './includes/header.php'; 
include './db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $number = $_POST['number'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $newPath = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tempPath = $_FILES['image']['tmp_name'];
        $imagename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($imagename, PATHINFO_EXTENSION)); 
        
        $newName = uniqid() . "." . $ext;
        $newPath = "./images/users/" . $newName;
    
        if (!is_dir('./images/users/')) {
            mkdir('./images/users/', 0755, true);
        }
    
        if (move_uploaded_file($tempPath, $newPath)) {
            echo "File uploaded successfully as: " . htmlspecialchars($newName);
        } else {
            echo "Error: Failed to move the uploaded file.";
        }
    } else {
        echo "No file uploaded or an error occurred during the upload.";
    }
    

    if($password == $confirmPassword){
        $encryptedPassword = password_hash($password , PASSWORD_DEFAULT);
        $sql = $conn -> query("INSERT INTO `users` (`number` , `name` , `email` , `password` , `profile`) VALUES ('$number' , '$name' , '$email' , '$encryptedPassword' , '$newPath')");
        $msg = "Application Submitted We will get back to you";
        echo ("<script>window.location.href = 'register.php?msg=$msg'</script>");

    }else{
        echo "Password Didn't match";
    }

}
?>

    <div class="modal-dialog modal-lg" role="document" style="margin-top: 10rem;">
        <div class="modal-content rounded-0 border-0 p-4">
            <h5><?php echo isset($_GET['msg'])? $_GET['msg'] : ''; ?></h5>
            <div class="modal-header border-0">
                <h3>Register</h3>
            </div>
            <div class="modal-body">
                <div class="login">
                    <form action="#" class="row" method="post" enctype="multipart/form-data">
                        <div class="col-12">
                            <input type="text" class="form-control mb-3" id="signupPhone" name="number" placeholder="Phone" required>
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control mb-3" id="signupName" name="name" placeholder="Name" required>
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control mb-3" id="signupEmail" name="email" placeholder="Email" required>
                        </div>
                        <div class="col-12">
                            <input type="password" class="form-control mb-3" id="signupPassword" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-12">
                            <input type="password" class="form-control mb-3" id="signupPassword" name="confirmPassword" placeholder="Confirm Password" required>
                        </div>
                        <div class="col-12">
                            <input type="file" class="form-control mb-3" id="image" name="image" accept="png/jpg/jpeg" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include './includes/footer.php'; ?>