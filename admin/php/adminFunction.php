<?php
// conncet database
require_once("config.php");
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error connecting to database");

// show page according to the request
function showPage($page, $data = "")
{
    include("views/$page.php");
}


function checkLogin($formInfo)
{
    $output = array('status' => true);

    $requiredFields = array(
        'email' => 'Email is required',
        'password' => 'Password is required'
    );

    foreach ($requiredFields as $field => $message) {
        if (empty($formInfo[$field])) {
            return array(
                'message' => $message,
                'status' => false,
                'input' => $field
            );
        }
    }

    $validationResult = validateAdmin($formInfo);
    if (!$validationResult['status']) {
        return array(
            'message' => 'Invalid email or password',
            'status' => false,
            'input' => 'validateUser'
        );
    }

    $output['admin'] = $validationResult['admin'];
    return $output;
}

// Validate user
function validateAdmin($loginInfo)
{
    global $db;
    $email = $loginInfo['email'];
    $password = $loginInfo['password'];

    $sql = "SELECT * FROM admin WHERE admin_email = '$email' AND password = '$password'";
    $start = mysqli_query($db, $sql);
    $data['admin'] = mysqli_fetch_assoc($start) ?? array();

    if (count($data['admin']) > 0) {
        $data['status'] = true;
    } else {
        $data['status'] = false;
    }
    return $data;
}

function getAllUsers()
{
    global $db;
    $sql = "SELECT id, full_name, email, username, account_status FROM users";
    $result = mysqli_query($db, $sql);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

function getTotalVerifiedUsers()
{
    global $db;
    $sql = "SELECT COUNT(*) as total FROM users WHERE account_status = 1";
    $result = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

function getTotalUnverifiedUsers()
{
    global $db;
    $sql = "SELECT COUNT(*) as total FROM users WHERE account_status = 0";
    $result = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

function getTotalPosts()
{
    global $db;
    $sql = "SELECT COUNT(*) as total FROM posts";
    $result = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

function getTotalLikes()
{
    global $db;
    $sql = "SELECT COUNT(*) as total FROM likes";
    $result = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

function getTotalComments()
{
    global $db;
    $sql = "SELECT COUNT(*) as total FROM comments";
    $result = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

// show error
function error($input)
{
    if (isset($_SESSION['error'])) {
        $err = $_SESSION['error'];
        if (isset($err['input']) && $err['input'] == $input) {

            echo "<div class='alert alert-danger alert-dismissible fade show my-2' role='alert'>
                   " . $err['message'] . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
    }
}
