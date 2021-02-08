<?php

use danolez\lib\DB\Attribute;
use danolez\lib\DB\Credential;
use danolez\lib\DB\Database;
use danolez\lib\DB\DBBackup;
use danolez\lib\DB\DataType;


$db = new Database(Credential::SHOP_DB);
$contactTb =  $db->Table(Credential::CONTACTS_TBL);
$contactTb->addColumn(ContactColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(ContactColumn::NAME, DataType::TEXT)
  ->addColumn(ContactColumn::EMAIL, DataType::TEXT)
  ->addColumn(ContactColumn::SUBJECT, DataType::TEXT)
  ->addColumn(ContactColumn::MESSAGE, DataType::TEXT)
  ->addColumn(ContactColumn::TIMESTAMP, DataType::integer(16))
  ->addColumn(ContactColumn::LOG, DataType::TEXT)
  ->addColumn(ContactColumn::TO, DataType::TEXT)
  ->create();

$userTb =  $db->Table(Credential::USERS_TBL);
$userTb->addColumn(UserColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(UserColumn::ID, DataType::TEXT)
  ->addColumn(UserColumn::NAME, DataType::TEXT)
  ->addColumn(UserColumn::EMAIL, DataType::TEXT)
  ->addColumn(UserColumn::PHONENUMBER, DataType::TEXT)
  ->addColumn(UserColumn::PASSWORD, DataType::TEXT)
  ->addColumn(UserColumn::GOOGLETOKEN, DataType::TEXT)
  ->addColumn(UserColumn::FACEBOOKTOKEN, DataType::TEXT)
  ->addColumn(UserColumn::TIMECREATED, DataType::TEXT)
  ->addColumn(UserColumn::SESSION, DataType::TEXT)
  ->addColumn(UserColumn::COOKIE, DataType::TEXT)
  ->addColumn(UserColumn::LOG, DataType::TEXT)
  ->create();

$administratorTb = $db->Table(Credential::ADMINISTRATORS_TBL);
$administratorTb->addColumn(AdministratorColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(AdministratorColumn::ID, DataType::TEXT)
  ->addColumn(AdministratorColumn::BRANCHID, DataType::TEXT)
  ->addColumn(AdministratorColumn::EMAIL, DataType::TEXT)
  ->addColumn(AdministratorColumn::PHONENUMBER, DataType::TEXT)
  ->addColumn(AdministratorColumn::DATEJOINED, DataType::TEXT)
  ->addColumn(AdministratorColumn::ADDEDBY, DataType::TEXT)
  ->addColumn(AdministratorColumn::USERNAME, DataType::TEXT)
  ->addColumn(AdministratorColumn::PASSWORD, DataType::TEXT)
  ->addColumn(AdministratorColumn::INFO, DataType::TEXT)
  ->addColumn(AdministratorColumn::NAME, DataType::TEXT)
  ->addColumn(AdministratorColumn::ROLE, DataType::TEXT)
  ->addColumn(AdministratorColumn::LOG, DataType::TEXT)
  ->create();

$productTb = $db->Table(Credential::PRODUCTS_TBL);
$productTb->addColumn(ProductColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(ProductColumn::ID, DataType::TEXT)
  ->addColumn(ProductColumn::QUANTITY, DataType::TEXT)
  ->addColumn(ProductColumn::AVAILABILITY, DataType::TEXT)
  ->addColumn(ProductColumn::RATINGS, DataType::TEXT)
  ->addColumn(ProductColumn::PRICE, DataType::TEXT)
  ->addColumn(ProductColumn::NAME, DataType::TEXT)
  ->addColumn(ProductColumn::DESCRIPTION, DataType::TEXT)
  ->addColumn(ProductColumn::IMAGES, DataType::TEXT)
  ->addColumn(ProductColumn::DISPLAYIMAGE, DataType::TEXT)
  ->addColumn(ProductColumn::CATEGORY, DataType::TEXT)
  ->addColumn(ProductColumn::PRODUCTOPTIONS, DataType::TEXT)
  ->addColumn(ProductColumn::TIMECREATED, DataType::TEXT)
  ->addColumn(ProductColumn::AUTHOR, DataType::TEXT)
  ->addColumn(ProductColumn::TAX, DataType::TEXT)
  ->addColumn(ProductColumn::BRANCHID, DataType::TEXT)
  ->create();


$addressTb = $db->Table(Credential::ADDRESSES_TBL);
$addressTb->addColumn(AddressColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(AddressColumn::ID, DataType::TEXT)
  ->addColumn(AddressColumn::FIRSTNAME, DataType::TEXT)
  ->addColumn(AddressColumn::LASTNAME, DataType::TEXT)
  ->addColumn(AddressColumn::EMAIL, DataType::TEXT)
  ->addColumn(AddressColumn::ZIP, DataType::TEXT)
  ->addColumn(AddressColumn::CITY, DataType::TEXT)
  ->addColumn(AddressColumn::STATE, DataType::TEXT)
  ->addColumn(AddressColumn::ADDRESS, DataType::TEXT)
  ->addColumn(AddressColumn::BUILDING, DataType::TEXT)
  ->addColumn(AddressColumn::PHONENUMBER, DataType::TEXT)
  ->addColumn(AddressColumn::STREET, DataType::TEXT)
  ->addColumn(AddressColumn::USERID, DataType::TEXT)
  ->addColumn(AddressColumn::TIMECREATED, DataType::TEXT)
  ->addColumn(AddressColumn::LOG, DataType::TEXT)
  ->create();

$branchTb = $db->Table(Credential::BRANCHES_TBL);
$branchTb->addColumn(BranchColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(BranchColumn::ID, DataType::TEXT)
  ->addColumn(BranchColumn::NAME, DataType::TEXT)
  ->addColumn(BranchColumn::LOCATION, DataType::TEXT)
  ->addColumn(BranchColumn::STAFFNO, DataType::TEXT)
  ->addColumn(BranchColumn::STATUS, DataType::TEXT)
  ->addColumn(BranchColumn::TIMECREATED, DataType::TEXT)
  ->addColumn(BranchColumn::LOG, DataType::TEXT)
  ->addColumn(BranchColumn::ADMIN, DataType::TEXT)
  ->addColumn(BranchColumn::MINORDER, DataType::TEXT)
  ->addColumn(BranchColumn::OPERATIONTIME, DataType::TEXT)
  ->addColumn(BranchColumn::SHIPPINGFEE, DataType::TEXT)
  ->addColumn(BranchColumn::DELIVERYTIME, DataType::TEXT)
  ->addColumn(BranchColumn::DELIVERYTIMERANGE, DataType::TEXT)
  ->addColumn(BranchColumn::DELIVERYAREAS, DataType::TEXT)
  ->addColumn(BranchColumn::DELIVERYDISTANCE, DataType::TEXT)
  ->addColumn(BranchColumn::ADDRESS, DataType::TEXT)
  ->addColumn(BranchColumn::ADDRESS_NAME, DataType::TEXT)
  ->addColumn(BranchColumn::PRINT_LANGUAGE, DataType::TEXT)
  ->addColumn(BranchColumn::PRINTNODE_API, DataType::TEXT)
  ->addColumn(BranchColumn::DEFAULT_PRINTER, DataType::TEXT)
  ->create();

$cartTb = $db->Table(Credential::CARTS_TBL);
$cartTb->addColumn(CartColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(CartColumn::ID, DataType::TEXT)
  ->addColumn(CartColumn::AMOUNT, DataType::TEXT)
  ->addColumn(CartColumn::USERID, DataType::TEXT)
  ->addColumn(CartColumn::QUANTITY, DataType::TEXT)
  ->addColumn(CartColumn::PRODUCTID, DataType::TEXT)
  ->addColumn(CartColumn::PRODUCTOPTIONS, DataType::TEXT)
  ->addColumn(CartColumn::ADDITIONALNOTE, DataType::TEXT)
  ->addColumn(CartColumn::TIMECREATED, DataType::TEXT)
  ->addColumn(CartColumn::PRODUCTDETAILS, DataType::TEXT)
  ->addColumn(CartColumn::PRODUCTIMAGE, DataType::TEXT)
  ->addColumn(CartColumn::PRODUCT_DESCRIPTION, DataType::TEXT)
  ->create();

$orderTb = $db->Table(Credential::ORDERS_TBL);
$orderTb->addColumn(OrderColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(OrderColumn::ID, DataType::TEXT)
  ->addColumn(OrderColumn::DISPLAYID, DataType::TEXT)
  ->addColumn(OrderColumn::CART, DataType::TEXT)
  ->addColumn(OrderColumn::AMOUNT, DataType::TEXT)
  ->addColumn(OrderColumn::USERDETAILS, DataType::TEXT)
  ->addColumn(OrderColumn::VISIBILITY, DataType::TEXT)
  ->addColumn(OrderColumn::STATUS, DataType::TEXT)
  ->addColumn(OrderColumn::DELIVERYOPTION, DataType::TEXT)
  ->addColumn(OrderColumn::DELIVERYFEE, DataType::TEXT)
  ->addColumn(OrderColumn::SCHEDULED, DataType::TEXT)
  ->addColumn(OrderColumn::ADDRESS, DataType::TEXT)
  ->addColumn(OrderColumn::PAYMENTDETAILS, DataType::TEXT)
  ->addColumn(OrderColumn::PAYMENTMETHOD, DataType::TEXT)
  ->addColumn(OrderColumn::TIMECREATED, DataType::TEXT)
  ->addColumn(OrderColumn::LOG, DataType::TEXT)
  ->addColumn(OrderColumn::BRANCH, DataType::TEXT)
  ->create();

$favouriteTb = $db->Table(Credential::FAVORITES_TBL);
$favouriteTb->addColumn(FavoriteColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(FavoriteColumn::ID, DataType::TEXT)
  ->addColumn(FavoriteColumn::USERID, DataType::TEXT)
  ->addColumn(FavoriteColumn::PRODUCTID, DataType::TEXT)
  ->addColumn(FavoriteColumn::TIMECREATED, DataType::TEXT)
  // ->addColumn(FavoriteColumn::LOG, DataType::TEXT)
  ->create();

$categoryTb = $db->Table(Credential::CATEGORY_TBL);
$categoryTb->addColumn(CategoryColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(CategoryColumn::ID, DataType::TEXT)
  ->addColumn(CategoryColumn::NAME, DataType::TEXT)
  ->addColumn(CategoryColumn::DESCRIPTION, DataType::TEXT)
  ->addColumn(CategoryColumn::TYPE, DataType::TEXT)
  ->addColumn(CategoryColumn::TAGS, DataType::TEXT)
  ->addColumn(CategoryColumn::TIMECREATED, DataType::TEXT)
  ->addColumn(CategoryColumn::CREATOR, DataType::TEXT)
  ->create();

$paymentDetailsTb = $db->Table(Credential::PAYMENT_METHODS_TBL);
$paymentDetailsTb->addColumn(PaymentDetailsColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(PaymentDetailsColumn::ID, DataType::TEXT)
  ->addColumn(PaymentDetailsColumn::TIMECREATED, DataType::TEXT)
  ->addColumn(PaymentDetailsColumn::CREDITCARD, DataType::TEXT)
  ->addColumn(PaymentDetailsColumn::USERID, DataType::TEXT)
  ->addColumn(PaymentDetailsColumn::LOG, DataType::TEXT)
  ->create();

$trafficTb = $db->Table(Credential::TRAFFIC_TBL);
$trafficTb->addColumn(TrafficLoggerColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(TrafficLoggerColumn::COUNT, DataType::TEXT)
  ->addColumn(TrafficLoggerColumn::PAGESVIEWED, DataType::TEXT)
  ->addColumn(TrafficLoggerColumn::SESSION, DataType::TEXT)
  ->addColumn(TrafficLoggerColumn::TIME, DataType::TEXT)
  ->addColumn(TrafficLoggerColumn::URL, DataType::TEXT)
  ->addColumn(TrafficLoggerColumn::LOG, DataType::TEXT)
  ->create();

$ratingTb = $db->Table(Credential::RATINGS_TBL);
$ratingTb->addColumn(RatingsColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(RatingsColumn::ID, DataType::TEXT)
  ->addColumn(RatingsColumn::USERID, DataType::TEXT)
  ->addColumn(RatingsColumn::PRODUCTID, DataType::TEXT)
  ->addColumn(RatingsColumn::ORDERID, DataType::TEXT)
  ->addColumn(RatingsColumn::RATING, DataType::TEXT)
  ->addColumn(RatingsColumn::COMMENT, DataType::TEXT)
  ->addColumn(RatingsColumn::TIME, DataType::TEXT)
  ->create();

$notificationTb = $db->Table(Credential::NOTIFICATIONS_TBL);
// $notificationTb->addColumn(NotificationColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
//   ->addColumn(NotificationColumn::ID, DataType::TEXT)
//   // ->addColumn(NotificationColumn:, DataType::TEXT)
//   ->create();


$deliveryTb = $db->Table(Credential::DELIVERY_TBL);
$deliveryTb->addColumn(DeliveryColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
  ->addColumn(DeliveryColumn::ID, DataType::TEXT)
  ->addColumn(DeliveryColumn::ORDERID, DataType::TEXT)
  ->addColumn(DeliveryColumn::STATUS, DataType::TEXT)
  ->addColumn(DeliveryColumn::COURIERID, DataType::TEXT)
  ->addColumn(DeliveryColumn::LOCATION, DataType::TEXT)
  ->addColumn(DeliveryColumn::FROM, DataType::TEXT)
  ->addColumn(DeliveryColumn::TO, DataType::TEXT)
  ->addColumn(DeliveryColumn::TIME, DataType::TEXT)
  ->create();



// $promotionTb = $db->Table(Credential::PROMOTIONS_TBL);
// $promotionTb->addColumn(PromotionColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
//   ->addColumn(PromotionColumn::ID, DataType::TEXT)
//   // ->addColumn(PromotionColumn:, DataType::TEXT)
//   ->create();

// $messagingTb = $db->Table(Credential::MESSAGING_TBL);
// $messagingTb->addColumn(MessagingColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
//   ->addColumn(MessagingColumn::ID, DataType::TEXT)
//   // ->addColumn(MessagingColumn:, DataType::TEXT)
//   ->create();

// $settingsTb = $db->Table(Credential::SETTINGS_TBL);
// $settingsTb//->addColumn(SettingsColumn::SN, DataType::integer(10), Attribute::AUTO_INCREMENT, Attribute::PRIMARY_KEY)
//   ->addColumn(SettingsColumn::PAYMENTMETHODS, DataType::TEXT)
//   ->addColumn(SettingsColumn::LOGO, DataType::TEXT)
//   ->addColumn(SettingsColumn::ADDRESS, DataType::TEXT)
//   ->addColumn(SettingsColumn::PHONENUMBER, DataType::TEXT)
//   ->addColumn(SettingsColumn::ADDRESSNAME, DataType::TEXT)
//   ->addColumn(SettingsColumn::SOCIALS, DataType::TEXT)
//   ->addColumn(SettingsColumn::BANNERTITLE, DataType::TEXT)
//   ->addColumn(SettingsColumn::BANNERTEXT, DataType::TEXT)
//   ->addColumn(SettingsColumn::DELIVERYTIME, DataType::TEXT)
//   ->addColumn(SettingsColumn::OPERATIONALTIME, DataType::TEXT)
//   ->addColumn(SettingsColumn::MINORDER, DataType::TEXT)
//   ->addColumn(SettingsColumn::DISPLAYRATING, DataType::TEXT)
//   ->addColumn(SettingsColumn::TITLE, DataType::TEXT)
//   ->addColumn(SettingsColumn::WEBSITEURL, DataType::TEXT)
//   ->addColumn(SettingsColumn::STORENAME, DataType::TEXT)
//   ->addColumn(SettingsColumn::METACONTENT, DataType::TEXT)
//   ->addColumn(SettingsColumn::MOBILELOGO, DataType::TEXT)
//   ->addColumn(SettingsColumn::BANNERIMAGE, DataType::TEXT)
//   ->addColumn(SettingsColumn::SLIDERTYPE, DataType::TEXT)
//   ->addColumn(SettingsColumn::MENU_DISPLAY_ORIENTATION, DataType::TEXT)
//   ->addColumn(SettingsColumn::INFO_DISPLAY_ORIENTATION, DataType::TEXT)
//   ->addColumn(SettingsColumn::PRODUCT_DISPLAY_ORIENTATION, DataType::TEXT)
//   ->addColumn(SettingsColumn::DISPLAY_ORDER_COUNT, DataType::TEXT)
//   ->addColumn(SettingsColumn::THEME, DataType::TEXT)
//   ->addColumn(SettingsColumn::DELIVERYDISTANCE, DataType::TEXT)
//   ->addColumn(SettingsColumn::FOOTERTYPE, DataType::TEXT)
//   ->addColumn(SettingsColumn::SCRIPTS, DataType::TEXT)
//   ->addColumn(SettingsColumn::BRANCHES, DataType::TEXT)
//   ->addColumn(SettingsColumn::COLORS, DataType::TEXT)
//   ->addColumn(SettingsColumn::CURRENCY, DataType::TEXT)
//   ->addColumn(SettingsColumn::SHOWTAX, DataType::TEXT)
//   ->addColumn(SettingsColumn::SHIPPINGFEE, DataType::TEXT)
//   ->addColumn(SettingsColumn::DELIVERYAREAS, DataType::TEXT)
//   ->addColumn(SettingsColumn::DELIVERYTIMERANGE, DataType::TEXT)
  // ->delete();
