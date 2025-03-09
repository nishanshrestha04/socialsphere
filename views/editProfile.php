<?php
global $user;
?>
<div class="editProfile">
    <div class="row">
        <form method="post" action="php/updateProfile.php?update" enctype="multipart/form-data" class="container col-10 col-md-8 col-lg-6 p-3">
            <h1 class="editHeadline fs-3 fw-bold">Edit Profile</h1>
            <div class=' photo-container  d-flex align-items-center justify-content-between rounded-4 mb-2  '>
                <div class="photo">
                    <img id="profilePicPreview" src="images/profile/<?= $user['profile_pic'] ?> ?>" class="changePhoto" height="40" width="40" alt="">
                </div>
                <button type="button" class="btn btn-primary rounded-2 btn-upload">
                    Change Profile
                    <input type="file" name="profile-pic" id="profilePicInput" onchange="previewProfilePic()">
                </button>
            </div>
            <p class="text-muted">Upload image upto 5MB</p>
            <?= error('profile-pic') ?>


            <div class="form-floating mb-2 ">
                <input type="text" class="form-control rounded-4" id="full_name" name="full_name" placeholder=""
                    value="<?= $user['full_name'] ?>">
                <label for="full_name">Full Name</label>
            </div>
            <?= error('full_name') ?>

            <div class="form-floating mb-2 ">
                <input type="email" class="form-control rounded-4" id="email" name="email" placeholder=""
                    value="<?= $user['email'] ?>" disabled>
                <label for="full_name">Email</label>
            </div>
            <?= error('email') ?>

            <div class="form-floating mb-2 ">
                <input type="text" class="form-control rounded-4" id="username" name="username" placeholder=""
                    value="<?= $user['username'] ?>">
                <label for="username">Username</label>
            </div>
            <?= error('username') ?>

            <div class="form-floating mb-2 ">
                <input type="password" class="form-control rounded-4" id="password" placeholder="Password" name="password">
                <label for="password">New Password</label>
            </div>
            <?= error('password') ?>

            <div class="d-flex gap-2 justify-content-end">
                <button class="btn btn-primary col-4 " type="submit">Update</button>
                <button class="btn btn-danger col-4" type="button" id="deleteAccountBtn">Delete Account</button>
            </div>
        </form>
    </div>
</div>
