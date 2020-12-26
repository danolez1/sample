<?php
if (!is_null($dashboardController_error)) { ?>
    <script>
        webToast.Danger({
            status: dictionary['error-occured'][lang],
            message: dictionary<?php echo "['" . $dashboardController_error->{"trn"} . "']['" . $_COOKIE['lingo'] . "']"; ?>,
            delay: 10000
        });
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <?php } else {
    if ($showDashboardController_result) { ?>
        <script>
            webToast.Success({
                status: dictionary['successful'][lang],
                message: dictionary['settings-updated'][lang],
                delay: 5000
            });
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
<?php }
} ?>
<main class="content-wrapper">
    <h3>Settings</h3>
    <div class="row col-12 mt-3">
        <div class="col-lg-8 col-md-12 col-sm-12 col-12">

            <form  enctype="multipart/form-data" method="POST" action="">
                <h4 class="mt-5">Banner Image</h4>
                <div class="card mt-2 col-12 p-0 m-0 upload-image text-center" style="background-color:#E0E0E0;border:#E0E0E0;" type="button">
                    <label for="browse">
                        <input type="hidden" value="" name="banner" />
                        <img id="browse-preview" class="img img-fluid" src="<?php echo !isEmpty($this->settings->getBannerImage()) ? $this->settings->getBannerImage() : 'assets/images/dashboard/hero.svg'; ?>" alt="" />
                    </label>
                </div>
                <input type="file" id="browse" name="browse" accept="image/*" style="display: none">
                <div class="card card-footer justify-content-right p-2" style="background-color:#FFF; margin-top:-2px; ">
                    <button type="submit" name="upload-banner" class="btn btn-sm tx-14 btn-danger col-4 ">Upload</button>
                </div>
            </form>
            <form  method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-4 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title">Header Information</h6>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field">
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getTitle()) ? $this->settings->getTitle() : ''; ?>" name="store-title" trn="seo-title-placeholder" id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Title</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <label class="mr-3 ml-2" style="margin-top: .18em;">Use name as Logo</label>
                                            <div class="mdc-switch mt-2" data-mdc-auto-init="MDCSwitch">
                                                <div class="mdc-switch__track"></div>
                                                <div class="mdc-switch__thumb-underlay">
                                                    <div class="mdc-switch__thumb">
                                                        <input type="checkbox" <?php echo !isEmpty($this->settings->getUseTitleAsLogo()) ? 'checked' : ''; ?> name="use-title-as-logo" id="basic-switch" class="mdc-switch__native-control" role="switch">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field">
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getStoreName()) ? $this->settings->getStoreName() : ''; ?>" name="store-name" trn="seo-store-placeholder" id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Store Name</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-web"></i>
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getWebsiteUrl()) ? $this->settings->getWebsiteUrl() : ''; ?>" name="website-url" trn="seo-url-placeholder" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Website Url</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field input-textarea mdc-text-field--outlined">
                                                <textarea class="mdc-text-field__input" name="seo-tags" trn="seo-tags-placeholder" id="text-field-hero-input"><?php echo !isEmpty($this->settings->getTags()) ? $this->settings->getTags() : ''; ?></textarea>
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Tags</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field input-textarea mdc-text-field--outlined">
                                                <textarea class="mdc-text-field__input" name="seo-description" trn="seo-description-placeholder" id="text-field-hero-input"><?php echo !isEmpty($this->settings->getDescription()) ? $this->settings->getDescription() : ''; ?></textarea>
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Description</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="save-header-info" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>
            <form enctype="multipart/form-data" method="POST" action="">
                <h5 class="mt-5">Logo</h5>
                <div class="card mt-4 col-lg-6 col-md-6 col-12 p-0 setting-card text-center" style="background-color:#E0E0E0;border:#E0E0E0;">
                    <label for="browse1">
                        <input type="hidden" value="" name="logo" />
                        <img id="browse-preview1" class="img img-fluid" src="<?php echo !isEmpty($this->settings->getLogo()) ? $this->settings->getLogo() : 'assets/images/dashboard/hero.svg'; ?>" alt="" />
                    </label>
                </div>
                <input type="file" id="browse1" name="browse1" accept="image/*" style="display:none">
                <div class="card card-footer col-lg-6 col-md-6 col-12 p-2" style="background-color:#FFF;margin-top:-2px;">
                    <button type="submit" name="upload-logo" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-4 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title">Website Design</h6>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field">
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getBannerTitle()) ? $this->settings->getBannerTitle() : ''; ?>" name="banner-title" id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Banner Title</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field input-textarea mdc-text-field--outlined">
                                                <textarea class="mdc-text-field__input" name="banner-content" trn="seo-tags-placeholder" id="text-field-hero-input"><?php echo !isEmpty($this->settings->getBannerText()) ? $this->settings->getBannerText() : ''; ?></textarea>
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Banner Content</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input required type="hidden" value="<?php echo !isEmpty($this->settings->getSliderType() + 1) ? $this->settings->getSliderType() + 1 : '1'; ?>" name="slider-type">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo !isEmpty($this->settings->getSliderType() + 1) ? $this->settings->getSliderType() + 1 : '1'; ?>" aria-selected="true">
                                                            Slider <?php echo !isEmpty($this->settings->getSliderType() + 1) ? $this->settings->getSliderType() + 1 : '1'; ?> </li>
                                                        <?php for ($i = 1; $i < 5; $i++) {
                                                            if ($i == intval($this->settings->getSliderType() + 1));
                                                            else if (isEmpty($this->settings->getSliderType() + 1) && $i == 1);
                                                            else { ?>
                                                                <li class="mdc-list-item" data-value="<?php echo $i; ?>">
                                                                    Slider <?php echo $i; ?>
                                                                </li>

                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Slider Type</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input required type="hidden" value="<?php echo !isEmpty($this->settings->getFooterType() + 1) ? $this->settings->getFooterType() + 1 : '1'; ?>" name="footer-type">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo !isEmpty($this->settings->getFooterType() + 1) ? $this->settings->getFooterType() + 1 : '1'; ?>" aria-selected="true">
                                                            Footer <?php echo !isEmpty($this->settings->getFooterType() + 1) ? $this->settings->getFooterType() + 1 : '1'; ?> </li>
                                                        <?php for ($i = 1; $i < 3; $i++) {
                                                            if ($i == intval($this->settings->getFooterType() + 1));
                                                            else if (isEmpty($this->settings->getFooterType() + 1) && $i == 1);
                                                            else { ?>
                                                                <li class="mdc-list-item" data-value="<?php echo $i; ?>">
                                                                    Footer <?php echo $i; ?>
                                                                </li>
                                                        <?php }
                                                        } ?>

                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Footer Type</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input required type="hidden" value="<?php echo !isEmpty($this->settings->getMenuDisplayOrientation()) ? $this->settings->getMenuDisplayOrientation() : '1'; ?>" name="menu-display">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo !isEmpty($this->settings->getMenuDisplayOrientation()) ? $this->settings->getMenuDisplayOrientation() : '1'; ?>" aria-selected="true">
                                                            <?php echo !isEmpty($this->settings->getMenuDisplayOrientation()) ? ($this->settings->getOrientationWords($this->settings->getMenuDisplayOrientation())[0]) : 'Horizontal'; ?></li>
                                                        <li class="mdc-list-item" data-value="<?php echo !isEmpty($this->settings->getMenuDisplayOrientation()) ? intval($this->settings->getMenuDisplayOrientation() == 1) ? '2' : '1' : '2'; ?>">
                                                            <?php echo !isEmpty($this->settings->getMenuDisplayOrientation()) ? ($this->settings->getOrientationWords($this->settings->getMenuDisplayOrientation())['other'][0]) : 'Vertical'; ?>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Menu Display</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input required type="hidden" value="<?php echo !isEmpty($this->settings->getInfoDisplayOrientation()) ? $this->settings->getInfoDisplayOrientation() : '1'; ?>" name="info-display">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo !isEmpty($this->settings->getInfoDisplayOrientation()) ? $this->settings->getInfoDisplayOrientation() : '1'; ?>" aria-selected="true">
                                                            <?php echo !isEmpty($this->settings->getInfoDisplayOrientation()) ? ($this->settings->getOrientationWords($this->settings->getInfoDisplayOrientation())[0]) : 'Horizontal'; ?></li>
                                                        <li class="mdc-list-item" data-value="<?php echo !isEmpty($this->settings->getInfoDisplayOrientation()) ? intval($this->settings->getInfoDisplayOrientation() == 1) ? '2' : '1' : '2'; ?>">
                                                            <?php echo !isEmpty($this->settings->getInfoDisplayOrientation()) ? ($this->settings->getOrientationWords($this->settings->getInfoDisplayOrientation())['other'][0]) : 'Vertical'; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Information Display</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input required type="hidden" value="<?php echo !isEmpty($this->settings->getProductDisplayOrientation()) ? $this->settings->getProductDisplayOrientation() : '1'; ?>" name="product-display">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="1" aria-selected="true">
                                                            Grid</li>
                                                        <!-- <li class="mdc-list-item" data-value="2">
                                                            List
                                                        </li> -->
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Product Display</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                                <i class="material-icons mdc-text-field__icon">color_lens</i>
                                                <input class="mdc-text-field__input" id="color-picker" value="<?php echo !isEmpty($this->settings->getColors()) ? $this->settings->getColors() : ''; ?>" name="theme-color" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input pb-3" class="mdc-floating-label">Theme Color</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="save-website-design" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>

            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-4 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title">Website Information</h6>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getPhoneNumber()) ? $this->settings->getPhoneNumber() : ''; ?>" name="phone" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Phone Number</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getEmail()) ? $this->settings->getEmail() : ''; ?>" name="email" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Email</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-facebook"></i>
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getSocials()->facebook) ? $this->settings->getSocials()->facebook : ''; ?>" name="fb" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Facebook Url</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-twitter"></i>
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getSocials()->twitter) ? $this->settings->getSocials()->twitter : ''; ?>" name="twitter" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Twitter Url</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-instagram"></i>
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getSocials()->instagram) ? $this->settings->getSocials()->instagram : ''; ?>" name="ig" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Instagram Url</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="website-info" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>
        </div>

        <div class="col-lg-4 col-md-12 col-sm-12 col-12  mt-4">
            <form method="POST" action="">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Delivery Information</h5>

                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                <i class="material-icons mdc-text-field__icon icofont-yen yen"></i>
                                <input type="number" class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getShippingFee()) ? $this->settings->getShippingFee() : ''; ?>" name="shipping-fee" id="text-field-hero-input">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label">Shipping Fee</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-3">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                <i class="material-icons mdc-text-field__icon">access_time</i>
                                <input type="number" class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getDeliveryTime()) ? $this->settings->getDeliveryTime() : ''; ?>" name="delivery-time" id="text-field-hero-input" placeholder="In minutes">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label">Delivery Time</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-3">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                <i class="material-icons mdc-text-field__icon">timer</i>
                                <input type="number" class="mdc-text-field__input" placeholder="In minutes" value="<?php echo !isEmpty($this->settings->getDeliveryTimeRange()) ? $this->settings->getDeliveryTimeRange() : ''; ?>" name="time-range" id="text-field-hero-input">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label">Time Range</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-3">
                            <div class="mdc-text-field mdc-text-field--outlined input-textarea mdc-text-field--with-trailing-icon">
                                <i class="material-icons mdc-text-field__icon">my_location</i>
                                <textarea class="mdc-text-field__input" name="address" id="text-field-hero-input"><?php echo !isEmpty($this->settings->getAddress()) ? $this->settings->getAddress() : ''; ?></textarea>
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label">Store Address</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-3">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                <i class="material-icons mdc-text-field__icon">location_searching</i>
                                <input type="number" placeholder="In meters" class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getDeliveryDistance()) ? $this->settings->getDeliveryDistance() : ''; ?>" name="delivery-distance" id="text-field-hero-input">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label">Delivery Distance</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-3">
                            <div class="mdc-text-field mdc-text-field--outlined input-textarea">
                                <textarea class="mdc-text-field__input" name="delivery-area" id="text-field-hero-input"><?php echo !isEmpty($this->settings->getDeliveryAreas()) ? $this->settings->getDeliveryAreas() : ''; ?></textarea>
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label">Delivery Area</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="delivery-options" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="card mt-5">
                    <div class="card-body">
                        <h5 class="card-title">Product Information</h5>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                <i class="material-icons mdc-text-field__icon icofont-yen yen"></i>
                                <input type="number" class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getMinOrder()) ? $this->settings->getMinOrder() : ''; ?>" name="min-order" id="text-field-hero-input">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label">Minimum Order</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-sm-2">
                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                <input required type="hidden" name="currency">
                                <i class="mdc-select__dropdown-icon"></i>
                                <div class="mdc-select__selected-text"></div>
                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                    <ul class="mdc-list" style="width: 15em;">
                                        <li class="mdc-list-item mdc-list-item--selected" data-value="jpy" aria-selected="true">
                                            JPY <i class="material-icons mdc-text-field__icon icofont-yen yen" style="font-size: 12px !important;"></i> </li>
                                    </ul>
                                </div>
                                <span class="mdc-floating-label">Currency</span>
                                <div class="mdc-line-ripple"></div>
                            </div>
                        </div>
                        <div class="mdc-form-field">
                            <div class="mdc-checkbox mdc-checkbox--info">
                                <input type="checkbox" name="display-rating" <?php echo ($this->settings->getDisplayRating()) ? 'checked' : ''; ?> id="basic-disabled-checkbox" class="mdc-checkbox__native-control" />
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Display Ratings</label>
                        </div>
                        <div class="mdc-form-field">
                            <div class="mdc-checkbox mdc-checkbox--info">
                                <input type="checkbox" name="display-order-count" <?php echo ($this->settings->getDisplayOrderCount()) ? 'checked' : ''; ?> id="basic-disabled-checkbox" class="mdc-checkbox__native-control" />
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Display Order Count</label>
                        </div>
                        <div class="mdc-form-field">
                            <div class="mdc-checkbox mdc-checkbox--info">
                                <input type="checkbox" name="display-tax" <?php echo ($this->settings->getShowTax()) ? 'checked' : ''; ?> id="basic-disabled-checkbox" class="mdc-checkbox__native-control" />
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Display Tax</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="save-product-info" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>
            <form enctype="multipart/form-data" method="POST" action="">
                <h5 class="mt-5">Product Image Placeholder</h5>
                <div class="card mt-4 col-12 p-0 setting-card text-center" style="background-color:#E0E0E0;border:#E0E0E0;">
                    <label for="browse2">
                        <input type="hidden" name="image-placeholder" value="" />
                        <img id="browse-preview2" class="img img-fluid" src="<?php echo !isEmpty($this->settings->getImagePlaceholder()) ? $this->settings->getImagePlaceholder() : 'assets/images/dashboard/hero.svg'; ?>" />
                    </label>
                </div>
                <input type="file" id="browse2" name="browse2" accept="image/*" style="display: none">
                <div class="card card-footer col-12 p-2" style="background-color:#FFF;margin-top:-2px;">
                    <button type="submit" name="upload-placeholder" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-5 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title">Payment</h6>
                                <div class="template-demo">
                                    <div class="mdc-form-field">
                                        <div class="mdc-checkbox">
                                            <input type="checkbox" <?php echo !isEmpty($this->settings->getPaymentMethods()->cash) ? 'checked' : ''; ?> name="pm-cash" class="mdc-checkbox__native-control" id="checkbox-1" />
                                            <div class="mdc-checkbox__background">
                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                </svg>
                                                <div class="mdc-checkbox__mixedmark"></div>
                                            </div>
                                        </div>
                                        <label for="checkbox-1">Cash</label>
                                    </div>
                                    <div class="mdc-form-field">
                                        <div class="mdc-checkbox">
                                            <input type="checkbox" <?php echo !isEmpty($this->settings->getPaymentMethods()->card) ? 'checked' : ''; ?> name="pm-card" class="mdc-checkbox__native-control" id="checkbox-1" />
                                            <div class="mdc-checkbox__background">
                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                </svg>
                                                <div class="mdc-checkbox__mixedmark"></div>
                                            </div>
                                        </div>
                                        <label for="checkbox-1">Card</label>
                                    </div>
                                    <div class="mdc-form-field">
                                        <div class="mdc-checkbox mdc-checkbox--disabled">
                                            <input type="checkbox" name="pm-line-pay" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" disabled />
                                            <div class="mdc-checkbox__background">
                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                </svg>
                                                <div class="mdc-checkbox__mixedmark"></div>
                                            </div>
                                        </div>
                                        <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Line Pay</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="payment-method" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-5 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title">Operation Time</h6>
                                <div class="template-demo">
                                    <div class="accordion" id="accordionTime">
                                        <?php for ($i = 0; $i < count(daysOfWeek()); $i++) { ?>
                                            <div class="card">
                                                <div class="card-header p-0" id="headingOne">
                                                    <h5 class="mb-0 p-0">
                                                        <button class="btn btn-link text-dark tx-14 text-left" type="button" data-toggle="collapse" data-target="#collapse<?php echo daysOfWeek()[$i]; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                            <?php echo daysOfWeek()[$i]; ?>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="collapse<?php echo daysOfWeek()[$i]; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionTime">
                                                    <div class="card-body p-2">
                                                        <div class="row col-12 m-0 p-0 ">
                                                            <span class="col-4 m-0 p-0 pt-2"> Open:</span>
                                                            <div class="input-group mb-3 m-0 p-0 col-7">
                                                                <input type="text" name="shop-open['<?php echo daysOfWeek()[$i]; ?>']" value="<?php echo !isEmpty($this->settings->getOperationalTime()[$i]) ? $this->settings->getOperationalTime()[$i]->open : ''; ?>" class="form-control m-0 p-0 timepicker" style="background-color: #eee;">
                                                                <div class="input-group-append d-sm-block d-none">
                                                                    <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row col-12 m-0 p-0 ">
                                                            <span class="col-4 m-0 p-0 pt-2"> Break:</span>
                                                            <div class="input-group mb-3 m-0 p-0 col-7">
                                                                <input type="text" name="shop-break-start['<?php echo daysOfWeek()[$i]; ?>']" value="<?php echo !isEmpty($this->settings->getOperationalTime()[$i]) ? $this->settings->getOperationalTime()[$i]->breakStart : ''; ?>" class="form-control m-0 p-0 timepicker" style="background-color: #eee;">
                                                                <div class="input-group-append d-sm-block d-none">
                                                                    <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row col-12 m-0 p-0 ">
                                                            <span class="col-4 m-0 p-0 pt-2"></span>
                                                            <div class="input-group mb-3 m-0 p-0 col-7">
                                                                <input type="text" name="shop-break-end['<?php echo daysOfWeek()[$i]; ?>']" value="<?php echo !isEmpty($this->settings->getOperationalTime()[$i]) ? $this->settings->getOperationalTime()[$i]->breakEnd : ''; ?>" class="form-control m-0 p-0 timepicker" style="background-color: #eee;">
                                                                <div class="input-group-append d-sm-block d-none">
                                                                    <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row col-12 m-0 p-0 ">
                                                            <span class="col-4 m-0 p-0 pt-2"> Close:</span>
                                                            <div class="input-group mb-3 m-0 p-0 col-7">
                                                                <input type="text" name="shop-close['<?php echo daysOfWeek()[$i]; ?>']" value="<?php echo !isEmpty($this->settings->getOperationalTime()[$i]) ? $this->settings->getOperationalTime()[$i]->close : ''; ?>" class="form-control m-0 p-0 timepicker" style="background-color: #eee;">
                                                                <div class="input-group-append d-sm-block d-none">
                                                                    <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="operational-time" class="btn btn-danger btn-sm tx-14">Save changes</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-5 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title">Subscription</h6>
                                <div class="template-demo">
                                    <div class="row col-12 p-0 m-0 mb-1">
                                        <h6 class="col-6 p-0 m-0">Plan :</h6>
                                        <div class="col-6 p-0 m-0"> sd<?php ?></h6>
                                        </div>
                                    </div>
                                    <div class="row col-12 p-0 m-0 mb-1">
                                        <h6 class="col-6 p-0 m-0">Branches :</h6>
                                        <div class="col-6 p-0 m-0"> sd<?php ?></h6>
                                        </div>
                                    </div>
                                    <div class="row col-12 p-0 m-0 mb-1">
                                        <h6 class="col-6 p-0 m-0">Due Date :</h6>
                                        <div class="col-6 p-0 m-0"> sd<?php ?></h6>
                                        </div>
                                    </div>
                                    <div class="row col-12 p-0 m-0 mb-1">
                                        <h6 class="col-6 p-0 m-0">Amount :</h6>
                                        <div class="col-6 p-0 m-0"> sd<?php ?></h6>
                                        </div>
                                    </div>
                                    <h6>Credit Card <i class="icofont-credit-card"></i></h6>
                                    <div class="alert alert-info p-1 pl-2" role="alert">
                                        <i class="icofont-ui-edit float-right option-right hover click"></i>
                                        <span class="tx-13"> <i class="icofont-jcb pr-2 pt-1" style="font-size:20px;"></i>Fatunmbi Daniel</span>
                                        <div class="tx-13">3454 **** **** 3453</div>
                                        <div class="tx-13">30/23</div>
                                    </div>
                                    <span class="tx-13 btn-sm btn btn-success"><i class="icofont-ui-add txt-10 mr-2"></i>Add Card</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <a target="_blank" href="home" type="button" class="btn btn-danger mt-5 col-lg-8 col-sm-12">Preview My Hompage</a>
</main>