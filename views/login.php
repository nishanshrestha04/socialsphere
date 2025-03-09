<div class="form-container">
    <div class="row">
        <form method="post" action="php/loginSignup.php?login" class="container col-10 col-sm-6 col-lg-3 border pb-3">
            <div class="logo-container d-flex justify-content-center">
                <img class="logo" src="images/logo.png" alt="">
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="emailUsername" name="emailUsername" placeholder="Email" value="<?= previousValue('emailUsername') ?>">
                <label for="emailUsername">Email or Username</label>
            </div>
            <?= error('emailUsername') ?>

            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                <label for="password">Password</label>
            </div>
            <?= error('password') ?>
            <?= error('validateUser') ?>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Login</button>
            </div>
            <div class="or w-100 mt-2 d-flex gap-3 justify-content-center align-items-center">
                <span style="height: 1px;" class="line w-50 border"></span>
                <p class="text-center mt-3">OR</p>
                <span style="height: 1px;" class="line w-50 border"></span>
            </div>
            <div class="forget  d-flex justify-content-center ">
                <a href="?forgotPassword" class="text-decoration-none">Forgot password?</a>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="container col-10 col-sm-6 col-lg-3 border p-2 mt-2  d-flex justify-content-center">
            <p class="mb-0">Don't have an account? &nbsp;</p>
            <a href="?signup" class="text-decoration-none">Sign up</a>
        </div>
    </div>
</div>
