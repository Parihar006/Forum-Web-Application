<?php

$showError="false";
if($_SERVER['REQUEST_METHOD']=='POST'){
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];
    $sql = "SELECT * FROM `users` WHERE user_email='$email'";
    $result = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);
    if($num==1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass,$row['password'])){
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['useremail']=$email;
            $_SESSION['sno'] = $row['sno'];
        }
        else{
            $showError = "Password do not match";
        }
    }
    else{
        $showError = "Email doesn't exist";
    }
    if($showError!="false"){
        $_SESSION['loggedin']=false;
        $_SESSION['loginerror']=$showError;
    }
    header("location: /forum/index.php");
}

?>