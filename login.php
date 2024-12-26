<?php include './includes/header.php';
include './db.php';


if (isset($_SESSION['role'])) {
    redirect();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = $conn->query("SELECT * FROM `users` WHERE `email` = '$email'");
    if ($sql->num_rows > 0) {
        $row = $sql->fetch_assoc();
        if (password_verify($password, $row['password'])) {

            if ($row['status'] == 'pending') {
                $msg = 'Your Account is Pending';
                echo "<script>window.location.href = 'login.php?msg=$msg';</script>";
                exit();
            } elseif ($row['status'] == 'blocked') {
                $msg = 'Your Account is Blocked';
                echo "<script>window.location.href = 'login.php?msg=$msg';</script>";
                exit();
            } elseif ($row['status'] == 'active') {
                $msg = 'Login Successful';
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                redirect();
                exit();
            }
            else {
                $msg = 'Invalid Account';
                echo "<script>window.location.href = 'login.php?msg=$msg';</script>";
                exit();
            }
        } else {
            $msg = 'Invalid Password';
            echo "<script>window.location.href = 'login.php?msg=$msg';</script>";
            exit();
        }
    } else {
        $msg = 'Account not Found';
        echo "<script>window.location.href = 'login.php?msg=$msg';</script>";
        exit();
    }
}
?>

<div class="modal-dialog  modal-lg" role="document" style="margin-top: 10rem;">
    <div class="modal-content rounded-0 border-0 p-4">
        <h5><?php echo isset($_GET['msg']) ? $_GET['msg'] : ''; ?></h5>
        <div class="modal-header border-0">
            <h3>Login</h3>
            </button>
        </div>
        <div class="modal-body">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row">

                <div class="col-12">
                    <input type="email" class="form-control mb-3" id="email" name="email" placeholder="Your Email">
                </div>
                <div class="col-12">
                    <input type="password" class="form-control mb-3" id="loginPassword" name="password" placeholder="Password">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include './includes/footer.php' ?>