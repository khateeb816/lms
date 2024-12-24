<?php
include '../../db.php';

$courses = $_POST['courses'];
$semesterId = $_POST['semesterid'];

$courses = implode(',', $courses);


if($conn -> query("UPDATE `semesters` SET `courses` = '$courses' WHERE `id` = '$semesterId'")){
    header('location:'.$_SERVER['HTTP_REFERER']);
}
?>
