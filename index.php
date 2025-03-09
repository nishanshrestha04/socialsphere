<?php
require_once("php/function.php");

if (isset($_GET['newfp'])) {
    unset($_SESSION['authTemp'], $_SESSION['forgotCode'], $_SESSION['forgotEmail']);
}

if (isset($_SESSION['Auth']) && isset($_SESSION['user'])) {
    $user = getUser($_SESSION['user']['id']);
    if ($user) {
        $posts = filterPosts();
        $suggestion = filterFollow();
    } else {
        // Handle case where user is not found
        unset($_SESSION['Auth'], $_SESSION['user']);
        header("Location: index.php");
        exit();
    }
}

$page = count($_GET);

// manage routes
if (isset($_SESSION['Auth']) && isset($user)) {
    if ($user['account_status'] == 1) {
        if (!$page || isset($_GET['login'])) {
            showPage("header", ["title" => 'Home']);
            showPage('navigation');
            showPage("feed");
        } elseif (isset($_GET['profile'])) {
            $profile = getUserUsername($_GET['profile']);
            if (!$profile) {
                showPage("header", ["title" => 'Profile Not Found']);
                showPage("navigation");
                showPage("userNotFound");
            } else {
                $profilePost = getPostsById($profile['id']);
                showPage("header", ["title" => $profile['full_name'] . ' (@' . $profile['username'] . ')']);
                showPage("navigation");
                showPage("profile");
            }
        } elseif (isset($_GET['editProfile'])) {
            showPage("header", ["title" => 'Edit Profile']);
            showPage("navigation");
            showPage("editProfile");
        } else {
            showPage("header", ["title" => 'Home']);
            showPage('navigation');
            showPage("feed");
        }
    } elseif ($user['account_status'] == 0) {
        showPage("header", ["title" => 'Verify Email']);
        showPage("verify");
    }
} else {
    if (isset($_GET['signup'])) {
        showPage("header", ["title" => 'Social Sphere - Signup']);
        showPage("signup");
    } elseif (isset($_GET['forgotPassword'])) {
        showPage("header", ["title" => 'Social Sphere - Reset Password']);
        showPage("forgot_password");
    } else {
        showPage("header", ["title" => 'Social Sphere - Login']);
        showPage("login");
    }
}

showPage("footer");
unset($_SESSION["error"], $_SESSION["formData"]);
