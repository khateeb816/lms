<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>

<div class="container-fluid">
    <h2>Messages</h2>
    <div class="messages">
        <?php
        include '../../db.php'; 

        $user_id = $_SESSION['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message_id'])) {
            $message_id = $_POST['message_id'];
            $conn->query("UPDATE `alerts` SET `status` = 'read' WHERE `id` = '$message_id' AND `user_id` = '$user_id'");
            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}'</script>";
            exit();
        }

        $sql = $conn->query("SELECT * FROM `alerts` WHERE `user_id` = '$user_id' ORDER BY `created_at` DESC");

        if ($sql->num_rows > 0) {
            while ($row = $sql->fetch_assoc()) {
                $readClass = $row['status'] == 'read' ? 'bg-light' : 'alert-info';
                echo "<div class='alert $readClass' role='alert' style='position: relative;'>";
                echo "<strong>{$row['title']}</strong><br>";
                echo "{$row['message']}<br>";
                echo "<small><em>{$row['created_at']}</em></small>";
                if ($row['status'] != 'read') {
                    echo "<form method='POST' action='' style='position: absolute; right: 10px; top: 10px;'>";
                    echo "<input type='hidden' name='message_id' value='{$row['id']}'>";
                    echo "<button type='submit' class='btn btn-sm btn-primary'>Mark as Read</button>";
                    echo "</form>";
                } else {
                    echo "<span class='badge bg-success' style='position: absolute; right: 10px; top: 10px;'>Read</span>";
                }
                echo "</div>";
            }
        } else {
            echo "<div class='alert alert-warning' role='alert'>No messages found.</div>";
        }
        ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>