<?php
include '../../db.php';

$teachers = $_POST['teacherss'];
$courseid = $_POST['courseid'];

$teachersString = implode(',', $teachers);


if($conn -> query("UPDATE `courses` SET `teacher_id` = '$teachersString' WHERE `id` = '$courseid'")){
    header('location:'.$_SERVER['HTTP_REFERER']);
}
?>
