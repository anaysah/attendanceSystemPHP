<?php include_once('templates/header.php') ?>

<section>
    <div class="auth-box">
        <div class="auth-nav">
            <span class="auth-nav-Btn" id="auth-nav-loginBtn">Log In</span>
            <span class="auth-nav-Btn" id="auth-nav-signupBtn">Sign Up</span>
        </div>


        <div class="auth-card" id="loginBox">

            <form action="includes/signup.inc.php" method="post">
                <div class="form-group">
                    <input type="email" name="login-email" class="form-style" placeholder="Your Email" id="logemail"
                        autocomplete="off">
                    <i class="input-icon uil uil-at"></i>
                </div>

                <div class="form-group mt-2">
                    <input type="password" name="login-pass" class="form-style" placeholder="Your Password" id="logpass"
                        autocomplete="off">
                    <i class="input-icon uil uil-lock-alt"></i>
                </div>

                <input type="submit" value="submit" class="btn mt-4">
                <a href="#0" class="link">Forgot your password?</a>
            </form>

        </div>


        <div class="auth-card" id="signupBox">

            <form action="includes/signup.inc.php" method="post">
                <div class="form-group">
                    <input type="text" name="signup-name" class="form-style" placeholder="Your Full Name" id="signname"
                        autocomplete="off">
                    <i class="input-icon uil uil-user"></i>
                </div>

                <div class="form-group mt-2">
                    <input type="email" name="signup-email" class="form-style" placeholder="Your Email" id="signmail"
                        autocomplete="off">
                    <i class="input-icon uil uil-at"></i>
                </div>

                <div class="form-group mt-2">
                    <input type="password" name="signup-pass" class="form-style" placeholder="Your Password"
                        id="signpass" autocomplete="off">
                    <i class="input-icon uil uil-lock-alt"></i>
                </div>

                <input type="submit" name="submit" value="submit" class="btn mt-4">
            </form>

        </div>

    </div>
</section>


<?php include_once('templates/footer.php') ?>