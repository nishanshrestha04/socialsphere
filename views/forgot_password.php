<div class="form-container">
    <div class="row">
        <?php
        if(isset($_SESSION['forgotCode']) && !isset($_SESSION['authTemp'])){
            $action = 'verifyCode';
        }elseif(isset($_SESSION['forgotCode']) && isset($_SESSION['authTemp'])){
            $action = 'resetPassword';
        }else {
            $action = 'forgotPassword';
        }
        ?>
        <form method="post" action="php/loginSignup.php?<?= $action ?>"
            class="container col-10 col-sm-6 col-lg-3 border pb-3">
            <div class="logo-container d-flex justify-content-center">
                <img class="logo" src="images/logo.png" alt="">
            </div>
            <?php if ($action == 'forgotPassword'): ?>
                <div class="header">
                    <h3 class="fs-4 fw-bold">Find your account</h3>
                </div>
                <p>Enter your email.</p>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                        value="<?= previousValue('email') ?>">
                    <label for="email">Email</label>
                </div>
                <?= error('email') ?>
                <p>You may receive email from us for security and login purposes.</p>
                <div class="d-flex justify-content-center my-3">
                    <button class="btn btn-primary col-5" type="submit"> Send Code </button>
                </div>

            <?php elseif ($action == 'verifyCode'): ?>
                <div class="header">
                    <h3 class="fs-4 fw-bold">Enter the code</h3>
                </div>
                <p>Enter the six-digit code sent to you.</p>
                <div class="form-floating mt-1">
                    <input type="number" class="form-control space text-center fw-bold rounded-0" id="code" placeholder="" name="vCode" />
                    <label for="code">Enter the six-digit code</label>
                </div>
                <?= error('emailVerify') ?>


                <div class="d-flex justify-content-center my-3">
                    <button class="btn btn-primary col-5" type="submit"> Verify Code </button>
                </div>

            <?php elseif ($action == 'resetPassword'): ?>
                <div class="header">
                    <h3 class="fs-4 fw-bold">Reset password</h3>
                </div>
                <p>Enter new paassword</p>
                <div class="form-floating mt-1">
                    <input type="password" class="form-control fw-bold rounded-0" id="newPassword" placeholder="" name="newPassword" />
                    <label for="newPassword">New password</label>
                </div>
                <?= error('newPassword') ?>


                <div class="d-flex justify-content-center my-3">
                    <button class="btn btn-primary col-5" type="submit"> Reset  </button>
                </div>

            <?php endif; ?>



            <div class="login  d-flex justify-content-start ">
                <a href="?login" class="text-decoration-none">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                    Go Back To Login

                </a>
            </div>
        </form>
    </div>
</div>
