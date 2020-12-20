<?php 
// Based on https://en.wikipedia.org/wiki/Payment_card_number
// This constant is used in get_card_brand()
// Note: We're not using regex anymore, with this approach way we can easily read/write/change bin series in this array for future changes
// Key     (string)           brand, keep it unique in the array
// Value   (array)            for each element in the array:
//   Key   (string)           prefix of card number, minimum 1 digit maximum 6 digits per prefix. You can use "dash" for range. Example: "34" card number starts with 34. Range Example: "34-36" (which means first 6 digits starts with 340000-369999) card number starts with 34, 35 or 36
//   Value (array of strings) valid length of card number. You can set multiple ones. You can also use "dash" for range. Example: "16" means length must be 16 digits. Range Example: "15-17" length must be 15, 16 or 17. Multiple values example: ["12", "15-17"] card number can be 12 or 15 or 16 or 17 digits
define('CARD_NUMBERS', [
    'american-express' => [
        '34' => ['15'],
        '37' => ['15'],
    ],
    'diners-club' => [
        '36'      => ['14-19'],
        '300-305' => ['16-19'],
        '3095'    => ['16-19'],
        '38-39'   => ['16-19'],
    ],
    'jcb' => [
        '3528-3589' => ['16-19'],
    ],
    'discover' => [
        '6011'          => ['16-19'],
        '622126-622925' => ['16-19'],
        '624000-626999' => ['16-19'],
        '628200-628899' => ['16-19'],
        '64'            => ['16-19'],
        '65'            => ['16-19'],
    ],
    'dankort' => [
        '5019' => ['16'],
        //'4571' => ['16'],// Co-branded with Visa, so it should appear as Visa
    ],
    'maestro' => [
        '6759'   => ['12-19'],
        '676770' => ['12-19'],
        '676774' => ['12-19'],
        '50'     => ['12-19'],
        '56-69'  => ['12-19'],
    ],
    'mastercard' => [
        '2221-2720' => ['16'],
        '51-55'     => ['16'],
    ],
    'unionpay' => [
        '81' => ['16'], // Treated as Discover cards on Discover network
    ],
    'visa' => [
        '4' => ['13-19'], // Including related/partner brands: Dankort, Electron, etc. Note: majority of Visa cards are 16 digits, few old Visa cards may have 13 digits, and Visa is introducing 19 digits cards
    ],
]);

/**
 * Pass card number and it will return brand if found
 * Examples:
 *     get_card_brand('4111111111111111');                    // Output: "visa"
 *     get_card_brand('4111.1111 1111-1111');                 // Output: "visa" function will remove following noises: dot, space and dash
 *     get_card_brand('411111######1111');                    // Output: "visa" function can handle hashed card numbers
 *     get_card_brand('41');                                  // Output: "" because invalid length
 *     get_card_brand('41', false);                           // Output: "visa" because we told function to not validate length
 *     get_card_brand('987', false);                          // Output: "" no match found
 *     get_card_brand('4111 1111 1111 1111 1111 1111');       // Output: "" no match found
 *     get_card_brand('4111 1111 1111 1111 1111 1111', false);// Output: "visa" because we told function to not validate length
 * Implementation Note: This function doesn't use regex, instead it compares digit by digit. 
 *                      Because we're not using regex in this function, it's easier to add/edit/delete new bin series to global constant CARD_NUMBERS
 * Performance Note: This function is extremely fast, less than 0.0001 seconds
 * @param  String|Int $cardNumber     (required) Card number to know its brand. Examples: 4111111111111111 or 4111 1111-1111.1111 or 411111###XXX1111
 * @param  Boolean    $validateLength (optional) If true then will check length of the card which must be correct. If false then will not check length of the card. For example you can pass 41 with $validateLength = false still this function will return "visa" correctly
 * @return String                                returns card brand if valid, otherwise returns empty string
 */
function get_card_brand($cardNumber, $validateLength = true)
{
    $foundCardBrand = '';

    $cardNumber = (string)$cardNumber;
    $cardNumber = str_replace(['-', ' ', '.'], '', $cardNumber); // Trim and remove noise

    if (in_array(substr($cardNumber, 0, 1), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'])) { // Try to find card number only if first digit is a number, if not then there is no need to check
        $cardNumber = preg_replace('/[^0-9]/', '0', $cardNumber); // Set all non-digits to zero, like "X" and "#" that maybe used to hide some digits
        $cardNumber = str_pad($cardNumber, 6, '0', STR_PAD_RIGHT); // If $cardNumber passed is less than 6 digits, will append 0s on right to make it 6

        $firstSixDigits   = (int)substr($cardNumber, 0, 6); // Get first 6 digits
        $cardNumberLength = strlen($cardNumber); // Total digits of the card

        foreach (CARD_NUMBERS as $brand => $rows) {
            foreach ($rows as $prefix => $lengths) {
                $prefix    = (string)$prefix;
                $prefixMin = 0;
                $prefixMax = 0;
                if (strpos($prefix, '-') !== false) { // If "dash" exist in prefix, then this is a range of prefixes
                    $prefixArray = explode('-', $prefix);
                    $prefixMin = (int)str_pad($prefixArray[0], 6, '0', STR_PAD_RIGHT);
                    $prefixMax = (int)str_pad($prefixArray[1], 6, '9', STR_PAD_RIGHT);
                } else { // This is fixed prefix
                    $prefixMin = (int)str_pad($prefix, 6, '0', STR_PAD_RIGHT);
                    $prefixMax = (int)str_pad($prefix, 6, '9', STR_PAD_RIGHT);
                }

                $isValidPrefix = $firstSixDigits >= $prefixMin && $firstSixDigits <= $prefixMax; // Is string starts with the prefix

                if ($isValidPrefix && !$validateLength) {
                    $foundCardBrand = $brand;
                    break 2; // Break from both loops
                }
                if ($isValidPrefix && $validateLength) {
                    foreach ($lengths as $length) {
                        $isValidLength = false;
                        if (strpos($length, '-') !== false) { // If "dash" exist in length, then this is a range of lengths
                            $lengthArray = explode('-', $length);
                            $minLength = (int)$lengthArray[0];
                            $maxLength = (int)$lengthArray[1];
                            $isValidLength = $cardNumberLength >= $minLength && $cardNumberLength <= $maxLength;
                        } else { // This is fixed length
                            $isValidLength = $cardNumberLength == (int)$length;
                        }
                        if ($isValidLength) {
                            $foundCardBrand = $brand;
                            break 3; // Break from all 3 loops
                        }
                    }
                }
            }
        }
    }

    return $foundCardBrand;
}
