<div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="?">Social Sphere </a>
                </div>
            </div>

            <div class="sidebar-footer">
                <a href="php/login.php?logout" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-4 py-3">
                <form action="#" class="d-none d-sm-inline-block">

                </form>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="images/logo.png" class="avatar img-fluid" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded">

                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3 class="fw-bold fs-4 mb-3">Admin Dashboard</h3>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="card border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">Verified Users</h5>
                                        <p class="mb-2 fw-bold"><?php echo getTotalVerifiedUsers(); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">Unverified Users</h5>
                                        <p class="mb-2 fw-bold"><?php echo getTotalUnverifiedUsers(); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">Total Posts</h5>
                                        <p class="mb-2 fw-bold"><?php echo getTotalPosts(); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">Total Likes</h5>
                                        <p class="mb-2 fw-bold"><?php echo getTotalLikes(); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">Total Comments</h5>
                                        <p class="mb-2 fw-bold"><?php echo getTotalComments(); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="fw-bold fs-4 my-3">All Users</h3>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="highlight">
                                            <th scope="col">S.N</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $users = getAllUsers();
                                        foreach ($users as $index => $user) {
                                            if ($user['account_status'] == 1) {
                                                $statusButton = "<button class='btn btn-sm btn-success' disabled>Verified</button>";
                                            } else {
                                                $statusButton = "<a href='php/verifyUser.php?id=" . $user['id'] . "' class='btn btn-sm btn-danger'>Unverified</a>";
                                            }

                                            echo "<tr>
                                                    <th scope='row'>" . ($index + 1) . "</th>

                                                    <td>" . $user['full_name'] . "</td>
                                                    <td>" . $user['username'] . "</td>
                                                    <td>" . $user['email'] . "</td>
                                                    <td>" . $statusButton . " "  . "</td>
                                                  </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
