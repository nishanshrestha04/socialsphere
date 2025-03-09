<?php
global $user;
global $posts;
global $suggestion;
?>

<div class="feed-cointaner d-flex">
    <div class="container feed-items col-12 col-lg-7 d-grid justify-items-center">
        <?php
        if (is_array($posts) && !empty($posts)) {
            $posts = array_unique($posts, SORT_REGULAR);
            foreach ($posts as $post) {
                $isLiked = isLikedByUser($post['id']);
        ?>
                <div class="card mb-4 col-10 p-3" id="post-<?= $post['id'] ?>">
                    <div class="card-title d-flex align-items-center justify-content-between">
                        <div class="profile-and-name-section d-flex align-items-center">
                            <div class="profile-pic-container">
                                <img src="images/profile/<?= $post['profile_pic'] ?>" width="40" height="40" class="rounded-circle" alt="">
                            </div>
                            <div>
                                <a href="?profile=<?= $post['username'] ?>" class="text-decoration-none text-dark">
                                    <p class="feed-username"><?= $post['username'] ?></p>
                                </a>
                            </div>
                        </div>
                        <?php if ($user['id'] == $post['user_id']) { ?>
                        <div class="three-dots dropdown">
                            <i class="bi bi-three-dots" id="dropdownMenuButton<?= $post['id'] ?>" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $post['id'] ?>">
                                <li><a class="dropdown-item delete-post-btn" href="#" data-post-id="<?= $post['id'] ?>">Delete Post</a></li>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>

                    <img src="images/posts/<?= $post['post_img'] ?>" alt="">
                    <div class="like-comment " style="font-size: 28px;">
                        <i class="bi <?= $isLiked ? 'bi-heart-fill text-danger' : 'bi-heart' ?> likeBtn" data-post-id="<?= $post['id'] ?>"></i>
                        <i class="bi bi-chat" data-post-id="<?= $post['id'] ?>" data-bs-toggle="modal" data-bs-target="#post-description"></i>
                    </div>
                    <div class="caption-add-comment">
                        <div class="like-count">
                            <a class="fw-bold m-0 like-count-btn text-decoration-none text-dark" data-post-id="<?= $post['id'] ?>" data-bs-toggle="modal" data-bs-target="#likesModal"><?= getLikeCount($post['id']) ?> likes</a>
                        </div>
                        <?php
                        if ($post['caption'] != '') {
                        ?>
                            <div class="caption">
                                <p class=""><span class="fw-bold"><?= $post['username'] ?></span> <?= $post['caption'] ?></p>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="comment-section">
                            <p class="p-2 border-bottom comment-input" data-post-id="<?= $post['id'] ?>" data-bs-toggle="modal" data-bs-target="#post-description">
                                <?= getCommentCount($post['id']) ?> Comments
                            </p>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p class='text-muted p-2'>No posts available</p>";
        }
        ?>

    </div>

    <div class="follow  col-5 mt-4 p-3">
        <div class="d-flex align-items-center p-2 gap-2">
            <div class="profile-image">
                <img src="images/profile/<?= $user['profile_pic'] ?>" height="60" width="60" class="rounded-circle" alt="">
            </div>
            <div class="d-flex flex-column justify-content-center">
                <a href="?profile=<?= $user['username'] ?>" class="text-decoration-none text-dark">
                    <h6 style="margin: 0px;"><?= $user['username'] ?></h6>
                    <p style="margin:0px;font-size:small" class="text-muted"><?= $user['full_name'] ?></p>
                </a>
            </div>
        </div>

        <div class="follow-list">
            <h6 class="text-muted p-2">People you may know</h6>
            <?php
            if (empty($suggestion)) {
                echo "<p class='text-muted p-2'>No suggestions available</p>";
            } else {
                foreach ($suggestion as $suggestedUser) {
            ?>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center p-2 gap-2">
                            <div class="follow-profile-image">
                                <img src="images/profile/<?= $suggestedUser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a href="?profile=<?= $suggestedUser['username'] ?>" class="text-decoration-none text-dark">
                                    <h6 style="margin: 0px;font-size: small;"><?= $suggestedUser['username'] ?></h6>
                                    <p style="margin:0px;font-size:small" class="text-muted"><?= $suggestedUser['full_name'] ?></p>

                              </a>
                             </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm <?= isFollowing($suggestedUser['id']) ? 'btn-danger' : 'btn-primary' ?> followBtn"
                                data-user-id="<?= $suggestedUser['id'] ?>">
                                <?= isFollowing($suggestedUser['id']) ? 'Unfollow' : 'Follow' ?>
                            </button>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

// Likes modal
<div class="modal fade" id="likesModal" tabindex="-1" aria-labelledby="likesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="likesModalLabel">Likes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="likesListBody">
                <!-- Likes list will be populated here -->
                <div id="likesListTemplate" style="display: none;">
                    <div class="d-flex align-items-center justify-content-between p-2 gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="follow-profile-image">
                                <img src="" alt="" height="40" width="40" class="rounded-circle">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a href="" class="text-decoration-none text-dark">
                                    <h6 style="margin: 0px;font-size: small;"></h6>
                                    <p style="margin:0px;font-size:small" class="text-muted"></p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm followBtn" data-user-id="">
                                Follow
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Modal -->
<div class="modal fade" id="post-description" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column" id="postDescriptionBody">
                <div class="d-flex">
                    <div class="post-image-container flex-shrink-0 me-3" style="max-width: 50%;">
                        <img id="postImage" class="img-fluid mb-3 w-100" style="object-fit: contain;" />
                    </div>
                    <div class="post-comments flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <img id="postUserProfilePic" alt="" height="30" width="30" class="rounded-circle">
                                <strong id="postUsername"></strong>
                            </div>
                            <small id="postTime" class="text-muted"></small>
                        </div>
                        <p id="postCaption"></p>
                        <h6>Comments:</h6>
                        <ul class="list-group list-unstyled gap-2" id="postCommentsList" style="max-height: 200px; overflow-y: auto;">
                            <!-- Comments will be populated here -->
                        </ul>
                    </div>
                </div>
                <div class="input-group p-2 border-top mt-auto">
                    <input type="text" class="form-control rounded-0 border-0" id="commentInput" placeholder="Add a comment..." aria-label="Recipient's username" aria-describedby="postCommentBtn">
                    <button class="btn btn-outline-primary rounded-0 border-0" type="button" id="postCommentBtn">Post</button>
                </div>
            </div>
        </div>
    </div>
</div>
