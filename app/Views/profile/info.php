<!-- ADDRESS AND INFO -->
<div id="#info" style="display:none">
    <div class="row col-12 mb-3">
        <h5 class="col-lg-8 col-sm-12 text-left text-dark">Make orders faster by saving your address and lnformation</h5>
    </div>

    <div class="row col-12">
        <?php for ($i = 0; $i < count($this->addresses); $i++) {
            $address = $this->addresses[$i];
            include 'app/Views/profile/info_item.php';
        } ?>
    </div>
    <button type="button" id="add_address" class="btn btn-sm btn-outline-danger ml-2"> <i class='bx bx-plus'></i><span trn="add-address"> Add New Address</span> </button>

    <div id="contact_form" class="contact col-12 text-left" style="padding: 0;display:<?php echo (($showUserController_result)) ? 'block' : 'none' ?>">
        <form action="" method="post" role="form" class="php-email-form" style="background-color: #fefefe;">
            <div class="mt-3">
                <div class="col-lg-9">
                    <?php if (!is_null($userController_error)) { ?>
                        <div class="alert alert-danger text-center col-lg-9 col-md-10 col-sm-12 mt-4" role="alert" style="margin: auto;">
                            <strong style="font-size:12px;" trn="<?php echo $userController_error->{"trn"} ?>"><?php echo $userController_error->{0}; ?></strong>
                        </div>
                    <?php } else if (!is_null($userController_result)) { ?>
                        <div class="alert alert-success alert-dismissible fade show col-lg-9 col-md-10 col-sm-12 mt-4" style="margin: auto;" role="alert">
                            <strong trn="address-added">Information Successfull Added</strong>
                            <button type="button" class="close" data-dismiss="alert" id="close-card-success" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                            location.reload();
                        </script>
                    <?php } ?>
                    <h3 class="col-form-label mt-3 mb-2" trn="personal-info">Personal information</h3>
                    <div class="form-row">
                        <div class="col">
                            <input type="text" name="fname" trn="fname" value="<?php echo count(explode(' ', $this->user->getName()) ?? []) > 1 ? explode(' ', $this->user->getName())[0] : $this->user->getName(); ?>" class="form-control" trn="first-name" placeholder="First name">
                        </div>
                        <div class="col">
                            <input type="text" name="lname" trn="lname" value="<?php echo count(explode(' ', $this->user->getName() ?? []) ?? []) > 1 ? explode(' ', $this->user->getName())[1] : ''; ?>" class="form-control" trn="last-name" placeholder="Last name">
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col">
                            <input type="text" name="phone" trn="phone-number" value="<?php echo $this->user->getPhoneNumber(); ?>" class="form-control" trn="phone" placeholder="Phone Number">
                        </div>
                        <div class="col">
                            <input type="text" name="email" trn="email" value="<?php echo $this->user->getEmail(); ?>" class="form-control" trn="email" placeholder="Email">
                        </div>
                    </div>
                    <h3 class="col-form-label mt-5 mb-1" trn="address">Address</h3>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="zip" id="postalCode" required class="form-control" trn="zip" placeholder="Zip">
                        </div>
                        <div class="form-group col-md-6">
                            <!-- <label class="text-muted">City</label> -->
                            <input type="text" name="city" id="locality" required class="form-control" trn="city" placeholder="City">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="state" id="adminDistrict" class="form-control" trn="state" placeholder="State">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" name="address" id="formattedAddress" required class="form-control" trn="address" placeholder="Address">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="street" class="form-control" required trn="street" placeholder="Street ○-○○">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" name="building" id="formattedAddress" class="form-control" trn="building" placeholder="Building Name, Room Number">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-12  mt-2 mb-5">
                <div class="col-lg-3 col-sm-4"></div>
                <div class="col-lg-4 col-sm-4 text-sm-center text-lg-left mt-5 mb-5" style="margin-left: -10px;">
                    <button type="submit" name="save-address" class="btn btn-demae-success col-10">Save</button>
                </div>
                <div class="col-lg-5 col-sm-0"></div>
            </div>
        </form>
        <?php if (!is_null($userController_error)) {
            keepFormValues($_POST);
        } ?>
    </div>
</div>
<!-- END ADDRESS AND INFO -->