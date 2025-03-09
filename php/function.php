<?php
// conncet database
require_once("config.php");
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error connecting to database");

// show page according to the request
function showPage($page, $data = "")
{
    include("views/$page.php");
}


// Toggle follow/unfollow user
function toggleFollowUser($user_id) {
    $currentLoggedInUserId = $_SESSION['user']['id'];
    global $db;

    // Check if already following
    $sql = "SELECT * FROM follower_list WHERE follower_id = $currentLoggedInUserId AND user_id = $user_id";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Unfollow user
        $sql = "DELETE FROM follower_list WHERE follower_id = $currentLoggedInUserId AND user_id = $user_id";
    } else {
        // Follow user
        $sql = "INSERT INTO follower_list (follower_id, user_id) VALUES ($currentLoggedInUserId, $user_id)";
    }

    return mysqli_query($db, $sql);
}

// Toggle like/unlike post
function toggleLikePost($post_id) {
    $currentLoggedInUserId = $_SESSION['user']['id'];
    global $db;

    // Check if already liked
    $sql = "SELECT * FROM likes WHERE user_id = $currentLoggedInUserId AND post_id = $post_id";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Unlike post
        $sql = "DELETE FROM likes WHERE user_id = $currentLoggedInUserId AND post_id = $post_id";
    } else {
        // Like post
        $sql = "INSERT INTO likes (user_id, post_id) VALUES ($currentLoggedInUserId, $post_id)";
    }

    return mysqli_query($db, $sql);
}

// Get like count for a post
function getLikeCount($post_id) {
    global $db;
    $sql = "SELECT count(*) as row FROM likes WHERE post_id = $post_id";
    $start = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($start)['row'];
}

// Get comment count for a post
function getCommentCount($post_id) {
    global $db;
    $sql = "SELECT count(*) as row FROM comments WHERE post_id = $post_id";
    $start = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($start)['row'];
}

// Check if the current user has liked a post
function isLikedByUser($post_id) {
    $currentLoggedInUserId = $_SESSION['user']['id'];
    global $db;
    $sql = "SELECT * FROM likes WHERE user_id = $currentLoggedInUserId AND post_id = $post_id";
    $result = mysqli_query($db, $sql);
    return mysqli_num_rows($result) > 0;
}

// show the error
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

// show prev data
function previousValue($input)
{
    if (isset($_SESSION['formData'])) {
        $formData = $_SESSION['formData'];
        return $formData[$input];
    }
}

// check duplicate email
function checkDuplicateEmail($email)
{
    global $db;
    $sql = "SELECT count(*) as row FROM users WHERE email = '$email'";
    $start = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($start);
    return $data['row'];
}
// check duplicate username
function checkDuplicateUsername($username)
{
    global $db;
    $sql = "SELECT count(*) as row FROM users WHERE username = '$username'";
    $start = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($start);
    return $data['row'];
}
// cheke duplicate username by other
function checkDuplicateUsernameByOther($username)
{
    global $db;
    $user_id = $_SESSION['user']['id'];
    $sql = "SELECT count(*) as row FROM users WHERE username = '$username' && id != $user_id";
    $start = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($start);
    return $data['row'];
}



// check if the input is filed is blank or not
function checkSignup($formInfo)
{
    $output = array('status' => true);

    $requiredFields = array(
        'email' => 'Email is required',
        'password' => 'Password is required',
        'full_name' => 'Full Name is required',
        'username' => 'Username is required',
    );

    foreach ($requiredFields as $field => $message) {
        if (empty($formInfo[$field])) {
            $output['message'] = $message;
            $output['status'] = false;
            $output['input'] = $field;
            return $output;
        }
    }

    if (checkDuplicateEmail($formInfo['email'])) {
        $output['message'] = 'Email already exists';
        $output['status'] = false;
        $output['input'] = 'email';
    } elseif (checkDuplicateUsername($formInfo['username'])) {
        $output['message'] = 'Username already exists';
        $output['status'] = false;
        $output['input'] = 'username';
    }

    return $output;
}

