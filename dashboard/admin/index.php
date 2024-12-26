<?php include './includes/header.php' ?>
<?php include './includes/sidebar.php';
include '../../db.php';
$sqlCounts = " SELECT 
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'student') AS Active_Users,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'student') AS Blocked_Users,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'student') AS Pending_Users,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'student') AS Active_Management,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'student') AS Blocked_Management,
        (SELECT COUNT(*) FROM `users` WHERE `status` = 'active' AND `role` = 'student') AS Pending_Management,
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


<?php include './includes/footer.php' ?>