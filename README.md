Introduction
============

With PEAR::Numbers_Words class you can change an integer number
to simple words. This can be usefull when you need to spell a currency
value e.g. on an invoice.

You can choose between several languages (language files are located
in Numbers/Words/ directory).

BTW: if you need to change number to currency, use money_format()
PHP function (available since 4.3 (not yet released)). But you must
know that locale LC_MONETARY rules are sometimes unclear.

Getting started
---------------

First you need to install Numbers_Words PEAR package.
You can do it (as root) with:

```php
composer install ncrypthic/numbers
```

In your php script you need to load Numbers/Words.php header file:
```php
use Numbers\Words;
```

Then you can call ```Numbers_Words::toWords()``` function with two
arguments: integer number (can be a string with digits) and
optional locale name (default is *en_US*):

```php
$ret = Words::toWords($num,"en_GB");
if (PEAR::isError($ret)) {
    echo "Error: " . $ret->message . "\n";
  } else {
    echo "Num $num in British English is '<b>$ret</b>'<p>\n";
}
```

For  this would display:

Num 12340000000 in British English is '<b>twelve thousand million three hundred forty million</b>'<p>
