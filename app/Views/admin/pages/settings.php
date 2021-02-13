<?php

use danolez\lib\Res\PrintNodeApi;
use danolez\lib\Security\Encoding;

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
}
include 'app/Views/admin/pages/add_card.php'; ?>
<main class="content-wrapper">
    <h3 trn="settings">Settings</h3>
    <div class="row col-12 mt-3">
        <div class="col-lg-8 col-md-12 col-sm-12 col-12">

            <form enctype="multipart/form-data" method="POST" action="">
                <h4 class="mt-5" trn="banner-image">Banner Image</h4>
                <div class="card mt-2 col-12 p-0 m-0 upload-image text-center" style="background-color:#E0E0E0;border:#E0E0E0;" type="button">
                    <label for="browse">
                        <input type="hidden" value="" name="banner" />
                        <img id="browse-preview" class="img img-fluid" src="<?php echo !isEmpty($this->settings->getBannerImage()) ? $this->settings->getBannerImage() : 'assets/images/dashboard/hero.svg'; ?>" alt="" />
                    </label>
                </div>
                <input type="file" id="browse" name="browse" accept="image/*" style="display: none">
                <div class="card card-footer justify-content-right p-2" style="background-color:#FFF; margin-top:-2px; ">
                    <button type="submit" name="upload-banner" class="btn btn-sm tx-14 btn-danger col-4" trn="upload">Upload</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-4 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title" trn="header-info">Header Information</h6>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field">
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getTitle()) ? $this->settings->getTitle() : ''; ?>" name="store-title" trn="seo-title-placeholder" id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label" trn="title">Title</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <label class="mr-3 ml-2" style="margin-top: .18em;" trn="use-name-as-logo">Use name as Logo</label>
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
                                                <label for="text-field-hero-input" class="mdc-floating-label" trn="store-name">Store Name</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-web"></i>
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getWebsiteUrl()) ? $this->settings->getWebsiteUrl() : ''; ?>" name="website-url" trn="seo-url-placeholder" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="website">Website Url</label>
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
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="tags">Tags</label>
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
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="descr">Description</label>
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
                    <button type="submit" name="save-header-info" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                </div>
            </form>
            <form enctype="multipart/form-data" method="POST" action="">
                <h5 class="mt-5" trn="logo">Logo</h5>
                <div class="card mt-4 col-lg-6 col-md-6 col-12 p-0 setting-card text-center" style="background-color:#E0E0E0;border:#E0E0E0;">
                    <label for="browse1">
                        <input type="hidden" value="" name="logo" />
                        <img id="browse-preview1" class="img img-fluid" src="<?php echo !isEmpty($this->settings->getLogo()) ? $this->settings->getLogo() : 'assets/images/dashboard/hero.svg'; ?>" alt="" />
                    </label>
                </div>
                <input type="file" id="browse1" name="browse1" accept="image/*" style="display:none">
                <div class="card card-footer col-lg-6 col-md-6 col-12 p-2" style="background-color:#FFF;margin-top:-2px;">
                    <button type="submit" name="upload-logo" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-4 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title" trn="web-design">Website Design</h6>
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
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="banner-content">Banner Content</label>
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
                                                            <span trn='slidder-ride'>Slider</span> <?php echo !isEmpty($this->settings->getSliderType() + 1) ? $this->settings->getSliderType() + 1 : '1'; ?>
                                                        </li>
                                                        <?php for ($i = 1; $i < 5; $i++) {
                                                            if ($i == intval($this->settings->getSliderType() + 1));
                                                            else if (isEmpty($this->settings->getSliderType() + 1) && $i == 1);
                                                            else { ?>
                                                                <li class="mdc-list-item" data-value="<?php echo $i; ?>">
                                                                    <span trn='slidder-ride'>Slider</span><?php echo $i; ?>
                                                                </li>

                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label" trn="slider-type">Slider Type</span>
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
                                                <span class="mdc-floating-label" tr="footer">Footer Type</span>
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
                                                <span class="mdc-floating-label" trn="menu-display">Menu Display</span>
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
                                                <span class="mdc-floating-label" trn="info-display">Information Display</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <!-- <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input required type="hidden" value="<?php //echo !isEmpty($this->settings->getProductDisplayOrientation()) ? $this->settings->getProductDisplayOrientation() : '1'; 
                                                                                        ?>" name="product-display">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="1" aria-selected="true">
                                                            Grid</li>
                                                        <li class="mdc-list-item" data-value="2">
                                                            List
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Product Display</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div> -->
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                                <i class="material-icons mdc-text-field__icon">color_lens</i>
                                                <input class="mdc-text-field__input" id="color-picker" value="<?php echo !isEmpty($this->settings->getColors()) ? $this->settings->getColors() : ''; ?>" name="theme-color" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input pb-3" class="mdc-floating-label" trn="theme-color">Theme Color</label>
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
                    <button type="submit" name="save-website-design" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                </div>
            </form>

            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-4 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title" trn="web-info">Website Information</h6>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getPhoneNumber()) ? $this->settings->getPhoneNumber() : ''; ?>" name="phone" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="number">Phone Number</label>
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
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="email">Email</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-facebook"></i>
                                                <input class="mdc-text-field__input" value="<?php echo isset($this->settings->getSocials()->facebook) ? $this->settings->getSocials()->facebook : ''; ?>" name="fb" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="fb-url">Facebook Url</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-twitter"></i>
                                                <input class="mdc-text-field__input" value="<?php echo isset($this->settings->getSocials()->twitter) ? $this->settings->getSocials()->twitter : ''; ?>" name="twitter" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="tw-url">Twitter Url</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-instagram"></i>
                                                <input class="mdc-text-field__input" value="<?php echo isset($this->settings->getSocials()->instagram) ? $this->settings->getSocials()->instagram : ''; ?>" name="ig" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="ig-url">Instagram Url</label>
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
                    <button type="submit" name="website-info" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                </div>
            </form>

            <?php

            try {
                $printers = new PrintNodeApi($this->settings->getPrintNodeApi());
                $printers = $printers->getPrinters();
            } catch (Exception $e) {
                $printers = array();
            }
            $printers = $printers ?? [];
            ?>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-4 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title" trn="printer-info">Printer Information</h6>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-key"></i>
                                                <input class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getPrintNodeApi()) ? $this->settings->getPrintNodeApi() : ''; ?>" name="pnapi" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Print Node API</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input required type="hidden" value="<?php echo !isEmpty($this->settings->getDefaultPrinter()) ? $this->settings->getDefaultPrinter()  : ''; ?>" name="default-printer">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <?php foreach ($printers ?? [] as $printer) {
                                                            if ($printer->getId() == $this->settings->getDefaultPrinter()) { ?>
                                                                <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $printer->getId(); ?>" aria-selected="true">
                                                                    <?php echo $printer->getName(); ?> </li>
                                                            <?php   } ?>
                                                            <li class="mdc-list-item" data-value="<?php echo $printer->getId(); ?>">
                                                                <?php echo $printer->getName(); ?>
                                                            </li>
                                                        <?php
                                                        } ?>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Printers</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input required type="hidden" value="<?php echo !isEmpty($this->settings->getprintLanguage()) ? $this->settings->getprintLanguage() : ''; ?>" name="print-lang">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo !isEmpty($this->settings->getprintLanguage()) ? ($this->settings->getprintLanguage() == "jp") ? 'jp' : 'en' : 'en'; ?>" aria-selected="true">
                                                            <?php echo !isEmpty($this->settings->getprintLanguage()) ? ($this->settings->getprintLanguage() == "jp") ? '日本語' : "English" : 'English'; ?></li>
                                                        <li class="mdc-list-item" data-value="<?php echo !isEmpty($this->settings->getprintLanguage()) ? $this->settings->getprintLanguage() == "en" ? 'jp' : 'en' : 'jp'; ?>">
                                                            <?php echo !isEmpty($this->settings->getprintLanguage()) ? ($this->settings->getprintLanguage() == "en") ? '日本語' : "English" : '日本語'; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label" trn="print-lang">Print Language</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="printer-info" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                    <!-- <button class="btn btn-danger btn-sm tx-14 float-right">Test Print</button> -->
                </div>
            </form>



        </div>

        <div class="col-lg-4 col-md-12 col-sm-12 col-12  mt-4">
            <form method="POST" action="">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" trn="delivery-info">Delivery Information</h5>

                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                <i class="material-icons mdc-text-field__icon icofont-yen yen"></i>
                                <input type="number" class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getShippingFee()) ? $this->settings->getShippingFee() : ''; ?>" name="shipping-fee" id="text-field-hero-input">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="shipping-fee">Shipping Fee</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-3">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                <i class="material-icons mdc-text-field__icon icofont-yen yen"></i>
                                <input type="number" class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getFreeDeliveryPrice()) ? $this->settings->getFreeDeliveryPrice() : ''; ?>" name="free-shipping-price" id="text-field-hero-input">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label tx-14" trn="free-shipping-price">Free Shipping Price</label>
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
                                        <label for="text-field-hero-input" class="mdc-floating-label" trm="time-updated him">Delivery Time</label>
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
                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="time-ranges">Time Range</label>
                                    </div>
                                    <div class="mdc-notched-outline__trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-3">
                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                <i class="material-icons mdc-text-field__icon">location_city</i>
                                <input placeholder="" class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getAddressName()) ? $this->settings->getAddressName() : ''; ?>" name="address-name" id="text-field-hero-input">
                                <div class="mdc-notched-outline">
                                    <div class="mdc-notched-outline__leading"></div>
                                    <div class="mdc-notched-outline__notch">
                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="address-name">Address Name</label>
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
                                        <label for="text-field-hero-input" class="mdc-floating-label" address="store-name">Store Address</label>
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
                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="delivery-distance">Delivery Distance</label>
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
                    <button type="submit" name="delivery-options" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
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
                                        <label for="text-field-hero-input" class="mdc-floating-label" trn="min-order">Minimum Order</label>
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
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label" trn="display-rating">Display Ratings</label>
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
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label" trn="display-order-count">Display Order Count</label>
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
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label" trn="display-taxes">Display Tax</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="save-product-info" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
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
                    <button type="submit" name="upload-placeholder" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-5 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title" trn="payment">Payment</h6>
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
                                        <label for="checkbox-1" trn="cash">Cash</label>
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
                                        <label for="checkbox-1" trn="card">Card</label>
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
                    <button type="submit" name="payment-method" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                </div>
            </form>

            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-5 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title" trn="delivery-service">Delivery Service</h6>
                                <div class="template-demo">
                                    <div class="mdc-form-field">
                                        <div class="mdc-checkbox">
                                            <input type="checkbox" <?php echo !isEmpty($this->settings->getHomeDelivery()) ? 'checked' : ''; ?> name="home-delivery" class="mdc-checkbox__native-control" id="checkbox-1" />
                                            <div class="mdc-checkbox__background">
                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                </svg>
                                                <div class="mdc-checkbox__mixedmark"></div>
                                            </div>
                                        </div>
                                        <label for="checkbox-1" trn="delivery">Delivery</label>
                                    </div>
                                    <div class="mdc-form-field">
                                        <div class="mdc-checkbox">
                                            <input type="checkbox" <?php echo !isEmpty($this->settings->getTakeOut()) ? 'checked' : ''; ?> name="takeout" class="mdc-checkbox__native-control" id="checkbox-1" />
                                            <div class="mdc-checkbox__background">
                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                </svg>
                                                <div class="mdc-checkbox__mixedmark"></div>
                                            </div>
                                        </div>
                                        <label for="checkbox-1" trn="takeout">Takeout</label>
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
                                        <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label" trn="reservations">Reservation</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 save-changes">
                    <button type="submit" name="delivery-method" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                </div>
            </form>

            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-5 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title" trn="operational-time">Operation Time</h6>
                                <div class="template-demo">
                                    <div class="accordion" id="accordionTime">
                                        <?php  ?>
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
                                                            <span class="col-4 m-0 p-0 pt-2" trn="open">Open</span>:
                                                            <div class="input-group mb-3 m-0 p-0 col-7">
                                                                <input type="text" name="shop-open['<?php echo daysOfWeek()[$i]; ?>']" value="<?php echo !isEmpty($this->settings->getOperationalTime()[$i]) ? $this->settings->getOperationalTime()[$i]->open : ''; ?>" class="form-control m-0 p-0 timepicker" style="background-color: #eee;">
                                                                <div class="input-group-append d-sm-block d-none">
                                                                    <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row col-12 m-0 p-0 ">
                                                            <span class="col-4 m-0 p-0 pt-2" trn="break"> Break:</span>
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
                                                            <span class="col-4 m-0 p-0 pt-2" trn="close"> Close</span>:
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
                    <button type="submit" name="operational-time" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                </div>
            </form>
            <form method="POST" action="">
                <div class="mdc-layout-grid m-0 mt-5 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title" trn="subscription">Subscription</h6>
                                <div class="template-demo">
                                    <div class="row col-12 p-0 m-0 mb-1">
                                        <h6 class="col-6 p-0 m-0" trn="plan">Plan</h6>:
                                        <div class="col-6 p-0 m-0" trn="monthly">Monthly<?php ?></h6>:
                                        </div>
                                    </div>
                                    <div class="row col-12 p-0 m-0 mb-1">
                                        <h6 class="col-6 p-0 m-0" trn="branches">Branches</h6>:
                                        <div class="col-6 p-0 m-0"><?php echo count($this->branches); ?></h6>
                                        </div>
                                    </div>
                                    <div class="row col-12 p-0 m-0 mb-1">
                                        <h6 class="col-6 p-0 m-0" trn="due-date">Due Date</h6>:
                                        <div class="col-6 p-0 m-0"><?php echo date('j M,Y', intval($this->settings->getTImeCreated()) + (30 * 24 * 3600)) ?></h6>
                                        </div>
                                    </div>
                                    <div class="row col-12 p-0 m-0 mb-1">
                                        <h6 class="col-6 p-0 m-0" trn="amount">Amount</h6>:
                                        <div class="col-6 p-0 m-0"> <?php echo $this->settings->getCurrency() . number_format($this->settings->calculateSubscription(count($this->branches))); ?></h6>
                                        </div>
                                    </div><br>
                                    <h6><span trn="credit-card">Credit Card</span> <i class="icofont-credit-card"></i></h6>
                                    <?php foreach ($this->paymentDetails as $creditCard) { ?>
                                        <div class="alert alert-info p-1 pl-2" role="alert">
                                            <i class="icofont-ui-delete float-right option-right hover click" id="delete-card" data-id="<?php echo Encoding::encode(json_encode(array($this->settings->getSubscriptions(), $creditCard->getId()))); ?>"></i>
                                            <span class="tx-13"> <i class="icofont-<?php echo $creditCard->cardType ?> pr-2 pt-1" style="font-size:20px;"></i><?php echo $creditCard->cardName; ?></span>
                                            <div class="tx-13"><?php echo $creditCard->cardNumber; ?></div>
                                            <div class="tx-13"><?php echo $creditCard->expiryDate; ?></div>
                                        </div>
                                    <?php }
                                    if (empty($this->paymentDetails)) { ?>
                                        <span class="tx-13 btn-sm btn btn-success" data-toggle="modal" data-target="#addCardModal"><i class="icofont-ui-add txt-10 mr-2"></i><span trn="add-card">Add Card</span></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <a target="_blank" href="home" type="button" class="btn btn-danger mt-5 col-lg-8 col-sm-12">Preview My Hompage</a>
</main>