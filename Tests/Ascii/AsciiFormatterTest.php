<?php

namespace Ham\Ascii;


use Ham\Base\Element\Title\Level1;

class FormatterTest extends \PHPUnit_Framework_TestCase
{

    private function getFormatter(){
        return new AsciiFormatter();
    }

    public function testFormatLevel1()
    {
        $title = new Level1("Hello world");
        $this->assertSame('<h1>Hello world</h1>', $title->format($this->getFormatter()));
    }
}
 