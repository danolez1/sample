<?php

namespace Demae\Auth\Models;

class Error
{
    const NullName =  array("Fill in your name", "trn" => "error-name");
    const NullFirstName = array("Fill in your first name", "trn" => "error-first-name");
    const NullLastName = array("Fill in your last name", "trn" => "error-last-name");
    const NullAddress = array("Fill in your Address", "trn" => "error-address");
    const NullBuilding = array("Fill in building", "trn" => "error-building");
    const NullStreet = array("Fill in street", "trn" => "error-street");
    const InvalidEmail = array("Enter a valid email", "trn" => "invalid-email");
    const NullPhone = array("Enter a valid phone  number", "trn" => "error-phone");
    const InvalidPassword = array("Incorrect password", "trn" => "error-password");
    const WrongDetails = array("Incorrect email or password", "trn" => "wrong-details");
    const UserExist = array("User already exist", "trn" => "user-exist");
    const UserNoExist = array("User does not exist", "trn" => "user-no-exist");
    const AdministratorExist = array('Email already exist', 'trn' => 'admin-exist');
    const InvalidRole = array("Select Role", "trn" => "error-role");
    const InvalidBranch = array("Select Branch", "trn" => "error-branch");
    const InvalidMaster = array("Unauthorised Action", "trn" => "error-master");
    const InvalidCardNumber = array("Invalid card number", "trn" => "error-card");
    const InvalidCVV = array("Enter in cvc/cvv", "trn" => "error-cvv");
    const InvalidExpiryDate = array("Invalid Expiry Date", "trn" => "error-expirydate");
    const ExpiredCard = array("Card Expired", "trn" => "error-expired");
    const NullBranchName = array("Enter Branch Name", "trn" => "error-branch-name");
    const NullLocation = array("Enter Branch Location", "trn" => "error-branch-location");
    const Unauthorised = array("Unauthorised", "trn" => "unauthorised");
    const NullCategoryName = array("Enter category name", "trn" => "error-category-name");
    const CategoryNameExist = array("Category name exist", "trn" => "category-name-exist");
    const NullProductName = array("Enter product name", "trn" => "error-product-name");
    const NullPrice = array("Enter product price", "trn" => "error-product-price");
    const CouldNotAddToCart  = array("Could not add product to cart", "trn" => "could-not-add-to-cart");
    const ItemDoesNotExist = array("Item not in cart", "trn" => "item-non-existence");
    const InvalidDeliveryMethod = array("Invalid delivery method", "trn" => "invalid-delivery-method");
    const InvalidTime = array("Invalid time or date", "trn" => "invalid-time-or-date");
    const InvalidDeliveryTime = array("Invalid delivery time", "trn" => "invalid-delivery-time");
    const InvalidDeliveryDate = array("Invalid delivery date", "trn" => "invalid-delivery-date");
    const InvalidTakeoutDate = array("Invalid takeout date", "trn" => "invalid-takeout-date");
    const InvalidTakeoutTime = array("Invalid takeout time", "trn" => "invalid-takeout-time");
    const NullCard = array("Invalid payment details", "trn" => "invalid-payment-details");
    const NullCreditCardName = array("Fill name on your card", "trn" => "invalid-credit-card-name");
    const PaymentUnsuccessful = array("Payment was unsuccessful", "trn" => "unsucessful-payment");
    const NullZip = array("Invalid zip code", "trn" => "error-zip");
    const AlreadyRated = array("Already rated", "trn" => "already-rated");
    const Closed = array("Closed", "trn" => "closed");
    const BelowMinOrder = array("Order Below Min. Order", "trn" => "below-minimum");
    const InvalidOrder = array("Order not found", "trn" => "invalid-order");
    const InvalidDetails = array("Invalid delivery details", "trn" => "invalid-details");
    const ErrorOccured  = array("Error occured", "trn" => "error-occured");
    const RecoveryEmailSent = array("Check your email for recovery code", "trn" => "check-mail-code");
    const PasswordReset = array("Password reset successful", "trn" => "password-reset");
    const  PasswordMismatch = array("Password Mismatch", "trn" => "password-mismatch");
    const InvalidRecoveryCode = array("Incorrect Recovery Code","trn"=>"invalid-r-code");
    // const  = array("","trn"=>"");
    // const  = array("","trn"=>"");
    // const  = array("","trn"=>"");
    // const  = array("","trn"=>"");
}
