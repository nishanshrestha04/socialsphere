<div class="form-container">
    <div class="row">
        <form method="post" action="php/login.php?login" class="container col-10 col-sm-6 col-lg-3 border pb-3">
            <div class="logo-container d-flex justify-content-center">

            <img class="logo" src="images/logo.png" alt="">
            </div>
            <p class="text-center">Admin Id: admin@admin</p>
            <p class="text-center">Password: 123</p>
            <input type="hidden" name="action" value="login">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                <label for="email">Email</label>
            </div>
            <?= error('email') ?>

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
        </form>
    </div>
</div>
