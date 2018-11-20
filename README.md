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
 
 #### Getting Users Geolocation Info
 
 ```php
 <?php
 //...
 
 $ip_geo_helper = new Netliva\Helper\IpGeo();
 echo $ip_geo_helper->getIp();
 // output: "123.123.123.123" (ip of your)
 echo $ip_geo_helper->getInfo("city");
 // output: "Izmir" (city of your location)
  
 //...
 ?>
  ```
Supported purposes are `"country", "country_code", "state", "region", "city", "address", "currency_code", "currency_symbol", "currency_converter"`
 
 #### Getting A IP Geolocation Info
 
 ```php
 <?php
 //...
 
 $ip_geo_helper = new Netliva\Helper\IpGeo();
 $ip_geo_helper->setIp("172.217.168.238");
 echo $ip_geo_helper->getInfo("country");
 // output: "United States" (country of google ip location)
  
 //...
 ?>
  ```
  #### Getting All Purposes
 
 ```php
 <?php
 //...
 
 $ip_geo_helper = new Netliva\Helper\IpGeo();
 echo $ip_geo_helper->getInfo();
 /*
  * output:
  * 
  * Array
  * (
  *	 [ip] => 123.123.123.123
  *	 [city] => Izmir
  *	 [state] => Izmir
  *	 [country] => Turkey
  *	 [country_code] => TR
  *	 [continent] => Asia
  *	 [continent_code] => AS
  *	 [currency_code] => TRY
  *	 [currency_symbol] => YTL
  *	 [currency_converter] => 5.4604
  * )
  */
  
 //...
 ?>
  ```
