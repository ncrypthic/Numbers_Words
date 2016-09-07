<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 autoindent: */
/**
 * Numbers_Words class extension to spell numbers in Spanish (Castellano).
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
 * @author     Xavier Noguer <xnoguer.php@gmail.com>
 * @copyright  1997-2008 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/Numbers_Words
 */
namespace LLA\Numbers\Words\Locale;

use LLA\Numbers\Words;

class idTest extends \PHPUnit_Framework_TestCase
{

    var $handle;

    function setUp()
    {
        $this->handle = new Words();
    }

    /**
     * Testing numbers between 0 and 9
     */
    function testDigits()
    {
        $digits = array(
                        'nol',
                        'satu',
                        'dua',
                        'tiga',
                        'empat',
                        'lima',
                        'enam',
                        'tujuh',
                        'delapan',
                        'sembilan',
                        'sepuluh'
                       );
        for ($i = 0; $i < 10; $i++)
        {
            $number = $this->handle->toWords($i, 'id');
            $this->assertEquals($digits[$i], $number);
        }
    }

    /**
     * Testing numbers between 10 and 99
     */
    function testTens()
    {
        $tens = array(11 => 'sebelas',
                      12 => 'dua belas',
                      16 => 'enam belas',
                      19 => 'sembilan belas',
                    );
        foreach ($tens as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, 'id'));
        }
    }

    /**
     * Testing numbers between 100 and 999
     */
    function testHundreds()
    {
        $hundreds = array(100 => 'seratus');
        foreach ($hundreds as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, 'id'));
        }
    }

    /**
     * Testing numbers between 1000 and 1000000
     */
    function testThousands()
    {
        $thousands = array("1000" => 'seribu',
                           "2012" => 'dua ribu dua belas',
                           "11000" => 'sebelas ribu',
                           "111011" => 'seratus sebelas ribu sebelas',
                           "1000000" => 'satu juta',
                           "1234567" => 'satu juta dua ratus tiga puluh empat ribu lima ratus enam puluh tujuh'
                          );
        foreach ($thousands as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords((int)$number, 'id'));
        }
    }
}
