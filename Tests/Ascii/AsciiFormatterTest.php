<?php

namespace Ham\Ascii;


use Ham\Base\Element\Title\Level1;

class FormatterTest extends \PHPUnit_Framework_TestCase
{

    private function getFormatter(){
        return new AsciiFormatter();
    }

    public function testTitle()
    {
        $this->assertSame("Hello world\n===========", $this->getFormatter()->title(new Level1("Hello world")));
    }
}
 