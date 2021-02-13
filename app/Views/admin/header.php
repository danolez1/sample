<?php

use danolez\lib\Security\Encoding; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Demae System</title>
  <link rel="icon" href="assets/images/home/logo.svg" type="image/svg">
  <link rel="shortcut icon" href="assets/images/home/logo.svg" type="image/svg" />
  <meta name="author" content="Fatunmbi Daniel Tunmise">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="https://www.demae-system.com/xmlrpc.php">
  <title>店舗様のデリバリー受注サイトを作成します。 - ネットオーダー出前システム</title>
  <meta name="description" content="出前を始めたい、電話でしか注文受けていない、お店屋さんのネットオーダー出前システム機能を持った 、ホームページを作成します、簡単にスマホやPCで注文出来る受注ツールなので、自動的に宅配、出前をサポートしてくれます、飲食店、花屋など、個人店舗,（法人中小企業向け" />
  <meta name="robots" content="index, follow" />
  <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
  <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
  <link rel="canonical" href="https://www.demae-system.com/" />
  <meta property="og:locale" content="ja_JP" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="店舗様のデリバリー受注サイトを作成します。 - ネットオーダー出前システム" />
  <meta property="og:description" content="出前を始めたい、電話でしか注文受けていない、お店屋さんのネットオーダー出前システム機能を持った 、ホームページを作成します、簡単にスマホやPCで注文出来る受注ツールなので、自動的に宅配、出前をサポートしてくれます、飲食店、花屋など、個人店舗,（法人中小企業向け" />
  <meta property="og:url" content="https://www.demae-system.com/" />
  <meta property="og:site_name" content="ネットオーダー出前システム" />
  <meta property="article:modified_time" content="2020-11-18T06:16:40+00:00" />
  <meta property="og:image" content="assets/images/home/logo.svg" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="description" content="出前を始めたい、電話でしか注文受けていない、お店屋さんのネットオーダー出前システム機能を持った 、ホームページを作成します、簡単にスマホやPCで注文出来る受注ツールなので、自動的に宅配、出前をサポートしてくれます、飲食店、花屋など、個人店舗,（法人中小企業向け" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel='dns-prefetch' href='//translate.google.com' />
  <link rel='dns-prefetch' href='//ajax.googleapis.com' />
  <link rel='dns-prefetch' href='//fonts.googleapis.com' />
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.theme.default.css">
  <link rel="stylesheet" href="assets/vendors/aos/css/aos.css">
  <link rel="stylesheet" href="assets/vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="assets/vendors/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="assets/vendors/remixicon/remixicon.css">
  <link rel="stylesheet" href="assets/vendors/icofont/icofont.min.css">
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/css/mdtimepicker.css">
  <link rel="stylesheet" href="assets/css/shopadmin.css">
  <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
  <!-- End plugin css for this page -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="assets/css/admin/style.css">
  <link rel="stylesheet" href="assets/css/jquery-spinner.min.css">
  <link rel="stylesheet" href="assets/css/webToast.min.css">
  <link rel="stylesheet" href="assets/css/dialog-mobile.css">
  <link rel="stylesheet" type="text/css" href="assets/css/color-spectrum.css">
  <!-- End layout styles -->
</head>

<body>
  <script src="assets/vendors/jquery/jquery.min.js"></script>
  <script src="assets/js/tiny_color.js"></script>
  <script src="assets/js/preloader.js"></script>
  <script src="assets/js/webToast.min.js"></script>
  <script src="assets/js/first_load.js"></script>
  <script src="assets/js/admin_dictionary.js"></script>
  <div class="body-wrapper">

    <?php

    if (!$this->includesOnly) {
      if (!is_null($this->admin) && (intval($this->admin->getRole()) == 1 || intval($this->admin->getRole()) == 2)) { ?>
        <button class="hover" id="delivery-time-fab" type="button" data-toggle="modal" data-target="#delivery-time">
          <img src="assets/images/dashboard/timer.svg" alt="cart" width="46" height="46">
        </button>
      <?php } ?>
      <!-- partial:partials/_sidebar.html -->
      <?php include 'app/Views/admin/sidebar.php'; ?>
      <!-- partial -->
      <div class="main-wrapper mdc-drawer-app-content">
        <!-- partial:partials/_navbar.html -->
        <?php include 'app/Views/admin/navbar.php'; ?>
        <!-- partial -->
      <?php   } ?>
      <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <?php if (!is_null($this->session->get(self::ADMIN_ID))) { ?>
          <input type="hidden" value="<?php echo Encoding::encode(json_encode(array($this->branchOrder, $this->admin->getBranchId(), $this->admin->getRole()))); ?>" name="order-count" />
          <input type="hidden" value="<?php echo $this->branchOrder ?>" name="noc" />
          <audio id="notification" src="assets/audio/notification.mp3"></audio>
        <?php } ?>