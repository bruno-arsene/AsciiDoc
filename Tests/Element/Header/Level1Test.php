<?php
/**
 * @author Nicolas De Boose
 */

namespace AsciiDoc\Element\Header;


class Level1Test extends \PHPUnit_Framework_TestCase
{

    public function testToHtmlEmpty()
    {
        $level1 = new Level1('');
        $this->assertSame('<h1></h1>', $level1->toHtml());
    }

    public function testToHtml()
    {
        $level1 = new Level1('Hello world');
        $this->assertSame('<h1>Hello world</h1>', $level1->toHtml());
    }

    public function testToHtmlWithHtml()
    {
        $level1 = new Level1('Hello<br />world');
        $this->assertSame('<h1>Hello&lt;br /&gt;world</h1>', $level1->toHtml());
    }
}
