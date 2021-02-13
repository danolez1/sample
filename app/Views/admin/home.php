<?php

use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\Setting;

?>
<main class="content-wrapper">
    <h3 trn="dashboard">Dashboard</h3>
    <p class="mb-4" trn="welcome-back">Welcome back, You can manage your entire online store operations here.</p>
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--purple">
                    <div class="card-inner">
                        <h5 class="card-title" trn="total-earnings">Total Earnings</h5>
                        <h5 class="font-weight-bold pb-2 mb-1 border-bottom card-value-purple"><?php echo number_format($totalEarnings); ?></h5>
                        <p class="tx-12 text-success">% increase</p>
                        <div class="card-icon-wrapper">
                            <i class="material-icons bx bx-yen font-weight-bold" style="font-size:21px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--pink">
                    <div class="card-inner">
                        <h5 class="card-title" trn="total-customers">Total Customers</h5>
                        <h5 class="font-weight-bold pb-2 mb-1 border-bottom card-value-pink">
                            <?php echo count($this->customers); ?>
                        </h5>
                        <p class="tx-12 text-success">% increase</p>
                        <div class="card-icon-wrapper">
                            <i class="material-icons">people</i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--orange">
                    <div class="card-inner">
                        <h5 class="card-title" trn="total-order">Total Order</h5>
                        <h5 class="font-weight-bold pb-2 mb-1 border-bottom card-value-orange"> <?php echo count($this->orders); ?>
                        </h5>
                        <p class="tx-12 text-success">% increase</p>
                        <div class="card-icon-wrapper">
                            <i class="material-icons mdc-drawer-item-icon bx bxs-dish"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--blue">
                    <div class="card-inner">
                        <h5 class="card-title" trn="weekly-visits">Weekly Visits</h5>
                        <h5 class="font-weight-bold pb-2 mb-1 border-bottom card-value-blue"><?php echo number_format($weeklyTraffic); ?></h5>
                        <p class="tx-12 text-danger">% increase</p>
                        <div class="card-icon-wrapper">
                            <i class="material-icons icofont-web"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8">
                <div class="mdc-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-2 mb-sm-0" trn="orders">Orders</h4>
                        <div class="d-flex justtify-content-between align-items-center">
                            <p class="d-none d-sm-block text-muted tx-12 mb-0 mr-2">% increase</p>
                            <i class="material-icons options-icon">more_vert</i>
                        </div>
                    </div>
                    <div class="d-block d-sm-flex justify-content-between align-items-center">
                        <h6 class="card-sub-title mb-0" trn="sales-performance">Sales performance revenue with time</h6>
                        <div class="mdc-tab-wrapper revenue-tab mdc-tab--secondary">
                            <div class="mdc-tab-bar" role="tablist">
                                <div class="mdc-tab-scroller">
                                    <div class="mdc-tab-scroller__scroll-area">
                                        <div class="mdc-tab-scroller__scroll-content">
                                            <button class="mdc-tab mdc-tab--active revenew-tab" data-index="0" role="tab" aria-selected="true" tabindex="0">
                                                <span class="mdc-tab__content">
                                                    <span class="mdc-tab__text-label">1W</span>
                                                </span>
                                                <span class="mdc-tab-indicator mdc-tab-indicator--active">
                                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                </span>
                                                <span class="mdc-tab__ripple"></span>
                                            </button>
                                            <button class="mdc-tab mdc-tab revenew-tab" data-index="1" role="tab" aria-selected="true" tabindex="1">
                                                <span class="mdc-tab__content">
                                                    <span class="mdc-tab__text-label">1M</span>
                                                </span>
                                                <span class="mdc-tab-indicator mdc-tab-indicator">
                                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                </span>
                                                <span class="mdc-tab__ripple"></span>
                                            </button>
                                            <button class="mdc-tab mdc-tab revenew-tab" data-index="2" role="tab" aria-selected="true" tabindex="2">
                                                <span class="mdc-tab__content">
                                                    <span class="mdc-tab__text-label">3M</span>
                                                </span>
                                                <span class="mdc-tab-indicator mdc-tab-indicator">
                                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                </span>
                                                <span class="mdc-tab__ripple"></span>
                                            </button>
                                            <button class="mdc-tab mdc-tab revenew-tab" data-index="3" role="tab" aria-selected="true" tabindex="3">
                                                <span class="mdc-tab__content">
                                                    <span class="mdc-tab__text-label">1Y</span>
                                                </span>
                                                <span class="mdc-tab-indicator mdc-tab-indicator">
                                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                </span>
                                                <span class="mdc-tab__ripple"></span>
                                            </button>
                                            <button class="mdc-tab mdc-tab revenew-tab" data-index="4" role="tab" aria-selected="true" tabindex="4">
                                                <span class="mdc-tab__content">
                                                    <span class="mdc-tab__text-label">ALL</span>
                                                </span>
                                                <span class="mdc-tab-indicator mdc-tab-indicator">
                                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                </span>
                                                <span class="mdc-tab__ripple"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content content--active">
                            </div>
                            <div class="content">
                            </div>
                            <div class="content">
                            </div>
                            <div class="content">
                            </div>
                            <div class="content">
                            </div>
                        </div>
                    </div>
                    <div class="chart-container mt-4">
                        <canvas id="revenue-chart" height="260"></canvas>
                    </div>
                </div>
            </div>

            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet">
                <div class="mdc-card">
                    <div class="d-flex d-lg-block d-xl-flex justify-content-between">
                        <div>
                            <h4 class="card-title" trn="audience">Audience</h4>
                            <h6 class="card-sub-title" trn="customers">Customers <?php echo number_abbr(count($this->customers ?? [])); ?></h6>
                        </div>
                    </div>
                    <div class="chart-container mt-4">
                        <canvas id="chart-sales" height="260"></canvas>
                    </div>

                    <div id="sales-legend" class="d-flex flex-wrap"></div>
                </div>
            </div>

            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 justify-content-between pl-2 pr-2 mt-4 pb-1">
                <div class="d-flex">
                    <h4 class="card-title mb-0 tx-14"><span trn="pending-orders">Pending Orders</span>: <span class="tx-14" trn="attend-to-pending-orders">Attend to pending order</span>
                    </h4>
                </div>
                <div>
                    <i class="material-icons refresh-icon hover option-span rotate" onclick="location.reload();">refresh</i>
                    <i class="material-icons options-icon ml-2">more_vert</i>
                </div>
            </div>

            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12" style="margin-top: -16px;">
                <div class="mdc-card p-0">
                    <div class="table-responsive">
                        <table class="table table-hoverable dashboard-table">
                            <thead>
                                <tr style="background: #EFF3F3;">
                                    <th trn="customer">Customer</th>
                                    <th trn="order-summary">Order Summary</th>
                                    <th trn="location">Location</th>
                                    <!-- <th trn="">ETA</th> -->
                                    <th trn="delivery-status">Delivery Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($this->orders as $order) {
                                    if ($this->admin->getBranchId() == $order->getBranch() || $this->admin->getRole() == 1) {

                                        $address = fromDbJson($order->getAddress());
                                        $cart = fromDbJson($order->getCart());
                                        if (intval($order->getStatus()) != OrderColumn::ORDER_DELIVERED) { ?>
                                            <tr>
                                                <td class="mdc-layout-grid__cell--span-2">
                                                    <?php echo unicode2html($address->firstName . " " . $address->lastName); ?>
                                                </td>
                                                <td class=" font-weight-medium mdc-layout-grid__cell--span-3">
                                                    <?php foreach ($cart as $item) {
                                                        $content = "";
                                                        foreach ($item->productOptions as $option) {
                                                            $content .= ($option->name . ' <strong>x ' . $option->amount . '</strong>・');
                                                        }
                                                        echo unicode2html($item->productDetails . "<br>" . $content);
                                                    } ?></td>
                                                <td class="mdc-layout-grid__cell--span-3"><?php echo smartWordWrap(unicode2html(str_replace('u', '\u', $address->address)) . " " . $address->street . " " . $address->building); ?></td>
                                                <!-- <td class=" font-weight-medium mdc-layout-grid__cell--span-2"> 39% </td> -->
                                                <td class=" font-weight-medium mdc-layout-grid__cell--span-2">
                                                    <button class="btn btn-sm btn-light dropdown-toggle tx-12" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUserName(), $order->getId()))); ?>" data-async="order-status" trn="<?php echo $order->getStatusInfo()[0]['trn']; ?>" data="<?php echo $order->getStatusInfo()[0]['data']; ?>" color="<?php echo $order->getStatusInfo()[0]['color']; ?>" style="background-color: <?php echo $order->getStatusInfo()[0]['color']; ?>;color:white;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $order->getStatusInfo()[0][0]; ?></button>
                                                    <div class="dropdown-menu p-0">
                                                        <?php for ($i = 1; $i < 5; $i++) { ?>
                                                            <a class="dropdown-item" trn="<?php echo $order->getStatusInfo()[$i]['trn']; ?>" data="<?php echo $order->getStatusInfo()[$i]['data']; ?>" color="<?php echo $order->getStatusInfo()[$i]['color']; ?>"><?php echo $order->getStatusInfo()[$i][0]; ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                <?php  }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>