<?php

use danolez\lib\Res\PrintNodeApi;
use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\Administrator;

if (!is_null($dashboardController_error)) { ?>
    <script>
        webToast.Danger({
            status: dictionary['error-occured'][lang],
            message: dictionary<?php echo "['" . $dashboardController_error->{"trn"} . "']['" . $_COOKIE['lingo'] . "']"; ?>,
            delay: 10000
        });
    </script>
    <?php } else {
    if ($showDashboardController_result) { ?>
        <script>
            webToast.Success({
                status: dictionary['successful'][lang],
                message: dictionary['branch-updated'][lang],
                delay: 5000
            });
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
            location.reload();
        </script>
<?php }
} ?>
<main class="content-wrapper">
    <h3　trn="branches">Branches</h3>
    <p class="mb-4" trn="branches-instruct">You can change your staff positions, branch or add new staff here</p>
    <input id="selectedBranch" type="hidden" value="<?php echo ($this->admin->getRole() == 1) ? '' : $this->branches[0]->getId() ?>" />

    <?php if ($this->admin->getRole() == 1) { ?>
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
            <div class="mdc-card p-0">
                <div class="table-responsive">
                    <table class="table table-hoverable dashboard-table">
                        <thead>
                            <tr style="background: #EFF3F3;">
                                <th trn="branch">Branch</th>
                                <th trn="location">Location</th>
                                <th trn="no-of-staff">No of Staffs</th>
                                <th trn="status">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($this->branches); $i++) {
                                $branch = $this->branches[$i];
                            ?>

                                <tr class="branch" data-id="<?php echo $branch->getId(); ?>" data-times='<?php echo !isEmpty($branch->getOperationTime()) ? base64_encode(json_encode(fromDbJson($branch->getOperationTime()))) : 'null'; ?>' data-details='<?php echo base64_encode(json_encode($branch->getDetails())); ?>'>
                                    <td class=" text-uppercase">
                                        <?php echo $branch->getName(); ?>
                                    </td>
                                    <td><?php echo smartWordWrap($branch->getLocation()); ?></td>
                                    <td><?php echo $branch->getStaffNo(); ?></td>
                                    <td>
                                        <input type="hidden" name="status" id="status" value="<?php echo $branch->getStatus(); ?>" />
                                        <button class="btn btn-sm btn-success dropdown-toggle" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUserName(), $branch->getId()))); ?>" data-async="branch-status" type="button" color="<?php echo $branch->getStatusName()["color"]; ?>" data="<?php echo $branch->getStatus(); ?>" trn="<?php echo $branch->getStatusName()['trn']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $branch->getStatusName()[0]; ?></button>
                                        <div class="dropdown-menu p-0">
                                            <a class="dropdown-item" color="<?php echo $branch->getStatusName($branch->getStatusName()["other"])['color']; ?>" data="<?php echo $branch->getStatusName()["other"]; ?>" trn="<?php echo $branch->getStatusName($branch->getStatusName()["other"])['trn']; ?>"><?php echo $branch->getStatusName($branch->getStatusName()["other"])[0]; ?></a>
                                        </div>
                                    </td>
                                    <td> <i class="icofont-ui-edit hover click "></i>
                                        <i class="icofont-ui-delete hover click ml-3 async" data-page="delete-branch" data-id='<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $branch->getId()))); ?>'></i>
                                    </td>
                                </tr>
                            <?php } ?>
                            <form method="post" class="php-form" action="">
                                <tr id="add-branch-form" style="display: none">
                                    <td>
                                        <input type="text" class="form-control" required name="name" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" required name="location" />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control col-6" required name="staff-no" />
                                    </td>
                                    <td>
                                        <input type="hidden" name="status" id="status" value="1" />
                                        <button class="btn btn-success dropdown-toggle" data-async="branch-status" trn="opened" data="1" color="#28A745" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OPENED</button>
                                        <div class="dropdown-menu p-0">
                                            <a class="dropdown-item" trn="closed" data="2" color="#000000">CLOSED</a>
                                        </div>
                                    </td>
                                    <td class="pr-3">
                                        <button type="submit" name="add-branch" class=" btn btn-light text-success font-weight-bold h5" trn="save">save</button>
                                </tr>
                            </form>
                            <?php if (!is_null($dashboardController_error)) {
                                keepFormValues($_POST);
                            } ?>
                            <tr>
                                <td>
                                    <button id="add-branch" type="button" class="btn btn-sm btn-outline-danger ml-2"> <i class='bx bx-plus'></i> <span trn="add-new-branch">Add New Branch</span> </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php } else {  ?>
        　　　　<data id="branchData" hidden data-times='<?php echo !isEmpty($this->branches[0]->getOperationTime()) ? base64_encode(json_encode(fromDbJson($this->branches[0]->getOperationTime()))) : 'null'; ?>' data-details='<?php echo base64_encode(json_encode($this->branches[0]->getDetails())); ?>'></data>
    <?php } ?>

    <div style="display: <?php echo (intval($this->admin->getRole()) == 1) ? 'none' : 'block' ?>;" id="branchInfo">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mt-5">
            <div class="mdc-card p-0">
                <div class="table-responsive">
                    <form method="POST" action="">
                        <input name="branch-id" type="hidden" value="<?php echo ($this->admin->getRole() == 1) ? '' : $this->branches[0]->getId() ?>" />
                        <table class="table table-bordered dashboard-table time">
                            <tr>
                                <div class="pt-3 pl-3 pb-3 m-0 row col-12 d-flex m-0" style="min-width:673px;width: 100% !important;">
                                    <span class="col-6">
                                        <span trn="opening-hours">Opening Hours</span>
                                    </span>
                                    <div class="col-6 text-right">
                                        <button type="submit" id="add-branch" name="save-branch-optime" class="btn btn-sm btn-outline-danger ml-2"> <i class="icofont-save"></i> Save </button>
                                    </div>
                                </div>
                            </tr>
                            <thead>
                                <tr style="background: #EFF3F3;">
                                    <th trn="days">Days</th>
                                    <th trn="opening">Opening</th>
                                    <th trn="break-period">Break Period</th>
                                    <th trn="closing">Closing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count(daysOfWeek()); $i++) { ?>
                                    <tr>
                                        <td>
                                            <span trn="<?php echo strtolower(daysOfWeek()[$i]); ?>"> <?php echo daysOfWeek()[$i]; ?></span>
                                        </td>
                                        <td>
                                            <div class="input-group mb-3" style="min-width:170px !important;">
                                                <input type="text" name="shop-open['<?php echo daysOfWeek()[$i]; ?>']" data-day="open[<?php echo  daysOfWeek()[$i]; ?>]" class="form-control col-12 m-0 p-0 col-sm-5 timepicker" style="background-color: #eee;">
                                                <div class="input-group-append">
                                                    <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row d-flex col-12 m-0 p-0 justify-content-center">
                                                <div class="input-group mb-3 col-6 justify-content-end" style="min-width:170px !important; ">
                                                    <input type="text" name="shop-break-start['<?php echo daysOfWeek()[$i]; ?>']" class="form-control col-12 m-0 p-0 col-sm-5 timepicker " data-day="breakStart[<?php echo  daysOfWeek()[$i]; ?>]" style="background-color: #eee;">
                                                    <div class="input-group-append">
                                                        <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3 col-6" style="min-width:170px !important;">
                                                    <h2 class="pr-3">~</h2>
                                                    <input type="text" name="shop-break-end['<?php echo daysOfWeek()[$i]; ?>']" class="form-control col-12 m-0 p-0 col-sm-5 timepicker" data-day="breakEnd[<?php echo  daysOfWeek()[$i]; ?>]" style="background-color: #eee;">
                                                    <div class="input-group-append">
                                                        <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group mb-3 justify-content-center" style="min-width:170px !important;">
                                                <input type="text" name="shop-close['<?php echo daysOfWeek()[$i]; ?>']" class="form-control col-12 m-0 p-0 col-sm-5 timepicker" data-day="close[<?php echo  daysOfWeek()[$i]; ?>]" style="background-color: #eee;">
                                                <div class="input-group-append">
                                                    <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

        <div class="col row m-0 p-0  mt-4">
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 m-0 pr-2 p-0">
                <form method="POST" action="">
                    <input name="branch-id" type="hidden" value="<?php echo ($this->admin->getRole() == 1) ? '' : $this->branches[0]->getId() ?>" />
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3" trn="branch-info">Branch Information</h5>
                            <div class="mdc-layout-grid__cell stretch-card mb-3 mdc-layout-grid__cell--span-6-desktop">
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
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                    <i class="material-icons mdc-text-field__icon">access_time</i>
                                    <input type="number" class="mdc-text-field__input" value="<?php echo !isEmpty($this->settings->getDeliveryTime()) ? $this->settings->getDeliveryTime() : ''; ?>" name="delivery-time" id="text-field-hero-input" placeholder="In minutes">
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label for="text-field-hero-input" class="mdc-floating-label" trn="delivery-time">Delivery Time</label>
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
                                            <label for="text-field-hero-input" class="mdc-floating-label" trn="time-range">Time Range</label>
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
                                            <label for="text-field-hero-input" class="mdc-floating-label" trn="store-address">Store Address</label>
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
                                            <label for="text-field-hero-input" class="mdc-floating-label" trn="delivery-area">Delivery Area</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->admin->getRole() == 2) { ?>
                        <div class="card-footer p-2 save-changes">
                            <button type="submit" name="branch-details" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                        </div>
                    <?php } ?>
                </form>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-12 m-0 pl-2 p-0">
                <?php
                try {
                    if (!empty($this->branches)) {
                        $printers = new PrintNodeApi($this->branches[0]->getPrintNodeApi(), $this->branches[0]->getDefaultPrinter());
                        $printers = $printers->getPrinters();
                    } else {

                        $printers = array();
                    }
                } catch (Exception $e) {
                    $printers = array();
                }
                // var_dump((array_values($printers))) 
                ?>
                <form method="POST" action="">
                    <input name="branch-id" type="hidden" value="<?php echo ($this->admin->getRole() == 1) ? '' : $this->branches[0]->getId() ?>" />
                    <div class="mdc-layout-grid m-0 p-0">
                        <div class="mdc-layout-grid__inner">
                            <div class="mdc-layout-grid__cell--span-12">
                                <div class="mdc-card">
                                    <h6 class="card-title" trn="printer-info">Printer Information</h6>
                                    <div class="template-demo">
                                        <div class="mdc-layout-grid__inner">
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon icofont-key"></i>
                                                    <input class="mdc-text-field__input" value="<?php echo  $this->admin->getRole() == Administrator::OWNER ? $this->settings->getPrintNodeApi()  : $this->branches[0]->getPrintNodeApi() ?? $this->settings->getPrintNodeApi();  ?>" name="pnapi" id="text-field-hero-input">
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
                                                    <input required type="hidden" value="<?php echo $this->admin->getRole() == Administrator::OWNER ? $this->settings->getDefaultPrinter()  : $this->branches[0]->getDefaultPrinter() ?? $this->settings->getDefaultPrinter(); ?>" name="default-printer">
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
                                                    <span class="mdc-floating-label" trn="printers">Printers</span>
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
                    <?php if ($this->admin->getRole() == 2) { ?>
                        <div class="card-footer p-2 save-changes">
                            <button type="submit" name="branch-printer-info" class="btn btn-danger btn-sm tx-14" trn="save-changes">Save changes</button>
                            <!-- <button class="btn btn-danger btn-sm tx-14 float-right">Test Print</button> -->
                        </div>
                    <?php } ?>
                </form>
            </div>

        </div>
    </div>
</main>