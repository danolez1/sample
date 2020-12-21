<?php

use danolez\lib\Security\Encoding\Encoding;

if (!is_null($dashboardController_error)) { ?>
    <script>
        webToast.Danger({
            status: "<?php echo ($_COOKIE['lingo'] == 'jp') ?  'エラーが発生しました' :  'Error Occured'; ?>",
            message: dictionary<?php echo "['" . $dashboardController_error->{"trn"} . "']." . $_COOKIE['lingo']; ?>,
            delay: 10000
        });
    </script>
    <?php } else {
    if ($showDashboardController_result) { ?>
        <script>
            webToast.Success({
                status: "<?php echo ($_COOKIE['lingo'] == 'jp') ?  '成功' :  'Successful'; ?>",
                message: "<?php echo ($_COOKIE['lingo'] == 'jp') ?  '枝店舗を追加されました' :  'Branch Added'; ?>",
                delay: 5000
            });
        </script>
<?php }
} ?>
<main class="content-wrapper">
    <h3>Branches</h3>
    <p class="mb-4">You can change your staff positions, branch or add new staff here</p>
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
                        <!-- 
                            
    private $shippingFee;
    private $deliveryTime;
    private $deliveryTimeRange;
    private $deliveryAreas;
    private $deliveryDistance;
    // PAYMENT
    private $paymentMethods;
    private $operationalTime; 
                         -->
                        <?php for ($i = 0; $i < count($this->branches); $i++) {
                            $branch = $this->branches[$i];
                        ?>
                            <tr>
                                <td class="text-uppercase">
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
                                    <i class="icofont-ui-delete hover click ml-3 async" data-page="delete-branch" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $branch->getId()))); ?>"></i> </td>
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

    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mt-5">
        <div class="mdc-card p-0">
            <div class="table-responsive">
                <table class="table table-bordered dashboard-table">
                    <tr>
                        <div class="pt-3 pl-3 pb-3">Opening Hours</div>
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
                        <tr>
                            <td>
                                Monday
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control col-5 col-sm-10 timepicker" style="background-color: #eee;">
                                    <div class="input-group-append">
                                        <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row d-flex col-12">
                                    <div class="input-group mb-3 col-lg-5 col-md-5 col-sm-10 col-12">
                                        <input type="text" class="form-control col-10 timepicker" style="background-color: #eee;">
                                        <div class="input-group-append">
                                            <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                        </div>
                                    </div>
                                    <h2 class="mt-1">~</h2>
                                    <div class="input-group mb-3 col-lg-5 col-md-5 col-sm-10 col-12">
                                        <input type="text" class="form-control col-10 timepicker" style="background-color: #eee;">
                                        <div class="input-group-append">
                                            <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-info ml-2"> <i class='bx bx-plus'></i> Add New Break</button>
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control col-lg-5 col-md-5 col-sm-10 col-12  timepicker" style="background-color: #eee;">
                                    <div class="input-group-append">
                                        <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet mt-5 col-lg-8 col-md-12">
        <div class="mdc-card p-0">
            <div class="table-responsive">
                <table class="table dashboard-table">
                    <thead>
                        <tr style="background: #EFF3F3;">
                            <th>General Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="row d-flex col-12">
                                    <h6 class="mt-1"> Minimum order amount</h6>
                                    <div class="input-group mb-3 col-5">
                                        <div class="input-group-prepend">
                                            <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="icofont-yen"></i></span>
                                        </div>
                                        <input type="text" class="form-control col-10" style="background-color: #eee;">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row d-flex col-12">
                                    <h6 class="mt-1"> Average delivery time</h6>
                                    <div class="input-group mb-3 col-7">
                                        <input type="number" class="form-control col-8 " style="background-color: #eee;">
                                        <div class="input-group-append" style="background-color: #12cad6;">
                                            <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text">Min</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="background-color: #12cad6;color:#EFF3F3" class="input-group-text"><i class="ri-timer-line"></i></span>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>