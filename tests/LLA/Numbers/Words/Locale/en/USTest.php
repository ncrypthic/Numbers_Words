<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 autoindent: */
/**
 * Numbers_Words class extension to spell numbers in United States English.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Numbers
 * @package    Numbers_Words
 * @author     Piotr Klaban <makler@man.torun.pl>
 * @copyright  1997-2008 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/Numbers_Words
 */
/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace LLA\Numbers\Words\Locale\en;

use LLA\Numbers\Words;

class USTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Numbers\Words
     */
    private $handle;
    /**
     * @var string
     */
    private $lang = 'en_US';

    function setUp()
    {
        $this->handle = new Words();
    }

    /**
     * Testing numbers between 0 and 9
     */
    function testDigits()
    {
        $digits = array('zero',
                        'one',
                        'two',
                        'three',
                        'four',
                        'five',
                        'six',
                        'seven',
                        'eight',
                        'nine'
                    );
        for ($i = 0; $i < 10; $i++) {
            $number = $this->handle->toWords($i, $this->lang);
            $this->assertEquals($digits[$i], $number);
        }
    }

    /**
     * Testing numbers between 10 and 99
     */
    function testTens()
    {
        $tens = array(11 => 'eleven',
                      12 => 'twelve',
                      16 => 'sixteen',
                      19 => 'nineteen',
                      20 => 'twenty',
                      21 => 'twenty-one',
                      26 => 'twenty-six',
                      30 => 'thirty',
                      31 => 'thirty-one',
                      40 => 'forty',
                      43 => 'forty-three',
                      50 => 'fifty',
                      55 => 'fifty-five',
                      60 => 'sixty',
                      67 => 'sixty-seven',
                      70 => 'seventy',
                      79 => 'seventy-nine'
                     );
        foreach ($tens as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, $this->lang));
        }
    }

    /**
     * Testing numbers between 100 and 999
     */
    function testHundreds()
    {
        $hundreds = array(100 => 'one hundred',
                          101 => 'one hundred one',
                          199 => 'one hundred ninety-nine',
                          203 => 'two hundred three',
                          287 => 'two hundred eighty-seven',
                          300 => 'three hundred',
                          356 => 'three hundred fifty-six',
                          410 => 'four hundred ten',
                          434 => 'four hundred thirty-four',
                          578 => 'five hundred seventy-eight',
                          689 => 'six hundred eighty-nine',
                          729 => 'seven hundred twenty-nine',
                          894 => 'eight hundred ninety-four',
                          999 => 'nine hundred ninety-nine'
                         );
        foreach ($hundreds as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, $this->lang));
        }
    }

    /**
     * Testing numbers between 1000 and 9999
     */
    function testThousands()
    {
        $thousands = array(1000 => 'one thousand',
                           1001 => 'one thousand one',
                           1097 => 'one thousand ninety-seven',
                           1104 => 'one thousand one hundred four',
                           1243 => 'one thousand two hundred forty-three',
                           2385 => 'two thousand three hundred eighty-five',
                           3766 => 'three thousand seven hundred sixty-six',
                           4196 => 'four thousand one hundred ninety-six',
                           5846 => 'five thousand eight hundred forty-six',
                           6459 => 'six thousand four hundred fifty-nine',
                           7232 => 'seven thousand two hundred thirty-two',
                           8569 => 'eight thousand five hundred sixty-nine',
                           9539 => 'nine thousand five hundred thirty-nine'
                          );
        foreach ($thousands as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, $this->lang));
        }
    }



    /**
     * en_GB (old version) and en_US differentiate in their millions/billions/trillions
     * because en_GB once used the long scale, and en_US the short scale.
     *
     * We're testing the short scale here.
     */
    function testMore()
    {

        $this->assertEquals('one million', $this->handle->toWords(1000000, $this->lang));

        $this->assertEquals('two billion', $this->handle->toWords(2000000000, $this->lang));


        // 32 bit systems vs PHP_INT_SIZE - 3 trillion is a little high, so use a string version.
        $number = '3000000000000' > PHP_INT_SIZE? '3000000000000' : 3000000000000;

        $this->assertEquals('three trillion', $this->handle->toWords($number, $this->lang));
    }

}