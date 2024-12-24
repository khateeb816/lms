<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';
include '../../db.php';


// Fetch top 5 messages from alerts table
$user_id = $_SESSION['id'];
$sqlMessages = "SELECT * FROM `alerts` WHERE `user_id` = '$user_id' ORDER BY `created_at` DESC LIMIT 5";
$sqlMessagesResult = $conn->query($sqlMessages);
if (!$sqlMessagesResult) {
    die("Database query failed: " . $conn->error);
}
$messages = $sqlMessagesResult->fetch_all(MYSQLI_ASSOC);
?>

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