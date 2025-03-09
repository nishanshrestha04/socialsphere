<?php
require_once("function.php");


if(isset($_GET['addPost'])){
    $output = checkPost($_FILES['post_image']);
    if($output['status']){
        if(createPost($_POST, $_FILES['post_image'])){
            
            header("location: ../?new_post_added");
        }else {
            echo "error";
        }
    }else {
        $error = $_SESSION['error'] = $output;
        header("location: ../");
    }
}
