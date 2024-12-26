<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
$user_id = $_SESSION['id']; // Assuming the user ID is stored in the session

$sqlCounts = " SELECT 
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'student') AS Active_Students,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'block' AND `role` = 'student') AS Blocked_Students,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'pending' AND `role` = 'student') AS Pending_Students,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'teacher') AS Active_Teachers,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'block' AND `role` = 'teacher') AS Blocked_Teachers,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'pending' AND `role` = 'teacher') AS Pending_Teachers,
        (SELECT COUNT(*) FROM `courses` WHERE `status` = 'active' ) AS Active_Courses,
        (SELECT COUNT(*) FROM `courses` WHERE `status` = 'block' ) AS Blocked_Courses,
        (SELECT COUNT(*) FROM `courses` WHERE `status` = 'pending' ) AS Pending_Courses
        ";

$sqlCountsResult = $conn->query($sqlCounts);
if (!$sqlCountsResult) {
    die("Database query failed: " . $conn->error);
}
$counts = $sqlCountsResult->fetch_assoc();
function renderCard($name, $count)
{
    echo "<div class='col-sm-6 col-md-4 col-xl-3'>
            <div class='bg-light rounded d-flex align-items-center justify-content-between p-4'>
                <i class='fa fa-chart-pie fa-3x text-primary'></i>
                <div class='ms-3'>
                    <p class='mb-2'>$name</p>
                    <h6 class='mb-0'>$count</h6>
                </div>
            </div>
        </div>";
}



?>

<!-- Cards Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <?php foreach($counts as $name => $count){
            $Text = str_replace("_", " ", $name);

            renderCard($Text, $count);
        }
        ?>
    </div>
</div>
<!-- Cards End  -->
<!-- Widgets Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-light rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Messages</h6>
                    <a href="all_messages.php">Show All</a>
                </div>
                <?php
                // Fetch the top 5 messages sent to the current user
                $sqlMessages = $conn->query("SELECT * FROM `alerts` WHERE `user_id` = '$user_id' ORDER BY `created_at` DESC LIMIT 5");

                if ($sqlMessages->num_rows > 0) {
                    while ($message = $sqlMessages->fetch_assoc()) {
                        $title = htmlspecialchars($message['title']);
                        $messageContent = htmlspecialchars($message['message']);
                        $createdAt = htmlspecialchars($message['created_at']);
                        echo "
                        <div class='d-flex align-items-center border-bottom py-3'>
                            <img class='rounded-circle flex-shrink-0' src='img/user.jpg' alt='' style='width: 40px; height: 40px;'>
                            <div class='w-100 ms-3'>
                                <div class='d-flex w-100 justify-content-between'>
                                    <h6 class='mb-0'>{$title}</h6>
                                    <small>{$createdAt}</small>
                                </div>
                                <span>{$messageContent}</span>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<div class='alert alert-info'>No messages found.</div>";
                }
                ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-light rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Calender</h6>
                    <a href="">Show All</a>
                </div>
                <div id="calender"></div>
            </div>
        </div>
    </div>
</div>
<!-- Widgets End -->


<?php include './includes/footer.php'; ?>