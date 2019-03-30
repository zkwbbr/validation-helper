# zkwbbr/validation-helper

Helper class for Respect\\Validation

---

## Install

Install via composer as `zkwbbr/validation-helper`

## Sample Usage

```php
<?php

use Zkwbbr\ValidationHelper;
use Respect\Validation\Validator as v;

$rules = [
    'foo' => v::email()->contains('.'),
    'bar' => v::numeric()
];

$data = [
    'foo' => 'fooValue',
    'bar' => 'barValue'
];

// init validation helper
$vH = new ValidationHelper\Helper;
$vH->setErrorsHtmlWrap('<div class="myerror">|</div>');

// get all failed rules in all fields
$errors = $vH->allErrors($rules, $data);
print_r($errors);

// get first failed rules in all fields
$errors = $vH->oneError($rules, $data);
print_r($errors);

// get first failed rules in all fields with error messages wrapped in HTML code
$errors = $vH->oneErrorHtmlWrap($rules, $data);
print_r($errors);
```