<?php 
include 'db.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name']; 
    $lname = $_POST['lname']; 
    $email = $_POST['email']; 
    $number = $_POST['number'];
    $password = $_POST['password']; 
    $confirmPassword = $_POST['confirmPassword']; 

    if($password == $confirmPassword){
        $encryptedPassword = password_hash($password , PASSWORD_DEFAULT);
        $sql = "INSERT INTO users ( f_name , l_name , email , number , password) VALUES ('$fname' , '$lname' , '$email' , '$number' , '$encryptedPassword')";

        if($conn -> query($sql) == TRUE){
            header('location:login.php');
        }

    }
}
?>