<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 26/01/14
 * Time: 3:59
 */

namespace Ham\Ascii\Element\Title;


use Ham\Ascii\AsciiDocument;
use Ham\Ascii\AsciiFormatter;

class Title1FinderTest extends \PHPUnit_Framework_TestCase {


    private function getFinder(){
        return new Title1Finder();
    }

    public function testGetMatchesEmpty(){
        $this->assertCount(0, $this->getFinder()->getMatches(""));
    }

    public function testFormatOneTitle(){
        $this->assertCount(1, $this->getFinder()->getMatches("Hello\n=="));
    }

    public function testFormatTwoTitle(){
        $this->assertCount(2, $this->getFinder()->getMatches("Hello\n==\n\nWorld\n=="));
    }

    public function testFormatTwoSameTitle(){
        $this->assertCount(2, $this->getFinder()->getMatches("Hello\n==\n\nHello\n=="));
    }

    public function testFormatNoTitle(){
        $this->assertCount(0, $this->getFinder()->getMatches("Hello\n\n=="));
    }
}
 