<?php

use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\Setting;

if (!$this->includesOnly && !is_null($this->admin)) {
    if (intval($this->admin->getRole()) == 1 || intval($this->admin->getRole()) == 2) {
        if (intval($this->admin->getRole()) == 1) $deliveryTime = Setting::getInstance()->getDeliveryTime();
        if (intval($this->admin->getRole()) == 2) $deliveryTime = $this->branches[0]->getDeliveryTime();
?>
        <div id="timer" class="card p-2" style="display:none">
            <div class="card-body p-2">
                <h5 class="card-title text-light" trn="average-delivery-time">Average Delivery Time</h5>
                <div class="input-group">
                    <input type="number" id="avdetime" class="form-control text-right" value="<?php echo $deliveryTime; ?>">
                    <div class="input-group-append" id="save-average-time" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUsername()))); ?>">
                        <span type="button" style="background-color: #17A2B8;color:#EFF3F3" class="input-group-text btn btn-success" trn="min">Min</span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- partial:partials/_footer.html -->
    <footer>
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                    <span class="tx-14">Copyright © 2020 <a href="https://www.demae-system.com/" class="text-danger tx-15">Demae-System.</a>All rights reserved.</span>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex justify-content-end">
                    <div class="d-flex align-items-center">
                        <a href="" trn="documentation">Documentation</a>
                        <span class="vertical-divider"></span>
                        <a href="" trn="faq">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- partial -->
<?php }  ?>
</div>
</div>
</div>
<!-- plugins:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- <script src="assets/vendors/popper/popper.min.js"></script> -->
<script src="assets/vendors/bootstrap/bootstrap.min.js"></script>
<script src="assets/vendors/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.card.js"></script>
<script src="assets/vendors/aos/js/aos.js"></script>
<script src="assets/vendors/chartjs/Chart.min.js"></script>
<script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- End plugin js for this page-->
<script src="assets/js/color-spectrum.js"></script>
<script src="assets/js/material.js"></script>
<script src="assets/js/misc.js"></script>
<script src="assets/js/jquery-spinner.min.js"></script>
<script src="assets/js/mcx-dialog.min.js"></script>
<!-- Custom js for this page-->
<script src="assets/js/chartjs.js"></script>
<!-- End custom js for this page-->
<!-- endinject -->
<!-- Custom js for this page-->
<script src="assets/js/mdtimepicker.js"></script>
<script src="assets/js/translator.js"></script>
<?php echo $script ?? ''; ?>
<script src="assets/js/shopadmin.js?<?php echo time() ?>"></script>
<script src="assets/js/dashboard.js?<?php echo time() ?>"></script>
<script>
    $('.langauth').click(function() {
        setCookie("lingo", $(this).attr('language'), 365);
        translator($(this).attr('language'));
    });
</script>
<!-- End custom js for this page-->
</body>

</html>