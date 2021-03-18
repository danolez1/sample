<?php

?>
<main class="content-wrapper">
    <h3>Orders</h3>
    <p class="mb-4">You can manage your orders here</p>

    <div class="row col-12 btn-toolbar m-0 p-0" role="toolbar">
        <div class="btn-group col-12 me-2" role="group" style="margin-left: .5em;padding-left:0;">
            <button type="button" id="pending-order" class="btn btn-lg btn-outline-danger col-6 active">
                Pending orders <span class="badge badge-info ml-2"><?php echo $pendingOrder; ?></span>
            </button>
            <button type="button" id="completed-order" class="btn btn-lg btn-outline-danger col-6">Completed orders <span class="badge badge-info ml-2"><?php echo $completedOrder; ?></span></button>
        </div>
    </div>

    <div class="card ml-2 mr-2">
        <div class="pt-3 pl-2 pb-3 row d-flex col-12 justify-content-between m-0 p-0" style="background-color: #fff;">
            <div class="col-6">
                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon search-text-field d-none d-md-flex ml-3 ">
                    <i class="material-icons mdc-text-field__icon">search</i>
                    <input class="mdc-text-field__input" id="text-field-hero-input">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="text-field-hero-input" class="mdc-floating-label">Search..</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
            </div>
            <div class="col-6 text-right">
                <span trn="sort-by">Sort by :</span>
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Date</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Time</a>
                    <a class="dropdown-item" href="#">Amount</a>
                    <a class="dropdown-item" href="#">Driver</a>
                </div>
            </div>
        </div>


        <div id="pending-order-display">
            <?php
            foreach ($this->orders as $order) {
                if ($this->admin->getBranchId() == $order->getBranch() || $this->admin->getRole() == 1) {
                    if (intval($order->getStatus()) != OrderColumn::ORDER_DELIVERED) {
                        include 'app/Views/admin/pages/order_item.php';
                    }
                }
            }
            ?>
        </div>

        <div id="completed-order-display" style="display: none;">
            <?php foreach ($this->orders as $order) {
                if ($this->admin->getBranchId() == $order->getBranch() || $this->admin->getRole() == 1) {
                    if (intval($order->getStatus()) == OrderColumn::ORDER_DELIVERED) {
                        include 'app/Views/admin/pages/order_item.php';
                    }
                }
            } ?>
        </div>

        <div class="card-footer p-2 row col-12 p-0 m-0">
            <span class="mt-1 pt-1 tx-14 ml-3">
                Showing: 1 - 10 of 1000 Orders</span>

            <nav class="mx-auto">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active"><a class="page-link" href="#">2 <span class="sr-only">(current)</span></a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</main>