// check login
function checkLogin($formInfo)
{
    $output = array('status' => true);

    $requiredFields = array(
        'emailUsername' => 'Email or Username is required',
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

    $validationResult = validateUser($formInfo);
    if (!$validationResult['status']) {
        return array(
            'message' => 'Invalid email or password',
            'status' => false,
            'input' => 'validateUser'
        );
    }

    $output['user'] = $validationResult['user'];
    return $output;
}



// Validate user
function validateUser($loginInfo)
{
    global $db;
    $emailUsername = $loginInfo['emailUsername'];
    $password = md5($loginInfo['password']);

    $sql = "SELECT * FROM users WHERE (email = '$emailUsername' OR username = '$emailUsername') AND password = '$password'";
    $start = mysqli_query($db, $sql);
    $data['user'] = mysqli_fetch_assoc($start) ?? array();

    if (count($data['user']) > 0) {
        $data['status'] = true;
    } else {
        $data['status'] = false;
    }
    return $data;
}

// get user by id
function getUser($userID)
{
    global $db;

    $sql = "SELECT * FROM users WHERE id = $userID";
    $start = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($start);
}

// get user by username
function getUserUsername($username)
{
    global $db;

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $start = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($start);
}

// filter follower suggestion
function filterFollow()
{
    $suggestion = getFollow();
    $filter_list = array();
    foreach ($suggestion as $user) {
        if(!isFollowing($user['id'])){
            $filter_list[] = $user;
        }
    }
    return $filter_list;
}

// checking the user is following or not
function isFollowing($user_id)
{
    if (!isset($_SESSION['user']['id'])) {
        return 0;
    }
    $currentLoggedIn = $_SESSION['user']['id'];
    global $db;
    $sql = "SELECT count(*) as row FROM follower_list WHERE follower_id = $currentLoggedIn AND user_id = $user_id";
    $start = mysqli_query($db, $sql);
    if (!$start) {
        return 0;
    }
    return mysqli_fetch_assoc($start)['row'];
}

// for getting users for follow
function getFollow(){
    if (!isset($_SESSION['user']['id'])) {
        return array();
    }
    $currentLoggedInUserId = $_SESSION['user']['id'];
    global $db;
    $sql = "SELECT * FROM users WHERE id != $currentLoggedInUserId";
    $start = mysqli_query($db, $sql);
    if (!$start) {
        return array();
    }
    $data = array();
    while ($row = mysqli_fetch_assoc($start)) {
        $data[] = $row;
    }
    return $data;
}


// get user by id
function getPostsById($user_id)
{
    global $db;
    $sql = "SELECT * FROM posts WHERE user_id =  $user_id ORDER BY created_at DESC";
    $start = mysqli_query($db, $sql);
    if (!$start) {
        return array();
    }
    $data = array();
    while ($row = mysqli_fetch_assoc($start)) {
        $data[] = $row;
    }
    return $data;
}
// verify email
function verifyEmail($email)
{
    global $db;
    $sql = "UPDATE users SET account_status = 1 WHERE email = '$email'";
    return mysqli_query($db, $sql);
}
// reset password
function changePassword($email, $password)
{
    global $db;
    $password = md5($password);
    $sql = "UPDATE users SET password = '$password' WHERE email = '$email'";
    return mysqli_query($db, $sql);
}


// Check Update
function checkUpdate($formInfo, $imageData)
{
    $output = array('status' => true);

    $requiredFields = array(
        'full_name' => 'Full Name is required',
        'username' => 'Username is required',
    );

    foreach ($requiredFields as $field => $message) {
        if (empty($formInfo[$field])) {
            $output['message'] = $message;
            $output['status'] = false;
            $output['input'] = $field;
            return $output;
        }
    }

    if (checkDuplicateUsernameByOther($formInfo['username'])) {
        $output['message'] = $formInfo['username'] . ' is alredy taken';
        $output['status'] = false;
        $output['input'] = 'username';
    }

    if ($imageData['name']) {
        $image = basename($imageData['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $imageData['size'] / 1000;

        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
            $output['message'] = 'Invalid image format';
            $output['status'] = false;
            $output['input'] = 'profile-pic';
        }
        if ($size > 5000) {
            $output['message'] = 'Image size is too large. Maximum 5MB is allowed';
            $output['status'] = false;
            $output['input'] = 'profile-pic';
        }
    }

    return $output;
}

// Check post
function checkPost($imageData)
{
    $output = array('status' => true);

    if (empty($imageData['name'])) {
        return array(
            'message' => 'Image is required',
            'status' => false,
            'input' => 'post_image'
        );
    }

    $image = basename($imageData['name']);
    $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $size = $imageData['size'] / 1000;

    if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
        return array(
            'message' => 'Invalid image format',
            'status' => false,
            'input' => 'post_image'
        );
    }

    if ($size > 5000) {
        return array(
            'message' => 'Image size is too large. Maximum 5MB is allowed',
            'status' => false,
            'input' => 'post_image'
        );
    }

    return $output;
}

// get followers count

function getFollowersCount($user_id)
{
    global $db;
    $sql = "SELECT count(*) as row FROM follower_list WHERE user_id = $user_id";
    $start = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($start)['row'];
}

// get following count
function getFollowingCount($user_id)
{
    global $db;
    $sql = "SELECT count(*) as row FROM follower_list WHERE follower_id = $user_id";
    $start = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($start)['row'];
}

// get posts count
function getPostsCount($user_id)
{
    global $db;
    $sql = "SELECT count(*) as row FROM posts WHERE user_id = $user_id";
    $start = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($start)['row'];
}

// create a new user
function createUser($formInfo)
{
    global $db;
    $email = mysqli_real_escape_string($db, $formInfo['email']);
    $password = mysqli_real_escape_string($db, $formInfo['password']);
    $password = md5($password);
    $username = mysqli_real_escape_string($db, $formInfo['username']);
    $full_name = mysqli_real_escape_string($db, $formInfo['full_name']);
    $sql = "INSERT INTO users (username, email, password, full_name) VALUES ('$username', '$email', '$password', '$full_name')";
    return mysqli_query($db, $sql);
}

// update profile
function  updateProfile($formInfo, $imageData)
{
    if (!isset($_SESSION['user']['id'])) {
        return false;
    }
    global $db;
    $full_name = mysqli_real_escape_string($db, $formInfo['full_name']);
    $username = mysqli_real_escape_string($db, $formInfo['username']);
    $password = mysqli_real_escape_string($db, $formInfo['password']);
    if (!$formInfo['password']) {
        $password = $_SESSION['user']['password'];
    } else {
        $password = md5($password);
        $_SESSION['user']['password'] = $password;
    }
    $profilePic = "";
    if ($imageData['name']) {
        $imageName = time() . basename($imageData['name']);
        $image_dir = "../images/profile/$imageName";
        move_uploaded_file($imageData['tmp_name'], $image_dir);
        $profilePic = ", profile_pic = '$imageName'";
    }

    $sql = "UPDATE users SET full_name = '$full_name', username = '$username', password = '$password' $profilePic WHERE id = " . $_SESSION['user']['id'];
    return mysqli_query($db, $sql);
}


// create post
function createPost($caption, $image)
{
    global $db;
    $caption = mysqli_real_escape_string($db, $caption['caption']);
    $user_id = $_SESSION['user']['id'];
    $imageName = time() . basename($image['name']);
    $image_dir = "../images/posts/$imageName";
    move_uploaded_file($image['tmp_name'], $image_dir);

    $sql = "INSERT INTO posts (user_id, caption, post_img) VALUES ($user_id, '$caption', '$imageName')";
    return mysqli_query($db, $sql);
}

// Delete a post by ID and remove associated likes, comments, and image
function deletePost($post_id) {
    global $db;
    $user_id = $_SESSION['user']['id'];

    // Get the post image filename
    $sql = "SELECT post_img FROM posts WHERE id = $post_id AND user_id = $user_id";
    $result = mysqli_query($db, $sql);
    $post = mysqli_fetch_assoc($result);
    if ($post) {
        $post_img = $post['post_img'];
        $image_path = "../images/posts/$post_img";

        // Delete the image file from the server
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // Delete likes associated with the post
    $sql = "DELETE FROM likes WHERE post_id = $post_id";
    mysqli_query($db, $sql);

    // Delete comments associated with the post
    $sql = "DELETE FROM comments WHERE post_id = $post_id";
    mysqli_query($db, $sql);

    // Delete the post
    $sql = "DELETE FROM posts WHERE id = $post_id AND user_id = $user_id";
    return mysqli_query($db, $sql);
}

// get  posts dynamically
function filterPosts()
{
    global $db;
    $currentLoggedInUserId = $_SESSION['user']['id'];
    $sql = "SELECT posts.id, posts.user_id, posts.post_img, posts.caption, posts.created_at, users.username, users.profile_pic
            FROM posts
            JOIN users ON users.id = posts.user_id
            LEFT JOIN follower_list ON follower_list.user_id = posts.user_id
            WHERE follower_list.follower_id = $currentLoggedInUserId OR posts.user_id = $currentLoggedInUserId
            ORDER BY posts.created_at DESC";
    $start = mysqli_query($db, $sql);
    $filter_list = array();
    while ($row = mysqli_fetch_assoc($start)) {
        $filter_list[] = $row;
    }
    return $filter_list;
}

// Get the list of followers for a user
function getFollowers($user_id) {
    global $db;
    $sql = "SELECT users.id, users.username, users.profile_pic, users.full_name
            FROM follower_list
            JOIN users ON users.id = follower_list.follower_id
            WHERE follower_list.user_id = $user_id";
    $start = mysqli_query($db, $sql);
    $followers = array();
    while ($row = mysqli_fetch_assoc($start)) {
        $followers[] = $row;
    }
    return $followers;
}

// Get the list of users that the current user is following
function getFollowing($user_id) {

    global $db;
    $sql = "SELECT users.id, users.username, users.profile_pic, users.full_name
            FROM follower_list
            JOIN users ON users.id = follower_list.user_id
            WHERE follower_list.follower_id = $user_id";
    $start = mysqli_query($db, $sql);
    $following = array();
    while ($row = mysqli_fetch_assoc($start)) {
        $following[] = $row;
    }
    return $following;
}

// Get users who liked a post
function getLikes($post_id) {
    global $db;
    $currentLoggedInUserId = $_SESSION['user']['id'];
    $sql = "SELECT users.id, users.username, users.profile_pic, users.full_name,
            (SELECT count(*) FROM follower_list WHERE follower_id = $currentLoggedInUserId AND user_id = users.id) as isFollowing
            FROM likes
            JOIN users ON users.id = likes.user_id
            WHERE likes.post_id = $post_id";
    $start = mysqli_query($db, $sql);
    $likes = array();
    while ($row = mysqli_fetch_assoc($start)) {
        $row['isFollowing'] = $row['isFollowing'] > 0;
        $likes[] = $row;
    }
    return $likes;
}

// Get post by id
function getPostById($post_id) {
    global $db;
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $start = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($start);
}

// Get comments by post id
function getCommentsByPostId($post_id) {
    global $db;
    $sql = "SELECT comments.*, users.username, users.profile_pic FROM comments
            JOIN users ON users.id = comments.user_id
            WHERE comments.post_id = $post_id
            ORDER BY comments.created_at DESC";
    $start = mysqli_query($db, $sql);
    $comments = array();
    while ($row = mysqli_fetch_assoc($start)) {
        $comments[] = $row;
    }
    return $comments;
}

// Post a comment
function postComment($post_id, $comment) {
    global $db;
    $user_id = $_SESSION['user']['id'];
    $comment = mysqli_real_escape_string($db, $comment);
    $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES ($post_id, $user_id, '$comment')";
    return mysqli_query($db, $sql);
}

// Delete a comment
function deleteComment($comment_id) {
    global $db;
    $user_id = $_SESSION['user']['id'];
    $sql = "DELETE FROM comments WHERE id = $comment_id AND user_id = $user_id";
    return mysqli_query($db, $sql);
}
