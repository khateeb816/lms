<?php 
include '../db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM `users` WHERE `id` = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>window.location.href = document.referrer;</script>";
    } else {
        echo "<script>window.location.href = document.referrer;</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No user ID provided.'); window.location.href = document.referrer;</script>";
}

$conn->close();
?>