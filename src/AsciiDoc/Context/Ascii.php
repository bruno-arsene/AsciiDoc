<?php
/**
 * @author Nicolas De Boose
 */

namespace AsciiDoc\Context;


class Ascii implements Contextable{

    private $input;
    private $currentLine;

    public function __construct($text)
    {
        $normalizedEolText = str_replace("\r\n", "\n", $text);
        $this->input = explode("\n", $normalizedEolText);
        $this->currentLine = 0;
    }

    public function getCurrent(){
        return $this->input[$this->currentLine];
    }

    public function fetch(){
        $this->currentLine++;
        return $this->currentLine < count($this->input);
    }
}
