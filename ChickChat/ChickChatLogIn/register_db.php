<?php
session_start();
include("../server/connect.php");

$error = array();

if(isset($_POST["confrim_Regis"])){
    $username = mysqli_real_escape_string($connect,$_POST['Username']);
    $password = mysqli_real_escape_string($connect,$_POST['password_1']);
    $ConfrimPassword = mysqli_real_escape_string($connect,$_POST['password_2']);
}//ดักmethod post

if($password != $ConfrimPassword){
    array_push($error,"The two password do not match");
    $_SESSION['error'] = 'The two password do not match';
    header('location: login.php');
}//chech matching password

$Dbpassword = md5($password);
$user_check_query = "SELECT * FROM users where Username = '$username'AND Password = '$Dbpassword'";
$query = mysqli_query($connect,$user_check_query);
$result = mysqli_fetch_assoc($query);
//query old data form DB

if($result['Username'] === $username){
        array_push($error,"Username already exist");
        $_SESSION['error'] = 'Username already exist';
        header('location: login.php');
}

if(count($error)==0){
    //
    $sql = "INSERT INTO users(Username,Password) Value('$username','$Dbpassword')";
    mysqli_query($connect,$sql);
    //insert new data to DB
    //
    $sql = "SELECT UserID FROM users where Username = '$username'AND Password = '$Dbpassword'";
    $query = mysqli_query($connect,$sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION["UserID"] = $result["UserID"];
    //select UserID  and keep in session
    header('location: ../ChickChatDressing/Dressing.php');
}


?>