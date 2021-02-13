<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
    <div class="mdc-drawer__header">
        <a href="admin" class="brand-logo">
            <img src="assets/images/home/logo_red.svg" alt="logo">
        </a>
    </div>
    <div class="mdc-drawer__content">
        <div class="mdc-list-group">
            <nav class="mdc-list mdc-drawer-menu">

                <?php if (intval($this->admin->getRole()) == 1 || intval($this->admin->getRole()) == 2) { ?>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="dashboard">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon mdi mdi-view-dashboard" aria-hidden="true"></i>
                            <span trn="dashboard">Dashboard</span>
                        </a>
                    </div>
                <?php } ?>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link" href="orders">
                        <!-- <a class="mdc-expansion-panel-link" href="branches" data-toggle="expansionPanel" data-target="ui-sub-menu"> -->
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon bx bxs-dish" aria-hidden="true"></i>
                        <span trn="orders"> Orders</span>
                        <i class="mdc-drawer-arrow material-icons" style="visibility: hidden;">chevron_right</i>
                        <span class="badge badge-info"><?php echo $pendingOrder; ?></span>
                    </a>
                    <!-- <div class="mdc-expansion-panel" id="ui-sub-menu">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="">
                                    Buttons
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="">
                                    Typography
                                </a>
                            </div>
                        </nav>
                    </div> -->
                </div>
                <?php if (intval($this->admin->getRole()) == 1 || intval($this->admin->getRole()) == 2) { ?>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="products">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-fast-food" aria-hidden="true"></i>
                            <span trn="products">Products</span>
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="<?php echo  intval($this->admin->getRole()) == 1 ? 'branches' : 'branch-setting'; ?>">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon mdi mdi-source-branch" aria-hidden="true"></i>
                            <?php echo  intval($this->admin->getRole()) == 1 ? '<span trn="branches">Branches</span>' : '<span trn="settings">Settings</span>'; ?>
                        </a>
                    </div>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="staffs">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-people" aria-hidden="true"></i>
                            <span trn="staffs">Staffs</span>
                        </a>
                    </div>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="users">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-users" aria-hidden="true"></i>
                            <span trn="customers"> Customers</span>
                        </a>
                    </div>
                <?php }
                if (intval($this->admin->getRole()) == 1) { ?>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="promotions">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-gift" aria-hidden="true"></i>
                            <span trn="promotions">Promotions</span>
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="settings">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-settings" aria-hidden="true"></i>
                            <span trn="settings">Settings</span>
                        </a>
                    </div>
                <?php } ?>
            </nav>
        </div>
        <div class="profile-actions">
            <a href="javascript:;" class="lang" lang="en">English</a>
            <span class="divider mt-1"></span>
            <a href="javascript:;" class="lang" lang="jp">日本語</a>
        </div>
        <div class="mdc-card premium-card mt-5">
            <div class="d-flex align-items-center">
                <div class="mdc-card icon-card box-shadow-0">
                    <i class="mdi mdi-shield-outline"></i>
                </div>
                <div>
                    <p class="mt-0 mb-1 ml-2 font-weight-bold tx-12"><?php echo $this->admin->getName(); ?></p>
                    <p class="mt-0 mb-0 ml-2 tx-10" trn="<?php echo $this->admin->getRoleName()[0]["trn"]; ?>"><?php echo $this->admin->getRoleName()[0][0]; ?></p>
                </div>
            </div>
            <p class="tx-10 mt-3 mb-1"><span trn="branch">Branch</span>: <br><span trn="info">Info</span> : </p>
            <div class="text-center mt-2">
                <a href="admin-logout">
                    <span class="mdc-button mdc-button--raised mdc-button--white p-1 col-6" trn="logout">Logout</span>
                </a>
            </div>
        </div>

        <div class="profile-actions p-0 m-0 text-center mb-5" style="width: 100%;">
            <a style="width: 100%;" href="https://demae-system.com">©CLB Solutions</a>
        </div>
    </div>
</aside>