<?php

use Demae\Auth\Models\Error;

?><div class="main-wrapper">
    <div class="page-wrapper full-page-wrapper d-flex align-items-center justify-content-center">
        <main class="auth-page">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-1-tablet"></div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-6-tablet">
                        <!-- SIGN IN -->
                        <div class="mdc-card" id="sign-in" style="display: <?php echo $resetPassword ? 'none' : 'block' ?>;">
                            <form method="post" role="form" action="">
                                <div class="row col-12 justify-content-center pr-0 pl-0 ml-0 mr-0" style="margin-top: -1em;">
                                    <?php if (!is_null($userController_error) && (array)($userController_error) != Error::UserNoExist) { ?>
                                        <div class="alert la alert-danger text-center col-lg-6 col-md-6 col-sm-12" role="alert">
                                            <strong style="font-size:12px;" trn="<?php echo $userController_error->{"trn"} ?>"><?php echo $userController_error->{0}; ?></strong>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="mdc-layout-grid">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-text-field w-100">
                                                <input class="mdc-text-field__input" type="text" name="username" required id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label" trn="username">Username</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-text-field w-100">
                                                <input class="mdc-text-field__input" type="password" name="password" required id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label" trn="password">Password</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-form-field">
                                                <div class="mdc-checkbox">
                                                    <input type="checkbox" class="mdc-checkbox__native-control" id="checkbox-1" />
                                                    <div class="mdc-checkbox__background">
                                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                        </svg>
                                                        <div class="mdc-checkbox__mixedmark"></div>
                                                    </div>
                                                </div>
                                                <label for="checkbox-1" trn="remember-me">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex align-items-center justify-content-end">
                                            <a href="javascript:;" id="forgot" trn="forgot-password">Forgot Password</a>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <button type="submit" name="auth" class="mdc-button mdc-button--raised w-100" trn="login">
                                                Login
                                            </button>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <a href="javascript:;" class="langauth col-6 mdc-layout-grid__cell--span-6 text-right" language="en">English</a>
                                            <span class="divider mt-1"></span>
                                            <a href="javascript:;" class="langauth col-6 mdc-layout-grid__cell--span-6 text-left" language="jp">日本語</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- FORGOT PASSWORD -->
                        <div class="mdc-card" id="forgot-password" style="display: <?php echo $resetPassword ? 'block' : 'none' ?>;">
                            <form method="post" role="form" action="">
                                <div class="row col-12 justify-content-center pr-0 pl-0 ml-0 mr-0" style="margin-top: -1em;">
                                    <?php if (!is_null($userController_error)) { ?>
                                        <div class="alert ra alert-danger text-center col-lg-6 col-md-6 col-sm-12" role="alert">
                                            <strong style="font-size:12px;" trn="<?php echo $userController_error->{"trn"} ?>"><?php echo $userController_error->{0}; ?></strong>
                                        </div>
                                        <?php } else {
                                        if ($resetPassword) { ?>
                                            <div class="alert ra alert-success text-center col-lg-6 col-md-6 col-sm-12" role="alert">
                                                <strong style="font-size:12px;" trn="password-reset">Password reset successful</strong>
                                            </div>
                                    <?php  }
                                    } ?>
                                </div>
                                <div class="mdc-layout-grid">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-text-field w-100">
                                                <input class="mdc-text-field__input" type="text" name="username" required id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label" trn="username">Username</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex align-items-start justify-content-start">
                                            <a href="javascript:;" id="login" trn="login">Login</a>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <button type="submit" name="reset" class="mdc-button mdc-button--raised w-100" trn="reset">
                                                Reset
                                            </button>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <a href="javascript:;" class="langauth col-6 mdc-layout-grid__cell--span-6 text-right" language="en">English</a>
                                            <span class="divider mt-1"></span>
                                            <a href="javascript:;" class="langauth col-6 mdc-layout-grid__cell--span-6 text-left" language="jp">日本語</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-1-tablet"></div>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
    $('#forgot').click(function(e) {
        $('#forgot-password').css('display', 'block');
        $('#sign-in').css('display', 'none')
        $('.la').css('display', 'none');
        $('.ra').css('display', 'block');
        console.log($('.la'))
        console.log($('.ra'))
    });
    $('#login').click(function(e) {
        $('#forgot-password').css('display', 'none');
        $('#sign-in').css('display', 'block')
        $('.ra').css('display', 'none');
        $('.la').css('display', 'block');
        console.log($('.la'))
        console.log($('.ra'))

    });
</script>