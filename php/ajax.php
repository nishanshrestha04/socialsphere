<?php
require_once("function.php");

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'toggleFollow') {
        $user_id = $_POST['user_id'];
        $result = toggleFollowUser($user_id);
        $followingCount = getFollowingCount($_SESSION['user']['id']);
        $followersCount = getFollowersCount($user_id);
        echo json_encode(['success' => $result, 'followingCount' => $followingCount, 'followersCount' => $followersCount]);
    } elseif ($_POST['action'] == 'toggleLike') {
        $post_id = $_POST['post_id'];
        $result = toggleLikePost($post_id);
        $likeCount = getLikeCount($post_id);
        echo json_encode(['success' => $result, 'likeCount' => $likeCount]);
    } elseif ($_POST['action'] == 'getLikes') {
        $post_id = $_POST['post_id'];
        $likes = getLikes($post_id);
        $currentUserId = $_SESSION['user']['id'];
        echo json_encode(['success' => true, 'likes' => $likes, 'currentUserId' => $currentUserId]);
    } elseif ($_POST['action'] == 'getPostDescription') {
        $post_id = $_POST['post_id'];
        $post = getPostById($post_id);
        $comments = getCommentsByPostId($post_id);
        $user = getUser($post['user_id']);
        $currentUserId = $_SESSION['user']['id'];
        echo json_encode(['success' => true, 'post' => $post, 'comments' => $comments, 'user' => $user, 'currentUserId' => $currentUserId]);
    } elseif ($_POST['action'] == 'postComment') {
        $post_id = $_POST['post_id'];
        $comment = $_POST['comment']; // Ensure the comment is retrieved from POST data
        $comment_id = postComment($post_id, $comment); // Get the comment ID
        $user = $_SESSION['user'];
        echo json_encode(['success' => $comment_id !== false, 'username' => $user['username'], 'profile_pic' => $user['profile_pic'], 'comment_id' => $comment_id]);
    } elseif ($_POST['action'] == 'deleteComment') {
        $comment_id = $_POST['comment_id'];
        $result = deleteComment($comment_id);
        echo json_encode(['success' => $result]);
    } elseif ($_POST['action'] == 'deletePost') {
        $post_id = $_POST['post_id'];
        $result = deletePost($post_id);
        echo json_encode(['success' => $result]);
    }
}
?>
