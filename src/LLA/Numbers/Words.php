<?php
/**
 * Coutesy of https://github.com/pear/Numbers_Words
 *
 * @author Lim Afriyadi<lim.afriyadi.id@gmail.com>
 */
namespace LLA\Numbers;

/**
 * Numbers_Words
 *
 * PHP version 5
 *
 * Copyright (c) 1997-2006 The PHP Group
 *
 * This source file is subject to version 3.01 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is
 * available at through the world-wide-web at
 * http://www.php.net/license/3_01.txt
 * If you did not receive a copy of the PHP license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@php.net so we can mail you a copy immediately.
 *
 * Authors: Piotr Klaban <makler@man.torun.pl>
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Piotr Klaban <makler@man.torun.pl>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/Numbers_Words
 */

/**
 * The Numbers_Words class provides method to convert arabic numerals to words.
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Piotr Klaban <makler@man.torun.pl>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @link     http://pear.php.net/package/Numbers_Words
 * @since    PHP 4.2.3
 * @access   public
 */
class Words
{
    /**
     * Masculine gender, for languages that need it
     */
    const GENDER_MASCULINE = 0;

    /**
     * Feminine gender, for languages that need it
     */
    const GENDER_FEMININE = 1;

    /**
     * Neuter gender, for languages that need it
     */
    const GENDER_NEUTER = 2;

    /**
     * This is not an actual gender; some languages
     * have different ways of numbering actual things
     * (e.g. Romanian: "un nor, doi nori" for "one cloud, two clouds")
     * and for just counting in an abstract manner
     * (e.g. Romanian: "unu, doi" for "one, two"
     */
    const GENDER_ABSTRACT = 3;

    /**
     * Default Locale name
     * @var string
     * @access public
     */
    public $locale = 'en_US';

    /**
     * Default decimal mark
     * @var string
     * @access public
     */
    public $decimalPoint = '.';

    public function __construct($locale = 'en_US') 
    {
        $this->locale = $locale;
    }

    public static function fromNumber($num, $locale = 'en_US')
    {
        $inst = new Words($locale);
        return $inst->toWords($num, $locale);
    }

    /**
     * Converts a number to its word representation
     *
     * @param integer $num     An integer between -infinity and infinity inclusive :)
     *                         that should be converted to a words representation
     * @param string  $locale  Language name abbreviation. Optional. Defaults to
     *                         current loaded driver or en_US if any.
     * @param array   $options Specific driver options
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  PHP 4.2.3
     * @return string  The corresponding word representation
     */
    public function toWords($num, $locale = null, $options = array())
    {
        $obj = self::loadLocale($locale ? $locale : $this->locale);
        if (!is_int($num)) {
            $num = $obj->normalizeNumber($num);

            // cast (sanitize) to int without losing precision
            $num = preg_replace('/(.*?)('.preg_quote($obj->decimalPoint).'.*?)?$/', '$1', $num);
        }

        return trim($obj->getWords($num));
    }

    /**
     * Converts a currency value to word representation (1.02 => one dollar two cents)
     * If the number has not any fraction part, the "cents" number is omitted.
     *
     * @param float  $num      A float/integer/string number representing currency value
     *
     * @param string $locale   Language name abbreviation. Optional. Defaults to en_US.
     *
     * @param string $intCurr  International currency symbol
     *                         as defined by the ISO 4217 standard (three characters).
     *                         E.g. 'EUR', 'USD', 'PLN'. Optional.
     *                         Defaults to $def_currency defined in the language class.
     *
     * @param string $decimalPoint  Decimal mark symbol
     *                         E.g. '.', ','. Optional.
     *                         Defaults to $decimalPoint defined in the language class.
     *
     * @return string  The corresponding word representation
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  PHP 4.2.3
     * @return string
     */
    public function toCurrency($num, $locale = 'en_US', $intCurr = '', $decimalPoint = null)
    {
        $ret = $num;
        $obj = self::loadLocale($locale);

        if (is_null($decimalPoint)) {
            $decimalPoint = $obj->decimalPoint;
        }

        // round if a float is passed, use Math_BigInteger otherwise
        if (is_float($num)) {
            $num = round($num, 2);
        }

        $num = $obj->normalizeNumber($num, $decimalPoint);

        if (strpos($num, $decimalPoint) === false) {
            return trim($obj->toCurrencyWords($intCurr, $num));
        }

        $currency = explode($decimalPoint, $num, 2);

        $len = strlen($currency[1]);

        if ($len == 1) {
            // add leading zero
            $currency[1] .= '0';
        } elseif ($len > 2) {
            // get the 3rd digit after the comma
            $round_digit = substr($currency[1], 2, 1);

            // cut everything after the 2nd digit
            $currency[1] = substr($currency[1], 0, 2);

            if ($round_digit >= 5) {
                // round up without losing precision
                // @todo Replace with composer library
                $int_str = bcadd(join($currency), 1);

                $currency[0] = substr($int_str, 0, -2);
                $currency[1] = substr($int_str, -2);

                // check if the rounded decimal part became zero
                if ($currency[1] == '00') {
                    $currency[1] = false;
                }
            }
        }

        return trim($obj->toCurrencyWords($intCurr, $currency[0], $currency[1]));
    }

