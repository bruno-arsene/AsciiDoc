<?php
/**
 * @author Nicolas De Boose
 */

namespace AsciiDoc\Element\Title;


class Level1Test extends \PHPUnit_Framework_TestCase
{

    public function testTitleEmpty()
    {
        $level1 = new Level1('');
        $this->assertSame('', $level1->getTitle());
    }

    public function testTitleNull()
    {
        $level1 = new Level1(null);
        $this->assertSame('', $level1->getTitle());
    }

    public function testTitle()
    {
        $level1 = new Level1('Hello world');
        $this->assertSame('Hello world', $level1->getTitle());
    }

    public function testToHtmlWithHtml()
    {
        $level1 = new Level1('Hello<br />world');
        $this->assertSame('Hello&lt;br /&gt;world', $level1->getTitle());
    }
}
