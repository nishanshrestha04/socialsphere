<?php
global $user;
?>
<aside class="sidebar">
    <header class="sidebar-header">
        <a href="?">
            <img class="logo-img" src="images/logo2.png" />
            <img src="images/logo.png" alt="" class="logo-icon">
        </a>
    </header>
    <nav>
        <a href="?" class="nav-link text-decoration-none">
            <button>
                <span>
                    <i class="uil uil-estate"></i>
                    <span>Home</span>
                </span>
            </button>
        </a>

        <button data-bs-toggle="modal" data-bs-target="#addPost">
            <span>
                <i class="uil uil-plus-circle"> </i>
                <span>Create</span>
            </span>
        </button>
        <a href="?profile=<?= $user['username']?>" class="nav-link text-decoration-none">
            <button>
                <span>
                    <img style="border-radius:50%;" src="images/profile/<?= $user['profile_pic'] ?>" />
                    <span>Profile</span>
                </span>
            </button>
        </a>

        <button>
            <span>
                <i class="uil uil-signout text-danger"></i>
                <a class="span text-danger text-decoration-none" href="php/loginSignup.php?logout"><span>Logout</span></a>
            </span>
        </button>

    </nav>
</aside>
