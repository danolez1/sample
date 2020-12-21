<!DOCTYPE html>
<html lang="jp">

<head>
    <title><?php echo $settings->getTitle(); ?></title>
    <meta name="description" content="<?php echo $settings->getMetaContent(); ?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="assets/images/home/logo.svg" type="image/svg">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="https://www.demae-system.com/xmlrpc.php">
    <meta name="description" content="tags" />
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <link rel="canonical" href="url" />
    <meta property="og:locale" content="ja_JP" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="title" />
    <meta property="og:description" content="tags" />
    <meta property="og:url" content="url" />
    <meta property="og:site_name" content="store name" />
    <meta property="article:modified_time" content="2020-11-18T06:16:40+00:00" />
    <meta property="og:image" content="assets/images/home/logo.svg" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="description" content="description" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='dns-prefetch' href='//translate.google.com' />
    <link rel='dns-prefetch' href='//ajax.googleapis.com' />
    <link rel='dns-prefetch' href='//fonts.googleapis.com' />
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.theme.default.css">
    <link rel="stylesheet" href="assets/vendors/aos/css/aos.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/vendors/remixicon/remixicon.css">
    <link rel="stylesheet" href="assets/vendors/icofont/icofont.min.css">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/side_modal.css">
    <link rel="stylesheet" href="assets/css/shop.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <script src="assets/js/first_load.js"></script>
</head>

<body id="body" data-spy="scroll" data-target=".navbar" data-offset="100">
    <header id="header-section">
        <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar" style="background-color:#ffffff;">
            <div class="container">
                <div class="navbar-brand-wrapper d-flex w-100"><a href="shop"><?php echo $settings->getLogo(); ?></a><button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="mdi mdi-menu navbar-toggler-icon"></span></button></div>
                <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
                    <ul class="navbar-nav align-items-lg-center align-items-start ml-auto ">
                        <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
                            <div class="navbar-collapse-logo"><?php echo $settings->getMobileLogo(); ?></div>
                            <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="mdi mdi-close navbar-toggler-icon pl-5"></span></button>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#menu" trn="menu">Menu</a></li>
                        <li class="nav-item">
                            <div class="dropdown"><a type="button" class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span trn="branches">Branches</span></a>
                                <?php ?>
                                <div class="dropdown-menu"><button class="dropdown-item" id="">Tokyo</button></div>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="" style="width:120px;" trn="contact-us">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link"></a></li>
                        <li class="nav-item"><a class="nav-link"></a></li>
                        <li class="nav-item"><a class="nav-link"></a></li>
                        <li class="nav-item"><a class="nav-link"></a></li>
                        <li class="nav-item btn-contact-us pl-4 pl-lg-0">
                            <div class="dropdown"><button class="btn btn-sm btn-demae-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false value=" en" id="defaultLang">English </button>
                                <div class="dropdown-menu"><button class="dropdown-item" id="lang1" value="jp">日本語</button></div>
                            </div>
                        </li>
                        <li class="nav-item" style="margin-right:16px;margin-left:16px;">
                            <div class="dropdown"><a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/shop/profile.svg" width="45px" height="45px" class="rounded-circle" alt="Account"></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuA">
                                    <?php if (!is_null($this->session->get(self::USER_ID))) { ?>
                                        <a href="profile"> <button class="dropdown-item" type="button" trn="profile">My Account</button></a>
                                        <a href="profile#fav"> <button class="dropdown-item" type="button" trn="favorites">Favorites</button></a>
                                        <a href="profile#history"> <button class="dropdown-item" type="button" trn="order-history">Order History</button></a>
                                        <a href="track"> <button class="dropdown-item" type="button" trn="track-order">Track Order</button></a>
                                        <div class="dropdown-divider"></div>
                                        <a href="logout"><button class="dropdown-item" type="button" trn="logout">Logout</button></a>
                                    <?php } else { ?>
                                        <a href="auth"> <button class="dropdown-item" type="button" trn="login">Login</button></a>
                                        <a href="auth#register"> <button class="dropdown-item" type="button" trn="sign-up">Sign Up</button></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php include 'app/Views/shop/cart.php'; ?>
    <style>
        .search-s-_icon {
            background-color: #024f51;
        }

        .search-s-_icon i {
            color: #e74c3c;
        }

        .title {
            color: #fa1616;
        }

        .title-m {
            color: #fa1616;
        }

        .btn-demae-success {
            background-color: #05c7ca;
            border-color: rgba(60, 246, 250, 0.2);
            box-shadow: 0 1px 1px rgba(40, 246, 250, 0.1), 0 0 0 rgba(40, 246, 250, 0.35);
        }

        .btn-demae-success:hover {
            color: #05c7ca !important;
            background-color: #fff;
            border-color: #009a9a;
        }

        .btn-demae-success:focus,
        .btn-demae-success.focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 90, 90, 0.5);
        }
    </style>