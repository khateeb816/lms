<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && isset($_POST['message']) && isset($_POST['deadline']) && isset($_POST['status'])) {
        // Add announcement
        $title = $_POST['title'];
        $message = $_POST['message'];
        $deadline = $_POST['deadline'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("INSERT INTO `announcements` (`title`, `message`, `deadline`, `status`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $message, $deadline, $status);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'announcements.php?msg=Announcement Added Successfully!';</script>";
        } else {
            echo "<script>alert('Error adding announcement.'); window.location.href = 'announcements.php';</script>";
        }

        $stmt->close();
    } elseif (isset($_POST['announcement_id']) && isset($_POST['update_title']) && isset($_POST['update_message']) && isset($_POST['update_deadline']) && isset($_POST['update_status'])) {
        // Update announcement
        $announcement_id = $_POST['announcement_id'];
        $title = $_POST['update_title'];
        $message = $_POST['update_message'];
        $deadline = $_POST['update_deadline'];
        $status = $_POST['update_status'];

        $stmt = $conn->prepare("UPDATE `announcements` SET `title` = ?, `message` = ?, `deadline` = ?, `status` = ? WHERE `id` = ?");
        $stmt->bind_param("ssssi", $title, $message, $deadline, $status, $announcement_id);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'announcements.php?msg=Announcement Updated Successfully!';</script>";
        } else {
            echo "<script>alert('Error updating announcement.'); window.location.href = 'announcements.php';</script>";
        }

        $stmt->close();
    } elseif (isset($_POST['delete_announcement_id'])) {
        // Delete announcement
        $announcement_id = $_POST['delete_announcement_id'];

        $stmt = $conn->prepare("DELETE FROM `announcements` WHERE `id` = ?");
        $stmt->bind_param("i", $announcement_id);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'announcements.php?msg=Announcement Deleted Successfully!';</script>";
        } else {
            echo "<script>alert('Error deleting announcement.'); window.location.href = 'announcements.php';</script>";
        }

        $stmt->close();
    }
}

// Fetch existing announcements
$sql = $conn->query("SELECT * FROM `announcements` ORDER BY `created_at` DESC");
$announcements = [];
while ($row = $sql->fetch_assoc()) {
    $announcements[] = $row;
}
?>

<?php if (isset($_GET['msg'])): ?>
    <div id="successMessage" class="alert alert-success fixed-top" style="z-index: 1050;">
        <?php echo $_GET['msg']; ?>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 4000);
    </script>
<?php endif; ?>

<div class="container-fluid p-2">
    <h2>Announcements</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Make New Announcement</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Announcement</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Existing Announcements</h3>
        </div>
        <div class="card-body">
            <?php if (count($announcements) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($announcements as $announcement): ?>
                        <li class="list-group-item">
                            <strong>Title:</strong> <?php echo htmlspecialchars($announcement['title'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <strong>Message:</strong> <?php echo htmlspecialchars($announcement['message'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <strong>Deadline:</strong> <?php echo htmlspecialchars($announcement['deadline'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <strong>Status:</strong> <?php echo htmlspecialchars($announcement['status'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <button class="btn btn-sm btn-primary" onclick="openUpdateAnnouncementModal(<?php echo $announcement['id']; ?>, '<?php echo htmlspecialchars($announcement['title'], ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars($announcement['message'], ENT_QUOTES, 'UTF-8'); ?>', '<?php echo $announcement['deadline']; ?>', '<?php echo $announcement['status']; ?>')">Update</button>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="delete_announcement_id" value="<?php echo $announcement['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No announcements found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Update Announcement Modal -->
<div class="modal fade" id="updateAnnouncementModal" tabindex="-1" aria-labelledby="updateAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAnnouncementModalLabel">Update Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="announcement_id" id="updateAnnouncementId">
                    <div class="mb-3">
                        <label for="updateTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="updateTitle" name="update_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="updateMessage" name="update_message" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="updateDeadline" class="form-label">Deadline</label>
                        <input type="datetime-local" class="form-control" id="updateDeadline" name="update_deadline" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateStatus" class="form-label">Status</label>
                        <select class="form-control" id="updateStatus" name="update_status" required>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="blocked">Blocked</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openUpdateAnnouncementModal(id, title, message, deadline, status) {
        document.getElementById('updateAnnouncementId').value = id;
        document.getElementById('updateTitle').value = title;
        document.getElementById('updateMessage').value = message;
        document.getElementById('updateDeadline').value = deadline;
        document.getElementById('updateStatus').value = status;
        var updateAnnouncementModal = new bootstrap.Modal(document.getElementById('updateAnnouncementModal'));
        updateAnnouncementModal.show();
    }
</script>

<?php include './includes/footer.php'; ?>