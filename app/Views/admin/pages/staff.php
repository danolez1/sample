<?php

use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\Branch;

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
                message: dictionary['staff-added'][lang],
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
    <h3>Staffs</h3>
    <p class="mb-4">You can change your staff positions, branch or add new staff here</p>
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-0">
            <div class="table-responsive">
                <table class="table  table-hoverable  dashboard-table theme-form">
                    <?php if ($this->admin->getRole() == 1) { ?>
                        <!-- <tr>
                            <div class="pt-3 pl-3 pb-3 font-weight-bold text-danger">TOKYO BRANCH</div>
                        </tr> -->
                    <?php } ?>
                    <thead>
                        <tr style="background: #EFF3F3;">
                            <th>Name</th>
                            <th>Email</th>
                            <?php if ($this->admin->getRole() == 1) { ?>
                                <th>Branch</th>
                            <?php } ?>
                            <th>Level</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($this->staff); $i++) {
                            $staff = $this->staff[$i];
                        ?>
                            <tr>
                                <td>
                                    <?php echo $staff->getName(); ?>
                                </td>
                                <td> <?php echo $staff->getEmail(); ?></td>
                                <?php if ($this->admin->getRole() == 1) { ?>
                                    <td class="text-uppercase"> <?php $branch = new Branch();
                                                                echo  $branch->get(null, $staff->getBranchId())[0]->getName(); ?> </td>
                                <?php } ?>
                                <td>
                                    <input type="hidden" name="role" value="5" />
                                    <button class="btn btn-success dropdown-toggle" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUserName(), $staff->getId()))); ?>" data-async="staff-level" trn="<?php echo $staff->getRoleName()[0]['trn'] ?>" data="<?php echo $staff->getRoleName()[0]['data'] ?>" color="<?php echo $staff->getRoleName()[0]['color'] ?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $staff->getRoleName()[0][0] ?></button>
                                    <?php if ($this->admin->getRole() == 1) { ?>
                                        <div class="dropdown-menu p-0">
                                            <a type="button" class="dropdown-item" trn="<?php echo $staff->getRoleName()[1]['trn'] ?>" data="<?php echo $staff->getRoleName()[1]['data'] ?>" color="<?php echo $staff->getRoleName()[1]['color'] ?>"><?php echo $staff->getRoleName()[0][0] ?></a>
                                            <a type="button" class="dropdown-item" trn="<?php echo $staff->getRoleName()[2]['trn'] ?>" data="<?php echo $staff->getRoleName()[2]['data'] ?>" color="<?php echo $staff->getRoleName()[2]['color'] ?>"><?php echo $staff->getRoleName()[0][0] ?></a>
                                            <a type="button" class="dropdown-item" trn="<?php echo $staff->getRoleName()[3]['trn'] ?>" data="<?php echo $staff->getRoleName()[3]['data'] ?>" color="<?php echo $staff->getRoleName()[3]['color'] ?>"><?php echo $staff->getRoleName()[0][0] ?></a>
                                            <a type="button" class="dropdown-item" trn="<?php echo $staff->getRoleName()[4]['trn'] ?>" data="<?php echo $staff->getRoleName()[4]['data'] ?>" color="<?php echo $staff->getRoleName()[4]['color'] ?>"><?php echo $staff->getRoleName()[0][0] ?></a>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td class="pr-3"> <i type="button" class="icofont-ui-edit hover click"></i>
                                    <i class="icofont-ui-delete hover click ml-3 async" data-page="delete-staff" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $staff->getId()))); ?>"></i>
                                </td>
                            </tr>
                        <?php } ?>
                        <form method="post" class="php-form" action="">
                            <tr class="php-form" id="add-staff-form" style="display:<?php echo ($staffInfo) ? 'table-row' : 'none' ?>">
                                <td>
                                    <input type="text" class="form-control" required name="name" />
                                </td>
                                <td>
                                    <input type="text" class="form-control" required name="email" />
                                </td>
                                <?php if ($this->admin->getRole() == 1) { ?>
                                    <td>
                                        <input type="hidden" name="branch" value="<?php echo $this->branches[0]->getId(); ?>" />
                                        <button class="btn btn-light dropdown-toggle" type="button" data="<?php echo $this->branches[0]->getId(); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->branches[0]->getName(); ?></button>
                                        <div class="dropdown-menu p-0">
                                            <?php for ($i = 1; $i < count($this->branches); $i++) {
                                                $branch = $this->branches[$i];
                                            ?>
                                                <a type="button" class="dropdown-item" data="<?php echo $branch->getId(); ?>">
                                                    <?php echo $branch->getName(); ?>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                <?php } else { ?>
                                    <input type="hidden" name="branch" value="<?php echo $this->branches[0]->getId(); ?>" />
                                <?php } ?>
                                <td>
                                    <input type="hidden" name="role" value="5" />
                                    <button class="btn btn-success dropdown-toggle" data-async="staff-level" trn="staff" data="5" color="#28A745" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staff</button>
                                    <div class="dropdown-menu p-0">
                                        <?php if ($this->admin->getRole() == 1) { ?>
                                            <a type="button" class="dropdown-item" trn="ceo" data="1" color="#BEC5FF">CEO</a>
                                            <a type="button" class="dropdown-item" trn="manager" data="2" color="#AEFFAC">Manager</a>
                                        <?php } ?>
                                        <a type="button" class="dropdown-item" trn="cashier" data="3" color="#FFCEA0">Cashier</a>
                                        <a type="button" class="dropdown-item" trn="driver" data="4" color="#FEB9B9">Driver</a>
                                    </div>
                                </td>
                                <td class="pr-3">
                                    <button type="submit" name="add-staff" class=" btn btn-light text-success font-weight-bold h5">save</button>
                            </tr>
                        </form>
                        <?php if (!is_null($dashboardController_error)) {
                            keepFormValues($_POST);
                        } ?>
                        <tr>
                            <td>
                                <button id="add-staff" type="button" class="btn btn-sm btn-outline-danger ml-2"> <i class='bx bx-plus'></i> Add New Staff </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>