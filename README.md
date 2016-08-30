Introduction
============

This repository is a fork of PEAR::Numbers_Words as composer package with PSR-0 compliance.

Credits to all previous authors.

```
With PEAR::Numbers_Words class you can change an integer number
to simple words. This can be usefull when you need to spell a currency
value e.g. on an invoice.

You can choose between several languages (language files are located
in src/Numbers/Words/Locale directory).

BTW: if you need to change number to currency, use money_format()
PHP function (available since 4.3 (not yet released)). But you must
know that locale LC_MONETARY rules are sometimes unclear.
```

Getting started
---------------

First you need to install lla/numbers_words PEAR package.
You can do it (as root) with:

```php
composer install ncrypthic/numbers
```

In your php script you need to ```use Numbers\Words```header file:

```php
use \LLA\Numbers\Words;
```

Then you can call ```Numbers_Words::fromWords()``` function with two
arguments: integer number (can be a string with digits) and
optional locale name (default is *en_US*):

```php
use \LLA\Numbers\Words;

$num   = 12340000000;
$words = Words::fromWords($num,"en_GB");
echo "Num $num in British English is '<b>$words</b>'<p>\n";
```

For  this would display:
```
Num 12340000000 in British English is '<b>twelve thousand million three hundred forty million</b>'<p>
```

There are avaibale the following modules (called by locale name,
in alphabetical order):

  az     - Azerbaijani language.
           Author: Shahriyar Imanov

  bg     - Bulgarian language (in WIN-1251 charset).
           Author: Kouber Saparev

  cs     - Czech language.
           Author: Petr 'PePa' Pavel

  de     - German language.
           Author: Piotr Klaban

  dk     - Danish language.
           Author: Jesper Veggerby

  en_100 - Donald Knuth number naming system, in English language.
           Author: Piotr Klaban

  en_GB  - British English notation of numbers, where
           one billion is 1000000 times one million.
           1000 times million is just 'thousand million' here.
           I do not use a word billiard here, because
           English people do not use it often, and even could not know it.
           Author: Piotr Klaban

  en_US  - American English notation of numbers, where
           one billion is 1000 times one million
           Author: Piotr Klaban

  es     - Spanish (Castellano) language.
           Author: Xavier Noguer

  es_AR  - Argentinian Spanish language.
           Author: Martin Marrese

  et     - Estonian language.
           Author: Erkki Saarniit

  fr     - French language.
           Author: Kouber Saparev

  fr_BE  - French (Belgium) language.
           Author: Kouber Saparev, Philippe Bajoit

  he     - Hebrew language.
           Author: Hadar Porat

  hu_HU  - Hungarian language.
           Author: Nils Homp

  id     - Indonesia language.
           Authors: Ernas M. Jamil, Arif Rifai Dwiyanto

  it_IT  - Italian language.
           Authors: Filippo Beltramini, Davide Caironi

  lt     - Lithuanian language.
           Author: Laurynas Butkus

  nl     - Dutch language.
           Author: WHAM van Dinter

  pl     - Polish language (in an internet standard charset ISO-8859-2)
           Author: Piotr Klaban

  pt_BR  - Brazilian Portuguese language.
           Authors: Marcelo Subtil Marcal, Mario H.C.T., Igor Feghali

  ro_RO  - Romanian language.
           Author: Bogdan Stancescu	

  ru     - Russian language.
           Author: Andrey Demenev

  sv     - Swedish language.
           Author: Robin Ericsson

  tr_TR  - Turkish language.
           Author: Shahriyar Imanov

** What if numbers have fraction part?

You can split the number by the coma or dot. The example
function was provided by Ernas M. Jamil (see below).
I do not know if the splitting and concatenating numbers
should be supported by Numbers_Words ... Does each language
spell numbers with a 'coma'/'koma'? What do you think?

```php
use \LLA\Numbers\Words;

function num2word($num, $fract = 0) {

    $num = sprintf("%.".$fract."f", $num);
    $fnum = explode('.', $num);

    $ret =  Words::fromNumber($fnum[0],"id");
    if(!$fract) return $ret;

    $ret .=  ' koma '; // point in english
    $ret .= Words::fromNumber($fnum[1],"id");

    return $ret;
}
```

** How to convert decimal part and not fraction part of the currency value?

Rob King send me a patch that would allow to leave fraction part in digits.
I.e. you can convert 31.01 into 'thirty-one pounds 01 pence':

```php
use \LLA\Numbers\Words;
use \LLA\Numbers\Words\Locale\en\GB;

$obj = new GB();
$convert_fraction = false;
print $obj->toCurrencyWords('GBP', '31', '01', $convert_fraction) . "\n";

```

** How to write new Language Files:

Just copy existing en_US or en_GB etc. file into src/LLA/Numbers/Words/Locale/{your_country/locale code}.php
and translate digits, numbers, tousands to your language. Then please send it
to the author to the address makler@man.torun.pl.

** Credits

All changes from other people are desrcribed with details in ChangeLog.
There are also names of the people who send me patches etc.
Authors of the language files are mentioned in the language files directly
as the author.