    /**
     * Lists available locales for Numbers_Words
     *
     * @param mixed $locales string/array of strings $locale
     *                       Optional searched language name abbreviation.
     *                       Default: all available locales.
     *
     * @return array   The available locales (optionaly only the requested ones)
     * @author Piotr Klaban <makler@man.torun.pl>
     * @author Bertrand Gugger, bertrand at toggg dot com
     *
     * @return mixed[] Array of locale names ("de_DE", "en")
     */
    public static function getLocales($locales = null)
    {
        $ret = array();
        if (isset($locales) && is_string($locales)) {
            $locales = array($locales);
        }

        $dname = __DIR__ . DIRECTORY_SEPARATOR . 'Words'
            . DIRECTORY_SEPARATOR . 'Locale'
            . DIRECTORY_SEPARATOR;

        $sfiles = glob($dname . '??.php');
        foreach ($sfiles as $fname) {
            $lname = substr($fname, -6, 2);
            if (is_file($fname) && is_readable($fname)
                && (count($locales) == 0 || in_array($lname, $locales))
            ) {
                $ret[] = $lname;
            }
        }

        $mfiles = glob($dname . '??/??.php');
        foreach ($mfiles as $fname) {
            $lname = str_replace(array('/', '\\'), '_', substr($fname, -9, 5));
            if (is_file($fname) && is_readable($fname)
                && (count($locales) == 0 || in_array($lname, $locales))
            ) {
                $ret[] = $lname;
            }
        }

        sort($ret);
        return $ret;
    }

    /**
     * Load the given locale and return class name
     *
     * @param string $locale         Locale key, e.g. "de" or "en_US"
     * @param string $requiredMethod Method that this class needs to have
     *
     * @return string Locale class name
     *
     * @throws \InvalidArgumentException When the class was not found or 
     *                                   it doesn't implement LocaleInterface
     */
    public static function loadLocale($locale)
    {
        $classname = "LLA\Numbers\Words\Locale\\".str_replace('_', '\\', $locale);
        $obj       = null;
        try {
            if(!class_exists($classname)) {
                throw new \InvalidArgumentException(
                    "Locale ${locale} class does not exists"
                );
            }
            $obj = new $classname;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(
                "Locale ${locale} class does not exists"
            );
        }

        if ($obj instanceof Words\LocaleInterface === false) {
            throw new \InvalidArgumentException(
                "Locale class must implement \Numbers\Words\LocaleInterface interface"
            );
        }

        return $obj;
    }

    /**
     * Removes redundant spaces, thousands separators, etc.
     *
     * @param string $num            Some number
     * @param string $decimalPoint   The decimal mark, e.g. "." or ","
     *
     * @return string Number
     */
    public function normalizeNumber($num, $decimalPoint = null)
    {
        if (is_null($decimalPoint)) {
            $decimalPoint = $this->decimalPoint;
        }

        return preg_replace('/[^-'.preg_quote($decimalPoint).'0-9]/', '', $num);
    }
}

