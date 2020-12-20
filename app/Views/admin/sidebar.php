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
                        <a class="mdc-drawer-link" href="<?php echo  intval($this->admin->getRole()) == 1 ? 'dashboard' : 'branch-dashboard'; ?>">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon mdi mdi-view-dashboard" aria-hidden="true"></i>
                            Dashboard
                        </a>
                    </div>
                <?php } ?>
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link" href="orders">
                        <!-- <a class="mdc-expansion-panel-link" href="branches" data-toggle="expansionPanel" data-target="ui-sub-menu"> -->
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon bx bxs-dish" aria-hidden="true"></i>
                        Orders
                        <i class="mdc-drawer-arrow material-icons" style="visibility: hidden;">chevron_right</i>
                        <span class="badge badge-info">9</span>
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
                            Products
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="<?php echo  intval($this->admin->getRole()) == 1 ? 'branches' : 'branch-setting'; ?>">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon mdi mdi-source-branch" aria-hidden="true"></i>
                            <?php echo  intval($this->admin->getRole()) == 1 ? 'Branches' : 'Settings'; ?>
                        </a>
                    </div>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="staffs">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-people" aria-hidden="true"></i>
                            Staffs
                        </a>
                    </div>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="users">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-users" aria-hidden="true"></i>
                            Customers
                        </a>
                    </div>
                <?php }
                if (intval($this->admin->getRole()) == 1) { ?>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="promotions">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-gift" aria-hidden="true"></i>
                            Promotions
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="settings">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon icofont-settings" aria-hidden="true"></i>
                            Settings
                        </a>
                    </div>
                <?php } ?>
                <div class="mdc-card premium-card mt-5">
                    <div class="d-flex align-items-center">
                        <div class="mdc-card icon-card box-shadow-0">
                            <i class="mdi mdi-shield-outline"></i>
                        </div>
                        <div>
                            <p class="mt-0 mb-1 ml-2 font-weight-bold tx-12"><?php echo $this->admin->getName(); ?></p>
                            <p class="mt-0 mb-0 ml-2 tx-10" trn="<?php echo $this->admin->getRoleName()["trn"]; ?>"><?php echo $this->admin->getRoleName()[0]; ?></p>
                        </div>
                    </div>
                    <p class="tx-10 mt-3 mb-1">Info about Daniel...................</p>
                    <div class="text-center">
                        <a href="admin-logout ">
                            <span class="mdc-button mdc-button--raised mdc-button--white ">Logout</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</aside>