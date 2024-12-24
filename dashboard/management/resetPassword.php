<?php
include '../../db.php';


$id = $_POST['id'];
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$confirmNewPassword = $_POST['confirmNewPassword'];

$sqlUser = $conn -> query("SELECT `password` FROM `users` WHERE `id` = '$id'");
$sqlUser = $sqlUser -> fetch_assoc();
if(password_verify($oldPassword , $sqlUser['password'])){



if($newPassword == $confirmNewPassword){
    $encryptedPassword = password_hash($newPassword , PASSWORD_DEFAULT);
    if($conn -> query("UPDATE `users` SET `password` = '$encryptedPassword'")){
        $msg = "Password Updated Successfully";
        header("location:profile.php?msg=$msg&id=$id" );
        exit();
    }
} else{
    $msg = "New Password didn't match";
    header("location:profile.php?msg=$msg&id=$id" );
    exit();
    
}
}
else{
    $msg = "Old Password is invalid";
    header("location:profile.php?msg=$msg&id=$id" );
    exit();

}
?>