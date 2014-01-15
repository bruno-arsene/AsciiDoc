<?php

namespace Tests\Format\Ascii;


use AsciiDoc\Element\Title\Level1;
use AsciiDoc\Format\Ascii\Formatter;

class FormatterTest extends \PHPUnit_Framework_TestCase
{

    private function getFormatter(){
        return new Formatter();
    }

    public function testFormatLevel1()
    {
        $title = new Level1("Hello world");
        $this->assertSame('<h1>Hello world</h1>', $title->format($this->getFormatter()));
    }
}
 