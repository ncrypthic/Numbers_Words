<?php
namespace LLA\Numbers;

class WordsTest extends \PHPUnit_Framework_TestCase
{
    function testToWordsStatic()
    {
        error_reporting(error_reporting() & ~E_STRICT);
        $this->assertEquals('one', Words::fromNumber(1));
    }

    function testToWordsObjectLocale()
    {
        $nw = new Words();
        $nw->locale = 'de';
        $this->assertEquals('eins', $nw->toWords(1));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Locale doesnotexist class does not exists
     */
    function testToWordsInvalidLocale()
    {
        $nw = new Words();
        $nw->toWords(1, 'doesnotexist');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Locale doesnotexist class does not exists
     */
    function testToCurrencyInvalidLocale()
    {
        $nw = new Words();
        $nw->toCurrency(1, 'doesnotexist');
    }

    function testGetLocales()
    {
        $locales = Words::getLocales();
        $this->assertInternalType('array', $locales);
        $this->assertGreaterThan(27, count($locales));
        foreach ($locales as $locale) {
            $this->assertEquals(
                1, preg_match('#^[a-z]{2}(_[A-Z]{2})?$#', $locale)
            );
        }
    }

    function testGetLocalesString()
    {
        $locales = Words::getLocales('de');
        $this->assertInternalType('array', $locales);
        $this->assertEquals(1, count($locales));
        $this->assertContains('de', $locales);
    }

    function testGetLocalesArray()
    {
        $locales = Words::getLocales(array('de', 'en_US'));
        $this->assertInternalType('array', $locales);
        $this->assertEquals(2, count($locales));
        $this->assertContains('de', $locales);
        $this->assertContains('en_US', $locales);
    }

    function testAllLocales()
    {
        $locales = Words::getLocales();
        foreach ($locales as $locale) {
            $nw = new Words();
            $word = $nw->toWords(101, $locale);
            $this->assertNotEmpty(
                $word,
                'Word for "101" is empty in locale ' . $locale
            );
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Locale xyz class does not exists
     */
    function testLoadLocaleMethodMissing()
    {
        Words::loadLocale('xyz');
    }
}

