<div class="form-container ">
    <div class="row">
        <form method="post" action="php/loginSignup.php?signup" class="container col-10 col-sm-6 col-lg-3 border pb-3">
            <div class="logo-container d-flex justify-content-center">
                <img class="logo" src="images/logo.png" alt="">
            </div>

            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                    value="<?= previousValue('email') ?>">
                <label for="email">Email address</label>
            </div>
            <?= error('email') ?>

            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                <label for="password">Password</label>
            </div>
            <?= error('password') ?>

            <div class="form-floating mb-2">
                <input type="trait_exists" class="form-control" id="full_name" name="full_name" placeholder="Password"
                    value="<?= previousValue('full_name') ?>">
                <label for="full_name">Full Name</label>
            </div>
            <?= error('full_name') ?>

            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="username" name="username" placeholder="Password"
                    value="<?= previousValue('username') ?>">
                <label for="username">Username</label>
            </div>
            <?= error('username') ?>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Sign up</button>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="container col-10 col-sm-6 col-lg-3 border p-2 mt-2 d-flex justify-content-center">
            <a href="?login" class="text-decoration-none">Already have an account ?</a>
        </div>
    </div>
</div>
