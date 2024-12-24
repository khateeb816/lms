<!DOCTYPE html>
<html lang="en">


<?php
session_start();
include '../../db.php';
$sql = $conn -> query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['id']}'");
$user = $sql -> fetch_assoc();

$user_id = $_SESSION['id'];
$sql = $conn->query("SELECT * FROM `alerts` WHERE `user_id` = '$user_id' AND `status` = 'unread' ORDER BY `created_at` DESC LIMIT 5");
?>

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- DataTables Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet">


    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    </head>

<body>

        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown"><!-- Notifications -->
                        <?php
                        include '../../db.php'; // Include your database connection file

                        $user_id = $_SESSION['id'];
                        $sql = $conn->query("SELECT COUNT(*) as unread_count FROM `alerts` WHERE `user_id` = '$user_id' AND `status` = 'unread'");
                        $unread_count = $sql->fetch_assoc()['unread_count'];
                        ?>

                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <?php if ($unread_count > 0): ?>
                                <span class="badge bg-danger rounded-pill" style="position: absolute; top: 10px; right: 10px;"><?php echo $unread_count; ?></span>
                            <?php endif; ?>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <?php
                            $sql = $conn->query("SELECT * FROM `alerts` WHERE `user_id` = '$user_id' AND `status` = 'unread' ORDER BY `created_at` DESC LIMIT 5");

                            if ($sql->num_rows > 0) {
                                while ($row = $sql->fetch_assoc()) {
                                    echo "<a href='messages.php' class='dropdown-item'>";
                                    echo "<h6 class='fw-normal mb-0'>{$row['title']}</h6>";
                                    echo "<small>{$row['created_at']}</small>";
                                    echo "</a>";
                                }
                            } else {
                                echo "<a href='#' class='dropdown-item'>";
                                echo "<h6 class='fw-normal mb-0'>No new messages</h6>";
                                echo "</a>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="nav-item dropdown"><!-- Profile -->
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="<?php echo "../../{$user['profile']}" ?>" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $user['name'];?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href ="./profile.php?id=<?php echo $user['id'];?>" class="dropdown-item">My Profile</a>
                            <a href="../../logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>