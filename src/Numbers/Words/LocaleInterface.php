<?php
namespace Numbers\Words;

/**
 * Interface for locale translation
 * @author Lim Afriyadi<lim.afriyadi.id@gmail.com>
 */
interface LocaleInterface
{
    public function getWords($num, $power, $powsuffix);
    public function toCurrencyWords($int_curr, $decimal, $fraction = false, $convert_fraction = true);
}
