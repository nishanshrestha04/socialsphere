<?php
global $user;
?>
<div class="form-container">
    <div class="row">
        <form method="post" action="php/loginSignup.php?verifyEmail"
            class="container col-10 col-sm-6 col-lg-3 rounded  border pb-3">
            <div class="d-flex justify-content-center">
                <h1 class="h5 my-3 fw-bold">Verify Your Email Account </h1>
            </div>


            <p class="text-center">We emailed you a six-digit code. Enter the code to confirm your email </p>
            <div class="form-floating mt-1">

                <input type="number" class="form-control space text-center fw-bold rounded-0" id="floatingPassword"
                    placeholder="" name="vCode">
                <label for="floatingPassword">Enter the six-digit code</label>
            </div>
            <?php
            if (isset($_GET['resend'])) {
                echo "<div class='alert alert-success my-2' role='alert'>Verification code has been sent to your email</div>";
            }
            ?>
            <?= error('emailVerify') ?>
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Verify Email</button>
                <a href="php/loginSignup.php?resendVcode" class="text-decoration-none">Resend Code</a>
            </div>
            <br>
            <a href="php/loginSignup.php?logout" class="text-decoration-none mt-5"><i
                    class="bi bi-arrow-left-circle-fill"></i>
                Logout</a>
        </form>
    </div>
</div>
