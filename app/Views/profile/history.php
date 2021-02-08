<!-- HISTORY -->
<div id="#history" style="display:none">
    <?php if (count($this->history) < 1) { ?>
        <div class="alert alert-danger" role="alert" data-aos="fade-up" data-aos-easing="ease-in-back">
            <h4 class=" alert-heading"><span trn="">You do not have any Order history </span></h4>
            <div class="row col-12" style="padding: 0;">
                <p class="col-8">You can make an order from the home page</p>
                <div class="col-4 text-right">
                    <button type="button" class="btn btn-sm btn-danger"><span trn="">Home</span></button>
                </div>
            </div>
        </div>
    <?php } else {
        foreach ($this->history as $order) {
            if (!($order->getVisibility()))
                include 'app/Views/profile/history_item.php';
        }
    } ?>
</div>
<!-- END HISTORY -->