<?php

$showError="false";
if($_SERVER['REQUEST_METHOD']=='POST'){
    include '_dbconnect.php';
    $email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupCPassword'];
    $sql = "SELECT * FROM `users` WHERE user_email='$email'";
    $result = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);
    if($num>0){
        $showError = "Email already exists";
    }
    else{
        if($pass==$cpass){
            $hash = password_hash($pass,PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `password`, `time`) VALUES ('$email', '$hash', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            if($result){
                $showError="true";
                header('location: /forum/index.php?signupsuccess=true');
                exit();
            }
        }
        else{
            $showError = "Password do not match";
        }
    }
    header('location: /forum/index.php?signupsuccess=false&error='.$showError.'');
}

?>