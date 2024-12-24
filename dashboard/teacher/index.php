<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';
include '../../db.php';

$sqlCounts = " SELECT 
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'student') AS Total_Students,
        (SELECT COUNT(*) FROM `courses` WHERE `status` = 'active' ) AS Total_Courses
        ";

$sqlCountsResult = $conn->query($sqlCounts);
if (!$sqlCountsResult) {
    die("Database query failed: " . $conn->error);
}
$counts = $sqlCountsResult->fetch_assoc();

function renderCard($name, $count)
{
    echo "<div class='col-sm-6 col-xl-4'>
            <div class='bg-light rounded d-flex align-items-center justify-content-between p-4'>
                <i class='fa fa-chart-pie fa-3x text-primary'></i>
                <div class='ms-3'>
                    <p class='mb-2'>$name</p>
                    <h6 class='mb-0'>$count</h6>
                </div>
            </div>
        </div>";
}

$user_id = $_SESSION['id'];
$sqlMessages = "SELECT * FROM `alerts` WHERE `user_id` = '$user_id' ORDER BY `created_at` DESC LIMIT 5";
$sqlMessagesResult = $conn->query($sqlMessages);
if (!$sqlMessagesResult) {
    die("Database query failed: " . $conn->error);
}
$messages = $sqlMessagesResult->fetch_all(MYSQLI_ASSOC);
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
                    <a href="messages.php">Show All</a>
                </div>
                <?php
                if (count($messages) > 0) {
                    foreach ($messages as $message) {
                        echo "<div class='d-flex align-items-center border-bottom py-3'>";
                        echo "<img class='rounded-circle flex-shrink-0' src='img/user.jpg' alt='' style='width: 40px; height: 40px;'>";
                        echo "<div class='w-100 ms-3'>";
                        echo "<div class='d-flex w-100 justify-content-between'>";
                        echo "<h6 class='mb-0'>{$message['title']}</h6>";
                        echo "<small>{$message['created_at']}</small>";
                        echo "</div>";
                        echo "<span>{$message['message']}</span>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='alert alert-warning' role='alert'>No messages found.</div>";
                }
                ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-light rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Calender</h6>
                </div>
                <div id="calender"></div>
            </div>
        </div>
    </div>
</div>
<!-- Widgets End -->


<?php include './includes/footer.php' ?>