<?php
require_once("php/adminFunction.php");

if (isset($_SESSION['Auth']) && $_SESSION['Auth']) {
    showPage("header", ["title" => 'Admin - Dashboard']);
    showPage("adminDashboard");
} else {
    showPage("header", ["title" => 'Social Sphere - Login']);
    showPage("adminLogin");
}

showPage("footer");
unset($_SESSION["error"], $_SESSION["formData"]);
