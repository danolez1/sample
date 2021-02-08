<?php

use danolez\lib\Security\Encoding;

?>
<div class="alert alert-dark col-lg-5 ml-2 col-md-10 col-sm-12" style="background-color: white;" role="alert">
    <strong><?php echo $address->getFirstName() . ' ' . $address->getLastName(); ?></strong><br>
    <span><?php echo $address->getPhoneNumber(); ?></span><br>
    <span><?php echo $address->getEmail(); ?></span><br>
    <span><?php echo $address->getAddress() . ' ' . $address->getStreet() . ' ' . $address->getbuilding(); ?></span>
    <i class="mdi mdi-delete float-right delete-btn" data-toggle="modal" data-page="info" data-target="#confirmationModal" data-id="<?php echo Encoding::encode(json_encode(array($this->user->getId(), $address->getId()))); ?>"></i>
</div>