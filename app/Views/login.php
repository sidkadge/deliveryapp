<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/app.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/bundles/bootstrap-social/bootstrap-social.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/style.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='public/assets/img/favicon.ico' />

</head>
<style>
/* Styling for flash success message */
.flash-success {
    background-color: #4caf50;
    /* Green */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    margin-bottom: 10px;
}

/* Styling for flash error message */
.toast.toast-error {
    background-color: #f44336;
    /* Red */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    margin-bottom: 10px;
}

/* Positioning for flash error message */
.toast-top-right {
    top: 20px;
    right: 20px;
    position: fixed;
    z-index: 9999;
}
.form-group label{
    color: black;
}
/* style="background-image: url('public/assets/img/image-gallery/44.png');  background-repeat: no-repeat;" */
/* body {
            background-image: url('public/assets/img/image-gallery/42.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            width: 100%;
            margin: 0;
            padding: 0;
        } */

.form-group label{
    font-weight: bold;
}
.d-block control-label{
    font-weight: bold;
}
</style>

<body>
    <div id="flash-success-container">
        <?php if (session()->has('success')) : ?>
        <div class="flash-success">
            <?= session('success') ?>
        </div>
        <?php endif; ?>
    </div>
    <?php if (session()->has('error')): ?>

    <div id="toast-container" class="toast-top-right">
        <div class="toast toast-error" aria-live="assertive" style="">
            <div class="toast-message">
                <?= session('error') ?>
            </div>
        </div>
    </div>
    <?php endif ?>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary" style="background-image: linear-gradient(184deg, #2b7bc4 0%, #d0dce49e 100%);" >
                            <div class="card-header" >
                                <h4 >Login</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo base_url();?>dologin" class="needs-validation"
                                    novalidate="">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile number</label>
                                        <input id="mobile_no" type="tel" class="form-control" placeholder="Enter mobile number" name="mobile_no" tabindex="1"
                                            required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your email
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label" style="font-weight: bold;">Password</label>
                                            <div class="float-right">
                                                <!-- <a href="auth-forgot-password.html" class="text-small">
                                                    Forgot Password?
                                                </a> -->
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control" placeholder="Enter The Password" name="password"
                                            tabindex="2" required>
                                        <div class="invalid-feedback">
                                            please fill in your password
                                        </div>
                                    </div>
                                    <div class="form-group" >
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="mt-4 text-muted text-center" style="font-weight: bold; color: #000303 !important;">
                                        Don't have an account? <a href="<?=base_url(); ?>registraion" style="font-weight: bold;">register</a>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn btn-info btn-lg btn-block" tabindex="4" style="font-weight: bold; font-size: 15px;">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="<?=base_url(); ?>public/assets/js/app.min.js"></script>
    <script src="<?=base_url(); ?>public/assets/js/scripts.js"></script>
    <script src="<?=base_url(); ?>public/assets/js/custom.js"></script>
    <script>
    // jQuery function to hide the success message after 5 seconds
    $(document).ready(function() {
        setTimeout(function() {
            $(".toast").fadeOut(1000);
        }, 5000); // 5000 milliseconds = 5 seconds
    });
    </script>
</body>

</html>