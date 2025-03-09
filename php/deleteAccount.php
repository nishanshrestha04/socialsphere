<?php
require_once("function.php");

$user_id = $_SESSION['user']['id'];
global $db;

// Delete user's likes
$sql = "DELETE FROM likes WHERE user_id = $user_id";
mysqli_query($db, $sql);

// Delete user's comments
$sql = "DELETE FROM comments WHERE user_id = $user_id";
mysqli_query($db, $sql);

// Delete user from the database
$sql = "DELETE FROM users WHERE id = $user_id";
mysqli_query($db, $sql);

// Delete user's posts
$sql = "DELETE FROM posts WHERE user_id = $user_id";
mysqli_query($db, $sql);

// Delete user's followers and following
$sql = "DELETE FROM follower_list WHERE follower_id = $user_id OR user_id = $user_id";
mysqli_query($db, $sql);

// Destroy session and redirect to the homepage
session_destroy();
header("location: ../index.php");
exit();
?>
