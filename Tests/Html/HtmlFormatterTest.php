<?php
/**
 * Created by PhpStorm.
 * User: Nikoms
 * Date: 26/01/14
 * Time: 3:43
 */

namespace Ham\Html;


use Ham\Ascii\AsciiDocument;
use Ham\Base\Element\Title\Level1;


class HtmlFormatterTest extends \PHPUnit_Framework_TestCase {


    private function getFormatter(){
        return new HtmlFormatter();
    }

    public function testTitle(){
        $this->assertSame('<h1>Hello</h1>',$this->getFormatter()->title(new Level1("Hello")));
    }
}
 