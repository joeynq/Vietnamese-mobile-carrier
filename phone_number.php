<?php

$GLOBALS["carriers_number"] = [
    '096' => 'Viettel',
    '097' => 'Viettel',
    '098' => 'Viettel',
    '032' => 'Viettel',
    '033' => 'Viettel',
    '034' => 'Viettel',
    '035' => 'Viettel',
    '036' => 'Viettel',
    '037' => 'Viettel',
    '038' => 'Viettel',
    '039' => 'Viettel',

    '090' => 'Mobifone',
    '093' => 'Mobifone',
    '070' => 'Mobifone',
    '071' => 'Mobifone',
    '072' => 'Mobifone',
    '076' => 'Mobifone',
    '078' => 'Mobifone',

    '091' => 'Vinaphone',
    '094' => 'Vinaphone',
    '083' => 'Vinaphone',
    '084' => 'Vinaphone',
    '085' => 'Vinaphone',
    '087' => 'Vinaphone',
    '089' => 'Vinaphone',

    '099' => 'Gmobile',

    '092' => 'Vietnamobile',
    '056' => 'Vietnamobile',
    '058' => 'Vietnamobile',

    '095'  => 'SFone'
];

/**
 * Check if a string is started with another string
 *
 * @param string $needle The string being searched for.
 * @param string $haystack The string being searched
 * @return bool true if $haystack is started with $needle
 */
function start_with($needle, $haystack) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

/**
 * Detect carrier name by phone number
 *
 * @param string $number The input phone number
 * @return bool Name of the carrier, false if not found
 */
function detect_number ($number) {
    $number = str_replace(array('-', '.', ' '), '', $number);

    // $number is not a phone number
    if (!preg_match('/^0[0-9]{8}$/', $number)) return false;

    // Store all start number in an array to search
    $start_numbers = array_keys($GLOBALS["carriers_number"]);

    foreach ($start_numbers as $start_number) {
        // if $start number found in $number then return value of $carriers_number array as carrier name
        if (start_with($start_number, $number)) {
            return $GLOBALS["carriers_number"][$start_number];
        }
    }

    // if not found, return false
    return false;
}
