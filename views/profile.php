<?php
global $profile;
global $profilePost;
$followers = getFollowers($profile['id']);
$following = getFollowing($profile['id']);
?>
<div class="profile-container d-gird">
    <div class="profile-box d-flex col-12">
        <div class="profile-page-image-container p-5">
            <img src="images/profile/<?= $profile['profile_pic'] ?> " height="160" width="160" class="profile-page-image rounded-circle">
        </div>
        <div class="profile-description  col-6 mt-5">
            <div class="username-edit-profile d-flex align-items-center justify-content-between">
                <h5 class="profile-username m-0"><?= $profile['username'] ?></h5>
                <?php if ($profile['id'] == $_SESSION['user']['id']) { ?>
                    <a href="?editProfile=<?= $profile['username'] ?>" class="profile-edit text-decoration-none btn btn-primary text-white">Edit Profile</a>
                <?php } else { ?>
                    <button class="btn btn-sm <?= isFollowing($profile['id']) ? 'btn-danger' : 'btn-primary' ?> followBtn"
                        data-user-id="<?= $profile['id'] ?>" <?= $profile['id'] == $_SESSION['user']['id'] ? 'disabled' : '' ?>>
                        <?= isFollowing($profile['id']) ? 'Unfollow' : 'Follow' ?>
                    </button>
                <?php } ?>
            </div>

            <div class="post-follower-following col-12">
                <div class="d-flex justify-content-start gap-2 gap-lg-5 mt-3">
                    <div class="post">
                        <p><span class="fw-bold"><?= getPostsCount($profile['id']) ?></span> posts</p>
                    </div>
                    <div class="follower">
                        <a data-bs-toggle="modal" data-bs-target="#followerList"><span class="fw-bold" id="followersCount"><?= getFollowersCount($profile['id']) ?></span> followers</a>
                    </div>
                    <div class="following">
                        <a data-bs-toggle="modal" data-bs-target="#followingList"><span class="fw-bold" id="followingCount"><?= getFollowingCount($profile['id']) ?></span> following</a>
                    </div>
                </div>
            </div>
            <div class="profile-fullname">
                <p class="fw-bold"><?= $profile['full_name'] ?></p>
            </div>
        </div>
    </div>
    <h3 class="border-bottom mb-3">Posts</h3>
    <?php if ($profile['id'] == $_SESSION['user']['id'] && empty($profilePost)) { ?>
        <div class="text-center mb-4">
            <a href="?addPost" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPost">Add New Post</a>
        </div>
    <?php } ?>
    <div class="post-section w-75 d-flex justify-content-start">
        <div class="gallery d-flex flex-wrap justify-content-center gap-2 mb-4">
            <?php
            if (is_array($profilePost) && !empty($profilePost)) {
                foreach ($profilePost as $post) {
            ?>
                    <div class="gallery-item">
                        <img src="images/posts/<?= $post['post_img'] ?>" data-bs-toggle="modal"
                            data-bs-target="#post-description" class="gallery-image" data-post-id="<?= $post['id'] ?>" />
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-muted p-2'>No posts available</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- follower list -->
<div class="modal fade" id="followerList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Follower List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                if (empty($followers)) {
                    echo "<p class='text-muted p-2'>No followers available</p>";
                } else {
                    foreach ($followers as $follower) {
                ?>
                        <div class="d-flex align-items-center justify-content-between p-2 gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="follow-profile-image">
                                    <img src="images/profile/<?= $follower['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <a href="?profile=<?= $follower['username'] ?>" class="text-decoration-none text-dark">
                                        <h6 style="margin: 0px;font-size: small;"><?= $follower['username'] ?></h6>
                                        <p style="margin:0px;font-size:small" class="text-muted"><?= $follower['full_name'] ?></p>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm <?= isFollowing($follower['id']) ? 'btn-danger' : 'btn-primary' ?> followBtn"
                                    data-user-id="<?= $follower['id'] ?>" <?= $follower['id'] == $_SESSION['user']['id'] ? 'disabled' : '' ?>>
                                    <?= isFollowing($follower['id']) ? 'Unfollow' : 'Follow' ?>
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
</div>

<!-- following list -->
<div class="modal fade" id="followingList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Following List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="followingListBody">
                <?php
                if (empty($following)) {
                    echo "<p class='text-muted p-2'>No following available</p>";
                } else {
                    foreach ($following as $followedUser) {
                ?>
                        <div class="d-flex align-items-center justify-content-between p-2 gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="follow-profile-image">
                                    <img src="images/profile/<?= $followedUser['profile_pic'] ?>" alt="" height="40" width="40" class="rounded-circle">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <a href="?profile=<?= $followedUser['username'] ?>" class="text-decoration-none text-dark">
                                        <h6 style="margin: 0px;font-size: small;"><?= $followedUser['username'] ?></h6>
                                        <p style="margin:0px;font-size:small" class="text-muted"><?= $followedUser['full_name'] ?></p>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm <?= isFollowing($followedUser['id']) ? 'btn-danger' : 'btn-primary' ?> followBtn"
                                    data-user-id="<?= $followedUser['id'] ?>" <?= $followedUser['id'] == $_SESSION['user']['id'] ? 'hidden' : '' ?>>
                                    <?= isFollowing($followedUser['id']) ? 'Unfollow' : 'Follow' ?>
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
                <div class="d-flex post-body">
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
