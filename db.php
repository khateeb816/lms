<?php 
$conn = new mysqli('localhost','root','','lms');
if($conn -> connect_error){
    die("Error Connecting database");
}
?>