<?php

use danolez\lib\Security\Encoding\Encoding;

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
    <h3>Branches</h3>
    <p class="mb-4">You can change your staff positions, branch or add new staff here</p>
    <input id="selectedBranch" type="hidden" value="<?php echo ($this->admin->getRole() == 1) ? '' : $this->branches[0]->getId() ?>" />

    <?php if ($this->admin->getRole() == 1) { ?>
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
            <div class="mdc-card p-0">
                <div class="table-responsive">
                    <table class="table table-hoverable dashboard-table">
                        <thead>
                            <tr style="background: #EFF3F3;">
                                <th>Branch</th>
                                <th>Location</th>
                                <th>No of Staffs</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($this->branches); $i++) {
                                $branch = $this->branches[$i];
                            ?>

                                <tr class="branch" data-id="<?php echo $branch->getId(); ?>" data-times='<?php echo !isEmpty($branch->getOperationTime()) ? ($branch->getOperationTime()) : 'null'; ?>' data-details='<?php echo json_encode($branch->getDetails()); ?>'>
                                    <td class=" text-uppercase">
                                        <?php echo $branch->getName(); ?>
                                    </td>
                                    <td><?php echo smartWordWrap($branch->getLocation()); ?></td>
                                    <td><?php echo $branch->getStaffNo(); ?></td>
                                    <td>
                                        <input type="hidden" name="status" id="status" value="<?php echo $branch->getStatus(); ?>" />
                                        <button class="btn btn-sm btn-success dropdown-toggle" type="button" color="<?php echo $branch->getStatusName()["color"]; ?>" data="<?php echo $branch->getStatus(); ?>" trn="<?php echo $branch->getStatusName()['trn']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $branch->getStatusName()[0]; ?></button>
                                        <div class="dropdown-menu p-0">
                                            <a class="dropdown-item" color="<?php echo $branch->getStatusName($branch->getStatusName()["other"])['color']; ?>" data="<?php echo $branch->getStatusName()["other"]; ?>" trn="<?php echo $branch->getStatusName($branch->getStatusName()["other"])['trn']; ?>"><?php echo $branch->getStatusName($branch->getStatusName()["other"])[0]; ?></a>
                                        </div>
                                    </td>
                                    <td> <i class="icofont-ui-edit hover click "></i>
                                        <i class="icofont-ui-delete hover click ml-3 async" data-page="delete-branch" data-id='<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $branch->getId()))); ?>'></i> </td>
                                </tr>
                            <?php } ?>
                            <form method="post" class="php-form" action="">
                                <tr id="add-branch-form" style="display:<?php echo ($branchInfo) ? 'table-row' : 'none' ?>">
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
                                        <button type="submit" name="add-branch" class=" btn btn-light text-success font-weight-bold h5">save</button>
                                </tr>
                            </form>
                            <?php if (!is_null($dashboardController_error)) {
                                keepFormValues($_POST);
                            } ?>
                            <tr>
                                <td>
                                    <button id="add-branch" type="button" class="btn btn-sm btn-outline-danger ml-2"> <i class='bx bx-plus'></i> Add New Branch </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php } else { ?>
        　　　　<data id="branchData" hidden data-times='<?php echo !isEmpty($this->branches[0]->getOperationTime()) ? toDbJson($this->branches[0]->getOperationTime()) : 'null'; ?>' data-details='<?php echo json_encode($this->branches[0]->getDetails()); ?>'></data>
    <?php } ?>

    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mt-5" id="operationalTimes" style="display: <?php echo ($this->admin->getRole() == 1) ? 'none' : 'block' ?>;">
        <div class="mdc-card p-0">
            <div class="table-responsive">
                <form method="POST" action="">
                    <input name="branch-id" type="hidden" value="<?php echo ($this->admin->getRole() == 1) ? '' : $this->branches[0]->getId() ?>" />
                    <table class="table table-bordered dashboard-table time">
                        <tr>
                            <div class="pt-3 pl-3 pb-3 m-0 row col-12 d-flex m-0" style="min-width:673px;width: 100% !important;">
                                <span class="col-6">
                                    Opening Hours
                                </span>
                                <div class="col-6 text-right">
                                    <button type="submit" id="add-branch" name="save-branch-optime" class="btn btn-sm btn-outline-danger ml-2"> <i class="icofont-save"></i> Save </button>
                                </div>
                            </div>
                        </tr>
                        <thead>
                            <tr style="background: #EFF3F3;">
                                <th>Days</th>
                                <th>Opening</th>
                                <th>Break Period</th>
                                <th>Closing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count(daysOfWeek()); $i++) { ?>
                                <tr>
                                    <td>
                                        <?php echo daysOfWeek()[$i]; ?>
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
                                                <input type="text" name="shop-break-end['<?php echo daysOfWeek()[$i]; ?>']" class="form-control col-12 m-0 p-0 col-sm-5 timepicker" data-day="breaEnd[<?php echo  daysOfWeek()[$i]; ?>]" style="background-color: #eee;">
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

    <div class="col-lg-6 col-md-12 col-sm-12 col-12 m-0 p-0  mt-4" id="branchInfo" style="display: <?php echo ($this->admin->getRole() == 1) ? 'none' : 'block' ?>;">
        <form method="POST" action="">
            <input name="branch-id" type="hidden" value="<?php echo ($this->admin->getRole() == 1) ? '' : $this->branches[0]->getId() ?>" />
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Branch Information</h5>
                    <div class="mdc-layout-grid__cell stretch-card mb-3 mdc-layout-grid__cell--span-6-desktop">
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
                <button type="submit" name="branch-details" class="btn btn-danger btn-sm tx-14">Save changes</button>
            </div>
        </form>
    </div>
</main>