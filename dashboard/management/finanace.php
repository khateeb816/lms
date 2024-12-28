<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['student_id']) && isset($_POST['amount']) && isset($_POST['reason'])) {
        // Add fine
        $student_id = $_POST['student_id'];
        $amount = $_POST['amount'];
        $reason = $_POST['reason'];

        $stmt = $conn->prepare("INSERT INTO `fines` (`user_id`, `amount`, `reason`) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $student_id, $amount, $reason);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'finanace.php?msg=Fine Added Successfully!';</script>";
        } else {
            echo "<script>window.location.href = 'finanace.php?msg=Error adding fine.';</script>";
        }

        $stmt->close();
    } elseif (isset($_POST['fine_id']) && isset($_POST['update_amount']) && isset($_POST['update_reason'])) {
        // Update fine
        $fine_id = $_POST['fine_id'];
        $amount = $_POST['update_amount'];
        $reason = $_POST['update_reason'];

        $stmt = $conn->prepare("UPDATE `fines` SET `amount` = ?, `reason` = ? WHERE `id` = ?");
        $stmt->bind_param("isi", $amount, $reason, $fine_id);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'finanace.php?msg=Fine Updated Successfully!';</script>";
        } else {
            echo "<script>window.location.href = 'finanace.php?msg=Error updating fine.';</script>";
        }

        $stmt->close();
    } elseif (isset($_POST['delete_fine_id'])) {
        // Delete fine
        $fine_id = $_POST['delete_fine_id'];

        $stmt = $conn->prepare("DELETE FROM `fines` WHERE `id` = ?");
        $stmt->bind_param("i", $fine_id);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'finanace.php?msg=Fine Deleted Successfully!';</script>";
        } else {
            echo "<script>window.location.href = 'finanace.php?msg=Error deleting fine.';</script>";
        }

        $stmt->close();
    }
}

$sql = $conn->query("SELECT * FROM `users` WHERE `role` = 'student'");
$students = [];
while ($row = $sql->fetch_assoc()) {
    $students[] = $row;
}
?>

<?php if (isset($_GET['msg'])): ?>
    <div id="successMessage" class="alert alert-success fixed-top" style="z-index: 1050;">
        <?php echo $_GET['msg'];?>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 4000);
    </script>
<?php endif; ?>

<div class="container-fluid p-2">
    <h2>Finance</h2>
    <a href="add_user.php" class="btn btn-primary my-2">Add Student</a>
    <table id="studentTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Unpaid Fee</th>
                <th>Action</th>
                <th>Fine</th>
                <th>Fines</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($students as $student) {
            $fee = $conn->query("SELECT `fees` FROM `semesters` WHERE `id` = '{$student['semester_id']}'")->fetch_assoc();
            $studentId = htmlspecialchars($student['id'], ENT_QUOTES, 'UTF-8');
            $status = htmlspecialchars($student['status'], ENT_QUOTES, 'UTF-8');

            // Fetch fines for the student
            $sqlFines = $conn->query("SELECT * FROM `fines` WHERE `user_id` = '$studentId'");
            $fines = [];
            while ($fine = $sqlFines->fetch_assoc()) {
                $fines[] = $fine;
            }

            echo "<tr>
                <td>" . htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($student['fee_status'] == 'unpaid' ? $fee['fees'] : 0, ENT_QUOTES, 'UTF-8') . "</td>
                <td><button class='btn btn-info'" . ($student['fee_status'] === 'paid' ? 'disabled' : '') . " onclick='sendFeeAlert({$student['id']})'>Send Fee Alert</button></td>
                <td><button class='btn btn-warning' onclick='openFineModal({$student['id']})'>Add Fine</button></td>
                <td>";
            if (count($fines) > 0) {
                foreach ($fines as $fine) {
                    echo "<div>
                        <strong>Amount:</strong> " . htmlspecialchars($fine['amount'], ENT_QUOTES, 'UTF-8') . "<br>
                        <strong>Reason:</strong> " . htmlspecialchars($fine['reason'], ENT_QUOTES, 'UTF-8') . "<br>
                        <button class='btn btn-sm btn-primary' onclick='openUpdateFineModal({$fine['id']}, {$fine['amount']}, \"{$fine['reason']}\")'>Update</button>
                        <form method='POST' action='' style='display:inline;'>
                            <input type='hidden' name='delete_fine_id' value='{$fine['id']}'>
                            <button type='submit' class='btn btn-sm btn-danger'>Delete</button>
                        </form>
                        <hr>
                    </div>";
                }
            } else {
                echo "No fines";
            }
            echo "</td>
            </tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Fine Modal -->
<div class="modal fade" id="fineModal" tabindex="-1" aria-labelledby="fineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="fineModalLabel">Add Fine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="fineStudentId">
                    <div class="mb-3">
                        <label for="fineAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="fineAmount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="fineReason" class="form-label">Reason</label>
                        <textarea class="form-control" id="fineReason" name="reason" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Fine</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Fine Modal -->
<div class="modal fade" id="updateFineModal" tabindex="-1" aria-labelledby="updateFineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateFineModalLabel">Update Fine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="fine_id" id="updateFineId">
                    <div class="mb-3">
                        <label for="updateFineAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="updateFineAmount" name="update_amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateFineReason" class="form-label">Reason</label>
                        <textarea class="form-control" id="updateFineReason" name="update_reason" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Fine</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    new DataTable('#studentTable');

    function sendFeeAlert(id) {
        if (confirm('Are you sure you want to send fee alert to this student?')) {
            window.location.href = 'sendFeeAlert.php?id=' + id + '&msg=You have pending fee';
        }
    }

    function openFineModal(studentId) {
        document.getElementById('fineStudentId').value = studentId;
        var fineModal = new bootstrap.Modal(document.getElementById('fineModal'));
        fineModal.show();
    }

    function openUpdateFineModal(fineId, amount, reason) {
        document.getElementById('updateFineId').value = fineId;
        document.getElementById('updateFineAmount').value = amount;
        document.getElementById('updateFineReason').value = reason;
        var updateFineModal = new bootstrap.Modal(document.getElementById('updateFineModal'));
        updateFineModal.show();
    }
</script>

<?php include './includes/footer.php'; ?>