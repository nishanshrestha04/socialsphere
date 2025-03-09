<?php
require_once("function.php");
require_once("vCode.php");

// Signup
if (isset($_GET['signup'])) {
    $output = checkSignup($_POST);
    if ($output['status']) {
        if (createUser($_POST)) {
            header("location: ../?login");
        } else {
            echo "";
        }
    } else {
        $_SESSION['error'] = $output;
        $_SESSION['formData'] = $_POST;
        header("location: ../?signup");
    }
}

// Login
if (isset($_GET['login'])) {
    $data = checkLogin(($_POST));
    if ($data['status']) {
        $_SESSION['Auth'] = true;
        $_SESSION['user'] = $data['user'];

        if ($data['user']['account_status'] == 0) {
            $_SESSION['vCode'] = $vCode = rand(100000, 999999);
            sendVCode($data['user']['email'], "Verify Your Email", $vCode);
        }
        header('location:../');
    } else {
        $_SESSION['error'] = $data;
        $_SESSION['formData'] = $_POST;
        header('location:../?login');
    }
}

if (isset($_GET['resendVcode'])) {
    $vCode = rand(100000, 999999);
    sendVCode($_SESSION['user']['email'], "Verify Your Email", $vCode);
    $_SESSION['vCode'] = $vCode;
    header('location:../?resend');
}

if (isset($_GET['verifyEmail'])) {
    $userVcode = $_POST['vCode'];
    $vCode = $_SESSION['vCode'];
    if ($vCode == $userVcode) {
        if (verifyEmail($_SESSION['user']['email'])) {
            header('location:../');
        } else {
            echo "Error verifying email";
        }
    } else {
        $output['message'] = "Invalid Verification Code";
        if (!$_POST['vCode']) {
            $output['message'] = "Verification Code is required";
        }
        $output['input'] = 'emailVerify';
        $_SESSION['error'] = $output;
        header('location:../');
    }
}

// Forgot Password
if (isset($_GET['forgotPassword'])) {
    if (!$_POST['email']) {
        $output['message'] = "Email is required";
        $output['input'] = 'email';
        $_SESSION['error'] = $output;
        header('location:../?forgotPassword');
    } elseif (!checkDuplicateEmail($_POST['email'])) {
        $output['message'] = "Email does not exist";
        $output['input'] = 'email';
        $_SESSION['error'] = $output;
        header('location:../?forgotPassword');
    } else {
        $_SESSION['forgotEmail'] = $_POST['email'];
        $vCode = rand(100000, 999999);
        sendVCode($_POST['email'], "Reset your password", $vCode);
        $_SESSION['forgotCode'] = $vCode;
        header('location:../?forgotPassword');
    }
}

// for  verifying reset code
if (isset($_GET['verifyCode'])) {
    $userVcode = $_POST['vCode'];
    $vCode = $_SESSION['forgotCode'];
    if ($vCode == $userVcode) {
        $_SESSION['authTemp'] = true;
        header('location:../?forgotPassword');
    } else {
        $output['message'] = "Invalid Verification Code";
        if (!$_POST['vCode']) {
            $output['message'] = "Verification Code is required";
        }
        $output['input'] = 'emailVerify';
        $_SESSION['error'] = $output;
        header('location:../?forgotPassword');
    }
}

if (isset($_GET['resetPassword'])) {
    if (!$_POST['newPassword']) {
        $output['message'] = "New Password is required";
        $output['input'] = 'newPassword';
        $_SESSION['error'] = $output;
        header('location:../?forgotPassword');
    } else {
        changePassword($_SESSION['forgotEmail'], $_POST['newPassword']);
        session_destroy();
        header('location:../?login');
    }
}

// logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('location:../');
}
