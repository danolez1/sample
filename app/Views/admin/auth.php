<div class="main-wrapper">
    <div class="page-wrapper full-page-wrapper d-flex align-items-center justify-content-center">
        <main class="auth-page">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-6-tablet">
                        <div class="mdc-card">
                            <form method="post" role="form" action="">
                                <div class="row col-12 justify-content-center pr-0 pl-0 ml-0 mr-0" style="margin-top: -1em;">
                                    <?php if (!is_null($userController_error)) { ?>
                                        <div class="alert alert-danger text-center col-lg-6 col-md-6 col-sm-12" role="alert">
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
                                                <label for="text-field-hero-input" class="mdc-floating-label">Username</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-text-field w-100">
                                                <input class="mdc-text-field__input" type="password" name="password" required id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Password</label>
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
                                                <label for="checkbox-1">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex align-items-center justify-content-end">
                                            <a href="#">Forgot Password</a>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <button type="submit" name="auth" class="mdc-button mdc-button--raised w-100">
                                                Login
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
                </div>
            </div>
        </main>
    </div>
</div>