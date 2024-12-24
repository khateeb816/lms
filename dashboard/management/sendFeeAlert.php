<?php 
include '../../db.php';
$msg = $_GET['msg'];
$id = $_GET['id'];

if($conn -> query("INSERT INTO `alerts` (`user_id`, `message`) VALUES ('$id', '$msg')")){
    header("location:" . $_SERVER['HTTP_REFERER']);
    exit();
}

?>