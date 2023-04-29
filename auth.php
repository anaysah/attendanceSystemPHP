<?php include_once('templates/header.php') ?>

<link rel="stylesheet" href="styles/auth.css">
<section id="auth-section">
    <div class="wrapper bgImage">
        <div class="title-text">
            <div class="title login">Login Form</div>
            <div class="title signup">Signup Form</div>
        </div>
        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>
            <div class="user-type-box">
                <input type="radio" name="user-type-slide" value="teacher" id="teacher" checked>
                <input type="radio" name="user-type-slide" value="student" id="student">
                <label for="teacher" class="slide teacher">Teacher</label>
                <label for="student" class="slide student">Student</label>
                <div class="slider-tab"></div>
            </div>

            <div class="form-inner">

                <form action="includes/login.inc.php" class="login" method="post">
                    <input type="hidden" name="user-type" value="teacher" >
                    <div class="field">
                        <input type="email" name="login-email" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
                        <i class="input-icon uil uil-at"></i>
                    </div>

                    <div class="field">
                        <input type="password" name="login-pass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">
                        <i class="input-icon uil uil-lock-alt"></i>
                    </div>
                    <div class="pass-link"><a href="#">Forgot password?</a></div>
                    <div class="field field-btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="submit" value="Login">
                    </div>
                    <div class="signup-link">Not a member? <a href="">Signup now</a></div>
                </form>

                <!-- ##### Signup form ##### -->
                <form action="includes/signup.inc.php" class="signup" method="post">
                    <input type="hidden" name="user-type" value="teacher" >
                    <div class="field">
                        <input type="text" name="signup-name" class="form-style" placeholder="Your Full Name" id="signname" autocomplete="off">
                        <i class="input-icon uil uil-user"></i>
                    </div>

                    <div class="field">
                        <input type="email" name="signup-email" class="form-style" placeholder="Your Email" id="signmail" autocomplete="off">
                        <i class="input-icon uil uil-at"></i>
                    </div>

                    <div class="field">
                        <input type="password" name="signup-pass" class="form-style" placeholder="Your Password" id="signpass" autocomplete="off">
                        <i class="input-icon uil uil-lock-alt"></i>
                    </div>

                    <div class="field">
                        <input type="password" name="signup-rpass" class="form-style" placeholder="Repeat Password" id="signrpass" autocomplete="off">
                        <i class="input-icon uil uil-lock-alt"></i>
                    </div>
                    <div class="field field-btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="submit" value="Signup">
                    </div>
                </form>
            </div>
        </div>
    </div>


</section>
<script>
    const loginText = document.querySelector(".title-text .login");
    const loginForm = document.querySelector("form.login"); //pura login form ka div
    const loginBtn = document.querySelector("label.login"); //sabse upar vala login btn toogle vale mei se
    const signupBtn = document.querySelector("label.signup"); //sabse upar vala sign btn toogle vale mei se
    const signupLink = document.querySelector("form .signup-link a"); //not a member vala button
    signupBtn.onclick = (() => {
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
    });
    loginBtn.onclick = (() => {
        loginForm.style.marginLeft = "0%";
        loginText.style.marginLeft = "0%";
    });
    signupLink.onclick = (() => {
        signupBtn.click();
        return false;
    });

    // jab bhi user type change vale kisi bhi radio pe click hoga toh hidden input jo form mei hai uska value change ho jayega
    const radioButtons = document.querySelectorAll('input[name="user-type-slide"]');
    radioButtons.forEach((radioButton) => {
        radioButton.addEventListener('change', () => {
            // Set the value of hidden input to the selected radio button's value
            const userType = document.querySelectorAll('input[name="user-type"]');
            userType.forEach((element) => {
                element.value = radioButton.value;
            });
        });
    });
    //--end
</script>


<?php include_once('templates/footer.php') ?>