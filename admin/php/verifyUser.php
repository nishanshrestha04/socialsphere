<?php
require_once("config.php");
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error connecting to database");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $sql = "UPDATE users SET account_status = 1 WHERE id = $userId";
    mysqli_query($db, $sql);
}

header("Location: ../");
exit();
?>
