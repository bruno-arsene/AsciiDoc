<?php

namespace Ham\Ascii;

class DocumentTest extends \PHPUnit_Framework_TestCase
{

    public function testGetFirstElement()
    {
        $ascii = new AsciiDocument('Hello world');
        $this->assertSame('Hello world', $ascii->fetch());
    }


    public function testFetchWithoutEol()
    {
        $ascii = new AsciiDocument("Hello world");
        $ascii->fetch();
        $this->assertFalse($ascii->fetch());
    }

    public function testFetchOnce()
    {
        $ascii = new AsciiDocument("Hello world\nOk");
        $this->assertSame('Hello world', $ascii->fetch());
    }

    public function testSplitWithBackSlashN()
    {
        $ascii = new AsciiDocument("Hello world\nYes!");
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->fetch());
    }

    public function testSplitWithPHPEOL()
    {
        $ascii = new AsciiDocument("Hello world" . PHP_EOL . "Yes!");
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->fetch());
    }

    public function testSplitWithReturn()
    {
        $ascii = new AsciiDocument(
            "Hello world
Yes!"
        );
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->fetch());
    }

    public function testFetchToLast()
    {
        $ascii = new AsciiDocument("Hello world\nYes!\nOk");
        $ascii->fetch();
        $ascii->fetch();
        $this->assertSame('Ok', $ascii->fetch());
    }

    public function testLinesCount()
    {
        $ascii = new AsciiDocument("1\n2\n3\n4\n5");
        $i = 0;
        while ($ascii->fetch() !== false) {
            $i++;
        }
        $this->assertSame(5, $i);
    }

    public function testEmptyString()
    {
        $ascii = new AsciiDocument("");
        $this->assertSame('', $ascii->fetch());
        $this->assertSame(false, $ascii->fetch());
    }

    public function testEmptyLines()
    {
        $ascii = new AsciiDocument("\n\n\n\n");
        $i = 0;
        while ($ascii->fetch() !== false) {
            $i++;
        }
        $this->assertSame(5, $i);
    }
}
