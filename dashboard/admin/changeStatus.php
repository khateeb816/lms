<?php 
include '../../db.php';
$status = $_GET['status'];
$id = $_GET['id'];

if($conn -> query("UPDATE `users` SET `status` = '$status' WHERE `id` = '$id'")){
    header("location:" . $_SERVER['HTTP_REFERER']);
    exit();
}

?>