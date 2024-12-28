<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
$student_id = $_SESSION['id'];

// Fetch student details
$sqlStudent = $conn->query("SELECT * FROM `users` WHERE `id` = '$student_id' AND `role` = 'student'");
$student = $sqlStudent->fetch_assoc();

// Fetch pending fee
$sqlFee = $conn->query("SELECT `fees` FROM `semesters` WHERE `id` = '{$student['semester_id']}'");
$fee = $sqlFee->fetch_assoc();
$pendingFee = $student['fee_status'] == 'unpaid' ? $fee['fees'] : 0;

// Fetch fines
$sqlFines = $conn->query("SELECT * FROM `fines` WHERE `user_id` = '$student_id'");
$fines = [];
while ($fine = $sqlFines->fetch_assoc()) {
    $fines[] = $fine;
}
?>

<div class="container-fluid p-2">
    <h2>Finance</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Pending Fee</h3>
        </div>
        <div class="card-body">
            <p>Pending Fee: <?php echo htmlspecialchars($pendingFee, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Fines</h3>
        </div>
        <div class="card-body">
            <?php if (count($fines) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($fines as $fine): ?>
                        <li class="list-group-item">
                            <strong>Amount:</strong> <?php echo htmlspecialchars($fine['amount'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <strong>Reason:</strong> <?php echo htmlspecialchars($fine['reason'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <strong>Date:</strong> <?php echo htmlspecialchars($fine['created_at'], ENT_QUOTES, 'UTF-8'); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No fines.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>