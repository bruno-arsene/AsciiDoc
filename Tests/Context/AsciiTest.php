<?php
/**
 * @author Nicolas De Boose
 */

namespace Tests\Context;


use AsciiDoc\Context\Ascii;

class AsciiTest extends \PHPUnit_Framework_TestCase
{

    public function testGetFirstElement()
    {
        $ascii = new Ascii('Hello world');
        $this->assertSame('Hello world', $ascii->getCurrent());
    }


    public function testFetchWithoutEol()
    {
        $ascii = new Ascii("Hello world");
        $this->assertFalse($ascii->fetch());
    }

    public function testFetchOnce()
    {
        $ascii = new Ascii("Hello world\nOk");
        $this->assertTrue($ascii->fetch());
    }

    public function testSplitWithBackSlashN()
    {
        $ascii = new Ascii("Hello world\nYes!");
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->getCurrent());
    }

    public function testSplitWithPHPEOL()
    {
        $ascii = new Ascii("Hello world" . PHP_EOL . "Yes!");
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->getCurrent());
    }

    public function testSplitWithReturn()
    {
        $ascii = new Ascii(
            "Hello world
Yes!"
        );
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->getCurrent());
    }

    public function testFetchDouble()
    {
        $ascii = new Ascii("Hello world\nYes!\nOk");
        $ascii->fetch();
        $ascii->fetch();
        $this->assertSame('Ok', $ascii->getCurrent());
    }

    public function testFail(){
        $this->fail('make it fail!');
    }
}
