<style>
    :root {
        --input-padding-x: 1.5rem;
        --input-padding-y: .75rem;
    }

    /* body {
        background: #007bff;
        background: linear-gradient(to right, #0062E6, #33AEFF);
    } */

    .card-signin {
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.4);
    }

    .card-signin .card-body {
        padding: 2rem;
    }

    .form-signin {
        width: 100%;
    }

    .form-signin .btn {
        font-size: 80%;
        border-radius: 5rem;
        letter-spacing: .1rem;
        font-weight: bold;
        padding: 1rem;
        transition: all 0.2s;
    }

    .form-label-group {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-label-group input {
        height: auto;
        border-radius: 2rem;
    }

    .form-label-group>input,
    .form-label-group>label {
        padding: var(--input-padding-y) var(--input-padding-x);
    }

    .form-label-group>label {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        margin-bottom: 0;
        /* Override default `<label>` margin */
        line-height: 1.5;
        color: #495057;
        border: 1px solid transparent;
        border-radius: .25rem;
        transition: all .1s ease-in-out;
    }

    .btn-google {
        color: white;
        background-color: #ea4335;
    }

    .btn-facebook {
        color: white;
        background-color: #3b5998;
    }

    .btn-google:hover,
    .btn-facebook:hover {
        color: #fff;
        font-size: 14px;
    }

    @supports (-ms-ime-align: auto) {
        .form-label-group>label {
            display: none;
        }

        .form-label-group input::-ms-input-placeholder {
            color: #777;
        }
    }

    @media all and (-ms-high-contrast: none),
    (-ms-high-contrast: active) {
        .form-label-group>label {
            display: none;
        }

        .form-label-group input:-ms-input-placeholder {
            color: #777;
        }
    }
</style>
<div class="container" id="login">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h3 class="font-weight-bold card-title text-center mt-2" trn='login'>Sign In</h3>
                    <form method="post" role="form" class="form-signin mt-4" action="">
                        <div class="row col-12 justify-content-center pr-0 pl-0 ml-0 mr-0" style="margin-top: -1em;">
                            <?php if (!is_null($userController_error)) { ?>
                                <div class="alert alert-danger text-center col-lg-6 col-md-6 col-sm-12" role="alert">
                                    <strong style="font-size:12px;" trn="<?php echo $userController_error->{"trn"} ?>"><?php echo $userController_error->{0}; ?></strong>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-label-group">
                            <input type="email" name="lemail" trn="email" class="form-control" placeholder="Email address" required autofocus>
                        </div>

                        <div class="form-label-group">
                            <input type="password" name="lpassword" trn="password" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="custom-control custom-checkbox mb-3 text-center">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Remember password</label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="login" trn="login">Login</button>
                        <a href="#register" class="btn btn-lg btn-primary btn-block text-uppercase mt-2" trn="sign-up">Sign Up</a>
                        <!-- <hr class="my-4">
                        <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="bx bxl-twitter"></i> <span trn=""> Sign in with Google</span></button>
                        <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class='bx bxl-facebook'></i> <span trn=""> Sign in with Facebook</span> </button> -->
                    </form>
                    <?php if (!is_null($userController_error)) {
                        $_POST['lpassword'] = "";
                        keepFormValues($_POST);
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" id="register" style="display: none;">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h3 class="font-weight-bold card-title text-center mt-2" trn="sign-up">Sign Up</h3>
                    <form method="post" role="form" class="form-signin mt-4" action="">
                        <div class="row col-12 justify-content-center pr-0 pl-0 ml-0 mr-0" style="margin-top:-1em;">
                            <?php if (!is_null($userController_error)) { ?>
                                <div class="alert alert-danger text-center col-lg-6 col-md-6 col-sm-12 p-1" role="alert">
                                    <strong style="font-size:12px;" trn="<?php echo $userController_error->{"trn"} ?>"><?php echo $userController_error->{0}; ?></strong>
                                </div>
                            <?php } else if ($registration_result) { ?>
                                <div class="alert alert-success text-center col-lg-6 col-md-6 col-sm-12" role="alert">
                                    <strong style="font-size:12px;" trn="reg-successful">Registration Successful</strong>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-label-group">
                            <input type="text" name="name" trn="full-name" class="form-control" placeholder="Full Name" required autofocus>
                        </div>
                        <div class="form-label-group">
                            <input type="email" name="remail" trn="email" class="form-control" placeholder="Email address" required>
                        </div>

                        <div class="form-label-group">
                            <input type="phone" name="phone" trn="phone" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="form-label-group">
                            <input type="password" name="rpassword" trn="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="sign-up" trn="sign-up">Sign Up</button>
                        <a href="#login" class="btn btn-lg btn-primary btn-block text-uppercase mt-2" trn="login">Login</a>
                        <!-- <hr class="my-4">
                        <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="bx bxl-twitter"></i><span trn=""> Sign up with Google</span> </button>
                        <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class='bx bxl-facebook'></i> <span trn=""> Sign up with Facebook</span> </button> -->
                    </form>
                    <?php if (!is_null($userController_error)) {
                        $_POST['rpassword'] = "";
                        keepFormValues($_POST);
                    }; ?>
                </div>
            </div>
        </div>
    </div>
</div>