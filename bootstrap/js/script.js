document.addEventListener("DOMContentLoaded", function () {
    // Input field restrictions
    const inputField = document.querySelector(".space");
    if (inputField) {
        inputField.type = "number";
        inputField.maxLength = 6;
        inputField.addEventListener("input", function () {
            this.value = this.value.slice(0, 6);
            inputField.style.caretColor =
                this.value.length >= 6 ? "transparent" : "";
        });
    }

    // Profile picture preview
    document
        .getElementById("profilePicInput")
        ?.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onloadend = function () {
                    document.getElementById("profilePicPreview").src =
                        reader.result;
                };
                reader.readAsDataURL(file);
            }
        });

    // Post image preview
    document
        .getElementById("select-post-image")
        ?.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function () {
                    const img = document.getElementById("post-image-preview");
                    img.src = reader.result;
                    img.style.display = "block";
                    img.style.maxWidth = "100%";
                    img.style.height = "auto";
                };
                reader.readAsDataURL(file);
            }
        });

    // Like button functionality
    document.querySelectorAll(".likeBtn").forEach((button) => {
        button.addEventListener("click", function () {
            const postId = this.dataset.postId;
            this.classList.toggle("bi-heart");
            this.classList.toggle("bi-heart-fill");
            this.classList.toggle("text-danger");

            fetch("php/ajax.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `action=toggleLike&post_id=${postId}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        this.closest(
                            ".like-comment"
                        ).nextElementSibling.querySelector(
                            ".like-count a"
                        ).textContent = `${data.likeCount} likes`;
                    }
                })
                .catch(console.error);
        });
    });

    // Follow button functionality
    document.querySelectorAll(".followBtn").forEach((button) => {
        button.addEventListener("click", function () {
            const userId = this.dataset.userId;

            fetch("php/ajax.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `action=toggleFollow&user_id=${userId}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        this.textContent =
                            this.textContent.trim() === "Follow"
                                ? "Unfollow"
                                : "Follow";
                        this.classList.toggle("btn-primary");
                        this.classList.toggle("btn-danger");
                        if (document.getElementById("followersCount")) {
                            document.getElementById(
                                "followersCount"
                            ).textContent = data.followersCount;
                        }
                        location.reload();
                    }
                })
                .catch(console.error);
        });
    });

    // Like count click functionality
    document.querySelectorAll(".like-count-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const postId = this.dataset.postId;

            fetch("php/ajax.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `action=getLikes&post_id=${postId}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const likesListBody =
                            document.getElementById("likesListBody");
                        likesListBody.innerHTML = data.likes
                            .map(
                                (user) => `
                            <div class="d-flex align-items-center justify-content-between p-2 gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="follow-profile-image">
                                        <img src="images/profile/${
                                            user.profile_pic
                                        }" alt="" height="40" width="40" class="rounded-circle">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <a href="?profile=${
                                            user.username
                                        }" class="text-decoration-none text-dark">
                                            <h6 style="margin: 0px;font-size: small;">${
                                                user.username
                                            }</h6>
                                            <p style="margin:0px;font-size:small" class="text-muted">${
                                                user.full_name
                                            }</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm ${
                                        user.isFollowing
                                            ? "btn-danger"
                                            : "btn-primary"
                                    } followBtn" data-user-id="${user.id}" ${
                                    user.id == data.currentUserId
                                        ? "hidden"
                                        : ""
                                }>
                                        ${
                                            user.isFollowing
                                                ? "Unfollow"
                                                : "Follow"
                                        }
                                    </button>
                                </div>
                            </div>
                        `
                            )
                            .join("");

                        // Attach event listeners to follow/unfollow buttons in the modal
                        document
                            .querySelectorAll("#likesListBody .followBtn")
                            .forEach((button) => {
                                button.addEventListener("click", function () {
                                    const userId = this.dataset.userId;

                                    fetch("php/ajax.php", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type":
                                                "application/x-www-form-urlencoded",
                                        },
                                        body: `action=toggleFollow&user_id=${userId}`,
                                    })
                                        .then((response) => response.json())
                                        .then((data) => {
                                            if (data.success) {
                                                this.textContent =
                                                    this.textContent.trim() ===
                                                    "Follow"
                                                        ? "Unfollow"
                                                        : "Follow";
                                                this.classList.toggle(
                                                    "btn-primary"
                                                );
                                                this.classList.toggle(
                                                    "btn-danger"
                                                );
                                                location.reload();
                                            }
                                        })
                                        .catch(console.error);
                                });
                            });
                    }
                })
                .catch(console.error);
        });
    });

    // Post description modals
    const updatePostModal = (data) => {
        const postImage = document.getElementById("postImage");
        const postCaption = document.getElementById("postCaption");
        const postCommentsList = document.getElementById("postCommentsList");
        const postUserProfilePic =
            document.getElementById("postUserProfilePic");
        const postUsername = document.getElementById("postUsername");
        const postTime = document.getElementById("postTime");

        postImage.src = `images/posts/${data.post.post_img}`;
        postCaption.textContent = data.post.caption;
        postCommentsList.innerHTML = "";
        postTime.textContent = timeSince(new Date(data.post.created_at));

        if (data.comments.length > 0) {
            data.comments.forEach((comment) => {
                const listItem = document.createElement("li");
                listItem.classList.add(
                    "d-flex",
                    "align-items-center",
                    "gap-2",
                    "mb-2"
                );
                listItem.innerHTML = `
                    <img src="images/profile/${
                        comment.profile_pic
                    }" alt="" height="30" width="30" class="rounded-circle">
                    <div>
                        <strong>${
                            comment.username
                        }</strong><br/>
                        <span class="comment-text">${
                        comment.comment
                    }</span>
                    </div>
                    <small class="text-muted ms-auto">${timeSince(
                        new Date(comment.created_at)
                    )}</small>
                    ${
                        comment.user_id === data.currentUserId
                            ? `<button class="btn btn-sm btn-danger delete-comment-btn" data-comment-id="${comment.id}">Delete</button>`
                            : ""
                    }
                `;
                postCommentsList.appendChild(listItem);
            });
        } else {
            postCommentsList.innerHTML =
                '<p class="text-muted no-comments">No comments yet.</p>';
        }

        document.getElementById("postCommentBtn").dataset.postId = data.post.id;
        postUserProfilePic.src = `images/profile/${data.user.profile_pic}`;
        postUsername.textContent = data.user.username;
    };

    // fetch post description
    const fetchPostDescription = (postId) => {
        fetch("php/ajax.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `action=getPostDescription&post_id=${postId}`,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    updatePostModal(data);
                }
            })
            .catch(console.error);
    };

    document
        .querySelectorAll(".gallery-image, .comment-input, .bi-chat")
        .forEach((element) => {
            element.addEventListener("click", function () {
                const postId = this.dataset.postId;
                fetchPostDescription(postId);
            });
        });

    // Post comment functionality
    document
        .getElementById("postCommentBtn")
        ?.addEventListener("click", function () {
            const postId = this.dataset.postId;
            const commentInput = document.getElementById("commentInput");
            const comment = commentInput.value.trim();

            if (comment) {
                fetch("php/ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `action=postComment&post_id=${postId}&comment=${encodeURIComponent(
                        comment
                    )}`,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            const postCommentsList =
                                document.getElementById("postCommentsList");
                            const noCommentsMessage =
                                postCommentsList.querySelector(".no-comments");
                            if (noCommentsMessage) {
                                noCommentsMessage.remove();
                            }
                            const listItem = document.createElement("li");
                            listItem.classList.add(
                                "d-flex",
                                "align-items-center",
                                "gap-2",
                                "mb-2"
                            );
                            listItem.innerHTML = `
                            <img src="images/profile/${data.profile_pic}" alt="" height="30" width="30" class="rounded-circle">
                            <div>
                                <strong>${data.username}</strong><br/>
                                <span class="comment-text">${comment}</span>
                            </div>
                            <small class="text-muted ms-auto">just now</small>
                        `;
                            postCommentsList.appendChild(listItem);
                            commentInput.value = "";

                            // Reload the modal to reflect the new comment
                            fetchPostDescription(postId);
                        }
                    })
                    .catch(console.error);
            }
        });

    // Deleting comments
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("delete-comment-btn")) {
            const commentId = e.target.dataset.commentId;
            fetch("php/ajax.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `action=deleteComment&comment_id=${commentId}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        e.target.closest("li").remove();
                        // Update the comment count without reloading the page
                        const postId =
                            document.getElementById("postCommentBtn").dataset
                                .postId;
                        fetch("php/ajax.php", {
                            method: "POST",
                            headers: {
                                "Content-Type":
                                    "application/x-www-form-urlencoded",
                            },
                            body: `action=getPostDescription&post_id=${postId}`,
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.success) {
                                    const commentCountElement =
                                        document.querySelector(
                                            `.comment-input[data-post-id="${postId}"]`
                                        );
                                    if (commentCountElement) {
                                        commentCountElement.placeholder = `${data.comments.length} Comments`;
                                    }
                                }
                            })
                            .catch(console.error);
                    }
                })
                .catch(console.error);
        }
    });

    // Delete post functionality
    document.querySelectorAll(".delete-post-btn").forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            const postId = this.getAttribute("data-post-id");
            if (confirm("Are you sure you want to delete this post?")) {
                fetch("php/ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `action=deletePost&post_id=${postId}`,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            document.getElementById(`post-${postId}`).remove();
                        } else {
                            alert("Failed to delete post.");
                        }
                    });
            }
        });
    });

    // Account deletion
    function deleteAccount() {
        if (
            confirm(
                "Are you sure you want to delete your account? This action cannot be undone."
            )
        ) {
            window.location.href = "php/deleteAccount.php";
        }
    }

    document
        .getElementById("deleteAccountBtn")
        .addEventListener("click", deleteAccount);

    // Time since function
    function timeSince(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        let interval = seconds / 31536000;

        if (interval > 1) {
            return Math.floor(interval) + " years ago";
        }
        interval = seconds / 2592000;
        if (interval > 1) {
            return Math.floor(interval) + " months ago";
        }
        interval = seconds / 86400;
        if (interval > 1) {
            return Math.floor(interval) + " days ago";
        }
        interval = seconds / 3600;
        if (interval > 1) {
            return Math.floor(interval) + " hours ago";
        }
        interval = seconds / 60;
        if (interval > 1) {
            return Math.floor(interval) + " minutes ago";
        }
        if (seconds < 60) {
            return "just now";
        }
        return Math.floor(seconds) + " seconds ago";
    }

    // Update time since for all elements with data-timestamp attribute
    const timeElements = document.querySelectorAll(
        ".post-time[data-timestamp]"
    );
    timeElements.forEach((el) => {
        const timestamp = el.getAttribute("data-timestamp");
        el.textContent = timeSince(new Date(timestamp * 1000));
    });
});
