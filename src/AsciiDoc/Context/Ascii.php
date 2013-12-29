<?php
/**
 * @author Nicolas De Boose
 */

namespace AsciiDoc\Context;


class Ascii implements Contextable
{

    private $lines;
    private $currentLine;

    public function __construct($text)
    {
        $normalizedEolText = str_replace("\r\n", "\n", $text);
        $this->lines = explode("\n", $normalizedEolText);
        $this->currentLine = -1;
    }

    public function getCurrent()
    {
        return $this->getLine($this->currentLine);
    }

    public function fetch()
    {
        ++$this->currentLine;
        return $this->getCurrent();
    }

    private function getLine($line)
    {
        if ($line >= 0 && $line < count($this->lines)) {
            return $this->lines[$line];
        }
        return false;
    }
}
