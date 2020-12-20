<main class="content-wrapper">
    <h3>Settings</h3>
    <div class="row col-12 mt-3">
        <div class="col-lg-8 col-md-12 col-sm-12 col-12">

            <h4 class="mt-5">Banner Image</h4>
            <div class="card mt-2 col-12 p-0 m-0 upload-image" style="background-color:#E0E0E0;border:#E0E0E0;" type="button">
                <label for="browse">
                    <input type="hidden" value="" name="banner" />
                    <img id="browse-preview" class="img img-fluid" src="assets/images/dashboard/hero.svg" />
                </label>
            </div>
            <input type="file" id="browse" name="browse" accept="image/*" style="display: none">
            <div class="card card-footer justify-content-right p-2" style="background-color:#FFF; margin-top:-2px; ">
                <button type="submit" name="settings-upload-banner" class="btn btn-sm tx-14 btn-danger col-4 ">Upload</button>
            </div>


            <div class="mdc-layout-grid m-0 mt-4 p-0">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <h6 class="card-title">Header Information</h6>
                            <div class="template-demo">
                                <div class="mdc-layout-grid__inner">
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field">
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-line-ripple"></div>
                                            <label for="text-field-hero-input" class="mdc-floating-label">Title</label>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field">
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-line-ripple"></div>
                                            <label for="text-field-hero-input" class="mdc-floating-label">Store Name</label>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                        <div class="mdc-text-field">
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-line-ripple"></div>
                                            <label for="text-field-hero-input" class="mdc-floating-label">Banner Title</label>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                        <div class="mdc-text-field">
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-line-ripple"></div>
                                            <label for="text-field-hero-input" class="mdc-floating-label">Banner Content</label>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <label class="mr-3 ml-2" style="margin-top: .18em;">Use name as Logo</label>
                                        <div class="mdc-switch mt-2" data-mdc-auto-init="MDCSwitch">
                                            <div class="mdc-switch__track"></div>
                                            <div class="mdc-switch__thumb-underlay">
                                                <div class="mdc-switch__thumb">
                                                    <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch" checked>
                                                </div>
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
                <button type="submit" name="settings-banner-title" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>

            <h5 class="mt-5">Logo</h5>
            <div class="card mt-4 col-lg-6 col-md-6 col-12 p-0 setting-card" style="background-color:#E0E0E0;border:#E0E0E0;">
                <label for="browse1">
                    <input type="hidden" value="" name="logo" />
                    <img id="browse-preview1" class="img img-fluid" src="assets/images/dashboard/hero.svg" />
                </label>
            </div>
            <input type="file" id="browse1" name="browse1" accept="image/*" style="display: none">
            <div class="card card-footer col-lg-6 col-md-6 col-12 p-2" style="background-color:#FFF;margin-top:-2px;">
                <button type="button" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>

            <div class="mdc-layout-grid m-0 mt-4 p-0">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <h6 class="card-title">Website Design</h6>
                            <div class="template-demo">
                                <div class="mdc-layout-grid__inner">
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                            <input required type="hidden" name="option-category">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list" style="width: 15em;">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="0" aria-selected="true">
                                                        Slider 1</li>
                                                    <li class="mdc-list-item" data-value="1">
                                                        Slider 2
                                                    </li>
                                                    <li class="mdc-list-item" data-value="2">
                                                        Slider 3
                                                    </li>
                                                    <li class="mdc-list-item" data-value="3">
                                                        Slider 4
                                                    </li>
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Slider Type</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                            <input required type="hidden" name="option-category">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list" style="width: 15em;">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="0" aria-selected="true">
                                                        Footer 1</li>
                                                    <li class="mdc-list-item" data-value="1">
                                                        Footer 2
                                                    </li>
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Footer Type</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                            <input required type="hidden" name="option-category">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list" style="width: 15em;">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="0" aria-selected="true">
                                                        Horizontal</li>
                                                    <li class="mdc-list-item" data-value="1">
                                                        Verical
                                                    </li>
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Menu Display</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                            <input required type="hidden" name="option-category">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list" style="width: 15em;">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="0" aria-selected="true">
                                                        Horizontal</li>
                                                    <li class="mdc-list-item" data-value="1">
                                                        Verical
                                                    </li>
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Information Display</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                            <input required type="hidden" name="option-category">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list" style="width: 15em;">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="0" aria-selected="true">
                                                        Grid</li>
                                                    <li class="mdc-list-item" data-value="1">
                                                        List
                                                    </li>
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Product Display</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                            <i class="material-icons mdc-text-field__icon">color_lens</i>
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="text-field-hero-input" class="mdc-floating-label">Theme Color</label>
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
                <button type="submit" name="settings-banner-title" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>


            <div class="mdc-layout-grid m-0 mt-4 p-0">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <h6 class="card-title">Website Information</h6>
                            <div class="template-demo">
                                <div class="mdc-layout-grid__inner">
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
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
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="text-field-hero-input" class="mdc-floating-label">Email</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="text-field-hero-input" class="mdc-floating-label">Banner Content</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                            <i class="material-icons mdc-text-field__icon icofont-facebook"></i>
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
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
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
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
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="text-field-hero-input" class="mdc-floating-label">Instagram Url</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                            <i class="material-icons mdc-text-field__icon icofont-web"></i>
                                            <input class="mdc-text-field__input" id="text-field-hero-input">
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="text-field-hero-input" class="mdc-floating-label">Website Url</label>
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
                <button type="submit" name="settings-banner-title" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>



        </div>


        <div class="col-lg-4 col-md-12 col-sm-12 col-12  mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Delivery Information</h5>

                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                            <i class="material-icons mdc-text-field__icon icofont-yen yen"></i>
                            <input class="mdc-text-field__input" id="text-field-hero-input">
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
                            <input class="mdc-text-field__input" id="text-field-hero-input">
                            <div class="mdc-notched-outline">
                                <div class="mdc-notched-outline__leading"></div>
                                <div class="mdc-notched-outline__notch">
                                    <label for="text-field-hero-input" class="mdc-floating-label">Average Delivery Time</label>
                                </div>
                                <div class="mdc-notched-outline__trailing"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mt-3">
                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                            <i class="material-icons mdc-text-field__icon">timer</i>
                            <input class="mdc-text-field__input" id="text-field-hero-input">
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
                            <textarea class="mdc-text-field__input" id="text-field-hero-input"></textarea>
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
                            <input class="mdc-text-field__input" id="text-field-hero-input">
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
                            <textarea class="mdc-text-field__input" id="text-field-hero-input"></textarea>
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
                <button type="submit" name="settings-banner-title" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>

            <div class="card mt-5">
                <div class="card-body">
                    <h5 class="card-title">Product Information</h5>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                            <i class="material-icons mdc-text-field__icon icofont-yen yen"></i>
                            <input class="mdc-text-field__input" id="text-field-hero-input">
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
                            <input required type="hidden" name="option-category">
                            <i class="mdc-select__dropdown-icon"></i>
                            <div class="mdc-select__selected-text"></div>
                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                <ul class="mdc-list" style="width: 15em;">
                                    <li class="mdc-list-item mdc-list-item--selected" data-value="yen" aria-selected="true">
                                        JPY<i class="material-icons mdc-text-field__icon icofont-yen yen"></i> </li>
                                </ul>
                            </div>
                            <span class="mdc-floating-label">Currency</span>
                            <div class="mdc-line-ripple"></div>
                        </div>
                    </div>
                    <div class="mdc-form-field">
                        <div class="mdc-checkbox mdc-checkbox--info">
                            <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" checked />
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
                            <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" checked />
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
                            <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" checked />
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
                <button type="submit" name="settings-banner-title" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>


            <div class="mdc-layout-grid m-0 mt-5 p-0">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <h6 class="card-title">Payment</h6>
                            <div class="template-demo">
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
                                    <label for="checkbox-1">Cash</label>
                                </div>
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
                                    <label for="checkbox-1">Card</label>
                                </div>
                                <div class="mdc-form-field">
                                    <div class="mdc-checkbox mdc-checkbox--disabled">
                                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" disabled />
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
                <button type="submit" name="settings-banner-title" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>

            <div class="mdc-layout-grid m-0 mt-5 p-0">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <h6 class="card-title">Operation Time</h6>
                            <div class="template-demo">



                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-2 save-changes">
                <button type="submit" name="settings-banner-title" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>
        </div>
        <button type="button" class="btn btn-danger mt-5 col-12">Preview My Hompage</button>
</main>