<?php
require_once("adminFunction.php");

if (isset($_GET['login'])) {
    $data = checkLogin($_POST);
    if ($data['status']) {
        $_SESSION['Auth'] = true;
        $_SESSION['admin'] = $data['admin'];
        header('location:../');
    } else {
        $_SESSION['error'] = $data;
        $_SESSION['formData'] = $_POST;
        header('location:../?login');
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('location:../');
}
