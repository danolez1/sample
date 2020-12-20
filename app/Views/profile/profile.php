<!--Banner  -->
<div class="profile-banner">
    <div class="row col-12 mb-3 back-btn">
        <a href="shop">
            <i class="mdi mdi-arrow-left-bold ml-2"></i>
            <span style="font-size: 14px;" trn="back-home"> Back to Home</span></a>
    </div>
    <div class="row col-12 justify-content-center mt-3">
        <div class="col-lg-4 col-md-6 text-lg-right text-sm-center pt-lg-0 pt-md-2">
            <img src="assets/images/shop/profile.svg" class="mr-3" />
        </div>
        <div class="col-lg-8 col-md-6">
            <div class="mt-3 text-md-left text-sm-center">
                <h3><span trn="welcome">Welcome</span> <?php echo $this->user->getName(); ?></h3>
                <p trn="profile-top-info">You can manage your Favourite foods, check your Order history,<br>
                    Rate your orders and manage your Address & Payment information</p>
            </div>
        </div>
    </div>
</div>
<div class="profile-banner-bg">
</div>
<!-- END banner -->
<?php include 'app/Views/confirm.php'; ?>
<section style="background-color: #fefefe;">
    <div class="row col-12 pl-lg-5 m-0">
        <!-- NAV -->
        <div class="col-lg-3 col-sm-12 col-md-3 text-left" data-aos="zoom-in-right">
            <div class="nav flex-column nav-profile" aria-orientation="vertical">
                <a class="de-nav-link active" href="#fav" aria-selected="true" data-toggle="tab"><i class="ri-heart-line mr-2"></i><span trn="favorites">Favorites</span></a>
                <a class="de-nav-link" href="#history" data-toggle="tab"><i class="ri-history-line mr-2"></i><span trn="order-history">Order History</span></a>
                <a class="de-nav-link" href="#info" data-toggle="tab"><i class="ri-home-3-line mr-2"></i><span trn="address-info">Address & Info.</span></a>
                <a class="de-nav-link" href="#payment" data-toggle="tab"><i class="ri-bank-card-2-line mr-2"></i><span trn="payment">Payment</span></a>
                <a class="de-nav-link" href="#promotions" data-toggle="tab"><i class="ri-gift-line mr-2"></i><span trn="promotions">Promotions</span></a>
                <a class="de-nav-link" href="" id="logout" data-toggle="tab"><i class="ri-logout-circle-r-line mr-2"></i><span trn="logout">Logout</span></a>
            </div>
        </div>
        <!-- END NAV -->
        <!-- CONTENT -->
        <div class="col-lg-9 col-sm-12 col-md-9 pt-3">
            <?php
            include 'app/Views/profile/favorite.php';
            include 'app/Views/profile/history.php';
            include 'app/Views/profile/info.php';
            include 'app/Views/profile/payment.php';
            include 'app/Views/profile/promotions.php'; ?>

            <!-- END CONTENT -->
        </div>
    </div>
</section>