<?php
session_start();
include("../server/connect.php");

$error = array();

if(isset($_POST['login_user'])){
    $username = mysqli_real_escape_string($connect,$_POST['username']);
    $password = mysqli_real_escape_string($connect,$_POST['password']);

    if(count($error) == 0){
        $password = md5($password);
        $query = "SELECT * FROM users WHERE Username = '$username' and Password = '$password'";
        $result = mysqli_query($connect,$query);

        if(mysqli_num_rows($result) == 1){  //ถ้ามีข้อมูลนี้อยู่จริงๆ
            $_SESSION['UserID'] = $result['UserID'];
            header("location: ../ChickChatHome/home.php");
        }else{
            array_push($error,"########");
            $_SESSION['error'] = '##########';
            header("location: login.php");
        }
    }
}