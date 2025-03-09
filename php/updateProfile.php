<?php
require_once("function.php");
global $user;
global $profile;
if(isset($_GET['update'])){
    $output = checkUpdate($_POST, $_FILES['profile-pic']);
    if ($output['status']) {
        if(updateProfile($_POST, $_FILES['profile-pic'])){
            header("location: ../?profile=" . $_POST['username']);
        }else {
            echo "error";
        }
    } else {
        $_SESSION['error'] = $output;
        header("location: ../?editProfile=".$user['username']);
    }
}
