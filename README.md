netliva/helpers
============
This package helper for projects


Installation
============

Open a command console, enter your project directory and execute:

```console
$ composer require netliva/helpers
```


Basic Usage
===========
Getting a currency symbol with tree char currency code
 
 ```php
<?php
//...

$currency_symbols = new Netliva\Helper\CurrencySymbols();
echo  $currency_symbols->get("TRY")
// output: ₺
 
//...
?>
 ```
