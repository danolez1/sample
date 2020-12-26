<?php

use danolez\lib\DB\Column\Column;

/**
 * $ds = new Application();
        $keys = $ds->properties()[Model::KEYS];
        foreach ($keys as $k) {
            echo 'const ' . strtoupper($k) . ' = "' . ($k) . '";<br>';
        }

        // $class_methods = get_class_methods($settings);
        // foreach ($class_methods as $method_name) {
        //     echo '$settings->' . "$method_name();<br>";
        // }
 */
class ContactColumn extends Column
{
    const SN = "sn";
    const NAME = "name";
    const EMAIL = "email";
    const SUBJECT = "subject";
    const MESSAGE = "message";
    const TIMESTAMP = "timeStamp";
    const LOG = "log";
    const TO = "to";
}

class UserColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const NAME = "name";
    const EMAIL = "email";
    const PHONENUMBER = "phoneNumber";
    const PASSWORD = "password";
    const GOOGLETOKEN = "googleToken";
    const FACEBOOKTOKEN = "facebookToken";
    const TIMECREATED = "timeCreated";
    const SESSION = "session";
    const COOKIE = "cookie";
    const LOG = "log";
}

class AdministratorColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const BRANCHID = "branchId";
    const EMAIL = "email";
    const PHONENUMBER = "phoneNumber";
    const DATEJOINED = "dateJoined";
    const ADDEDBY = "addedBy";
    const USERNAME = "username";
    const PASSWORD = "password";
    const NAME = "name";
    const INFO = "info";
    const ROLE = "role";
    const LOG = "log";
}

class ProductColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const QUANTITY = "quantity";
    const AVAILABILITY = "availability";
    const RATINGS = "ratings";
    const PRICE = "price";
    const NAME = "name";
    const DESCRIPTION = "description";
    const IMAGES = "images";
    const DISPLAYIMAGE = "displayImage";
    const CATEGORY = "category";
    const PRODUCTOPTIONS = "productOptions";
    const TIMECREATED = "timeCreated";
    const AUTHOR = "author";
    const TAX = "tax";
    const BRANCHID = "branchId";
}

class AddressColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const FIRSTNAME = "firstName";
    const LASTNAME = "lastName";
    const PHONENUMBER = "phoneNumber";
    const EMAIL = "email";
    const ZIP = "zip";
    const CITY = "city";
    const STATE = "state";
    const BUILDING = "building";
    const STREET = "street";
    const ADDRESS = "address";
    const USERID = "userId";
    const TIMECREATED = "timeCreated";
    const LOG = "log";
}

class CategoryColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const NAME = "name";
    const DESCRIPTION = "description";
    const TYPE = "type";
    const TAGS = "tags";
    const TIMECREATED = "timeCreated";
    const CREATOR = "creator";
}
class BranchColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const NAME = "name";
    const LOCATION = "location";
    const STAFFNO = "staffNo";
    const STATUS = "status";
    const TIMECREATED = "timeCreated";
    const LOG = "log";
    const ADMIN = "admin";
    const MINORDER = "minOrder";
    const AVERAGEDELIVERYTIME = "averageDeliveryTime";
    const OPERATIONTIME = "operationTime";
    const SHIPPINGFEE = "shippingFee";
    const DELIVERYTIME = "deliveryTime";
    const DELIVERYTIMERANGE = "deliveryTimeRange";
    const DELIVERYAREAS = "deliveryAreas";
    const DELIVERYDISTANCE = "deliveryDistance";
    const ADDRESS = "address";
}

class CartColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const AMOUNT = "amount";
    const USERID = "userId";
    const QUANTITY = "quantity";
    const PRODUCTID = "productId";
    const PRODUCTOPTIONS = "productOptions";
    const ADDITIONALNOTE = "additionalNote";
    const TIMECREATED = "timeCreated";
    const PRODUCTDETAILS = "productDetails";
}

class DeliveryColumn extends Column
{
    const SN = "sn";
}

class FavoriteColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const USERID = "userId";
    const PRODUCTID = "productId";
    const TIMECREATED = "timeCreated";
    const LOG = "log";
}
class MessagingColumn extends Column
{
    const SN = "sn";
}
class NotificationColumn extends Column
{
    const SN = "sn";
}
class OrderColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const DISPLAYID = "displayId";
    const ORDERTYPE = "orderType";
    const SCHEDULED = "scheduled";
    const CART = "cart";
    const AMOUNT = "amount";
    const USERDETAILS = "userDetails";
    const PAYMENTDETAILS = "paymentDetails";
    const VISIBILITY = "visibility";
    const STATUS = "status";
    const DELIVERYDETAILS = "deliveryDetails";
    const TIMECREATED = "timeCreated";
    const LOG = "log";
    const TAX = "tax";


    const HOME_DELIVERY = 1;
    const TAKE_OUT = 2;
    const RESERVATION = 3;
}
class PaymentDetailsColumn extends Column
{
    const SN = "sn";
    const ID = "id";
    const USERID = "userId";
    const CREDITCARD = "creditCard";
    const TIMECREATED = "timeCreated";
    const LOG = "log";
}

class PromotionColumn extends Column
{
    const SN = "sn";
}
class SettingsColumn extends Column
{
    const TITLE = "title";
    const LOGO = "logo";
    const STORENAME = "storeName";
    const BANNERTITLE = "bannerTitle";
    const BANNERTEXT = "bannerText";
    const MOBILELOGO = "mobileLogo";
    const BANNERIMAGE = "bannerImage";
    const SLIDERTYPE = "sliderType";
    const FOOTERTYPE = "footerType";
    const COLORS = "colors";
    const MENUDISPLAYORIENTATION = "menuDisplayOrientation";
    const INFODISPLAYORIENTATION = "infoDisplayOrientation";
    const PRODUCTDISPLAYORIENTATION = "productDisplayOrientation";
    const ADDRESS = "address";
    const PHONENUMBER = "phoneNumber";
    const ADDRESSNAME = "addressName";
    const SOCIALS = "socials";
    const WEBSITEURL = "websiteUrl";
    const DISPLAYORDERCOUNT = "displayOrderCount";
    const CURRENCY = "currency";
    const SHOWTAX = "showTax";
    const MINORDER = "minOrder";
    const DISPLAYRATING = "displayRating";
    const IMAGEPLACEHOLDER = "imagePlaceholder";
    const SHIPPINGFEE = "shippingFee";
    const DELIVERYTIME = "deliveryTime";
    const DELIVERYTIMERANGE = "deliveryTimeRange";
    const DELIVERYAREAS = "deliveryAreas";
    const DELIVERYDISTANCE = "deliveryDistance";
    const PAYMENTMETHODS = "paymentMethods";
    const OPERATIONALTIME = "operationalTime";
    const METACONTENT = "metaContent";
    const THEME = "theme";
    const SCRIPTS = "scripts";
    const BRANCHES = "branches";
    const SUBSCRIPTIONS = "subscriptions";
}
