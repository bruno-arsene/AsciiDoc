<?php

namespace AsciiDoc\Format\Ascii;

class DocumentTest extends \PHPUnit_Framework_TestCase
{

    public function testGetFirstElement()
    {
        $ascii = new Document('Hello world');
        $this->assertSame('Hello world', $ascii->fetch());
    }


    public function testFetchWithoutEol()
    {
        $ascii = new Document("Hello world");
        $ascii->fetch();
        $this->assertFalse($ascii->fetch());
    }

    public function testFetchOnce()
    {
        $ascii = new Document("Hello world\nOk");
        $this->assertSame('Hello world', $ascii->fetch());
    }

    public function testSplitWithBackSlashN()
    {
        $ascii = new Document("Hello world\nYes!");
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->fetch());
    }

    public function testSplitWithPHPEOL()
    {
        $ascii = new Document("Hello world" . PHP_EOL . "Yes!");
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->fetch());
    }

    public function testSplitWithReturn()
    {
        $ascii = new Document(
            "Hello world
Yes!"
        );
        $ascii->fetch();
        $this->assertSame('Yes!', $ascii->fetch());
    }

    public function testFetchToLast()
    {
        $ascii = new Document("Hello world\nYes!\nOk");
        $ascii->fetch();
        $ascii->fetch();
        $this->assertSame('Ok', $ascii->fetch());
    }

    public function testLinesCount()
    {
        $ascii = new Document("1\n2\n3\n4\n5");
        $i = 0;
        while ($ascii->fetch() !== false) {
            $i++;
        }
        $this->assertSame(5, $i);
    }

    public function testEmptyString()
    {
        $ascii = new Document("");
        $this->assertSame('', $ascii->fetch());
        $this->assertSame(false, $ascii->fetch());
    }

    public function testEmptyLines()
    {
        $ascii = new Document("\n\n\n\n");
        $i = 0;
        while ($ascii->fetch() !== false) {
            $i++;
        }
        $this->assertSame(5, $i);
    }
}
