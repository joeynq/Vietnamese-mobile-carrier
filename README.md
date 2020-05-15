> **DEPRECATED**
> This repository is outdated for very long time. But this may give you an idea of what to do. Using with your own risks.
> For more complicated validation, I recommend to use https://github.com/giggsey/libphonenumber-for-php instead.

Code snippets dành cho việc nhận diện đầu số di động

### Nhận diện số di động

Từ 15/11/2018, số di động chỉ có 10 số và bắt đầu bằng 03, 05, 07, 08, 09.

Regex để nhận diện số điện thoại dạng này là: `/^0[0-9]{8}$/`.

Thông thường số điện thoại thường được nhập với ký tự `-`, `.`, `[Space]` vì vậy cần loại bỏ những ký tự này trước khi nhận diện. Ví dụ (PHP):
```php
<?php
$number = str_replace(array('-', '.', ' '), '', $number);
?>
```
Và sau đó nhận dạng regex:
```php
<?php
// return false if number is not mobile number
if (!preg_match('/^0[0-9]{8}$/', $number)) return false;
?>
```
### Nhận diện tên nhà mạng

Array chứa danh sách các nhà mạng (copy-paste):
```php
<?php

$carriers_number = [
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

?>
```

Kiểm tra 1 `string` có bắt đầu bằng 1 `string` khác hay không:
```php
<?php

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

?>
```

OK, bắt đầu search:
```php
<?php

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

?>
```

Done. Kết quả mong đợi là:
```php
<?php

$number = '0987654321';
$carrier = detect_number($number);
echo $carrier // Viettel

$wrong_number = '9876543210';
$carrier = detect_number($wrong_number);
echo $carrier; // false

?>
```

Hope this help.
