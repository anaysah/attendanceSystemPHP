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
                    <input type="radio" name="user-type-slide" id="teacher" checked>
                    <input type="radio" name="user-type-slide" id="student">
                    <label for="teacher" class="slide teacher">Teacher</label>
                    <label for="student" class="slide student">Student</label>
                    <div class="slider-tab"></div>
                </div>
                
                <div class="form-inner">
                    
                    <form action="#" class="login">
                        <div class="field">
                            <input type="email" name="login-email" class="form-style" placeholder="Your Email"
                                id="logemail" autocomplete="off">
                            <i class="input-icon uil uil-at"></i>
                        </div>
                        
                        <div class="field">
                            <input type="password" name="login-pass" class="form-style" placeholder="Your Password"
                                id="logpass" autocomplete="off">
                            <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <div class="pass-link"><a href="#">Forgot password?</a></div>
                        <div class="field field-btn">
                            <div class="btn-layer"></div>
                            <input type="submit" value="Login">
                        </div>
                        <div class="signup-link">Not a member? <a href="">Signup now</a></div>
                    </form>
                    <form action="#" class="signup">
                        
                        <div class="field">
                            <input type="text" name="signup-name" class="form-style" placeholder="Your Full Name" id="signname"
                                autocomplete="off">
                            <i class="input-icon uil uil-user"></i>
                        </div>
        
                        <div class="field">
                            <input type="email" name="signup-email" class="form-style" placeholder="Your Email" id="signmail"
                                autocomplete="off">
                            <i class="input-icon uil uil-at"></i>
                        </div>
        
                        <div class="field">
                            <input type="password" name="signup-pass" class="form-style" placeholder="Your Password"
                                id="signpass" autocomplete="off">
                            <i class="input-icon uil uil-lock-alt"></i>
                        </div>
        
                        <div class="field">
                            <input type="password" name="signup-rpass" class="form-style" placeholder="Repeat Password"
                                id="signrpass" autocomplete="off">
                            <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <div class="field field-btn">
                            <div class="btn-layer"></div>
                            <input type="submit" value="Signup">
                        </div>
                    </form>
                </div>
            </div>
        </div>


</section>
<script>
        const loginText = document.querySelector(".title-text .login");
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector("form .signup-link a");
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

    </script>


<?php include_once('templates/footer.php') ?>